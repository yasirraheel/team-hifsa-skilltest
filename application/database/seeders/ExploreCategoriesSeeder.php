<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Frontend;
use Illuminate\Database\Seeder;

class ExploreCategoriesSeeder extends Seeder
{
    /**
     * Seed Explore Categories section text and default category records.
     */
    public function run(): void
    {
        $existingContent = Frontend::where('data_keys', 'explore_categories.content')
            ->orderByDesc('id')
            ->first();

        $contentPayload = [
            'title' => 'Explore Categories',
            'subheading' => 'Choose a category that matches your goal and start a focused learning journey with practical, skill-based courses.',
        ];

        if ($existingContent) {
            $existingContent->data_values = array_merge((array) $existingContent->data_values, $contentPayload);
            $existingContent->save();
        } else {
            Frontend::create([
                'data_keys' => 'explore_categories.content',
                'data_values' => $contentPayload,
            ]);
        }

        $existingImage = Category::whereNotNull('image')
            ->where('image', '!=', '')
            ->value('image') ?? '';

        $categories = [
            'Web Development',
            'Mobile App Development',
            'Data Science',
            'Machine Learning',
            'UI UX Design',
            'Digital Marketing',
            'Business Analytics',
            'Graphic Design',
            'Cyber Security',
            'English Communication',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                [
                    'status' => 1,
                    'image' => $existingImage,
                ]
            );
        }
    }
}
