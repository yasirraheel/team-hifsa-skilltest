<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Seed meaningful, human-style blog entries for the platform.
     */
    public function run(): void
    {
        $existingContent = Frontend::where('data_keys', 'blog.content')
            ->orderByDesc('id')
            ->first();

        $contentPayload = [
            'title' => 'Latest Learning Insights',
            'subheading' => 'Practical articles to help students choose better courses, learn consistently, and get stronger outcomes.',
        ];

        if ($existingContent) {
            $existingContent->data_values = array_merge((array) $existingContent->data_values, $contentPayload);
            $existingContent->save();
        } else {
            Frontend::create([
                'data_keys' => 'blog.content',
                'data_values' => $contentPayload,
            ]);
        }

        $existingElements = Frontend::where('data_keys', 'blog.element')
            ->orderBy('id')
            ->get();

        $existingImages = [];
        foreach ($existingElements as $element) {
            $image = (string) ($element->data_values->blog_image ?? '');
            if ($image !== '') {
                $existingImages[] = $image;
            }
        }

        $posts = [
            [
                'title' => 'How to Choose the Right Course for Your Career Goal',
                'description' => 'Many learners waste time because they pick courses based on popularity instead of outcomes. Start with your target role, list the exact skills required, and compare those skills with the course curriculum. Review lesson depth, quiz quality, and whether the instructor explains practical workflows. The best course is not the longest one; it is the one that takes you from your current level to a clear capability you can apply in real work.',
                'blockquote' => 'Pick a course for where you want to work next, not for what is trending today.',
            ],
            [
                'title' => 'A Simple Weekly Study Plan That Actually Works',
                'description' => 'Consistency beats intensity in online learning. Block fixed study windows in your calendar, complete two to three lessons per session, and end each session with a short recap note. Use progress tracking to stay accountable and avoid skipping difficult topics. A realistic plan you can follow for twelve weeks is far more effective than an aggressive plan you quit in ten days.',
                'blockquote' => 'If your plan is sustainable, your results become predictable.',
            ],
            [
                'title' => 'Using Lesson Notes to Improve Long-Term Retention',
                'description' => 'Notes are most useful when they are short and actionable. Capture definitions in one line, write one practical example, and end with one question for revision. Keep notes attached to each lesson so review is fast before quizzes or interviews. This method helps convert passive watching into active understanding.',
                'blockquote' => 'The best notes are not longer notes, they are reusable notes.',
            ],
            [
                'title' => 'How Quiz Attempts Reveal Your Real Skill Gaps',
                'description' => 'Quizzes should not be treated as a final step; they are diagnostic tools. After each attempt, categorize mistakes into three groups: concept gap, careless mistake, and speed issue. Revisit only the lessons linked to those gaps instead of rewatching everything. This creates a focused revision loop that saves time and improves confidence.',
                'blockquote' => 'A wrong answer is useful data if you review it the right way.',
            ],
            [
                'title' => 'When to Mark a Lesson Complete and Move Forward',
                'description' => 'Mark a lesson complete when you can explain the concept in your own words and apply it in a small task. If you still depend on the video to recall basic steps, keep it pending and revisit quickly. Progress should reflect understanding, not just watch time. This keeps your completion percentage honest and meaningful.',
                'blockquote' => 'Completion is valuable only when it represents competence.',
            ],
            [
                'title' => 'From Enrollment to Completion: Staying Motivated',
                'description' => 'Motivation drops when goals are vague. Set a finish date, define weekly targets, and celebrate small milestones such as module completion and quiz improvements. Use the platform progress bar as a feedback loop, not just a visual element. Small measurable wins are what keep learners moving until the course is done.',
                'blockquote' => 'You do not need constant motivation, you need visible momentum.',
            ],
        ];

        Frontend::where('data_keys', 'blog.element')->delete();

        foreach ($posts as $index => $post) {
            $fallbackImage = $existingImages[0] ?? '';
            $image = $existingImages[$index] ?? $fallbackImage;

            Frontend::create([
                'data_keys' => 'blog.element',
                'data_values' => [
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'blockquote' => $post['blockquote'],
                    'blog_image' => $image,
                    'created_at' => now()->subDays($index + 1)->toDateString(),
                ],
            ]);
        }
    }
}
