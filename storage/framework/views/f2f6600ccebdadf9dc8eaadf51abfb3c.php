<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ClassTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f7fb] min-h-screen flex items-center justify-center p-4">

    <!-- Decorative background elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute top-20 -right-40 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    <div class="max-w-md w-full py-8">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-lg shadow-blue-500/30 mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 font-outfit">Buat Akun</h2>
            <p class="text-gray-500 mt-2">Mulai perjalanan belajar Anda</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 border border-gray-100">
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 text-sm font-medium border border-red-100">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register.post')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input name="name" type="text" placeholder="Budi Santoso" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input name="email" type="email" placeholder="contoh@sekolah.com" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input name="password" type="password" placeholder="••••••••" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" placeholder="••••••••" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Peran</label>
                    <select name="role" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white text-gray-700" required>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                        <option value="wali">Wali Murid</option>
                    </select>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="<?php echo e(route('login')); ?>" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Masuk di sini</a>
                </p>
                <div class="mt-4">
                    <a href="<?php echo e(url('/')); ?>" class="text-sm text-gray-400 hover:text-gray-600">&larr; Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\ClassTrackRepo\resources\views/register.blade.php ENDPATH**/ ?>