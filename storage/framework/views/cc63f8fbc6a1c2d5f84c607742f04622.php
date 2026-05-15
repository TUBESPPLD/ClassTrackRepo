<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Ruang Kelas - ' . $classroom->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Ruang Kelas - ' . $classroom->name)]); ?>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?php echo e(route('siswa.dashboard')); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800"><?php echo e($classroom->name); ?></h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100"><?php echo e($classroom->class_code); ?></span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Pengajar: <?php echo e($classroom->teacher->name ?? 'Admin'); ?></p>
        </div>
    </div>

    <!-- Alpine Tabs -->
    <div x-data="{ tab: 'informasi' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Tab Navigation -->
        <div class="flex overflow-x-auto border-b border-gray-100 hide-scrollbar">
            <button @click="tab = 'informasi'" :class="tab === 'informasi' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Pengumuman
            </button>
            <button @click="tab = 'materi'" :class="tab === 'materi' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Materi Belajar
            </button>
            <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Tugas & Kuis
            </button>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            
            <!-- PENGUMUMAN TAB -->
            <div x-show="tab === 'informasi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Pengumuman Kelas</h2>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $classroom->announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-5 border border-blue-100 rounded-xl bg-blue-50/30">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <h3 class="font-semibold text-gray-800"><?php echo e($announcement->title); ?></h3>
                            </div>
                            <p class="text-gray-600 text-sm ml-7 mb-2"><?php echo e($announcement->content); ?></p>
                            <p class="text-xs text-gray-400 ml-7"><?php echo e($announcement->created_at->diffForHumans()); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-10 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada pengumuman dari guru.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- MATERI TAB -->
            <div x-show="tab === 'materi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Materi Pembelajaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $classroom->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-5 border border-gray-100 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow group">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1"><?php echo e($materi->title); ?></h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-2"><?php echo e($materi->description); ?></p>
                            <a href="<?php echo e(Storage::url($materi->file_path)); ?>" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                Unduh Materi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-10 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada materi diunggah oleh guru.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TUGAS TAB -->
            <div x-show="tab === 'tugas'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Tugas -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Tugas Kelas</h2>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-5 border border-gray-100 rounded-xl bg-white shadow-sm hover:border-blue-200 transition-colors">
                                    <h3 class="font-bold text-gray-800 mb-1"><?php echo e($tugas->title); ?></h3>
                                    <p class="text-xs text-gray-500 mb-3"><?php echo e($tugas->description); ?></p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-1 text-xs font-medium <?php echo e(\Carbon\Carbon::parse($tugas->deadline)->isPast() ? 'text-red-500' : 'text-orange-500'); ?>">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Tenggat: <?php echo e(\Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i')); ?>

                                        </div>
                                        <?php if($tugas->file_path): ?>
                                            <a href="<?php echo e(Storage::url($tugas->file_path)); ?>" target="_blank" class="text-xs text-blue-600 hover:underline">File Soal</a>
                                        <?php endif; ?>
                                    </div>

                                    <?php
                                        $submission = $tugas->submissions()->where('student_id', auth()->id())->first();
                                    ?>

                                    <?php if($submission): ?>
                                        <div class="p-3 bg-green-50 rounded-lg border border-green-100 flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-green-700 font-semibold flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Telah Dikumpulkan
                                                </p>
                                                <?php if($submission->grade !== null): ?>
                                                    <p class="text-sm font-bold text-gray-800 mt-1">Nilai: <span class="text-blue-600"><?php echo e($submission->grade); ?></span>/100</p>
                                                <?php else: ?>
                                                    <p class="text-xs text-gray-500 mt-1">Menunggu Penilaian</p>
                                                <?php endif; ?>
                                            </div>
                                            <a href="<?php echo e(Storage::url($submission->file_path)); ?>" target="_blank" class="text-xs text-green-600 hover:underline">Lihat Jawaban</a>
                                        </div>
                                    <?php else: ?>
                                        <?php if(\Carbon\Carbon::parse($tugas->deadline)->isPast()): ?>
                                            <div class="p-3 bg-red-50 text-red-600 text-xs font-semibold border border-red-100 rounded-lg text-center">
                                                Waktu Pengumpulan Telah Habis
                                            </div>
                                        <?php else: ?>
                                            <form method="POST" action="<?php echo e(route('siswa.submit', $tugas)); ?>" enctype="multipart/form-data" class="mt-2 border-t border-gray-100 pt-3">
                                                <?php echo csrf_field(); ?>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Unggah Jawaban (PDF/DOC)</label>
                                                <div class="flex gap-2">
                                                    <input type="file" name="file" class="w-full text-xs border rounded-lg p-1.5" required>
                                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-blue-700 shrink-0">Kirim</button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada tugas.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Kuis -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Kuis Interaktif</h2>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kuis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-5 border border-gray-100 rounded-xl bg-white shadow-sm hover:border-purple-200 transition-colors">
                                    <h3 class="font-bold text-gray-800 mb-1"><?php echo e($kuis->title); ?></h3>
                                    <div class="flex items-center gap-1 text-xs font-medium text-purple-600 mb-4">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Waktu: <?php echo e($kuis->duration_minutes); ?> Menit
                                    </div>

                                    <?php
                                        $attempt = $kuis->attempts()->where('student_id', auth()->id())->first();
                                    ?>

                                    <?php if($attempt): ?>
                                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-100 text-center">
                                            <p class="text-xs text-purple-700 font-semibold mb-1">Sudah Dikerjakan</p>
                                            <p class="text-lg font-bold text-gray-800">Nilai: <span class="text-purple-600"><?php echo e($attempt->score); ?></span>/100</p>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('siswa.kuis', $kuis)); ?>" class="block w-full text-center py-2 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-medium rounded-lg text-sm hover:shadow-md transition-shadow">
                                            Mulai Kerjakan
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada kuis.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
<?php /**PATH /Users/brigitaselva/Downloads/ClassTrackRepo-main/resources/views/kelas/show-siswa.blade.php ENDPATH**/ ?>