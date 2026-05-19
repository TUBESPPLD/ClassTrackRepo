<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ClassTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f7fb] min-h-screen flex items-center justify-center p-4">
    <?php
        $role = request()->query('role', 'siswa');
        $roleNames = [
            'siswa' => 'Siswa',
            'guru' => 'Guru',
            'wali' => 'Wali Murid',
            'admin' => 'Admin'
        ];
        $selectedRoleName = $roleNames[$role] ?? 'Siswa';
    ?>

    <!-- Decorative background elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-lg shadow-blue-500/30 mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 font-outfit">Portal <?php echo e($selectedRoleName); ?></h2>
            <p class="text-gray-500 mt-2">Masuk ke sistem akademik SMA Bina Nusantara</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 border border-gray-100">
            <!-- Role Tabs -->
            <div class="flex bg-gray-50 p-1 rounded-xl mb-6 overflow-x-auto hide-scrollbar">
                <?php $__currentLoopData = $roleNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('login')); ?>?role=<?php echo e($key); ?>" class="flex-1 text-center py-2 text-sm font-semibold rounded-lg transition-all whitespace-nowrap px-3 <?php echo e($role === $key ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                        <?php echo e($name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 text-sm font-medium border border-green-100">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 text-sm font-medium border border-red-100">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-5" x-data="{ submitting: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input name="email" type="email" placeholder="contoh@sekolah.com" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white" required autofocus>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input name="password" type="password" placeholder="••••••••" class="w-full border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white" required>
                </div>

                <div class="pt-2 relative">
                    <button type="submit" :disabled="submitting" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Masuk</span>
                        <span x-show="submitting" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Memproses...
                        </span>
                    </button>
                    <!-- Overlay cleanup to prevent locked page -->
                    <div x-init="$watch('submitting', value => { if(!value) document.body.style.overflow = 'auto'; document.body.style.pointerEvents = 'auto'; })"></div>
                </div>
            </form>
            
            <script>
                // Fallback cleanup if any modal/backdrop leaves body locked
                document.addEventListener('DOMContentLoaded', () => {
                    document.body.style.overflow = 'auto';
                    document.body.style.pointerEvents = 'auto';
                    const backdrops = document.querySelectorAll('.bg-gray-900\\/50, .fixed.inset-0');
                    backdrops.forEach(b => {
                        if (b.id !== 'login-roles' && !b.children.length) {
                            b.remove();
                        }
                    });
                });
            </script>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="<?php echo e(route('register')); ?>" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Daftar sekarang</a>
                </p>
                <div class="mt-4">
                    <a href="<?php echo e(url('/')); ?>" class="text-sm text-gray-400 hover:text-gray-600">&larr; Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/alvaritzymaulidan/Documents/ClassTrackRepo-main/resources/views/login.blade.php ENDPATH**/ ?>