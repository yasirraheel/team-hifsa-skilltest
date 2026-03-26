<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LessonProgressController extends Controller
{
    public function complete(Request $request)
    {
        $debug = ((bool) config('app.debug')) || $request->boolean('lesson_debug');

        if ($debug) {
            Log::info('lesson.complete.hit', [
                'user_id' => auth()->id(),
                'course_id' => $request->input('course_id'),
                'lesson_id' => $request->input('lesson_id'),
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
            ]);
        }

        try {
            $request->validate([
                'course_id' => 'required|integer',
                'lesson_id' => 'required|integer',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($debug) {
                Log::warning('lesson.complete.validation_failed', [
                    'user_id' => auth()->id(),
                    'errors' => $e->errors(),
                ]);
            }
            throw $e;
        }

        $enroll = Enroll::where('course_id', $request->course_id)
            ->where('user_id', auth()->id())
            ->where('status', 1)
            ->first();

        if (!$enroll) {
            $anyEnroll = Enroll::where('course_id', $request->course_id)
                ->where('user_id', auth()->id())
                ->first();

            Log::warning('lesson.complete.not_enrolled', [
                'user_id' => auth()->id(),
                'course_id' => (int) $request->course_id,
                'lesson_id' => (int) $request->input('lesson_id'),
                'active_enrollment_found' => false,
                'any_enrollment_found' => (bool) $anyEnroll,
                'any_enrollment_status' => $anyEnroll?->status,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'You are not enrolled in this course',
            ], 403);
        }

        $lesson = Lesson::where('id', $request->lesson_id)
            ->where('course_id', $request->course_id)
            ->where('status', 1)
            ->first();

        if (!$lesson) {
            $lessonAnyStatus = Lesson::where('id', $request->lesson_id)
                ->where('course_id', $request->course_id)
                ->first();

            Log::warning('lesson.complete.invalid_lesson', [
                'user_id' => auth()->id(),
                'course_id' => (int) $request->course_id,
                'lesson_id' => (int) $request->input('lesson_id'),
                'lesson_found_active' => false,
                'lesson_found_any_status' => (bool) $lessonAnyStatus,
                'lesson_status' => $lessonAnyStatus?->status,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid lesson',
            ], 404);
        }

        try {
            LessonCompletion::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'course_id' => (int) $request->course_id,
                    'lesson_id' => (int) $request->lesson_id,
                ],
                [
                    'completed_at' => now(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('lesson.complete.persist_failed', [
                'user_id' => auth()->id(),
                'course_id' => (int) $request->course_id,
                'lesson_id' => (int) $request->lesson_id,
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to save lesson progress',
            ], 500);
        }

        $total = Lesson::where('course_id', $request->course_id)->where('status', 1)->count();
        $completed = LessonCompletion::where('user_id', auth()->id())
            ->where('course_id', $request->course_id)
            ->count();

        $percent = $total > 0 ? (int) floor(($completed / $total) * 100) : 0;

        if ($debug) {
            Log::info('lesson.complete.ok', [
                'user_id' => auth()->id(),
                'course_id' => (int) $request->course_id,
                'lesson_id' => (int) $request->lesson_id,
                'percent' => $percent,
                'completed' => $completed,
                'total' => $total,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'percent' => $percent,
            'completed' => $completed,
            'total' => $total,
            'lesson_id' => (int) $request->lesson_id,
        ]);
    }

    public function incomplete(Request $request)
    {
        $request->validate([
            'course_id' => 'required|integer',
            'lesson_id' => 'required|integer',
        ]);

        $enroll = Enroll::where('course_id', $request->course_id)
            ->where('user_id', auth()->id())
            ->where('status', 1)
            ->first();

        if (!$enroll) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not enrolled in this course',
            ], 403);
        }

        $lesson = Lesson::where('id', $request->lesson_id)
            ->where('course_id', $request->course_id)
            ->where('status', 1)
            ->first();

        if (!$lesson) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid lesson',
            ], 404);
        }

        LessonCompletion::where('user_id', auth()->id())
            ->where('course_id', (int) $request->course_id)
            ->where('lesson_id', (int) $request->lesson_id)
            ->delete();

        $total = Lesson::where('course_id', $request->course_id)->where('status', 1)->count();
        $completed = LessonCompletion::where('user_id', auth()->id())
            ->where('course_id', $request->course_id)
            ->count();

        $percent = $total > 0 ? (int) floor(($completed / $total) * 100) : 0;

        return response()->json([
            'status' => 'success',
            'percent' => $percent,
            'completed' => $completed,
            'total' => $total,
            'lesson_id' => (int) $request->lesson_id,
        ]);
    }
}

