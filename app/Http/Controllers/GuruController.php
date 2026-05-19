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
                'cover_image_url' => 'nullable|url',
                'cover_image_file' => 'nullable|image|max:4096'
            ]);

            $coverImage = null;
            if ($request->hasFile('cover_image_file')) {
                $coverImage = $request->file('cover_image_file')->store('covers', 'public');
            } elseif (!empty($data['cover_image_url'])) {
                $coverImage = $data['cover_image_url'];
            }

            Classroom::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'cover_image' => $coverImage,
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
        $data = $request->validate([
            'name' => 'required', 
            'description' => 'nullable',
            'cover_image_url' => 'nullable|url',
            'cover_image_file' => 'nullable|image|max:4096'
        ]);

        $coverImage = $classroom->cover_image;
        if ($request->hasFile('cover_image_file')) {
            if ($coverImage && !str_starts_with($coverImage, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($coverImage);
            }
            $coverImage = $request->file('cover_image_file')->store('covers', 'public');
        } elseif ($request->filled('cover_image_url')) {
            if ($coverImage && !str_starts_with($coverImage, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($coverImage);
            }
            $coverImage = $data['cover_image_url'];
        }

        $classroom->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'cover_image' => $coverImage
        ]);
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

    public function updateMateri(Request $request, Material $material)
    {
        $classroom = Classroom::findOrFail($material->class_id);
        abort_if($classroom->created_by !== auth()->id(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'segment' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf,doc,docx|max:4096',
        ]);

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material->update([
            'title' => $data['title'],
            'segment' => $data['segment'] ?? null,
            'description' => $data['description'] ?? null,
            'link_url' => $data['link_url'] ?? null,
            'file_path' => $data['file_path'] ?? $material->file_path,
        ]);

        return back()->with('success', 'Materi diperbarui.');
    }

    public function deleteMateri(Material $material)
    {
        $classroom = Classroom::findOrFail($material->class_id);
        abort_if($classroom->created_by !== auth()->id(), 403);

        if ($material->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return back()->with('success', 'Materi dihapus.');
    }

    public function pengumuman(Request $request, Classroom $classroom)
    {
        $data = $request->validate(['title' => 'required', 'content' => 'required']);
        Announcement::create([...$data, 'class_id' => $classroom->id, 'created_by' => auth()->id()]);
        return back()->with('success', 'Pengumuman dibuat.');
    }

    public function updatePengumuman(Request $request, Classroom $classroom, Announcement $announcement)
    {
        abort_if($classroom->created_by !== auth()->id() || $announcement->class_id !== $classroom->id, 403);
        $data = $request->validate(['title' => 'required', 'content' => 'required']);
        $announcement->update($data);
        return back()->with('success', 'Pengumuman diperbarui.');
    }

    public function deletePengumuman(Classroom $classroom, Announcement $announcement)
    {
        abort_if($classroom->created_by !== auth()->id() || $announcement->class_id !== $classroom->id, 403);
        $announcement->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }

    public function tugas(Request $request, Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'title' => 'required',
                'segment' => 'nullable|string',
                'description' => 'nullable',
                'deadline' => 'required|date',
                'file' => 'nullable|file|max:4096',
                'question_bank_ids' => 'nullable|array',
                'question_bank_ids.*' => 'integer|exists:question_bank_questions,id',
            ]);

            $assignment = Assignment::create([
                'title' => $data['title'],
                'segment' => $data['segment'] ?? null,
                'description' => $data['description'] ?? null,
                'deadline' => $data['deadline'],
                'file_path' => $request->hasFile('file') ? $request->file('file')->store('assignments', 'public') : null,
                'class_id' => $classroom->id,
                'created_by' => auth()->id(),
            ]);

            $qbIds = array_values(array_unique($data['question_bank_ids'] ?? []));
            if (count($qbIds) > 0) {
                $validIds = \App\Models\QuestionBankQuestion::where('class_id', $classroom->id)
                    ->whereIn('id', $qbIds)
                    ->pluck('id')
                    ->all();

                foreach (array_values($validIds) as $pos => $qbId) {
                    \Illuminate\Support\Facades\DB::table('assignment_question_bank_refs')->updateOrInsert(
                        ['assignment_id' => $assignment->id, 'question_bank_question_id' => $qbId],
                        ['position' => $pos, 'created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            return back()->with('success', 'Tugas dibuat.');
        }

        $bankQuestions = \App\Models\QuestionBankQuestion::where('class_id', $classroom->id)
            ->latest()
            ->get(['id', 'type', 'question_text']);

        $assignments = Assignment::where('class_id', $classroom->id)
            ->with(['submissions', 'questionBankReferences'])
            ->latest()
            ->get();

        return view('tugas.index', compact('assignments', 'classroom', 'bankQuestions'));
    }

    public function nilai(Request $request, Submission $submission)
    {
        $submission->update($request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]));

        // Automatically trigger EWS analysis for this student
        \App\Services\EWSService::analyzeStudent($submission->student_id, $submission->assignment->class_id);

        return back()->with('success', 'Nilai disimpan.');
    }

    public function anggota(Request $request, Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);
        if ($request->has('remove_student_id')) {
            $classroom->members()->detach($request->remove_student_id);
            return back()->with('success', 'Siswa dihapus dari kelas.');
        }

        $student = User::where('role', 'siswa')->find($request->student_id);
        if ($student) {
            $classroom->members()->syncWithoutDetaching([$student->id]);
            return back()->with('success', 'Siswa berhasil ditambahkan.');
        }

        return back()->withErrors(['student_id' => 'Siswa tidak ditemukan.']);
    }

    public function searchStudents(Request $request)
    {
        $term = $request->query('q');
        if (!$term) {
            return response()->json([]);
        }

        $students = User::where('role', 'siswa')
            ->where(function($q) use ($term) {
                $q->where('student_code', 'like', "%{$term}%")
                  ->orWhere('name', 'like', "%{$term}%");
            })
            ->take(5)
            ->get(['id', 'name', 'student_code']);
            
        return response()->json($students);
    }

    public function kuis(Request $request, Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'title' => 'required',
                'segment' => 'nullable|string',
                'duration_minutes' => 'required|integer|min:1',
                'deadline' => 'required|date',
                'question_bank_ids' => 'nullable|array',
                'question_bank_ids.*' => 'integer|exists:question_bank_questions,id',
            ]);

            $quiz = Quiz::create([...$data, 'class_id' => $classroom->id, 'created_by' => auth()->id()]);

            $qbIds = array_values(array_unique($data['question_bank_ids'] ?? []));
            if (count($qbIds) > 0) {
                $bankQuestions = \App\Models\QuestionBankQuestion::where('class_id', $classroom->id)
                    ->whereIn('id', $qbIds)
                    ->get();

                foreach ($bankQuestions as $bq) {
                    Question::create([
                        'quiz_id' => $quiz->id,
                        'question_bank_question_id' => $bq->id,
                        'question_text' => $bq->question_text,
                        'option_a' => $bq->option_a ?? '',
                        'option_b' => $bq->option_b ?? '',
                        'option_c' => $bq->option_c ?? '',
                        'option_d' => $bq->option_d ?? '',
                        'correct_answer' => $bq->correct_answer ?? 'a',
                    ]);
                }
            }

            foreach ($request->input('questions', []) as $index => $row) {
                $questionText = trim((string) ($row['question'] ?? ''));
                if ($questionText === '') continue;

                $imagePath = null;
                if ($request->hasFile("questions.{$index}.image")) {
                    $imagePath = $request->file("questions.{$index}.image")->store('questions', 'public');
                }

                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionText,
                    'image_path' => $imagePath,
                    'option_a' => $row['options']['a'] ?? '',
                    'option_b' => $row['options']['b'] ?? '',
                    'option_c' => $row['options']['c'] ?? '',
                    'option_d' => $row['options']['d'] ?? '',
                    'correct_answer' => $row['correct'] ?? 'a',
                ]);
            }

            return back()->with('success', 'Kuis dibuat.');
        }

        $bankQuestions = \App\Models\QuestionBankQuestion::where('class_id', $classroom->id)
            ->latest()
            ->get(['id', 'type', 'question_text']);

        $quizzes = Quiz::where('class_id', $classroom->id)
            ->with(['questions', 'attempts.student'])
            ->withCount('questions')
            ->get();

        return view('kuis.index', compact('quizzes', 'classroom', 'bankQuestions'));
    }

    public function bankSoal(Request $request, Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);

        $query = \App\Models\QuestionBankQuestion::where('class_id', $classroom->id)
            ->with('tags')
            ->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('q')) {
            $q = '%' . $request->string('q')->toString() . '%';
            $query->where(function ($sub) use ($q) {
                $sub->where('question_text', 'like', $q)
                    ->orWhereHas('tags', fn ($t) => $t->where('name', 'like', $q));
            });
        }

        $questions = $query->get();

        return view('kuis.bank-soal', compact('classroom', 'questions'));
    }

    public function createBankSoal(Request $request, Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);

        $data = $request->validate([
            'type' => 'required|in:mcq,essay',
            'question_text' => 'required|string',
            'option_a' => 'nullable|string',
            'option_b' => 'nullable|string',
            'option_c' => 'nullable|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'nullable|in:a,b,c,d',
            'explanation' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        if ($data['type'] === 'mcq') {
            foreach (['option_a', 'option_b', 'option_c', 'option_d'] as $opt) {
                if (!isset($data[$opt]) || trim((string) $data[$opt]) === '') {
                    return back()->withErrors([$opt => 'Opsi wajib diisi untuk pilihan ganda.'])->withInput();
                }
            }
            if (!isset($data['correct_answer'])) {
                return back()->withErrors(['correct_answer' => 'Jawaban benar wajib dipilih untuk pilihan ganda.'])->withInput();
            }
        }

        $question = \App\Models\QuestionBankQuestion::create([
            'class_id' => $classroom->id,
            'created_by' => auth()->id(),
            'type' => $data['type'],
            'question_text' => $data['question_text'],
            'option_a' => $data['type'] === 'mcq' ? ($data['option_a'] ?? null) : null,
            'option_b' => $data['type'] === 'mcq' ? ($data['option_b'] ?? null) : null,
            'option_c' => $data['type'] === 'mcq' ? ($data['option_c'] ?? null) : null,
            'option_d' => $data['type'] === 'mcq' ? ($data['option_d'] ?? null) : null,
            'correct_answer' => $data['type'] === 'mcq' ? ($data['correct_answer'] ?? null) : null,
            'explanation' => $data['explanation'] ?? null,
        ]);

        $tags = collect(explode(',', (string) ($data['tags'] ?? '')))
            ->map(fn ($t) => trim($t))
            ->filter();

        if ($tags->count() > 0) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = \App\Models\QuestionBankTag::firstOrCreate(
                    ['class_id' => $classroom->id, 'name' => $tagName],
                    ['created_by' => auth()->id()]
                );
                $tagIds[] = $tag->id;
            }
            $question->tags()->sync($tagIds);
        }

        return back()->with('success', 'Soal ditambahkan ke bank soal.');
    }

    public function deleteBankSoal(Classroom $classroom, \App\Models\QuestionBankQuestion $question)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);
        abort_if($question->class_id !== $classroom->id, 404);

        $question->delete();

        return back()->with('success', 'Soal dihapus.');
    }

    public function presensi(Request $request, Classroom $classroom)
    {
        foreach ($request->input('records', []) as $studentId => $status) {
            Attendance::updateOrCreate(
                ['class_id' => $classroom->id, 'student_id' => $studentId, 'date' => now()->startOfDay()],
                ['status' => $status]
            );
        }

        // Automatically trigger EWS analysis for all students in this class
        \App\Services\EWSService::analyzeClass($classroom->id);

        return back()->with('success', 'Presensi tersimpan.');
    }

    public function monitoring(Classroom $classroom)
    {
        abort_if($classroom->created_by !== auth()->id(), 403);

        $students = $classroom->members()->where('role', 'siswa')->get();
        $labels = [];
        $scores = [];
        $attRates = [];
        $data = [];

        foreach ($students as $student) {
            $labels[] = $student->name;

            $avgAssignment = Submission::where('student_id', $student->id)
                ->whereHas('assignment', fn ($q) => $q->where('class_id', $classroom->id))
                ->avg('grade');

            $avgQuiz = \App\Models\QuizAttempt::where('student_id', $student->id)
                ->whereHas('quiz', fn ($q) => $q->where('class_id', $classroom->id))
                ->avg('score');

            $totalGrades = [];
            if ($avgAssignment !== null) $totalGrades[] = $avgAssignment;
            if ($avgQuiz !== null) $totalGrades[] = $avgQuiz;
            $avgNilai = count($totalGrades) > 0 ? round(array_sum($totalGrades) / count($totalGrades), 2) : 0;
            $scores[] = $avgNilai;

            $hadir = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'hadir')->count();
            $izin = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'izin')->count();
            $alpa = Attendance::where('class_id', $classroom->id)->where('student_id', $student->id)->where('status', 'alpa')->count();
            $sakit = 0; // status ini belum ada di skema attendances

            $total = $hadir + $sakit + $izin + $alpa;
            $presensi = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
            $attRates[] = $presensi;

            $risk = \App\Models\RiskFlag::where('student_id', $student->id)
                ->where('class_id', $classroom->id)
                ->where('status', 'open')
                ->first();

            $data[] = [
                'student' => $student,
                'avgNilai' => $avgNilai,
                'presensi' => $presensi,
                'kehadiran' => [
                    'hadir' => $hadir,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpa' => $alpa,
                    'total' => $total,
                ],
                'risk' => $risk,
            ];
        }

        return view('monitoring.index', compact('classroom', 'labels', 'scores', 'attRates', 'data'));
    }

    public function remedial(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:users,id',
            'assignment_ids' => 'nullable|array',
            'assignment_ids.*' => 'integer|exists:assignments,id',
            'quiz_ids' => 'nullable|array',
            'quiz_ids.*' => 'integer|exists:quizzes,id',
            'deadline' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $classroom = Classroom::findOrFail((int) $data['class_id']);
        abort_if($classroom->created_by !== auth()->id(), 403);

        $studentId = (int) $data['student_id'];
        $deadline = $data['deadline'];
        $note = $data['note'] ?? null;
        $assignmentIds = array_values(array_unique($data['assignment_ids'] ?? []));
        $quizIds = array_values(array_unique($data['quiz_ids'] ?? []));

        if (count($assignmentIds) === 0 && count($quizIds) === 0) {
            RemedialTask::create([
                'assignment_id' => null,
                'quiz_id' => null,
                'class_id' => $classroom->id,
                'student_id' => $studentId,
                'created_by' => auth()->id(),
                'deadline' => $deadline,
                'note' => $note,
                'status' => 'assigned',
            ]);

            return back()->with('success', 'Program remedial umum diberikan.');
        }

        if (count($assignmentIds) > 0) {
            $validAssignmentIds = Assignment::where('class_id', $classroom->id)
                ->whereIn('id', $assignmentIds)
                ->pluck('id')
                ->all();

            foreach ($validAssignmentIds as $assignmentId) {
                RemedialTask::updateOrCreate(
                    ['student_id' => $studentId, 'assignment_id' => $assignmentId, 'quiz_id' => null, 'class_id' => $classroom->id],
                    [
                        'created_by' => auth()->id(),
                        'deadline' => $deadline,
                        'note' => $note,
                        'status' => 'assigned',
                    ]
                );
            }
        }

        if (count($quizIds) > 0) {
            $validQuizIds = Quiz::where('class_id', $classroom->id)
                ->whereIn('id', $quizIds)
                ->pluck('id')
                ->all();

            foreach ($validQuizIds as $quizId) {
                RemedialTask::updateOrCreate(
                    ['student_id' => $studentId, 'quiz_id' => $quizId, 'assignment_id' => null, 'class_id' => $classroom->id],
                    [
                        'created_by' => auth()->id(),
                        'deadline' => $deadline,
                        'note' => $note,
                        'status' => 'assigned',
                    ]
                );
            }
        }

        return back()->with('success', 'Program remedial diberikan.');
    }

    public function analisisRisiko(Classroom $classroom)
    {
        \App\Services\EWSService::analyzeClass($classroom->id);
        return back()->with('success', 'Analisis EWS (Deteksi Risiko) selesai dijalankan secara otomatis.');
    }
    public function updateKelompok(Request $request, Classroom $classroom, Group $group)
    {
        abort_if($classroom->created_by !== auth()->id() || $group->class_id !== $classroom->id, 403);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'nullable|array'
        ]);

        $group->update(['name' => $data['name']]);
        if ($request->has('members')) {
            $group->members()->sync($data['members']);
        }
        
        return back()->with('success', 'Kelompok diperbarui.');
    }

    public function deleteKelompok(Classroom $classroom, Group $group)
    {
        abort_if($classroom->created_by !== auth()->id() || $group->class_id !== $classroom->id, 403);
        $group->delete();
        return back()->with('success', 'Kelompok dihapus.');
    }

    public function updateTugas(Request $request, Assignment $assignment)
    {
        $classroom = Classroom::findOrFail($assignment->class_id);
        abort_if($classroom->created_by !== auth()->id(), 403);

        $data = $request->validate([
            'title' => 'required',
            'segment' => 'nullable|string',
            'description' => 'nullable',
            'deadline' => 'required|date',
            'file' => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('file')) {
            if ($assignment->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($assignment->file_path);
            }
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update($data);
        return back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function deleteTugas(Assignment $assignment)
    {
        $classroom = Classroom::findOrFail($assignment->class_id);
        abort_if($classroom->created_by !== auth()->id(), 403);
        
        if ($assignment->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($assignment->file_path);
        }
        
        $assignment->delete();
        return back()->with('success', 'Tugas berhasil dihapus.');
    }

    public function updateKuis(Request $request, Quiz $quiz)
    {
        $classroom = Classroom::findOrFail($quiz->class_id);
        abort_if($classroom->created_by !== auth()->id(), 403);

        $data = $request->validate([
            'title' => 'required',
            'duration_minutes' => 'required|integer|min:5',
            'deadline' => 'required|date',
        ]);

        $quiz->update($data);

        $existingQuestionIds = [];

        foreach ($request->input('questions', []) as $index => $row) {
            $questionText = trim((string) ($row['question'] ?? ''));
            if ($questionText === '') continue;

            $questionId = $row['id'] ?? null;
            $imagePath = null;

            if ($questionId) {
                $question = Question::find($questionId);
                if ($question && $question->quiz_id === $quiz->id) {
                    $existingQuestionIds[] = $question->id;
                    $imagePath = $question->image_path;

                    if ($request->hasFile("questions.{$index}.image")) {
                        if ($imagePath) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = $request->file("questions.{$index}.image")->store('questions', 'public');
                    }

                    $question->update([
                        'question_text' => $questionText,
                        'image_path' => $imagePath,
                        'option_a' => $row['options']['a'] ?? '',
                        'option_b' => $row['options']['b'] ?? '',
                        'option_c' => $row['options']['c'] ?? '',
                        'option_d' => $row['options']['d'] ?? '',
                        'correct_answer' => $row['correct'] ?? 'a',
                    ]);
                }
            } else {
                if ($request->hasFile("questions.{$index}.image")) {
                    $imagePath = $request->file("questions.{$index}.image")->store('questions', 'public');
                }

                $newQ = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionText,
                    'image_path' => $imagePath,
                    'option_a' => $row['options']['a'] ?? '',
                    'option_b' => $row['options']['b'] ?? '',
                    'option_c' => $row['options']['c'] ?? '',
                    'option_d' => $row['options']['d'] ?? '',
                    'correct_answer' => $row['correct'] ?? 'a',
                ]);
                $existingQuestionIds[] = $newQ->id;
            }
        }

        $questionsToDelete = Question::where('quiz_id', $quiz->id)
            ->whereNotIn('id', $existingQuestionIds)
            ->get();
            
        foreach ($questionsToDelete as $qt) {
            if ($qt->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($qt->image_path);
            }
            $qt->delete();
        }

        return back()->with('success', 'Kuis berhasil diperbarui.');
    }

    public function deleteKuis(Quiz $quiz)
    {
        $classroom = Classroom::findOrFail($quiz->class_id);
        abort_if($classroom->created_by !== auth()->id(), 403);
        $quiz->delete();
        return back()->with('success', 'Kuis berhasil dihapus.');
    }
}
