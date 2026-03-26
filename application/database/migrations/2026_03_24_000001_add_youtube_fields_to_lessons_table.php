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
            if (!Schema::hasColumn('lessons', 'youtube_video_id')) {
                $table->string('youtube_video_id')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('lessons', 'youtube_title')) {
                $table->string('youtube_title')->nullable()->after('youtube_video_id');
            }
            if (!Schema::hasColumn('lessons', 'youtube_thumbnail')) {
                $table->string('youtube_thumbnail')->nullable()->after('youtube_title');
            }
            if (!Schema::hasColumn('lessons', 'youtube_comments')) {
                $table->longText('youtube_comments')->nullable()->after('youtube_thumbnail');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('lessons')) {
            return;
        }

        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'youtube_comments')) {
                $table->dropColumn('youtube_comments');
            }
            if (Schema::hasColumn('lessons', 'youtube_thumbnail')) {
                $table->dropColumn('youtube_thumbnail');
            }
            if (Schema::hasColumn('lessons', 'youtube_title')) {
                $table->dropColumn('youtube_title');
            }
            if (Schema::hasColumn('lessons', 'youtube_video_id')) {
                $table->dropColumn('youtube_video_id');
            }
        });
    }
};

