<?php

namespace App\Http\Controllers\User;

use App\Models\Course;
use App\Models\Enroll;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use App\Models\InstructorNotification;

class EnrollController extends Controller
{
    public function enrollCourses(Request $request)
    {
        $pageTitle = "Enroll Courses";
        $enrolls = Enroll::with([
            'course' => function ($query) {
                $query->with('category')->withCount(['quizzes', 'questions']);
            }
        ])->where('user_id', auth()->id())->where('status', 1)->orderBy('id', 'desc');
        if ($request->search) {
            $enrolls = $enrolls->where('name', 'like', "%$request->search%")->paginate(getPaginate());
        } else {
            $enrolls = $enrolls->paginate(getPaginate());
        }
        $courseProgress = $this->buildCourseProgress($enrolls->pluck('course_id')->unique()->values()->all());
        return view($this->activeTemplate . 'user.enrolls.courses', compact('pageTitle', 'enrolls', 'courseProgress'));
    }

    public function allCourses(Request $request)
    {
        $pageTitle = "All Courses";
        $courses = Course::with('enrolls', 'category')->withCount(['quizzes', 'questions'])->whereIn('status', [1])->orderBy('id', 'desc');
        if ($request->search) {
            $courses = $courses->where('name', 'like', "%$request->search%")->paginate(getPaginate());
        } else {
            $courses = $courses->paginate(getPaginate());
        }
        return view($this->activeTemplate . 'user.enrolls.all_courses', compact('pageTitle', 'courses'));
    }

    private function buildCourseProgress(array $courseIds): array
    {
        if (empty($courseIds)) {
            return [];
        }

        $lessonTotals = Lesson::whereIn('course_id', $courseIds)
            ->where('status', 1)
            ->selectRaw('course_id, COUNT(*) as total_lessons')
            ->groupBy('course_id')
            ->pluck('total_lessons', 'course_id');

        $completedTotals = LessonCompletion::where('user_id', auth()->id())
            ->whereIn('course_id', $courseIds)
            ->selectRaw('course_id, COUNT(DISTINCT lesson_id) as completed_lessons')
            ->groupBy('course_id')
            ->pluck('completed_lessons', 'course_id');

        $progress = [];
        foreach ($courseIds as $courseId) {
            $total = (int) ($lessonTotals[$courseId] ?? 0);
            $completed = (int) ($completedTotals[$courseId] ?? 0);
            $percent = $total > 0 ? (int) floor(($completed / $total) * 100) : 0;
            $progress[$courseId] = [
                'completed' => $completed,
                'total' => $total,
                'percent' => $percent,
            ];
        }

        return $progress;
    }


    public function enroll($id)
    {
        $pageTitle = "Enroll Course";
        $course = Course::where('id', $id)->where('status', 1)->first();
        if (!$course) {
            $notify[] = ['error', 'Your course is not valid'];
            return back()->withNotify($notify);
        }

        $existingApprovedEnroll = Enroll::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->where('status', 1)
            ->first();

        if ($existingApprovedEnroll) {
            $notify[] = ['info', 'You are already enrolled in this course'];
            return to_route('course.details', [slug($course->name), $course->id])->withNotify($notify);
        }

        $price = $course->price;
        if ($course->discount) {
            $price = priceCalculate(@$course->price, @$course->discount);
        }

        if ((float) $price <= 0) {
            $enroll = Enroll::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'course_id' => $course->id,
                ],
                [
                    'deposit_id' => 0,
                    'owner_id' => $course->owner_id,
                    'owner_type' => $course->owner_type,
                    'name' => $course->name,
                    'discount' => $course->discount,
                    'price' => $course->price,
                    'total_amount' => 0,
                    'status' => 1,
                ]
            );

            if ($enroll->owner_type == 1) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = auth()->id();
                $adminNotification->title = 'New free enrollment from ' . auth()->user()->username;
                $adminNotification->click_url = urlPath('course.details', [slug($enroll->name), $enroll->course_id]);
                $adminNotification->save();
            }

            if ($enroll->owner_type == 2) {
                $instructorNotification = new InstructorNotification();
                $instructorNotification->instructor_id = $enroll->owner_id;
                $instructorNotification->title = 'New free enrollment from ' . auth()->user()->username;
                $instructorNotification->click_url = urlPath('course.details', [slug($enroll->name), $enroll->course_id]);
                $instructorNotification->save();
            }

            $notify[] = ['success', 'Free course enrollment approved instantly'];
            return to_route('course.details', [slug($course->name), $course->id])->withNotify($notify);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();

        return view($this->activeTemplate . 'user.payment.deposit', compact('course', 'pageTitle', 'gatewayCurrency', 'price'));
    }
}
