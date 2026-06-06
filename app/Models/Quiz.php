<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
<<<<<<< HEAD
    protected $fillable = ['title', 'duration_minutes', 'deadline', 'segment', 'class_id', 'created_by'];

    protected $casts = [
        'deadline' => 'datetime',
    ];
=======
    protected $fillable = ['title', 'duration_minutes', 'segment', 'class_id', 'created_by'];

>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
