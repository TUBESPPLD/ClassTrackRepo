<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        // Ambil semua user dengan role siswa atau guru yang student_code nya masih NULL atau kosong
        $users = User::whereIn('role', ['siswa', 'guru'])
            ->where(function ($query) {
                $query->whereNull('student_code')
                      ->orWhere('student_code', '');
            })
            ->get();

        foreach ($users as $user) {
            do {
                $studentCode = (string) random_int(100000, 999999);
            } while (User::where('student_code', $studentCode)->exists());

            $user->update(['student_code' => $studentCode]);
        }
    }

    public function down(): void
    {
        // Tidak diperlukan aksi khusus pada rollback karena ini hanya data backfill
    }
};
