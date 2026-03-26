<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('lesson_completions')) {
            return;
        }

        Schema::create('lesson_completions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('lesson_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id', 'lesson_id'], 'lesson_completions_unique');
            $table->index(['user_id', 'course_id'], 'lesson_completions_user_course_idx');
            $table->index(['course_id', 'lesson_id'], 'lesson_completions_course_lesson_idx');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('lesson_completions')) {
            return;
        }

        Schema::dropIfExists('lesson_completions');
    }
};

