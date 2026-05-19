<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function questionBankReferences(): BelongsToMany
    {
        return $this->belongsToMany(
            QuestionBankQuestion::class,
            'assignment_question_bank_refs',
            'assignment_id',
            'question_bank_question_id'
        )->withPivot(['position'])->orderBy('assignment_question_bank_refs.position');
    }
}
