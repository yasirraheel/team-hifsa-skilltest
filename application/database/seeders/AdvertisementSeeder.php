<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Seed Advertisement section content with meaningful platform-specific copy.
     */
    public function run(): void
    {
        $existingContent = Frontend::where('data_keys', 'advertisement.content')
            ->orderByDesc('id')
            ->first();

        $contentPayload = [
            'title' => 'Ready to grow your skills? Explore guided courses built for real outcomes.',
            'button_name' => 'Discover Courses',
            'url' => '/courses',
        ];

        if ($existingContent) {
            $existingContent->data_values = array_merge((array) $existingContent->data_values, $contentPayload);
            $existingContent->save();
            return;
        }

        Frontend::create([
            'data_keys' => 'advertisement.content',
            'data_values' => $contentPayload,
        ]);
    }
}
