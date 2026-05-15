<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\QuizAttempt;
use App\Models\Submission;

class WaliController extends Controller
{


    public function dashboardAnak()
    {
        $user = auth()->user();
        
        // Eager load data to prevent N+1 queries
        $user->load([
            'students.submissions', 
            'students.quizAttempts', 
            'students.attendances',
            'students.memberClasses.assignments'
        ]);

        $reports = [];

        foreach ($user->students as $student) {
            $nilaiTugas = $student->submissions->avg('grade') ?? 0;
            $nilaiKuis = $student->quizAttempts->avg('score') ?? 0;
            $avgNilai = round(($nilaiTugas + $nilaiKuis) / 2, 2);

            $total = $student->attendances->count();
            $hadir = $student->attendances->where('status', 'hadir')->count();
            $sakit = $student->attendances->where('status', 'sakit')->count();
            $izin = $student->attendances->where('status', 'izin')->count();
            $alpa = $student->attendances->where('status', 'alpa')->count();
            
            $presensi = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

            // EWS Logic: Count overdue assignments that are not submitted
            $missedAssignments = 0;
            $now = now();
            foreach ($student->memberClasses as $class) {
                foreach ($class->assignments as $assignment) {
                    if ($assignment->deadline < $now) {
                        $hasSubmitted = $student->submissions->where('assignment_id', $assignment->id)->isNotEmpty();
                        if (!$hasSubmitted) {
                            $missedAssignments++;
                        }
                    }
                }
            }

            $reports[] = [
                'student' => $student,
                'avgNilai' => $avgNilai,
                'nilaiTugas' => round($nilaiTugas, 2),
                'nilaiKuis' => round($nilaiKuis, 2),
                'presensi' => $presensi,
                'missedAssignments' => $missedAssignments,
                'attendanceData' => [$hadir, $sakit, $izin, $alpa]
            ];
        }

        return view('dashboard-wali', compact('reports'));
    }

    public function linkStudent(\Illuminate\Http\Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $student = \App\Models\User::where('email', $request->email)->where('role', 'siswa')->first();
        
        if (!$student) {
            return back()->with('error', 'Akun siswa dengan email tersebut tidak ditemukan.');
        }

        // Tautkan relasi
        auth()->user()->students()->syncWithoutDetaching([$student->id]);
        
        return back()->with('success', 'Berhasil menautkan data anak Anda.');
    }
}
