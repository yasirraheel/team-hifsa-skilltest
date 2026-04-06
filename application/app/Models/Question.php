<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $casts = [
        'options' => 'array',
        'correct_answers' => 'array',
    ];

    public function normalizedCorrectAnswers(): array
    {
        $answers = $this->correct_answers;

        if (!is_array($answers) || empty($answers)) {
            $answers = [(int) $this->correct_answer];
        }

        return collect($answers)
            ->map(fn ($item) => (int) $item)
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    public function isMultiAnswer(): bool
    {
        return count($this->normalizedCorrectAnswers()) > 1;
    }
}
