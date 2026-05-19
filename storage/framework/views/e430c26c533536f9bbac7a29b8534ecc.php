<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Bank Soal - ' . $classroom->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Bank Soal - ' . $classroom->name)]); ?>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?php echo e(route('guru.kelas.show', $classroom)); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Bank Soal</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100"><?php echo e($classroom->name); ?></span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Kelola soal pilihan ganda & essay, beri tag, dan gunakan sebagai referensi di tugas/kuis.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <form method="GET" class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex gap-3">
                <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari isi soal / tag..." class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 hover:bg-white focus:bg-white" />
                <select name="type" class="border border-gray-200 rounded-xl px-3 py-2.5 bg-gray-50">
                    <option value="">Semua</option>
                    <option value="mcq" <?php if(request('type')==='mcq'): echo 'selected'; endif; ?>>Pilihan Ganda</option>
                    <option value="essay" <?php if(request('type')==='essay'): echo 'selected'; endif; ?>>Essay</option>
                </select>
                <button class="px-4 py-2.5 bg-blue-600 text-white rounded-xl font-semibold">Cari</button>
            </form>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-full <?php echo e($qb->type === 'mcq' ? 'bg-purple-50 text-purple-700' : 'bg-amber-50 text-amber-700'); ?>">
                                        <?php echo e($qb->type === 'mcq' ? 'PILGAN' : 'ESSAY'); ?>

                                    </span>
                                    <span class="text-xs text-gray-400">#<?php echo e($qb->id); ?></span>
                                </div>
                                <p class="font-semibold text-gray-900 break-words"><?php echo e($qb->question_text); ?></p>

                                <?php if($qb->type === 'mcq'): ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3 text-sm">
                                        <?php $__currentLoopData = ['a','b','c','d']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $val = $qb->{'option_'.$opt}; ?>
                                            <?php if($val): ?>
                                                <div class="p-2 rounded-lg border <?php echo e($qb->correct_answer === $opt ? 'border-green-200 bg-green-50' : 'border-gray-100 bg-gray-50'); ?>">
                                                    <span class="font-bold text-gray-700"><?php echo e(strtoupper($opt)); ?>.</span>
                                                    <span class="text-gray-700"><?php echo e($val); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if(($qb->tags ?? collect())->count() > 0): ?>
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <?php $__currentLoopData = $qb->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-gray-100 text-gray-700"><?php echo e($tag->name); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <form method="POST" action="<?php echo e(route('guru.bank-soal.delete', [$classroom, $qb])); ?>" onsubmit="return confirm('Hapus soal ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-white rounded-2xl p-10 border border-dashed text-center text-gray-500">Belum ada soal di bank soal kelas ini.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Soal</h2>

            <form method="POST" action="<?php echo e(route('guru.bank-soal.create', $classroom)); ?>" class="space-y-4" x-data="{ type: 'mcq' }">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                    <select name="type" x-model="type" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">
                        <option value="mcq">Pilihan Ganda</option>
                        <option value="essay">Essay</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pertanyaan</label>
                    <textarea name="question_text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50" rows="4" required></textarea>
                </div>

                <div x-show="type === 'mcq'" class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-600 block mb-1">Opsi A</label>
                            <input name="option_a" class="w-full border rounded-xl px-3 py-2 bg-gray-50" :required="type === 'mcq'">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600 block mb-1">Opsi B</label>
                            <input name="option_b" class="w-full border rounded-xl px-3 py-2 bg-gray-50" :required="type === 'mcq'">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600 block mb-1">Opsi C</label>
                            <input name="option_c" class="w-full border rounded-xl px-3 py-2 bg-gray-50" :required="type === 'mcq'">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600 block mb-1">Opsi D</label>
                            <input name="option_d" class="w-full border rounded-xl px-3 py-2 bg-gray-50" :required="type === 'mcq'">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jawaban Benar</label>
                        <select name="correct_answer" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tag (pisahkan dengan koma)</label>
                    <input name="tags" placeholder="misal: pecahan, aljabar" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pembahasan (opsional)</label>
                    <textarea name="explanation" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50" rows="3"></textarea>
                </div>

                <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-3 font-bold">Simpan ke Bank Soal</button>
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
<?php /**PATH /Users/alvaritzymaulidan/Documents/ClassTrackRepo-main/resources/views/kuis/bank-soal.blade.php ENDPATH**/ ?>