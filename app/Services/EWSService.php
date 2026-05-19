<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\RiskFlag;
use App\Models\Submission;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Models\Classroom;

class EWSService
{
    /**
     * Analyze all students in a classroom.
     */
    public static function analyzeClass(int $classId)
    {
        $classroom = Classroom::findOrFail($classId);
        $students = $classroom->members()->where('role', 'siswa')->get();

        foreach ($students as $student) {
            self::analyzeStudent($student->id, $classId);
        }
    }

    /**
     * Analyze a specific student in a classroom.
     */
    public static function analyzeStudent(int $studentId, int $classId)
    {
        // 1. Get Assignment Data
        $totalAssignments = \App\Models\Assignment::where('class_id', $classId)->count();
        $submissionCount = Submission::where('student_id', $studentId)
            ->whereHas('assignment', fn ($q) => $q->where('class_id', $classId))
            ->count();
        $avgAssignment = Submission::where('student_id', $studentId)
            ->whereHas('assignment', fn ($q) => $q->where('class_id', $classId))
            ->avg('grade'); // Null if no submissions

        // 2. Get Quiz Data
        $totalQuizzes = \App\Models\Quiz::where('class_id', $classId)->count();
        $quizCount = QuizAttempt::where('student_id', $studentId)
            ->whereHas('quiz', fn ($q) => $q->where('class_id', $classId))
            ->count();
        $avgQuiz = QuizAttempt::where('student_id', $studentId)
            ->whereHas('quiz', fn ($q) => $q->where('class_id', $classId))
            ->avg('score'); // Null if no attempts

        // 3. Calculate Attendance Rate
        $totalAtt = Attendance::where('class_id', $classId)->where('student_id', $studentId)->count();
        $hadirAtt = Attendance::where('class_id', $classId)->where('student_id', $studentId)->where('status', 'hadir')->count();
        $attRate = $totalAtt > 0 ? ($hadirAtt / $totalAtt) * 100 : 100;

        $reasons = [];
        
        // --- ANALYSIS LOGIC ---

        // A. Performance Analysis (Grades)
        $totalGrades = [];
        if ($avgAssignment !== null) $totalGrades[] = $avgAssignment;
        if ($avgQuiz !== null) $totalGrades[] = $avgQuiz;
        
        if (count($totalGrades) > 0) {
            $avgGrade = array_sum($totalGrades) / count($totalGrades);
            if ($avgGrade < 70) {
                $reasons[] = "Nilai rata-rata rendah (" . round($avgGrade, 2) . ")";
            }
        }

        // B. Missing Work Analysis
        $missingTasks = 0;
        if ($totalAssignments > 0) $missingTasks += ($totalAssignments - $submissionCount);
        if ($totalQuizzes > 0) $missingTasks += ($totalQuizzes - $quizCount);

        if ($missingTasks > 0) {
            $reasons[] = "Ada $missingTasks tugas/kuis belum dikerjakan";
        }
        
        // C. Attendance Analysis
        if ($totalAtt >= 2 && $attRate < 80) { 
            $reasons[] = "Kehadiran rendah (" . round($attRate, 2) . "%)";
        }

        if (count($reasons) > 0) {
            RiskFlag::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $classId,
                ],
                [
                    'detected_at' => now(),
                    'reason' => implode(', ', $reasons),
                    'status' => 'open'
                ]
            );
        } else {
            // If they were at risk but now they are fine, mark as resolved
            RiskFlag::where('student_id' , $studentId)
                ->where('class_id', $classId)
                ->where('status', 'open')
                ->update(['status' => 'resolved']);
        }
    }
}
