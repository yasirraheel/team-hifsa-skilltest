<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('lessons')) {
            return;
        }

        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'image')) {
                $table->string('image')->nullable()->after('upload_video');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('lessons')) {
            return;
        }

        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};

