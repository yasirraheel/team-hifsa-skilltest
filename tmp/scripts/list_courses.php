<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$courses = DB::table('courses')->select('id','name')->orderBy('id')->limit(20)->get();
foreach ($courses as $c) {
    print "{$c->id} | {$c->name}" . PHP_EOL;
}
