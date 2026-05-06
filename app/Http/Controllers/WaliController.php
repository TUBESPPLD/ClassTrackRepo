<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\QuizAttempt;
use App\Models\Submission;

class WaliController extends Controller
{


    public function dashboardAnak()
    {
        $students = auth()->user()->students;
        $reports = [];

        foreach ($students as $student) {
            $nilaiTugas = Submission::where('student_id', $student->id)->avg('grade') ?? 0;
            $nilaiKuis = QuizAttempt::where('student_id', $student->id)->avg('score') ?? 0;
            $avgNilai = round(($nilaiTugas + $nilaiKuis) / 2, 2);

            $total = Attendance::where('student_id', $student->id)->count();
            $hadir = Attendance::where('student_id', $student->id)->where('status', 'hadir')->count();
            $presensi = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

            $reports[] = compact('student', 'avgNilai', 'presensi');
        }

        return view('dashboard-wali', compact('reports'));
    }
}
