<?php

namespace App\Console\Commands;

use App\Mail\RiskAlertMail;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\QuizAttempt;
use App\Models\RiskFlag;
use App\Models\Submission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckRiskStudents extends Command
{
    protected $signature = 'classtrack:check-risk-students';
    protected $description = 'Cek siswa berisiko (nilai/presensi rendah) dan kirim notifikasi wali';

    public function handle(): int
    {
        $classes = Classroom::with(['members' => fn ($q) => $q->where('role', 'siswa')])->get();

        foreach ($classes as $classroom) {
            foreach ($classroom->members as $student) {
                $avgTugas = Submission::where('student_id', $student->id)
                    ->whereHas('assignment', fn ($q) => $q->where('class_id', $classroom->id))
                    ->avg('grade') ?? 0;
                $avgKuis = QuizAttempt::where('student_id', $student->id)
                    ->whereHas('quiz', fn ($q) => $q->where('class_id', $classroom->id))
                    ->avg('score') ?? 0;
                $avgNilai = round(($avgTugas + $avgKuis) / 2, 2);

                $total = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->count();
                $hadir = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'hadir')->count();
                $persentaseHadir = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

                if ($avgNilai < 70 || $persentaseHadir < 75) {
                    $reason = "Nilai rata-rata: {$avgNilai}, Kehadiran: {$persentaseHadir}%";
                    RiskFlag::create([
                        'student_id' => $student->id,
                        'class_id' => $classroom->id,
                        'detected_at' => now(),
                        'reason' => $reason,
                        'status' => 'open',
                    ]);

                    foreach ($student->parents as $parent) {
                        Mail::to($parent->email)->send(new RiskAlertMail($student, $classroom, $reason));
                    }
                }
            }
        }

        $this->info('Risk check selesai.');
        return self::SUCCESS;
    }
}
