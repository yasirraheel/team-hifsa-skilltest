<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->longText('correct_answers')->nullable()->after('correct_answer');
        });

        DB::table('questions')->select('id', 'correct_answer')->orderBy('id')->chunkById(500, function ($rows) {
            foreach ($rows as $row) {
                DB::table('questions')
                    ->where('id', $row->id)
                    ->update([
                        'correct_answers' => json_encode([(int) $row->correct_answer]),
                    ]);
            }
        });

        DB::statement('ALTER TABLE quiz_user MODIFY user_answer LONGTEXT NULL');
        DB::statement('ALTER TABLE quiz_user MODIFY correct_answer LONGTEXT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE quiz_user MODIFY user_answer INT NULL');
        DB::statement('ALTER TABLE quiz_user MODIFY correct_answer INT NULL');

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('correct_answers');
        });
    }
};

