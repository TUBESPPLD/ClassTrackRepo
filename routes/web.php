<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\WaliController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'indexUser'])->name('users');
    Route::post('/users', [AdminController::class, 'createUser'])->name('users.create');
    Route::put('/users/{user}', [AdminController::class, 'editUser'])->name('users.edit');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/relations', [AdminController::class, 'manageRelation'])->name('relations');
    Route::patch('/roles/{user}', [AdminController::class, 'manageRole'])->name('roles');
});

Route::middleware(['auth', 'guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/kelas', [GuruController::class, 'kelolaKelas'])->name('kelas');
    Route::get('/kelas/{classroom}/detail', [GuruController::class, 'showKelas'])->name('kelas.show');
    Route::put('/kelas/{classroom}', [GuruController::class, 'updateKelas'])->name('kelas.update');
    Route::patch('/kelas/{classroom}/toggle-visibility', [GuruController::class, 'toggleVisibility'])->name('kelas.toggle-visibility');
    Route::delete('/kelas/{classroom}', [GuruController::class, 'deleteKelas'])->name('kelas.delete');
    Route::post('/kelas/{classroom}/anggota', [GuruController::class, 'anggotaKelas'])->name('anggota');
    Route::post('/kelas/{classroom}/kelompok', [GuruController::class, 'kelompok'])->name('kelompok');
    Route::post('/kelas/{classroom}/materi', [GuruController::class, 'materi'])->name('materi');
    Route::post('/kelas/{classroom}/pengumuman', [GuruController::class, 'pengumuman'])->name('pengumuman');
    Route::match(['get', 'post'], '/kelas/{classroom}/tugas', [GuruController::class, 'tugas'])->name('tugas');
    Route::post('/nilai/{submission}', [GuruController::class, 'nilai'])->name('nilai');
    Route::match(['get', 'post'], '/kelas/{classroom}/kuis', [GuruController::class, 'kuis'])->name('kuis');
    Route::post('/kelas/{classroom}/presensi', [GuruController::class, 'presensi'])->name('presensi');
    Route::get('/kelas/{classroom}/monitoring', [GuruController::class, 'monitoring'])->name('monitoring');
    Route::post('/remedial', [GuruController::class, 'remedial'])->name('remedial');
});

Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::post('/join-kelas', [SiswaController::class, 'joinKelas'])->name('join');
    Route::get('/kelas/{classroom}/detail', [SiswaController::class, 'showKelas'])->name('kelas.show');
    Route::post('/tugas/{assignment}/submit', [SiswaController::class, 'submissionTugas'])->name('submit');
    Route::match(['get', 'post'], '/kuis/{quiz}', [SiswaController::class, 'kerjakanKuis'])->name('kuis');
    Route::get('/nilai', [SiswaController::class, 'lihatNilai'])->name('nilai');
});

Route::middleware(['auth'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', [WaliController::class, 'dashboardAnak'])->name('dashboard');
    Route::post('/link-student', [WaliController::class, 'linkStudent'])->name('link-student');
});


Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? '';
    return match($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
        'wali' => redirect()->route('wali.dashboard'),
        default => redirect()->route('home'),
    };
})->middleware('auth')->name('dashboard');
