<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_bank_question_id',
        'question_text',
        'image_path',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function bankQuestion(): BelongsTo
    {
        return $this->belongsTo(QuestionBankQuestion::class, 'question_bank_question_id');
    }
}
