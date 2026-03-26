<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Seed testimonial content and testimonial elements.
     */
    public function run(): void
    {
        $existingContent = Frontend::where('data_keys', 'testimonial.content')
            ->orderByDesc('id')
            ->first();

        $shapeOne = '';
        $shapeTwo = '';
        $shapeThree = '';

        if ($existingContent && isset($existingContent->data_values)) {
            $shapeOne = (string) ($existingContent->data_values->shape_image_one ?? '');
            $shapeTwo = (string) ($existingContent->data_values->shape_image_two ?? '');
            $shapeThree = (string) ($existingContent->data_values->shape_image_three ?? '');
        }

        if ($existingContent) {
            $existingContent->data_values = [
                'shape_image_one' => $shapeOne,
                'shape_image_two' => $shapeTwo,
                'shape_image_three' => $shapeThree,
            ];
            $existingContent->save();
        } else {
            Frontend::create([
                'data_keys' => 'testimonial.content',
                'data_values' => [
                    'shape_image_one' => '',
                    'shape_image_two' => '',
                    'shape_image_three' => '',
                ],
            ]);
        }

        $existingElements = Frontend::where('data_keys', 'testimonial.element')
            ->orderBy('id')
            ->get();

        $existingImages = [];
        foreach ($existingElements as $element) {
            $img = (string) ($element->data_values->image_one ?? '');
            if ($img !== '') {
                $existingImages[] = $img;
            }
        }

        $testimonials = [
            'I bought this course to improve my skills after office hours. The lessons are clear, practical, and helped me apply concepts directly in my real work. - Sarah M., Product Analyst',
            'The progress tracking keeps me consistent. I can pause, resume, and continue without losing momentum. It finally feels like a learning platform built for working professionals. - Ahmed R., QA Engineer',
            'What I liked most is the structure. Topics are split into small lessons, and the notes feature helps me keep key points for revision before interviews. - Priya K., Junior Developer',
            'I started as a beginner and was worried about pace. The course flow is beginner-friendly, but still deep enough to make me job-ready step by step. - Bilal H., Career Switcher',
            'The quiz and lesson completion flow made learning measurable for me. I can clearly see where I am weak and what I need to revise again. - Maria T., Computer Science Student',
            'Support response was quick when I had a payment issue. I was able to enroll the same day, and the course experience has been smooth since then. - Usman A., Freelance Designer',
        ];

        Frontend::where('data_keys', 'testimonial.element')->delete();

        foreach ($testimonials as $index => $text) {
            $fallbackImage = $existingImages[0] ?? '';
            $image = $existingImages[$index] ?? $fallbackImage;

            Frontend::create([
                'data_keys' => 'testimonial.element',
                'data_values' => [
                    'title' => $text,
                    'image_one' => $image,
                ],
            ]);
        }
    }
}
