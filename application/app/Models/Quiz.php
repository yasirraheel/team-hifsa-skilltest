<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quiz extends Model
{
    use HasFactory;

    static function adminQuiz()
    {
        return self::where('owner_id', auth('admin')->id())->where('owner_type', 1);
    }

    static function instructorQuiz()
    {
        return self::where('owner_type', 2);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'owner_id', 'id');
    }


    public function userQuizzes(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'quiz_user','quiz_id','user_id')->withPivot('question_id', 'mark', 'user_answer', 'correct_answer')->withTimestamps();
    }


    public function marking($items)
    {
        $correctCount = 0;
        foreach ($items->userQuizzes as $data) {
            $userAnswers = $this->normalizeAnswerPayload($data->pivot->user_answer);
            $correctAnswers = $this->normalizeAnswerPayload($data->pivot->correct_answer);

            if ($userAnswers === $correctAnswers) {
                $correctCount += (int) $data->pivot->mark;
            }
        }
        return $correctCount;
    }

    private function normalizeAnswerPayload($value): array
    {
        if (is_null($value) || $value === '') {
            return [];
        }

        if (is_array($value)) {
            $items = $value;
        } elseif (is_numeric($value)) {
            $items = [(int) $value];
        } else {
            $decoded = json_decode((string) $value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $items = $decoded;
            } else {
                $items = [(int) $value];
            }
        }

        return collect($items)
            ->map(fn ($item) => (int) $item)
            ->unique()
            ->sort()
            ->values()
            ->all();
    }


}






