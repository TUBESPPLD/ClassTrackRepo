<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Kelola Kelas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kelola Kelas')]); ?>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kelas</h1>
            <p class="text-sm text-gray-500 mt-1">Buat dan kelola ruang kelas Anda.</p>
        </div>
        <button onclick="document.getElementById('modal-buat-kelas').classList.remove('hidden')" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Kelas Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = ($classes ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all group relative flex flex-col <?php echo e($class->is_hidden ? 'opacity-75 grayscale-[20%]' : ''); ?>">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-100 to-indigo-100 text-blue-600 flex items-center justify-center font-bold text-xl border-2 border-white shadow-sm">
                        <?php echo e(strtoupper(substr($class->name, 0, 1))); ?>

                    </div>
                    
                    <!-- Dropdown Actions -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 focus:outline-none p-1 rounded-full hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-10" x-transition>
                            <button @click="open = false; $dispatch('open-edit-modal', { id: <?php echo e($class->id); ?>, name: '<?php echo e(addslashes($class->name)); ?>', description: '<?php echo e(addslashes($class->description)); ?>', cover_image: '<?php echo e(addslashes($class->cover_image)); ?>' })" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit Kelas</button>
                            
                            <form method="POST" action="<?php echo e(route('guru.kelas.toggle-visibility', $class)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <?php echo e($class->is_hidden ? 'Tampilkan Kelas' : 'Sembunyikan Kelas'); ?>

                                </button>
                            </form>

                            <form method="POST" action="<?php echo e(route('guru.kelas.delete', $class)); ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini beserta seluruh datanya?');">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Hapus Kelas</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-xl font-bold text-gray-900 line-clamp-1" title="<?php echo e($class->name); ?>"><?php echo e($class->name); ?></h3>
                        <?php if($class->is_hidden): ?>
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-gray-100 text-gray-500 rounded-md uppercase tracking-wider">Hidden</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded inline-block mb-3">Kode: <?php echo e($class->class_code); ?></p>
                    <p class="text-sm text-gray-500 line-clamp-2 h-10"><?php echo e($class->description ?: 'Tidak ada deskripsi.'); ?></p>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-50">
                    <a href="<?php echo e(route('guru.kelas.show', $class)); ?>" class="w-full flex items-center justify-center gap-2 py-2.5 bg-blue-50 text-blue-600 font-medium rounded-xl hover:bg-blue-600 hover:text-white transition-colors">
                        Buka Ruang Kelas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white rounded-3xl p-12 border border-dashed border-blue-200 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">Anda belum membuat kelas satupun. Mulai buat kelas baru untuk menambahkan siswa dan membagikan materi.</p>
                <button onclick="document.getElementById('modal-buat-kelas').classList.remove('hidden')" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    Buat Kelas Pertama
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Create Kelas -->
    <div id="modal-buat-kelas" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-xl relative">
            <button onclick="document.getElementById('modal-buat-kelas').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mb-6 text-center">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Buat Kelas Baru</h3>
                <p class="text-sm text-gray-500 mt-1">Isi detail kelas yang akan Anda buat.</p>
            </div>

            <form method="POST" action="<?php echo e(route('guru.kelas')); ?>" x-data="{ submitting: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kelas <span class="text-red-500">*</span></label>
                        <input name="name" placeholder="Misal: Matematika X-A" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Kelas</label>
                        <textarea name="description" placeholder="Deskripsi singkat mengenai kelas ini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Gambar Cover (Opsional)</label>
                        <input name="cover_image" type="url" placeholder="https://images.unsplash.com/..." class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <button :disabled="submitting" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan & Buat Kelas</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kelas -->
    <div x-data="{ open: false, id: '', name: '', description: '', cover_image: '' }" 
         @open-edit-modal.window="open = true; id = $event.detail.id; name = $event.detail.name; description = $event.detail.description; cover_image = $event.detail.cover_image"
         x-show="open" 
         class="fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-xl relative" @click.away="open = false">
            <button @click="open = false" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mb-6 text-center">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Edit Kelas</h3>
                <p class="text-sm text-gray-500 mt-1">Ubah detail ruang kelas Anda.</p>
            </div>

            <form method="POST" :action="`/guru/kelas/${id}`" x-data="{ submitting: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kelas <span class="text-red-500">*</span></label>
                        <input name="name" x-model="name" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Kelas</label>
                        <textarea name="description" x-model="description" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Gambar Cover (Opsional)</label>
                        <input name="cover_image" type="url" x-model="cover_image" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <button :disabled="submitting" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan Perubahan</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
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
<?php /**PATH /Users/brigitaselva/Downloads/ClassTrackRepo-main/resources/views/kelas/index.blade.php ENDPATH**/ ?>