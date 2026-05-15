<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Dashboard Wali']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard Wali')]); ?>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 font-outfit">Pemantauan Wali Murid</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau perkembangan akademik dan kehadiran anak Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = ($reports ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all relative overflow-hidden">
                <!-- Status Indicator -->
                <?php if($report['avgNilai'] < 70 || $report['presensi'] < 75): ?>
                    <div class="absolute top-0 right-0 w-2 h-full bg-red-500"></div>
                <?php else: ?>
                    <div class="absolute top-0 right-0 w-2 h-full bg-green-500"></div>
                <?php endif; ?>

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-blue-100 to-indigo-100 text-blue-600 flex items-center justify-center font-bold text-xl border-2 border-white shadow-sm">
                        <?php echo e(strtoupper(substr($report['student']->name, 0, 1))); ?>

                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg"><?php echo e($report['student']->name); ?></h3>
                        <p class="text-xs text-gray-500">Siswa Terdaftar</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-600">Rata-rata Nilai</span>
                            <span class="font-bold <?php echo e($report['avgNilai'] < 70 ? 'text-red-600' : 'text-green-600'); ?>">
                                <?php echo e($report['avgNilai']); ?>

                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="<?php echo e($report['avgNilai'] < 70 ? 'bg-red-500' : 'bg-green-500'); ?> h-1.5 rounded-full" style="width: <?php echo e(min(100, $report['avgNilai'])); ?>%"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-600">Kehadiran</span>
                            <span class="font-bold <?php echo e($report['presensi'] < 75 ? 'text-red-600' : 'text-green-600'); ?>">
                                <?php echo e($report['presensi']); ?>%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="<?php echo e($report['presensi'] < 75 ? 'bg-red-500' : 'bg-green-500'); ?> h-1.5 rounded-full" style="width: <?php echo e(min(100, $report['presensi'])); ?>%"></div>
                        </div>
                    </div>
                </div>

                <?php if($report['avgNilai'] < 70 || $report['presensi'] < 75): ?>
                    <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-xl flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-xs text-red-700 font-medium">Perhatian: Nilai atau kehadiran anak Anda berada di bawah batas standar (Nilai: 70, Kehadiran: 75%).</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white rounded-2xl p-8 border border-dashed border-gray-300 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="text-gray-500 font-medium">Belum ada data siswa yang terkait dengan akun Anda.</p>
                <p class="text-sm text-gray-400 mt-1">Silakan hubungi administrator sekolah untuk menautkan akun siswa.</p>
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
<?php /**PATH /Users/brigitaselva/Downloads/ClassTrackRepo-main/resources/views/dashboard-wali.blade.php ENDPATH**/ ?>