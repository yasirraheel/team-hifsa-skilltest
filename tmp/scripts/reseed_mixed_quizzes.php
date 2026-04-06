<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

$base = __DIR__;
$sets = [
    [
        'quiz_name' => 'Network Fundamentals',
        'file' => $base . '/ccna_network_fundamentals_100_mixed_explained.json',
        'description' => 'CCNA 200-301 v1.1 Network Fundamentals bank with mixed single-answer and multi-answer scenario-based MCQs.',
    ],
    [
        'quiz_name' => 'Network Access',
        'file' => $base . '/ccna_network_access_100_mixed_explained.json',
        'description' => 'CCNA 200-301 v1.1 Network Access bank with mixed single-answer and multi-answer scenario-based MCQs.',
    ],
];

$now = Carbon::now()->toDateTimeString();

foreach ($sets as $set) {
    if (!file_exists($set['file'])) {
        throw new RuntimeException('Missing file: ' . $set['file']);
    }

    $payload = json_decode(file_get_contents($set['file']), true);
    $questions = $payload['questions'] ?? [];
    if (count($questions) !== 100) {
        throw new RuntimeException($set['quiz_name'] . ' bank does not have exactly 100 questions.');
    }

    $quiz = DB::table('quizzes')->where('name', $set['quiz_name'])->orderBy('id')->first();
    if (!$quiz) {
        throw new RuntimeException('Quiz not found: ' . $set['quiz_name']);
    }

    DB::transaction(function () use ($quiz, $questions, $set, $now) {
        DB::table('quizzes')->where('id', $quiz->id)->update([
            'description' => $set['description'],
            'total_question' => 100,
            'pass_mark' => 70,
            'time' => 120,
            'active_quiz' => 1,
            'updated_at' => $now,
        ]);

        DB::table('questions')->where('quiz_id', $quiz->id)->delete();

        $rows = [];
        foreach ($questions as $q) {
            $options = array_values($q['options'] ?? []);
            $correctAnswers = collect($q['correct_answers'] ?? [0])
                ->map(fn ($item) => (int) $item)
                ->unique()
                ->sort()
                ->values()
                ->all();

            if (empty($correctAnswers)) {
                $correctAnswers = [0];
            }

            $rows[] = [
                'quiz_id' => $quiz->id,
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

    $total = DB::table('questions')->where('quiz_id', $quiz->id)->count();
    $multi = 0;
    foreach (DB::table('questions')->where('quiz_id', $quiz->id)->select('correct_answers')->get() as $row) {
        $arr = json_decode($row->correct_answers, true) ?: [];
        if (count($arr) > 1) {
            $multi++;
        }
    }

    echo "{$set['quiz_name']} => quiz_id={$quiz->id}, total={$total}, multi={$multi}\n";
}
