<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('quizzes')->select('id','name','course_id','total_question')->orderBy('course_id')->orderBy('id')->get();
foreach ($rows as $r) {
    echo "{$r->id} | course={$r->course_id} | {$r->name} | total_field={$r->total_question}\n";
}
