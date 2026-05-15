<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Kelola Tugas - ' . $classroom->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kelola Tugas - ' . $classroom->name)]); ?>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?php echo e(route('guru.kelas.show', $classroom)); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Kelola Tugas</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100"><?php echo e($classroom->name); ?></span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Buat tugas baru dan berikan penilaian kepada siswa.</p>
        </div>
        <button onclick="document.getElementById('modal-buat-tugas').classList.remove('hidden')" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Tugas Baru
        </button>
    </div>

    <div class="space-y-6">
        <?php $__empty_1 = true; $__currentLoopData = ($assignments ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg"><?php echo e($tugas->title); ?></h3>
                            <div class="flex items-center gap-2 text-xs font-medium text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Tenggat: <?php echo e(\Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i')); ?>

                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-4"><?php echo e($tugas->description); ?></p>
                    <?php if($tugas->file_path): ?>
                        <a href="<?php echo e(Storage::url($tugas->file_path)); ?>" target="_blank" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat File Lampiran Soal
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Submissions Area -->
                <div class="w-full lg:w-1/2 bg-gray-50/50 rounded-2xl p-5 border border-gray-100">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Pengumpulan (<?php echo e($tugas->submissions->count()); ?> Siswa)
                    </h4>
                    
                    <div class="max-h-60 overflow-y-auto pr-2 space-y-3">
                        <?php $__empty_2 = true; $__currentLoopData = $tugas->submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm"><?php echo e($sub->student->name ?? 'Siswa'); ?></p>
                                        <p class="text-xs text-gray-500">Waktu Kumpul: <?php echo e(\Carbon\Carbon::parse($sub->submitted_at)->format('d M Y H:i')); ?></p>
                                        <?php if($sub->status == 'TERLAMBAT'): ?>
                                            <span class="inline-block px-2 py-0.5 mt-1 bg-red-50 text-red-600 rounded text-[10px] font-bold">TERLAMBAT</span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php echo e(Storage::url($sub->file_path)); ?>" target="_blank" class="text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline">Cek Jawaban</a>
                                </div>
                                
                                <form method="POST" action="<?php echo e(route('guru.nilai', $sub)); ?>" class="mt-3 flex gap-2">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex-1">
                                        <input type="number" name="grade" placeholder="Nilai (0-100)" value="<?php echo e($sub->grade); ?>" class="w-full text-xs border rounded-lg px-3 py-2 bg-gray-50 focus:bg-white" required min="0" max="100">
                                    </div>
                                    <div class="flex-2">
                                        <input type="text" name="feedback" placeholder="Komentar singkat..." value="<?php echo e($sub->feedback); ?>" class="w-full text-xs border rounded-lg px-3 py-2 bg-gray-50 focus:bg-white">
                                    </div>
                                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-medium hover:bg-indigo-700">Simpan</button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <p class="text-xs text-gray-500 text-center py-4">Belum ada siswa yang mengumpulkan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-3xl p-12 border border-dashed border-gray-200 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Tugas</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6 text-sm">Anda belum membuat tugas untuk kelas ini. Klik tombol di atas untuk membuat tugas baru.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Create Tugas -->
    <div id="modal-buat-tugas" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-lg p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-buat-tugas').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Buat Tugas Baru</h3>

            <form method="POST" action="<?php echo e(route('guru.tugas', $classroom)); ?>" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Tugas <span class="text-red-500">*</span></label>
                        <input name="title" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Segmen / Pertemuan</label>
                        <input name="segment" placeholder="Misal: Pertemuan 2" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi / Instruksi</label>
                        <textarea name="description" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batas Waktu (Deadline) <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">File Lampiran (Opsional)</label>
                        <input type="file" name="file" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white text-sm transition-all">
                    </div>
                    <div class="pt-2">
                        <button type="submit" :disabled="submitting" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span x-show="!submitting">Simpan & Terbitkan</span>
                            <span x-show="submitting">Memproses...</span>
                        </button>
                    </div>
                </div>
            </form>
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
<?php /**PATH /Users/brigitaselva/Downloads/ClassTrackRepo-main/resources/views/tugas/index.blade.php ENDPATH**/ ?>