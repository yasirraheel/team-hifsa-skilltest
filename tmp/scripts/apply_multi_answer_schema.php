<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$questionColumns = collect(DB::select('SHOW COLUMNS FROM questions'))->pluck('Field')->all();
if (!in_array('correct_answers', $questionColumns, true)) {
    DB::statement('ALTER TABLE questions ADD COLUMN correct_answers LONGTEXT NULL AFTER correct_answer');
    echo "Added questions.correct_answers\n";
}

DB::statement('ALTER TABLE quiz_user MODIFY user_answer LONGTEXT NULL');
DB::statement('ALTER TABLE quiz_user MODIFY correct_answer LONGTEXT NULL');
echo "Altered quiz_user answer columns to LONGTEXT NULL\n";

DB::table('questions')->select('id', 'correct_answer')->orderBy('id')->chunkById(500, function ($rows) {
    foreach ($rows as $row) {
        DB::table('questions')->where('id', $row->id)->update([
            'correct_answers' => json_encode([(int) $row->correct_answer]),
        ]);
    }
});

echo "Backfilled correct_answers\n";
