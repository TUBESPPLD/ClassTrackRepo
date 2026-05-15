<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Dashboard Siswa']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard Siswa')]); ?>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 font-outfit">Ruang Belajar Siswa</h1>
        <p class="text-sm text-gray-500 mt-1">Gabung ke kelas baru dan pantau perkembangan belajar Anda.</p>
    </div>

    <!-- Join Class Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 max-w-xl">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Gabung Kelas Baru
        </h2>
        <form method="POST" action="<?php echo e(route('siswa.join')); ?>" class="flex gap-3">
            <?php echo csrf_field(); ?>
            <input name="class_code" placeholder="Masukkan kode kelas (contoh: CLS-ABCDEF)" class="border border-gray-200 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-gray-50/50 hover:bg-white flex-1" required>
            <button class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 whitespace-nowrap">
                Join Kelas
            </button>
        </form>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">Kelas Anda</h2>
        <a href="<?php echo e(route('siswa.nilai')); ?>" class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
            Lihat Semua Nilai <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = ($classes ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                        <?php echo e(strtoupper(substr($class->name, 0, 1))); ?>

                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium"><?php echo e($class->class_code); ?></span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1"><?php echo e($class->name); ?></h3>
                <p class="text-sm text-gray-500 line-clamp-2 mb-6"><?php echo e($class->description ?: 'Tidak ada deskripsi'); ?></p>
                
                <a href="<?php echo e(route('siswa.kelas.show', $class)); ?>" class="block w-full text-center py-2.5 bg-gray-50 hover:bg-blue-50 text-blue-600 font-medium rounded-xl transition-colors border border-gray-100">
                    Masuk Kelas
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white rounded-2xl p-8 border border-dashed border-gray-300 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <p class="text-gray-500 font-medium">Anda belum terdaftar di kelas manapun.</p>
                <p class="text-sm text-gray-400 mt-1">Gunakan form di atas untuk bergabung.</p>
            </div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH /Users/brigitaselva/Downloads/ClassTrackRepo-main/resources/views/dashboard-siswa.blade.php ENDPATH**/ ?>