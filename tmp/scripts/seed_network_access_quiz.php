<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

$jsonPath = __DIR__ . '/ccna_network_access_100.json';
$data = json_decode(file_get_contents($jsonPath), true);
if (!is_array($data) || count($data['questions'] ?? []) < 100) {
    fwrite(STDERR, "Invalid Network Access question bank.\n");
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
    fwrite(STDERR, "No quiz exists in target course for owner metadata template.\n");
    exit(1);
}

$now = Carbon::now()->toDateTimeString();
$quizName = 'Network Access';

DB::transaction(function () use ($course, $templateQuiz, $quizName, $data, $now, &$quizId) {
    $existing = DB::table('quizzes')
        ->where('course_id', $course->id)
        ->where('name', $quizName)
        ->first();

    if ($existing) {
        $quizId = $existing->id;
        DB::table('quizzes')->where('id', $quizId)->update([
            'description' => 'CCNA 200-301 v1.1 Network Access domain set focused on VLANs, trunking, STP/RSTP, EtherChannel, WLAN operations, and secure access edge practices.',
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
            'description' => 'CCNA 200-301 v1.1 Network Access domain set focused on VLANs, trunking, STP/RSTP, EtherChannel, WLAN operations, and secure access edge practices.',
            'total_question' => 100,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $rows = [];
    foreach ($data['questions'] as $q) {
        $rows[] = [
            'quiz_id' => $quizId,
            'question' => $q['question'],
            'image' => '',
            'correct_answer' => (int)$q['correct_answer'],
            'mark' => (int)($q['mark'] ?? 1),
            'options' => json_encode(array_values($q['options']), JSON_UNESCAPED_UNICODE),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    foreach (array_chunk($rows, 50) as $chunk) {
        DB::table('questions')->insert($chunk);
    }
});

$total = DB::table('questions')->where('quiz_id', $quizId)->count();
$distinct = DB::table('questions')->where('quiz_id', $quizId)->distinct('question')->count('question');
$quiz = DB::table('quizzes')->where('id', $quizId)->first();

$dist = [4=>0,5=>0,6=>0,'other'=>0];
foreach (DB::table('questions')->where('quiz_id', $quizId)->select('options')->get() as $r) {
    $cnt = count(json_decode($r->options, true) ?: []);
    if (isset($dist[$cnt])) $dist[$cnt]++; else $dist['other']++;
}

echo "quiz_id={$quizId}\n";
echo "quiz_name={$quiz->name}\n";
echo "course_id={$quiz->course_id}\n";
echo "total_question_field={$quiz->total_question}\n";
echo "seeded_total={$total}\n";
echo "seeded_distinct={$distinct}\n";
echo "options_4={$dist[4]} options_5={$dist[5]} options_6={$dist[6]} other={$dist['other']}\n";
