<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$courseName = 'Free CCNA v1.1 200-301 | Complete Course 2026';
$quizName = 'Network Fundamentals';

$courses = DB::table('courses')->where('name', 'like', "%{$courseName}%")->select('id','name')->get();
$quizzes = DB::table('quizzes')->where('name', 'like', "%{$quizName}%")->select('id','name','course_id','total_question','pass_mark','time')->get();

print "courses=" . $courses->count() . PHP_EOL;
foreach ($courses as $c) {
    print "course: {$c->id} | {$c->name}" . PHP_EOL;
}
print "quizzes=" . $quizzes->count() . PHP_EOL;
foreach ($quizzes as $q) {
    $count = DB::table('questions')->where('quiz_id', $q->id)->count();
    print "quiz: {$q->id} | {$q->name} | course_id={$q->course_id} | questions={$count} | total_question={$q->total_question}" . PHP_EOL;
}

$cols = DB::select('SHOW COLUMNS FROM questions');
print "question_columns:" . PHP_EOL;
foreach ($cols as $col) {
    print $col->Field . ' ' . $col->Type . PHP_EOL;
}
