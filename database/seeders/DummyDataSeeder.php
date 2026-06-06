<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Services\EWSService;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users (Using updateOrCreate to prevent unique constraint errors)
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            ['name' => 'Admin ClassTrack', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        $guru = User::updateOrCreate(
            ['email' => 'guru@test.com'],
            ['name' => 'Bapak Guru Budi', 'password' => Hash::make('password'), 'role' => 'guru']
        );

        $siswaAman = User::updateOrCreate(
            ['email' => 'siswa1@test.com'],
            ['name' => 'Siswa Pintar (Aman)', 'password' => Hash::make('password'), 'role' => 'siswa']
        );

        $siswaBerisiko = User::updateOrCreate(
            ['email' => 'siswa2@test.com'],
            ['name' => 'Siswa Bermasalah (Berisiko)', 'password' => Hash::make('password'), 'role' => 'siswa']
        );

        $wali = User::updateOrCreate(
            ['email' => 'wali@test.com'],
            ['name' => 'Ibu Wali Murid', 'password' => Hash::make('password'), 'role' => 'wali']
        );

        // Connect Wali to Siswa Berisiko (Sync to prevent duplicates in pivot)
        $wali->students()->sync([$siswaBerisiko->id]);

        // 2. Create Classroom
        $kelas = Classroom::updateOrCreate(
            ['class_code' => 'MATH101'],
            ['name' => 'Matematika Dasar 101', 'description' => 'Kelas dasar matematika untuk pengenalan aljabar.', 'created_by' => $guru->id]
        );

        $kelas->members()->syncWithoutDetaching([$siswaAman->id, $siswaBerisiko->id]);

        // 3. Create Assignments
        $tugas1 = Assignment::updateOrCreate(
            ['title' => 'Tugas Aljabar 1', 'class_id' => $kelas->id],
            ['description' => 'Kerjakan soal halaman 10.', 'deadline' => now()->addDays(7), 'created_by' => $guru->id]
        );

        // 4. Create Submissions
        Submission::updateOrCreate(
            ['assignment_id' => $tugas1->id, 'student_id' => $siswaAman->id],
            ['file_path' => 'dummy.pdf', 'submitted_at' => now(), 'grade' => 90]
        );

        Submission::updateOrCreate(
            ['assignment_id' => $tugas1->id, 'student_id' => $siswaBerisiko->id],
            ['file_path' => 'dummy.pdf', 'submitted_at' => now(), 'grade' => 45]
        );

        // 5. Create Attendance
        $dates = [now()->subDays(3)->toDateString(), now()->subDays(2)->toDateString(), now()->subDays(1)->toDateString()];
        foreach ($dates as $date) {
            Attendance::updateOrCreate(
                ['class_id' => $kelas->id, 'student_id' => $siswaAman->id, 'date' => $date],
                ['status' => 'hadir']
            );

            Attendance::updateOrCreate(
                ['class_id' => $kelas->id, 'student_id' => $siswaBerisiko->id, 'date' => $date],
                ['status' => 'alpa']
            );
        }

        // 6. Create Quiz
        $kuis = Quiz::updateOrCreate(
            ['title' => 'Kuis Logika Dasar', 'class_id' => $kelas->id],
            ['duration_minutes' => 30, 'created_by' => $guru->id]
        );

        Question::updateOrCreate(
            ['quiz_id' => $kuis->id, 'question_text' => '1 + 1 = ?'],
            ['option_a' => '1', 'option_b' => '2', 'option_c' => '3', 'option_d' => '4', 'correct_answer' => 'b']
        );

        QuizAttempt::updateOrCreate(
            ['quiz_id' => $kuis->id, 'student_id' => $siswaAman->id],
            ['score' => 100, 'started_at' => now()->subMinutes(10), 'submitted_at' => now()]
        );

        QuizAttempt::updateOrCreate(
            ['quiz_id' => $kuis->id, 'student_id' => $siswaBerisiko->id],
            ['score' => 20, 'started_at' => now()->subMinutes(10), 'submitted_at' => now()]
        );

        // 7. Run Analysis
        EWSService::analyzeClass($kelas->id);
    }
}
