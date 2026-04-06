<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

foreach ([1,2] as $quizId) {
    $total = DB::table('questions')->where('quiz_id',$quizId)->count();
    $withExp = DB::table('questions')->where('quiz_id',$quizId)->whereNotNull('explanation')->where('explanation','!=','')->count();
    $sample = DB::table('questions')->where('quiz_id',$quizId)->select('question','explanation')->first();
    echo "quiz={$quizId} total={$total} with_explanation={$withExp}\n";
    echo "sample_q=" . substr(($sample->question ?? ''),0,80) . "\n";
    echo "sample_exp=" . substr(($sample->explanation ?? ''),0,120) . "\n\n";
}
