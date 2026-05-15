<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\Material;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\RemedialTask;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    public function dashboard()
    {
        $guruId = auth()->id();
        return view('dashboard-guru', [
            'kelas' => Classroom::where('created_by', $guruId)->count(),
            'tugas' => Assignment::where('created_by', $guruId)->count(),
            'kuis' => Quiz::where('created_by', $guruId)->count(),
            'materi' => Material::where('created_by', $guruId)->count(),
            'recentClasses' => Classroom::where('created_by', $guruId)->latest()->take(3)->get(),
        ]);
    }

    public function kelolaKelas(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'name' => 'required', 
                'description' => 'nullable',
                'cover_image' => 'nullable|url'
            ]);
            Classroom::create([
                ...$data,
                'class_code' => 'CLS-' . strtoupper(Str::random(6)),
                'created_by' => auth()->id(),
            ]);
            return back()->with('success', 'Kelas dibuat.');
        }

        return view('kelas.index', ['classes' => Classroom::where('created_by', auth()->id())->get()]);
    }

    public function showKelas(Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);
        $classroom->load(['members', 'groups.members', 'materials', 'announcements', 'assignments.submissions', 'quizzes.attempts']);
        return view('kelas.show-guru', compact('classroom'));
    }

    public function updateKelas(Request $request, Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);
        $classroom->update($request->validate([
            'name' => 'required', 
            'description' => 'nullable',
            'cover_image' => 'nullable|url'
        ]));
        return back()->with('success', 'Kelas diperbarui.');
    }

    public function toggleVisibility(Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);
        $classroom->update(['is_hidden' => !$classroom->is_hidden]);
        return back()->with('success', $classroom->is_hidden ? 'Kelas disembunyikan.' : 'Kelas ditampilkan.');
    }

    public function deleteKelas(Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);
        $classroom->delete();
        return back()->with('success', 'Kelas dihapus.');
    }

    public function anggotaKelas(Request $request, Classroom $classroom)
    {
        if ($request->filled('student_id')) {
            $classroom->members()->syncWithoutDetaching([$request->student_id]);
        }
        if ($request->filled('remove_student_id')) {
            $classroom->members()->detach($request->remove_student_id);
        }
        return back()->with('success', 'Anggota kelas diperbarui.');
    }

    public function kelompok(Request $request, Classroom $classroom)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_auto_shuffle' => 'nullable|boolean',
            'shuffle_count' => 'nullable|integer|min:2'
        ]);
        
        if ($request->input('is_auto_shuffle')) {
            $students = $classroom->members()->where('role', 'siswa')->inRandomOrder()->get();
            $count = $request->input('shuffle_count', 2);
            $chunks = $students->chunk(ceil($students->count() / $count));
            
            foreach ($chunks as $index => $chunk) {
                $group = Group::create(['name' => $data['name'] . ' ' . ($index + 1), 'class_id' => $classroom->id]);
                $group->members()->sync($chunk->pluck('id')->toArray());
            }
            return back()->with('success', 'Kelompok berhasil diacak dan dibuat.');
        } else {
            $group = Group::create(['name' => $data['name'], 'class_id' => $classroom->id]);
            $group->members()->sync($request->input('members', []));
            return back()->with('success', 'Kelompok dibuat.');
        }
    }

    public function materi(Request $request, Classroom $classroom)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'segment' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf,doc,docx|max:4096',
        ]);
        $path = $request->hasFile('file') ? $request->file('file')->store('materials', 'public') : '';
        Material::create([
            'title' => $data['title'],
            'segment' => $data['segment'] ?? null,
            'description' => $data['description'] ?? null,
            'link_url' => $data['link_url'] ?? null,
            'file_path' => $path,
            'class_id' => $classroom->id,
            'created_by' => auth()->id(),
        ]);
        return back()->with('success', 'Materi diunggah.');
    }

    public function pengumuman(Request $request, Classroom $classroom)
    {
        $data = $request->validate(['title' => 'required', 'content' => 'required']);
        Announcement::create([...$data, 'class_id' => $classroom->id, 'created_by' => auth()->id()]);
        return back()->with('success', 'Pengumuman dibuat.');
    }

    public function tugas(Request $request, Classroom $classroom)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'title' => 'required',
                'segment' => 'nullable|string',
                'description' => 'nullable',
                'deadline' => 'required|date',
                'file' => 'nullable|file|max:4096',
            ]);
            Assignment::create([
                'title' => $data['title'],
                'segment' => $data['segment'] ?? null,
                'description' => $data['description'] ?? null,
                'deadline' => $data['deadline'],
                'file_path' => $request->hasFile('file') ? $request->file('file')->store('assignments', 'public') : null,
                'class_id' => $classroom->id,
                'created_by' => auth()->id(),
            ]);
            return back()->with('success', 'Tugas dibuat.');
        }

        return view('tugas.index', ['assignments' => Assignment::where('class_id', $classroom->id)->latest()->get(), 'classroom' => $classroom]);
    }

    public function nilai(Request $request, Submission $submission)
    {
        $submission->update($request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]));
        return back()->with('success', 'Nilai disimpan.');
    }

    public function kuis(Request $request, Classroom $classroom)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'title' => 'required', 
                'segment' => 'nullable|string',
                'duration_minutes' => 'required|integer|min:1'
            ]);
            $quiz = Quiz::create([...$data, 'class_id' => $classroom->id, 'created_by' => auth()->id()]);
            foreach ($request->input('questions', []) as $row) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $row['question'] ?? '',
                    'option_a' => $row['options']['a'] ?? '',
                    'option_b' => $row['options']['b'] ?? '',
                    'option_c' => $row['options']['c'] ?? '',
                    'option_d' => $row['options']['d'] ?? '',
                    'correct_answer' => $row['correct'] ?? 'a',
                ]);
            }
            return back()->with('success', 'Kuis dibuat.');
        }

        return view('kuis.index', ['quizzes' => Quiz::where('class_id', $classroom->id)->with(['questions', 'attempts.student'])->withCount('questions')->get(), 'classroom' => $classroom]);
    }

    public function presensi(Request $request, Classroom $classroom)
    {
        foreach ($request->input('records', []) as $studentId => $status) {
            Attendance::updateOrCreate(
                ['class_id' => $classroom->id, 'student_id' => $studentId, 'date' => now()->startOfDay()],
                ['status' => $status]
            );
        }
        return back()->with('success', 'Presensi tersimpan.');
    }

    public function monitoring(Classroom $classroom)
    {
        $students = $classroom->members()->where('role', 'siswa')->get();
        $labels = [];
        $scores = [];
        $attRates = [];
        $data = [];
        
        foreach ($students as $student) {
            $labels[] = $student->name;
            
            $avgSubmission = Submission::where('student_id', $student->id)
                ->whereHas('assignment', fn ($q) => $q->where('class_id', $classroom->id))
                ->avg('grade') ?? 0;
            $avgQuiz = \App\Models\QuizAttempt::where('student_id', $student->id)
                ->whereHas('quiz', fn ($q) => $q->where('class_id', $classroom->id))
                ->avg('score') ?? 0;
            $avgGrade = round(($avgSubmission + $avgQuiz) / 2, 2);
            $avgGrade = Submission::where('student_id', $student->id)
                ->whereHas('assignment', fn ($q) => $q->where('class_id', $classroom->id))
                ->avg('grade') ?? 0;
            $avgGrade = round($avgGrade, 2);
            $scores[] = $avgGrade;
            
            $hadir = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'hadir')->count();
            $sakit = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'sakit')->count();
            $izin = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'izin')->count();
            $alpa = Attendance::where('class_id', $classroom->id)->where('status', 'alpa')->where('student_id', $student->id)->count();
            // Menghindari count() tanpa kondisi array, dan memastikan total diambil dari rekap
            $total = $hadir + $sakit + $izin + $alpa;
            
            $presensi = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
            $attRates[] = $presensi;
            
            $data[] = [
                'student' => $student,
                'avgNilai' => $avgGrade,
                'presensi' => $presensi,
                'kehadiran' => [
                    'hadir' => $hadir,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpa' => $alpa,
                    'total' => $total,
                ]
            ];
        }
        return view('monitoring.index', compact('classroom', 'labels', 'scores', 'attRates', 'data'));
    }

    public function remedial(Request $request)
    {
        $data = $request->validate([
            'assignment_id' => 'nullable|exists:assignments,id',
            'student_id' => 'required|exists:users,id',
            'deadline' => 'required|date',
        ]);
        RemedialTask::create([...$data, 'created_by' => auth()->id(), 'status' => 'assigned']);
        return back()->with('success', 'Remedial diberikan.');
    }
}
