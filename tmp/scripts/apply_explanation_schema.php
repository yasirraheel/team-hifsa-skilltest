<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$questionColumns = collect(DB::select('SHOW COLUMNS FROM questions'))->pluck('Field')->all();
if (!in_array('explanation', $questionColumns, true)) {
    DB::statement('ALTER TABLE questions ADD COLUMN explanation LONGTEXT NULL AFTER question');
    echo "Added questions.explanation\n";
} else {
    echo "questions.explanation already exists\n";
}
