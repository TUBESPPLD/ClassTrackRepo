<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        $request->session()->regenerate();

        return redirect()->route(auth()->user()->role . '.dashboard');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role' => ['required', 'in:guru,siswa,wali'],
        ]);

        $studentCode = null;
        if ($data['role'] === 'siswa') {
            do {
                $studentCode = (string) random_int(100000, 999999);
            } while (User::where('student_code', $studentCode)->exists());
        } elseif ($data['role'] === 'guru') {
            do {
                $studentCode = (string) random_int(100000, 999999);
            } while (User::where('student_code', $studentCode)->exists());
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'student_code' => $studentCode,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
