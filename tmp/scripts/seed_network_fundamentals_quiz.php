<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

$jsonPath = __DIR__ . '/ccna_network_fundamentals_100.json';
if (!file_exists($jsonPath)) {
    fwrite(STDERR, "Question JSON not found: {$jsonPath}" . PHP_EOL);
    exit(1);
}

$data = json_decode(file_get_contents($jsonPath), true);
if (!is_array($data) || empty($data['questions']) || count($data['questions']) < 100) {
    fwrite(STDERR, "Invalid question bank JSON or fewer than 100 questions." . PHP_EOL);
    exit(1);
}

$course = DB::table('courses')
    ->where('name', 'like', '%Free CCNA v1.1 200-301%Complete Course 2026%')
    ->first();

$quizQuery = DB::table('quizzes')->where('name', 'Network Fundamentals');
if ($course) {
    $quizQuery->where('course_id', $course->id);
}
$quiz = $quizQuery->orderBy('id')->first();

if (!$quiz) {
    fwrite(STDERR, "Target quiz 'Network Fundamentals' not found." . PHP_EOL);
    exit(1);
}

$now = Carbon::now()->toDateTimeString();

DB::transaction(function () use ($quiz, $course, $data, $now) {
    // 1) Update quiz metadata first
    DB::table('quizzes')->where('id', $quiz->id)->update([
        'name' => 'Network Fundamentals',
        'description' => 'CCNA 200-301 v1.1 Network Fundamentals domain question set focused on IPv4/IPv6 addressing and subnetting, Ethernet switching basics, wireless fundamentals, transport basics, and network architecture concepts.',
        'total_question' => 100,
        'pass_mark' => 70,
        'time' => 120,
        'active_quiz' => 1,
        'course_id' => $course ? $course->id : $quiz->course_id,
        'updated_at' => $now,
    ]);

    // 2) Replace existing questions with 100-seed set
    DB::table('questions')->where('quiz_id', $quiz->id)->delete();

    $rows = [];
    foreach ($data['questions'] as $q) {
        $rows[] = [
            'quiz_id' => $quiz->id,
            'question' => $q['question'],
            'image' => '',
            'correct_answer' => (int) $q['correct_answer'],
            'mark' => (int) ($q['mark'] ?? 1),
            'options' => json_encode(array_values($q['options']), JSON_UNESCAPED_UNICODE),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    foreach (array_chunk($rows, 50) as $chunk) {
        DB::table('questions')->insert($chunk);
    }
});

$count = DB::table('questions')->where('quiz_id', $quiz->id)->count();
$updatedQuiz = DB::table('quizzes')->where('id', $quiz->id)->first();

print "quiz_id={$quiz->id}" . PHP_EOL;
print "quiz_name={$updatedQuiz->name}" . PHP_EOL;
print "course_id={$updatedQuiz->course_id}" . PHP_EOL;
print "total_question={$updatedQuiz->total_question}" . PHP_EOL;
print "pass_mark={$updatedQuiz->pass_mark}" . PHP_EOL;
print "time={$updatedQuiz->time}" . PHP_EOL;
print "seeded_questions={$count}" . PHP_EOL;
