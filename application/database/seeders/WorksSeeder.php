<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class WorksSeeder extends Seeder
{
    /**
     * Seed "How It Works" section content and elements.
     */
    public function run(): void
    {
        $existingContent = Frontend::where('data_keys', 'works.content')
            ->orderByDesc('id')
            ->first();

        $image = '';
        $link = '';
        $icon = '<i class="fa-solid fa-play"></i>';

        if ($existingContent && isset($existingContent->data_values)) {
            $image = (string) ($existingContent->data_values->image ?? '');
            $link = (string) ($existingContent->data_values->link ?? '');
            $icon = (string) ($existingContent->data_values->icon ?? $icon);
        }

        $contentPayload = [
            'title' => 'How It Works',
            'subheading' => 'Start learning in a few simple steps: enroll in the right course, follow structured lessons, complete quizzes, and track your progress until completion.',
            'image' => $image,
            'link' => $link,
            'icon' => $icon,
        ];

        if ($existingContent) {
            $existingContent->data_values = $contentPayload;
            $existingContent->save();
        } else {
            Frontend::create([
                'data_keys' => 'works.content',
                'data_values' => $contentPayload,
            ]);
        }

        $steps = [
            [
                'title' => 'Choose the Right Course',
                'short_des' => 'Browse categories, review curriculum and ratings, then pick a course that matches your current level and learning goal.',
            ],
            [
                'title' => 'Enroll and Start Lessons',
                'short_des' => 'Enroll instantly and begin step-by-step lessons. Use notes while learning so important points are saved for revision.',
            ],
            [
                'title' => 'Complete Tasks and Quizzes',
                'short_des' => 'Mark lessons complete, attempt quizzes, and use feedback to strengthen weak areas before moving to advanced topics.',
            ],
            [
                'title' => 'Track Progress and Finish',
                'short_des' => 'Monitor your course progress in real time and complete all required lessons to confidently finish the course.',
            ],
        ];

        Frontend::where('data_keys', 'works.element')->delete();

        foreach ($steps as $step) {
            Frontend::create([
                'data_keys' => 'works.element',
                'data_values' => [
                    'title' => $step['title'],
                    'short_des' => $step['short_des'],
                ],
            ]);
        }
    }
}
