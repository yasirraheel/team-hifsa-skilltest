<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Seed SEO configuration for the platform.
     */
    public function run(): void
    {
        $existingSeo = Frontend::where('data_keys', 'seo.data')
            ->orderByDesc('id')
            ->first();

        $existingImage = '';
        if ($existingSeo && isset($existingSeo->data_values->image)) {
            $existingImage = (string) $existingSeo->data_values->image;
        }

        $seoPayload = [
            'keywords' => [
                'online courses',
                'e learning platform',
                'skill development',
                'professional training',
                'learn online',
                'course progress tracking',
                'quiz based learning',
                'career focused education',
            ],
            'description' => 'Team Hifsa Skillset is an online learning platform offering practical, career-focused courses with structured lessons, quizzes, progress tracking, and learner support.',
            'social_title' => 'Team Hifsa Skillset | Learn Practical Skills Online',
            'social_description' => 'Enroll in practical online courses, track lesson progress, complete quizzes, and build real skills for career growth with Team Hifsa Skillset.',
            'image' => $existingImage,
        ];

        if ($existingSeo) {
            $existingSeo->data_values = $seoPayload;
            $existingSeo->save();
            return;
        }

        Frontend::create([
            'data_keys' => 'seo.data',
            'data_values' => $seoPayload,
        ]);
    }
}
