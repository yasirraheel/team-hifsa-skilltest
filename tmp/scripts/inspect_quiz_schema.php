<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$quizCols = DB::select('SHOW COLUMNS FROM quizzes');
echo "quiz_columns:\n";
foreach ($quizCols as $col) {
    echo $col->Field . ' ' . $col->Type . ' NULL=' . $col->Null . ' DEFAULT=' . ($col->Default ?? 'NULL') . "\n";
}

$q = DB::table('quizzes')->where('id',1)->first();
echo "\nquiz1:\n";
foreach ((array)$q as $k=>$v) {
    echo "$k=" . (is_scalar($v) || $v===null ? (string)$v : json_encode($v)) . "\n";
}
