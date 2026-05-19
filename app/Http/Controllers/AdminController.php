<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard-admin', [
            'totalGuru' => User::where('role', 'guru')->count(),
            'totalSiswa' => User::where('role', 'siswa')->count(),
            'totalWali' => User::where('role', 'wali')->count(),
            'totalKelas' => Classroom::count(),
        ]);
    }

    public function indexUser()
    {
        return view('admin.users', ['users' => User::latest()->get()]);
    }

    public function createUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,guru,siswa,wali',
        ]);
        $data['password'] = Hash::make($data['password']);

        if ($data['role'] === 'siswa') {
            do {
                $studentCode = (string) random_int(1000000000, 9999999999);
            } while (User::where('student_code', $studentCode)->exists());
            $data['student_code'] = $studentCode;
        } elseif ($data['role'] === 'guru') {
            do {
                $studentCode = (string) random_int(100000, 999999);
            } while (User::where('student_code', $studentCode)->exists());
            $data['student_code'] = $studentCode;
        }

        User::create($data);

        return back()->with('success', 'User ditambahkan.');
    }

    public function editUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => 'required|in:admin,guru,siswa,wali',
        ]);
        $user->update($data);

        return back()->with('success', 'User diperbarui.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User dihapus.');
    }

    public function manageRelation(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|exists:users,id',
            'student_id' => 'nullable|exists:users,id',
            'class_id' => 'nullable|exists:classes,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if (!empty($data['parent_id']) && !empty($data['student_id'])) {
            \DB::table('parent_students')->updateOrInsert([
                'parent_id' => $data['parent_id'],
                'student_id' => $data['student_id'],
            ]);
        }

        if (!empty($data['class_id']) && !empty($data['teacher_id'])) {
            Classroom::whereKey($data['class_id'])->update(['created_by' => $data['teacher_id']]);
        }

        return back()->with('success', 'Relasi berhasil diatur.');
    }

    public function manageRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,guru,siswa,wali']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role diperbarui.');
    }
}
