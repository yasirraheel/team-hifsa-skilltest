<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Seed FAQ content and FAQ elements for the frontend.
     */
    public function run(): void
    {
        $existingFaqContent = Frontend::where('data_keys', 'faq.content')
            ->orderByDesc('id')
            ->first();

        $currentImage = '';
        if ($existingFaqContent && isset($existingFaqContent->data_values->image_one)) {
            $currentImage = (string) $existingFaqContent->data_values->image_one;
        }

        if ($existingFaqContent) {
            $existingFaqContent->data_values = [
                'title' => 'Frequently Asked Questions',
                'subtitle' => 'Important answers about enrollment, lesson progress, quizzes, payments, and account support.',
                'image_one' => $currentImage,
            ];
            $existingFaqContent->save();
        } else {
            Frontend::create([
                'data_keys' => 'faq.content',
                'data_values' => [
                    'title' => 'Frequently Asked Questions',
                    'subtitle' => 'Important answers about enrollment, lesson progress, quizzes, payments, and account support.',
                    'image_one' => '',
                ],
            ]);
        }

        $faqs = [
            [
                'question' => 'How do I enroll in a course?',
                'answer' => 'Open the course details page and click Enroll Now. After successful payment (or free enrollment), the course is added to your enrolled courses instantly.',
            ],
            [
                'question' => 'How is my course progress calculated?',
                'answer' => 'Progress is calculated from completed lessons divided by total active lessons in the course. The progress bar and percentage update after each completion or undo action.',
            ],
            [
                'question' => 'Can I mark a lesson as pending again?',
                'answer' => 'Yes. Use the Undo button on a completed lesson to mark it as pending again. Your course progress is recalculated immediately.',
            ],
            [
                'question' => 'Where can I find my lesson notes?',
                'answer' => 'Each lesson includes a Lesson Notes section where you can add, edit, and delete personal notes. Notes are saved per lesson and tied to your account.',
            ],
            [
                'question' => 'How do course quizzes work?',
                'answer' => 'If a course has quizzes, a Quiz button appears on the course page. You can attempt quizzes and your results are saved in your account history.',
            ],
            [
                'question' => 'What payment methods are supported?',
                'answer' => 'Available methods depend on admin configuration and can include options like Stripe, Razorpay, CoinGate, and manual payment gateways.',
            ],
            [
                'question' => 'Will I receive a certificate after course completion?',
                'answer' => 'Certificate availability depends on course and admin settings. If enabled, eligible learners can access their certificate from the dashboard.',
            ],
            [
                'question' => 'How can I get help if I face an issue?',
                'answer' => 'Use the support ticket section in your account to create a new ticket with details. You can track replies and continue the conversation there.',
            ],
        ];

        Frontend::where('data_keys', 'faq.element')->delete();

        foreach ($faqs as $faq) {
            Frontend::create([
                'data_keys' => 'faq.element',
                'data_values' => [
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                ],
            ]);
        }
    }
}
