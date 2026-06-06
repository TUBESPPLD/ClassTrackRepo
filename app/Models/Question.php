<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
<<<<<<< HEAD
        'question_bank_question_id',
        'question_text',
        'image_path',
=======
        'question_text',
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
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
<<<<<<< HEAD

    public function bankQuestion(): BelongsTo
    {
        return $this->belongsTo(QuestionBankQuestion::class, 'question_bank_question_id');
    }
=======
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
}
