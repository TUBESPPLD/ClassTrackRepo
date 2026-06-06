<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected static function booted()
    {
        static::creating(function ($user) {
            if ($user->role === 'siswa' && empty($user->student_code)) {
                do {
                    $studentCode = (string) random_int(100000, 999999);
                } while (static::where('student_code', $studentCode)->exists());
                $user->student_code = $studentCode;
            } elseif ($user->role === 'guru' && empty($user->student_code)) {
                do {
                    $studentCode = (string) random_int(100000, 999999);
                } while (static::where('student_code', $studentCode)->exists());
                $user->student_code = $studentCode;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto',
        'student_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdClasses(): HasMany
    {
        return $this->hasMany(Classroom::class, 'created_by');
    }

    public function memberClasses(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'class_members', 'user_id', 'class_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function riskFlags(): HasMany
    {
        return $this->hasMany(RiskFlag::class, 'student_id');
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_students', 'student_id', 'parent_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_students', 'parent_id', 'student_id');
    }
}
