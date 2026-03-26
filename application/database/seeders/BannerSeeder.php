<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Seed banner content and banner element cards with platform-specific copy.
     */
    public function run(): void
    {
        $existingContent = Frontend::where('data_keys', 'banner.content')
            ->orderByDesc('id')
            ->first();

        $contentDefaults = [
            'heading' => 'Build Real Skills with Practical Online Courses',
            'subheading' => 'Learn from structured lessons, track your progress in real time, attempt quizzes, and move from beginner to confident professional at your own pace.',
            'button_one_name' => 'Start Learning',
            'button_two_name' => 'Browse Courses',
            'image' => '',
            'user_image_one' => '',
            'user_image_two' => '',
            'user_image_three' => '',
            'user_image_four' => '',
        ];

        if ($existingContent && isset($existingContent->data_values)) {
            $contentDefaults['image'] = (string) ($existingContent->data_values->image ?? '');
            $contentDefaults['user_image_one'] = (string) ($existingContent->data_values->user_image_one ?? '');
            $contentDefaults['user_image_two'] = (string) ($existingContent->data_values->user_image_two ?? '');
            $contentDefaults['user_image_three'] = (string) ($existingContent->data_values->user_image_three ?? '');
            $contentDefaults['user_image_four'] = (string) ($existingContent->data_values->user_image_four ?? '');
        }

        if ($existingContent) {
            $existingContent->data_values = $contentDefaults;
            $existingContent->save();
        } else {
            Frontend::create([
                'data_keys' => 'banner.content',
                'data_values' => $contentDefaults,
            ]);
        }

        $existingElements = Frontend::where('data_keys', 'banner.element')
            ->orderBy('id')
            ->get();

        $existingImages = [];
        foreach ($existingElements as $element) {
            $image = (string) ($element->data_values->image ?? '');
            if ($image !== '') {
                $existingImages[] = $image;
            }
        }

        $cards = [
            [
                'title' => 'Explore',
                'short_des' => 'Browse available courses and pick the right learning path for your goals.',
            ],
            [
                'title' => 'Enroll',
                'short_des' => 'Enroll in your selected course and unlock the full lesson journey instantly.',
            ],
            [
                'title' => 'Learn',
                'short_des' => 'Complete lessons, take quizzes, and build practical skills step by step.',
            ],
        ];

        Frontend::where('data_keys', 'banner.element')->delete();

        foreach ($cards as $index => $card) {
            $fallbackImage = $existingImages[0] ?? '';
            $image = $existingImages[$index] ?? $fallbackImage;

            Frontend::create([
                'data_keys' => 'banner.element',
                'data_values' => [
                    'title' => $card['title'],
                    'short_des' => $card['short_des'],
                    'image' => $image,
                ],
            ]);
        }
    }
}
