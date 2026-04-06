<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$quizId = 1;
$total = DB::table('questions')->where('quiz_id', $quizId)->count();
$distinct = DB::table('questions')->where('quiz_id', $quizId)->distinct('question')->count('question');
$rows = DB::table('questions')->where('quiz_id', $quizId)->select('id','question','options','correct_answer')->limit(5)->get();

$dist = [4=>0,5=>0,6=>0,'other'=>0];
foreach (DB::table('questions')->where('quiz_id',$quizId)->select('options')->get() as $r) {
    $c = count(json_decode($r->options, true) ?: []);
    if (isset($dist[$c])) $dist[$c]++; else $dist['other']++;
}

echo "total={$total}\n";
echo "distinct={$distinct}\n";
echo "options_4={$dist[4]} options_5={$dist[5]} options_6={$dist[6]} other={$dist['other']}\n";
foreach ($rows as $r) {
    $opts = json_decode($r->options, true) ?: [];
    $ans = $opts[(int)$r->correct_answer] ?? 'N/A';
    echo "Q{$r->id}: {$r->question}\n";
    echo "  answer={$ans} | option_count=" . count($opts) . "\n";
}
