<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
=======
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    protected $fillable = ['title', 'description', 'segment', 'deadline', 'file_path', 'class_id', 'created_by'];

    protected $casts = ['deadline' => 'datetime'];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
<<<<<<< HEAD

    public function questionBankReferences(): BelongsToMany
    {
        return $this->belongsToMany(
            QuestionBankQuestion::class,
            'assignment_question_bank_refs',
            'assignment_id',
            'question_bank_question_id'
        )->withPivot(['position'])->orderBy('assignment_question_bank_refs.position');
    }
=======
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
}
