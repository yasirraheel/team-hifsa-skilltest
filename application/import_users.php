<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

$sqlFile = __DIR__ . '/../users.sql';
if (!file_exists($sqlFile)) {
    die("users.sql not found\n");
}

$sql = file_get_contents($sqlFile);
$sql = str_replace('CREATE TABLE `users`', 'CREATE TABLE `old_users`', $sql);
$sql = str_replace('INSERT INTO `users`', 'INSERT INTO `old_users`', $sql);
$sql = str_replace('ALTER TABLE `users`', 'ALTER TABLE `old_users`', $sql);

DB::statement('DROP TABLE IF EXISTS `old_users`');

DB::unprepared($sql);

$oldUsers = DB::table('old_users')->get();

foreach ($oldUsers as $oldUser) {
    if (empty(trim($oldUser->name))) {
        continue;
    }

    $nameParts = explode(' ', trim($oldUser->name));
    $firstname = $nameParts[0];
    $lastname = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
    
    // Generate base username
    $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $oldUser->name));
    if (empty($baseUsername)) {
        $baseUsername = explode('@', $oldUser->email)[0];
    }
    $username = $baseUsername;
    $counter = 1;
    while (DB::table('users')->where('username', $username)->where('email', '!=', $oldUser->email)->exists()) {
        $username = $baseUsername . $counter;
        $counter++;
    }

    $createdAt = date('Y-m-d H:i:s', $oldUser->created_at / 1000);

    DB::table('users')->updateOrInsert(
        ['email' => $oldUser->email],
        [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'password' => $oldUser->password_hash,
            'status' => $oldUser->status === 'active' ? 1 : 0,
            'ev' => 1,
            'sv' => 1,
            'kv' => 1,
            'created_at' => $createdAt,
            'updated_at' => now(),
        ]
    );

    echo "Imported user: {$oldUser->email}\n";
}

DB::statement('DROP TABLE `old_users`');
echo "Done importing users.\n";
