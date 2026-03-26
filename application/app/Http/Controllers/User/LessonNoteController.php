<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonNote;
use Illuminate\Http\Request;

class LessonNoteController extends Controller
{
    public function index($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $notes = LessonNote::where('lesson_id', $lesson->id)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['status' => 'success', 'notes' => $notes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|integer|exists:lessons,id',
            'course_id' => 'required|integer|exists:courses,id',
            'content' => 'required|string|max:5000',
        ]);

        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $lesson = Lesson::where('id', $request->lesson_id)->where('course_id', $request->course_id)->first();

        if (!$lesson) {
            return response()->json(['status' => 'error', 'message' => 'Invalid lesson/course'], 404);
        }

        $note = LessonNote::create([
            'lesson_id' => $lesson->id,
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Note saved', 'note' => $note]);
    }

    public function update(Request $request, $noteId)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $note = LessonNote::where('id', $noteId)->where('user_id', auth()->id())->first();

        if (!$note) {
            return response()->json(['status' => 'error', 'message' => 'Note not found'], 404);
        }

        $note->update(['content' => $request->input('content')]);

        return response()->json(['status' => 'success', 'message' => 'Note updated', 'note' => $note]);
    }

    public function destroy($noteId)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $note = LessonNote::where('id', $noteId)->where('user_id', auth()->id())->first();

        if (!$note) {
            return response()->json(['status' => 'error', 'message' => 'Note not found'], 404);
        }

        $note->delete();

        return response()->json(['status' => 'success', 'message' => 'Note deleted']);
    }
}
