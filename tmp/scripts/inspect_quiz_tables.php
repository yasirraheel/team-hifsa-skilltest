<?php
require __DIR__ . '/../../application/vendor/autoload.php';
$app = require_once __DIR__ . '/../../application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

foreach (['questions','quiz_user'] as $table) {
    echo "TABLE: {$table}\n";
    $cols = DB::select("SHOW COLUMNS FROM {$table}");
    foreach ($cols as $col) {
        echo $col->Field . ' ' . $col->Type . ' NULL=' . $col->Null . "\n";
    }
    echo "\n";
}
