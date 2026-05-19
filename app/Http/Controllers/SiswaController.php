<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\RemedialTask;
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

        $classroom->load(['materials', 'announcements', 'assignments.questionBankReferences', 'quizzes']);

        $remedials = RemedialTask::where('student_id', auth()->id())
            ->where('class_id', $classroom->id)
            ->where('status', 'assigned')
            ->whereNotNull('assignment_id')
            ->get()
            ->keyBy('assignment_id');

        $remedialQuizzes = RemedialTask::where('student_id', auth()->id())
            ->where('class_id', $classroom->id)
            ->where('status', 'assigned')
            ->whereNotNull('quiz_id')
            ->get()
            ->keyBy('quiz_id');

        return view('kelas.show-siswa', compact('classroom', 'remedials', 'remedialQuizzes'));
    }

    public function submissionTugas(Request $request, Assignment $assignment)
    {
        $request->validate(['file' => 'required|file|max:4096']);

        $assignment->loadMissing('classroom.members');
        abort_unless($assignment->classroom->members->contains(auth()->id()), 403);

        $submittedAt = now();

        $remedial = null;
        if ($submittedAt->gt($assignment->deadline)) {
            $remedial = RemedialTask::where('student_id', auth()->id())
                ->where('assignment_id', $assignment->id)
                ->whereIn('status', ['assigned', 'completed'])
                ->orderByDesc('deadline')
                ->first();

            if (!$remedial || $submittedAt->gt($remedial->deadline)) {
                return back()->withErrors(['file' => 'Gagal mengumpulkan: Batas waktu tugas sudah terlewat.']);
            }
        }

        Submission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => auth()->id()],
            [
                'file_path' => $request->file('file')->store('submissions', 'public'),
                'submitted_at' => $submittedAt,
                'status' => $remedial ? 'REMEDIAL' : 'TEPAT_WAKTU',
            ]
        );

        if ($remedial && $remedial->status === 'assigned') {
            $remedial->update(['status' => 'completed']);
        }

        return back()->with('success', $remedial ? 'Tugas dikumpulkan (remedial).' : 'Tugas dikumpulkan.');
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

            $remedial = RemedialTask::where('student_id', auth()->id())
                ->where('quiz_id', $quiz->id)
                ->where('status', 'assigned')
                ->first();

            if ($remedial) {
                $remedial->update(['status' => 'completed']);
            }

            // Automatically trigger EWS analysis for this student
            \App\Services\EWSService::analyzeStudent(auth()->id(), $quiz->class_id);

            return redirect()->route('siswa.nilai')->with('success', $remedial ? 'Kuis (Remedial) selesai.' : 'Kuis selesai.');
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
            ->orderByDesc('created_at')
            ->get();

        return view('tugas.submission', compact('assignmentScores', 'quizScores'));
    }
}
