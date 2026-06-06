<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemedialTask extends Model
{
<<<<<<< HEAD
    protected $fillable = ['assignment_id', 'quiz_id', 'class_id', 'student_id', 'created_by', 'deadline', 'note', 'status'];
=======
    protected $fillable = ['assignment_id', 'student_id', 'created_by', 'deadline', 'status'];
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a

    protected $casts = ['deadline' => 'datetime'];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

<<<<<<< HEAD
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

=======
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
