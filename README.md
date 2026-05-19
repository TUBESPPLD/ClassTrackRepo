# CLASSTRACK

Aplikasi web manajemen pembelajaran multi-aktor (Admin, Guru, Siswa, Wali) berbasis Laravel + MySQL.

## Stack

- PHP 8.2
- Laravel
- MySQL
- Blade + Tailwind CSS (responsive)
- JavaScript (quiz countdown timer + auto-submit)
- Chart.js (monitoring dashboard)

## Fitur Utama

- Role-based access: admin, guru, siswa, wali
- CRUD user & manajemen relasi parent-student/teacher-class
- Kelas dengan kode unik format `CLS-XXXXXX`
- Materi, pengumuman, tugas, submission, penilaian, feedback
- Quiz bank soal dengan timer dan auto-submit saat habis waktu
- Presensi + rekap persentase kehadiran otomatis
- Rekap nilai otomatis dari tugas + kuis
- EWS (Early Warning System) harian untuk siswa berisiko
- Notifikasi email ke wali (menggunakan `MAIL_MAILER=log`)

## Setup

1. Install dependency:
   - `composer install`
2. Copy env:
   - `copy .env.example .env` (Windows) atau `cp .env.example .env` (Linux/Mac)
3. Atur `.env`:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=127.0.0.1`
   - `DB_PORT=3306`
   - `DB_DATABASE=classtrack`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=`
   - `MAIL_MAILER=log`
4. Generate key:
   - `php artisan key:generate`
5. Storage link:
   - `php artisan storage:link`
6. Migrasi + seeder:
   - `php artisan migrate:fresh --seed`
7. Jalankan:
   - `php artisan serve`

## Akun Seeder (password: `password`)

- Admin: `admin@classtrack.test`
- Guru: `guru1@classtrack.test`, `guru2@classtrack.test`
- Siswa: `siswa1@classtrack.test` s/d `siswa5@classtrack.test`
- Wali: `wali1@classtrack.test`, `wali2@classtrack.test`

## EWS Scheduler

- Command manual: `php artisan classtrack:check-risk-students`
- Jadwal otomatis: setiap jam `00:00` via scheduler di `routes/console.php`
- Jalankan scheduler local: `php artisan schedule:work`
- Log email notifikasi: `storage/logs/laravel.log`
