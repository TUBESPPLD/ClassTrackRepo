<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        DB::table('parent_students')->truncate();
        DB::table('class_members')->truncate();
        DB::table('announcements')->truncate();
        DB::table('classes')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        $admin = User::create([
            'name' => 'Admin ClassTrack',
            'email' => 'admin@classtrack.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $gurus = collect([
            ['name' => 'Guru Matematika', 'email' => 'guru1@classtrack.test'],
            ['name' => 'Guru IPA', 'email' => 'guru2@classtrack.test'],
        ])->map(fn ($guru) => User::create([...$guru, 'password' => Hash::make('password'), 'role' => 'guru']));

        $students = collect(range(1, 5))->map(function ($i) {
            return User::create([
                'name' => "Siswa {$i}",
                'email' => "siswa{$i}@classtrack.test",
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);
        });

        $parents = collect([
            ['name' => 'Wali A', 'email' => 'wali1@classtrack.test'],
            ['name' => 'Wali B', 'email' => 'wali2@classtrack.test'],
        ])->map(fn ($wali) => User::create([...$wali, 'password' => Hash::make('password'), 'role' => 'wali']));

        $classA = Classroom::create([
            'name' => 'Kelas 10-A',
            'description' => 'Kelas Matematika Dasar',
            'class_code' => 'CLS-10A001',
            'created_by' => $gurus[0]->id,
        ]);
        $classB = Classroom::create([
            'name' => 'Kelas 10-B',
            'description' => 'Kelas IPA Dasar',
            'class_code' => 'CLS-10B002',
            'created_by' => $gurus[1]->id,
        ]);

        $classA->members()->sync([$students[0]->id, $students[1]->id, $students[2]->id]);
        $classB->members()->sync([$students[2]->id, $students[3]->id, $students[4]->id]);

        DB::table('parent_students')->insert([
            ['parent_id' => $parents[0]->id, 'student_id' => $students[0]->id, 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $parents[0]->id, 'student_id' => $students[1]->id, 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $parents[1]->id, 'student_id' => $students[2]->id, 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $parents[1]->id, 'student_id' => $students[3]->id, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
