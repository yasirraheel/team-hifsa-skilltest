<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

$jsonPath = __DIR__ . '/ccna_ip_connectivity_100_explained.json';
if (!file_exists($jsonPath)) {
    fwrite(STDERR, "Question bank file missing: {$jsonPath}\n");
    exit(1);
}

$payload = json_decode(file_get_contents($jsonPath), true);
$questions = $payload['questions'] ?? [];

if (count($questions) !== 100) {
    fwrite(STDERR, "IP Connectivity bank must contain exactly 100 questions.\n");
    exit(1);
}

$course = DB::table('courses')
    ->where('name', 'like', '%Free CCNA v1.1 200-301%Complete Course 2026%')
    ->orderBy('id')
    ->first();

if (!$course) {
    fwrite(STDERR, "Target course not found.\n");
    exit(1);
}

$templateQuiz = DB::table('quizzes')->where('course_id', $course->id)->orderBy('id')->first();
if (!$templateQuiz) {
    fwrite(STDERR, "No existing quiz found in target course for owner metadata.\n");
    exit(1);
}

$quizName = 'IP Connectivity';
$description = 'CCNA 200-301 v1.1 IP Connectivity domain set focused on route selection, static/floating routes, and single-area OSPFv2/OSPFv3 verification and troubleshooting.';
$now = Carbon::now()->toDateTimeString();

DB::transaction(function () use ($course, $templateQuiz, $quizName, $description, $questions, $now, &$quizId) {
    $existing = DB::table('quizzes')
        ->where('course_id', $course->id)
        ->where('name', $quizName)
        ->first();

    if ($existing) {
        $quizId = $existing->id;
        DB::table('quizzes')->where('id', $quizId)->update([
            'description' => $description,
            'total_question' => 100,
            'pass_mark' => 70,
            'time' => 120,
            'active_quiz' => 1,
            'updated_at' => $now,
        ]);
        DB::table('questions')->where('quiz_id', $quizId)->delete();
    } else {
        $quizId = DB::table('quizzes')->insertGetId([
            'owner_id' => $templateQuiz->owner_id,
            'owner_type' => $templateQuiz->owner_type,
            'course_id' => $course->id,
            'name' => $quizName,
            'image' => $templateQuiz->image ?: '',
            'time' => 120,
            'pass_mark' => 70,
            'active_quiz' => 1,
            'description' => $description,
            'total_question' => 100,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $rows = [];
    foreach ($questions as $q) {
        $options = array_values($q['options'] ?? []);
        $correctAnswers = collect($q['correct_answers'] ?? [0])
            ->map(fn ($item) => (int) $item)
            ->unique()
            ->sort()
            ->values()
            ->all();

        if (empty($options)) {
            throw new RuntimeException('Question has empty options list.');
        }
        if (empty($correctAnswers)) {
            $correctAnswers = [0];
        }

        $rows[] = [
            'quiz_id' => $quizId,
            'question' => (string) ($q['question'] ?? ''),
            'explanation' => (string) ($q['explanation'] ?? ''),
            'image' => '',
            'correct_answer' => (int) $correctAnswers[0],
            'correct_answers' => json_encode($correctAnswers),
            'mark' => (int) ($q['mark'] ?? 1),
            'options' => json_encode($options, JSON_UNESCAPED_UNICODE),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    foreach (array_chunk($rows, 50) as $chunk) {
        DB::table('questions')->insert($chunk);
    }
});

$total = DB::table('questions')->where('quiz_id', $quizId)->count();
$withExplanation = DB::table('questions')
    ->where('quiz_id', $quizId)
    ->whereNotNull('explanation')
    ->where('explanation', '!=', '')
    ->count();
$multi = 0;
foreach (DB::table('questions')->where('quiz_id', $quizId)->select('correct_answers')->get() as $row) {
    $arr = json_decode($row->correct_answers, true) ?: [];
    if (count($arr) > 1) {
        $multi++;
    }
}

echo "quiz_id={$quizId}\n";
echo "quiz_name={$quizName}\n";
echo "course_id={$course->id}\n";
echo "seeded_total={$total}\n";
echo "with_explanation={$withExplanation}\n";
echo "multi_answer_questions={$multi}\n";
