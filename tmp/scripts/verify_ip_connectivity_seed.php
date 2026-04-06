<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$q = DB::table('quizzes')->where('name','IP Connectivity')->orderBy('id')->first();
if(!$q){ echo "quiz_not_found\n"; exit(1);} 
$total = DB::table('questions')->where('quiz_id',$q->id)->count();
$withExp = DB::table('questions')->where('quiz_id',$q->id)->whereNotNull('explanation')->where('explanation','!=','')->count();
$sample = DB::table('questions')->where('quiz_id',$q->id)->select('question','explanation','correct_answers')->orderBy('id')->limit(3)->get();
echo "quiz_id={$q->id}\n";
echo "course_id={$q->course_id}\n";
echo "quiz_name={$q->name}\n";
echo "total={$total}\n";
echo "with_exp={$withExp}\n";
foreach($sample as $i=>$s){
  $idx=$i+1;
  echo "sample{$idx}_q=" . $s->question . "\n";
  echo "sample{$idx}_exp=" . substr($s->explanation,0,160) . "\n";
}
