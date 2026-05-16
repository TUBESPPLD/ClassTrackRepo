<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Submission;
use Illuminate\Http\Request;

class SiswaController extends Controller
{


    public function dashboard()
    {
        $user = auth()->user();
        $classes = $user->memberClasses()->where('is_hidden', false)->get();
        $riskFlags = \App\Models\RiskFlag::where('student_id', $user->id)
            ->where('status', 'open')
            ->with('classroom')
            ->get();
            
        return view('dashboard-siswa', compact('classes', 'riskFlags'));
    }

    public function joinKelas(Request $request)
    {
        $request->validate(['class_code' => 'required']);
        $classroom = Classroom::where('class_code', $request->class_code)->where('is_hidden', false)->firstOrFail();
        $classroom->members()->syncWithoutDetaching([auth()->id()]);
        return back()->with('success', 'Berhasil join kelas.');
    }

    public function showKelas(Classroom $classroom)
    {
        abort_unless($classroom->members->contains(auth()->id()), 403);
        abort_if($classroom->is_hidden, 404, 'Kelas sedang disembunyikan.');
        $classroom->load(['materials', 'announcements', 'assignments', 'quizzes']);
        return view('kelas.show-siswa', compact('classroom'));
    }

    public function submissionTugas(Request $request, Assignment $assignment)
    {
        $request->validate(['file' => 'required|file|max:4096']);
        $submittedAt = now();
        
        if ($submittedAt->gt($assignment->deadline)) {
            return back()->withErrors(['file' => 'Gagal mengumpulkan: Batas waktu tugas sudah terlewat.']);
        }

        Submission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => auth()->id()],
            [
                'file_path' => $request->file('file')->store('submissions', 'public'),
                'submitted_at' => $submittedAt,
                'status' => 'TEPAT_WAKTU',
            ]
        );
        return back()->with('success', 'Tugas dikumpulkan.');
    }

    public function kerjakanKuis(Request $request, Quiz $quiz)
    {
        if ($request->isMethod('post')) {
            $answers = $request->input('answers', []);
            $questions = Question::where('quiz_id', $quiz->id)->get();
            $correct = 0;
            foreach ($questions as $question) {
                if (($answers[$question->id] ?? null) === $question->correct_answer) {
                    $correct++;
                }
            }
            $score = $questions->count() ? ($correct / $questions->count()) * 100 : 0;
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'student_id' => auth()->id(),
                'score' => $score,
                'started_at' => now()->subMinutes($quiz->duration_minutes),
                'submitted_at' => now(),
                'answers_json' => $answers,
            ]);

            // Automatically trigger EWS analysis for this student
            \App\Services\EWSService::analyzeStudent(auth()->id(), $quiz->class_id);

            return redirect()->route('siswa.nilai')->with('success', 'Kuis selesai.');
        }

        return view('kuis.kerjakan', ['quiz' => $quiz->load('questions')]);
    }

    public function lihatNilai()
    {
        $studentId = auth()->id();
        $assignmentScores = Submission::where('student_id', $studentId)
            ->whereHas('assignment.classroom', function ($q) {
                $q->where('is_hidden', false);
            })
            ->with('assignment.classroom')
            ->get();
            
        $quizScores = QuizAttempt::where('student_id', $studentId)
            ->whereHas('quiz.classroom', function ($q) {
                $q->where('is_hidden', false);
            })
            ->with('quiz.classroom')
            ->get();

        return view('tugas.submission', compact('assignmentScores', 'quizScores'));
    }
}
