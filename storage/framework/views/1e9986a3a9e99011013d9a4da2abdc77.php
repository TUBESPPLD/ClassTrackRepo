<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Detail Kelas - ' . $classroom->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Detail Kelas - ' . $classroom->name)]); ?>
    <?php if($classroom->cover_image): ?>
        <div class="h-48 rounded-2xl mb-6 overflow-hidden relative shadow-sm">
            <img src="<?php echo e(str_starts_with($classroom->cover_image, 'http') ? $classroom->cover_image : Storage::url($classroom->cover_image)); ?>" alt="Cover Kelas" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="<?php echo e(route('guru.kelas')); ?>" class="text-white/80 hover:text-white transition-colors bg-black/20 p-1.5 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <h1 class="text-3xl font-bold text-white shadow-sm"><?php echo e($classroom->name); ?></h1>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white rounded-full text-xs font-semibold border border-white/30"><?php echo e($classroom->class_code); ?></span>
                    </div>
                    <p class="text-sm text-gray-200 ml-10 max-w-2xl"><?php echo e($classroom->description ?? 'Tidak ada deskripsi'); ?></p>
                </div>
                <div class="flex gap-2">
                    <button onclick="document.getElementById('modal-edit-kelas').classList.remove('hidden')" class="px-4 py-2 bg-white/20 backdrop-blur-md border border-white/30 text-white rounded-xl hover:bg-white/30 transition-colors text-sm font-medium shadow-sm">
                        Edit Kelas
                    </button>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <a href="<?php echo e(route('guru.kelas')); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800"><?php echo e($classroom->name); ?></h1>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100"><?php echo e($classroom->class_code); ?></span>
                </div>
                <p class="text-sm text-gray-500 ml-9"><?php echo e($classroom->description ?? 'Tidak ada deskripsi'); ?></p>
            </div>
            
            <div class="flex gap-2">
                <button onclick="document.getElementById('modal-edit-kelas').classList.remove('hidden')" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors text-sm font-medium">
                    Edit Kelas
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Alpine Tabs -->
    <div x-data="{ tab: 'informasi' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Tab Navigation -->
        <div class="flex overflow-x-auto border-b border-gray-100 hide-scrollbar">
            <button @click="tab = 'informasi'" :class="tab === 'informasi' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Informasi & Pengumuman
            </button>
            <button @click="tab = 'anggota'" :class="tab === 'anggota' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Anggota & Kelompok
            </button>
            <button @click="tab = 'materi'" :class="tab === 'materi' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Materi
            </button>
            <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Tugas & Kuis
            </button>
            <button @click="tab = 'monitoring'" :class="tab === 'monitoring' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                Monitoring & Presensi
            </button>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            
            <!-- INFORMASI TAB -->
            <div x-show="tab === 'informasi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Pengumuman Kelas</h2>
                    <button onclick="document.getElementById('modal-pengumuman').classList.remove('hidden')" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors text-sm font-medium">
                        + Buat Pengumuman
                    </button>
                </div>
                
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $classroom->announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 border border-gray-100 rounded-xl bg-gray-50/50 flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1"><?php echo e($announcement->title); ?></h3>
                                <div class="text-gray-600 text-sm mb-2 prose prose-sm max-w-none trix-content"><?php echo $announcement->content; ?></div>
                                <p class="text-xs text-gray-400"><?php echo e($announcement->created_at->diffForHumans()); ?></p>
                            </div>
                            <div class="flex items-start gap-2 shrink-0">
                                <button onclick="document.getElementById('modal-edit-pengumuman-<?php echo e($announcement->id); ?>').classList.remove('hidden')" class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="<?php echo e(route('guru.pengumuman.delete', ['classroom' => $classroom, 'announcement' => $announcement])); ?>" method="POST" id="form-delete-pengumuman-<?php echo e($announcement->id); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" onclick="confirmDelete('form-delete-pengumuman-<?php echo e($announcement->id); ?>', 'Hapus Pengumuman?')" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Edit Pengumuman (Per Item) -->
                        <div id="modal-edit-pengumuman-<?php echo e($announcement->id); ?>" class="fixed inset-0 z-[60] hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
                            <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-xl relative">
                                <button onclick="document.getElementById('modal-edit-pengumuman-<?php echo e($announcement->id); ?>').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
                                <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Pengumuman</h3>
                                <form method="POST" action="<?php echo e(route('guru.pengumuman.update', ['classroom' => $classroom->id, 'announcement' => $announcement->id])); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                                            <input name="title" value="<?php echo e($announcement->title); ?>" class="w-full border rounded-xl px-3 py-2" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                                            <input id="content-edit-<?php echo e($announcement->id); ?>" type="hidden" name="content" value="<?php echo e($announcement->content); ?>">
                                            <trix-editor input="content-edit-<?php echo e($announcement->id); ?>" class="trix-content bg-white rounded-xl min-h-[150px]"></trix-editor>
                                        </div>
                                        <div class="flex gap-3 justify-end pt-2">
                                            <button type="button" onclick="document.getElementById('modal-edit-pengumuman-<?php echo e($announcement->id); ?>').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">Batal</button>
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-10 text-gray-500 text-sm">Belum ada pengumuman di kelas ini.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ANGGOTA TAB -->
            <div x-show="tab === 'anggota'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800">Daftar Siswa</h2>
                            <div x-data="{ query: '', students: [], loading: false, showDropdown: false, selectedStudent: null }" class="relative">
                                <form action="<?php echo e(route('guru.anggota', $classroom)); ?>" method="POST" class="flex gap-2">
                                    <?php echo csrf_field(); ?>
                                    <div class="relative w-48">
                                        <input type="hidden" name="student_id" x-model="selectedStudent">
                                        <input type="text" x-model="query" @input.debounce.300ms="
                                            if(query.length > 2) {
                                                loading = true;
                                                fetch('/guru/search-students?q=' + query)
                                                    .then(res => res.json())
                                                    .then(data => { students = data; showDropdown = true; loading = false; });
                                            } else {
                                                showDropdown = false;
                                            }
                                        " @click.away="showDropdown = false" placeholder="ID / Nama Siswa" class="border border-gray-200 px-3 py-1.5 rounded-lg text-sm w-full bg-gray-50 focus:bg-white transition-colors" autocomplete="off">
                                        
                                        <!-- Dropdown -->
                                        <div x-show="showDropdown" style="display: none;" class="absolute top-full left-0 w-64 mt-1 bg-white border border-gray-100 shadow-lg rounded-xl z-50 overflow-hidden">
                                            <div x-show="loading" class="p-3 text-xs text-gray-500 text-center">Mencari...</div>
                                            <template x-for="s in students" :key="s.id">
                                                <div @click="query = s.student_code + ' - ' + s.name; selectedStudent = s.id; showDropdown = false;" class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0">
                                                    <p class="text-sm font-semibold text-gray-800" x-text="s.name"></p>
                                                    <p class="text-xs text-blue-600 font-mono" x-text="'ID: ' + s.student_code"></p>
                                                </div>
                                            </template>
                                            <div x-show="!loading && students.length === 0" class="p-3 text-xs text-gray-500 text-center">Siswa tidak ditemukan</div>
                                        </div>
                                    </div>
                                    <button :disabled="!selectedStudent" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 disabled:opacity-50 transition-colors font-medium">Tambah</button>
                                </form>
                            </div>
                        </div>
                        <ul class="divide-y divide-gray-100 border border-gray-100 rounded-xl">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->members->where('role', 'siswa'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs"><?php echo e(substr($member->name, 0, 1)); ?></div>
                                        <div>
                                            <p class="font-medium text-sm text-gray-800"><?php echo e($member->name); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($member->email); ?></p>
                                        </div>
                                    </div>
                                    <form action="<?php echo e(route('guru.anggota', $classroom)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="remove_student_id" value="<?php echo e($member->id); ?>">
                                        <button class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                                    </form>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="p-6 text-center text-sm text-gray-500">Belum ada siswa di kelas ini.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800">Daftar Kelompok</h2>
                            <button onclick="document.getElementById('modal-kelompok').classList.remove('hidden')" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors text-sm font-medium">
                                + Buat Kelompok
                            </button>
                        </div>
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-gray-800"><?php echo e($group->name); ?></h3>
                                        <div class="flex items-center gap-1">
                                            <button onclick="document.getElementById('modal-edit-kelompok-<?php echo e($group->id); ?>').classList.remove('hidden')" class="p-1 text-gray-400 hover:text-blue-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="<?php echo e(route('guru.kelompok.delete', ['classroom' => $classroom, 'group' => $group])); ?>" method="POST" id="form-delete-group-<?php echo e($group->id); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="button" onclick="confirmDelete('form-delete-group-<?php echo e($group->id); ?>', 'Hapus kelompok ini?')" class="p-1 text-gray-400 hover:text-red-600 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-1">Anggota:</p>
                                    <ul class="text-sm text-gray-600 list-disc list-inside">
                                        <?php $__currentLoopData = $group->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($gm->name); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-10 text-gray-500 text-sm">Belum ada kelompok dibentuk.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MATERI TAB -->
            <div x-show="tab === 'materi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Materi Pembelajaran</h2>
                    <button onclick="document.getElementById('modal-materi').classList.remove('hidden')" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors text-sm font-medium">
                        + Unggah Materi
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $classroom->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-5 border border-gray-100 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow group relative">
                            <div class="absolute top-4 right-4 flex gap-1">
                                <button onclick="document.getElementById('modal-edit-materi-<?php echo e($materi->id); ?>').classList.remove('hidden')" class="p-1 text-gray-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="<?php echo e(route('guru.materi.delete', $materi)); ?>" method="POST" id="form-delete-materi-<?php echo e($materi->id); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" onclick="confirmDelete('form-delete-materi-<?php echo e($materi->id); ?>', 'Hapus materi ini?')" class="p-1 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1 pr-12"><?php echo e($materi->title); ?></h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-2"><?php echo e($materi->description); ?></p>
                            
                            <div class="flex gap-3 text-sm font-medium">
                                <?php if($materi->file_path): ?>
                                <a href="<?php echo e(Storage::url($materi->file_path)); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                    Unduh File <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                                <?php endif; ?>
                                <?php if($materi->link_url): ?>
                                <a href="<?php echo e($materi->link_url); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                    Buka Link <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-10 text-gray-500 text-sm">Belum ada materi diunggah.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TUGAS TAB -->
            <div x-show="tab === 'tugas'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Tugas -->
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800">Tugas Terjadwal</h2>
                            <a href="<?php echo e(route('guru.tugas', $classroom)); ?>" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors text-sm font-medium">
                                Kelola Tugas & Nilai
                            </a>
                        </div>
                        <div class="space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-4 border border-gray-100 rounded-xl flex items-center justify-between hover:bg-gray-50">
                                    <div>
                                        <h3 class="font-semibold text-gray-800"><?php echo e($tugas->title); ?></h3>
                                        <p class="text-xs text-red-500 mt-1">Tenggat: <?php echo e(\Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i')); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada tugas.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Kuis -->
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800">Kuis Pilihan Ganda</h2>
                            <a href="<?php echo e(route('guru.kuis', $classroom)); ?>" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors text-sm font-medium">
                                Kelola Kuis
                            </a>
                        </div>
                        <div class="space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kuis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-4 border border-gray-100 rounded-xl flex items-center justify-between hover:bg-gray-50">
                                    <div>
                                        <h3 class="font-semibold text-gray-800"><?php echo e($kuis->title); ?></h3>
                                        <p class="text-xs text-gray-500 mt-1">Durasi: <?php echo e($kuis->duration_minutes); ?> menit</p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada kuis.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MONITORING TAB -->
            <div x-show="tab === 'monitoring'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <a href="<?php echo e(route('guru.monitoring', $classroom)); ?>" class="flex-1 flex items-center justify-center gap-2 p-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <span class="font-semibold text-lg">Buka Dashboard Monitoring (Grafik)</span>
                    </a>
                    
                    <button onclick="document.getElementById('modal-presensi').classList.remove('hidden')" class="flex-1 flex items-center justify-center gap-2 p-4 bg-white border-2 border-blue-100 text-blue-600 rounded-xl hover:bg-blue-50 transition-all font-semibold text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Isi Presensi Hari Ini
                    </button>
                </div>
                <div class="p-6 bg-yellow-50 border border-yellow-100 rounded-xl text-yellow-800 text-sm">
                    <strong>Penting:</strong> Sistem Early Warning (EWS) akan otomatis memproses nilai dan kehadiran siswa. Apabila Rata-rata < 70 atau Kehadiran < 75%, sistem akan mengirimkan email ke wali murid. Anda dapat melihat statistik tersebut di halaman Dashboard Monitoring.
                </div>
            </div>

        </div>
    </div>

    <!-- Modals -->
    <!-- Modal Edit Kelas -->
    <div id="modal-edit-kelas" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl relative">
            <button onclick="document.getElementById('modal-edit-kelas').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Kelas</h3>
            <form method="POST" action="<?php echo e(route('guru.kelas.update', $classroom)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input name="name" value="<?php echo e($classroom->name); ?>" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" class="w-full border rounded-xl px-3 py-2"><?php echo e($classroom->description); ?></textarea>
                    </div>
                    <button class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pengumuman -->
    <div id="modal-pengumuman" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-xl relative">
            <button onclick="document.getElementById('modal-pengumuman').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Buat Pengumuman</h3>
            <form method="POST" action="<?php echo e(route('guru.pengumuman', $classroom)); ?>">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input name="title" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                        <input id="content-create" type="hidden" name="content">
                        <trix-editor input="content-create" class="trix-content bg-white rounded-xl min-h-[150px]"></trix-editor>
                    </div>
                    <div class="flex gap-3 justify-end pt-2">
                        <button type="button" onclick="document.getElementById('modal-pengumuman').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Kelompok -->
    <div id="modal-kelompok" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl relative">
            <button onclick="document.getElementById('modal-kelompok').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Buat Kelompok</h3>
            <form method="POST" action="<?php echo e(route('guru.kelompok', $classroom)); ?>" x-data="{ submitting: false, autoShuffle: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelompok Dasar</label>
                        <input name="name" placeholder="Misal: Kelompok Belajar" class="w-full border rounded-xl px-3 py-2" required>
                    </div>

                    <div class="flex items-center gap-2 mb-2 p-3 bg-gray-50 rounded-xl border">
                        <input type="checkbox" id="autoShuffle" name="is_auto_shuffle" value="1" x-model="autoShuffle" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="autoShuffle" class="text-sm font-medium text-gray-700">Otomatis Acak & Bagi Kelompok</label>
                    </div>

                    <div x-show="autoShuffle" class="space-y-2 p-3 bg-blue-50/50 rounded-xl border border-blue-100">
                        <label class="block text-sm font-medium text-gray-700">Jumlah Kelompok yang Diinginkan</label>
                        <input type="number" name="shuffle_count" min="2" value="2" class="w-full border rounded-xl px-3 py-2" :required="autoShuffle">
                        <p class="text-xs text-gray-500 mt-1">Sistem akan otomatis membagi semua siswa secara merata ke dalam jumlah kelompok ini.</p>
                    </div>

                    <div x-show="!autoShuffle">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Anggota</label>
                        <div class="max-h-40 overflow-y-auto border rounded-xl p-2 bg-gray-50 space-y-1">
                            <?php $__empty_1 = true; $__currentLoopData = $classroom->members->where('role', 'siswa'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label class="flex items-center gap-2 text-sm p-1 hover:bg-gray-100 rounded">
                                    <input type="checkbox" name="members[]" value="<?php echo e($member->id); ?>">
                                    <?php echo e($member->name); ?>

                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-sm text-gray-500 p-2 text-center">Belum ada siswa di kelas ini. Tambahkan siswa terlebih dahulu.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button :disabled="submitting" class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium disabled:opacity-70">
                        <span x-show="!submitting">Buat Kelompok</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Materi -->
    <div id="modal-materi" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl relative">
            <button onclick="document.getElementById('modal-materi').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Unggah Materi</h3>
            <form method="POST" action="<?php echo e(route('guru.materi', $classroom)); ?>" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Materi</label>
                        <input name="title" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Segmen / Pertemuan</label>
                        <input name="segment" placeholder="Misal: Pertemuan 1" class="w-full border rounded-xl px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="description" class="w-full border rounded-xl px-3 py-2" rows="2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link URL Video / Referensi (Opsional)</label>
                        <input name="link_url" type="url" placeholder="https://youtube.com/..." class="w-full border rounded-xl px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File (PDF/DOC/DOCX)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <button :disabled="submitting" class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium disabled:opacity-70">
                        <span x-show="!submitting">Unggah</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Presensi -->
    <div id="modal-presensi" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-xl relative">
            <button onclick="document.getElementById('modal-presensi').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Isi Presensi - <?php echo e(now()->format('d M Y')); ?></h3>
            <form method="POST" action="<?php echo e(route('guru.presensi', $classroom)); ?>">
                <?php echo csrf_field(); ?>
                <div class="max-h-96 overflow-y-auto pr-2 mb-4">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-2 text-sm font-medium text-gray-600">Nama Siswa</th>
                                <th class="p-2 text-sm font-medium text-gray-600 text-center" title="Tugas yang dikumpulkan">Tugas</th>
                                <th class="p-2 text-sm font-medium text-gray-600 text-center" title="Kuis yang dikerjakan">Kuis</th>
                                <th class="p-2 text-sm font-medium text-gray-600 text-center">Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $classroom->members->where('role', 'siswa'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $tugasCount = $classroom->assignments->count();
                                    $tugasDone = $classroom->assignments->filter(fn($a) => $a->submissions->where('student_id', $member->id)->isNotEmpty())->count();
                                    $kuisCount = $classroom->quizzes->count();
                                    $kuisDone = $classroom->quizzes->filter(fn($q) => $q->attempts->where('student_id', $member->id)->isNotEmpty())->count();
                                ?>
                                <tr>
                                    <td class="p-2 text-sm text-gray-800 font-medium"><?php echo e($member->name); ?></td>
                                    <td class="p-2 text-center">
                                        <span class="text-xs font-bold <?php echo e($tugasDone == $tugasCount && $tugasCount > 0 ? 'text-green-600' : ($tugasDone == 0 && $tugasCount > 0 ? 'text-red-500' : 'text-orange-500')); ?> bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                            <?php echo e($tugasDone); ?>/<?php echo e($tugasCount); ?>

                                        </span>
                                    </td>
                                    <td class="p-2 text-center">
                                        <span class="text-xs font-bold <?php echo e($kuisDone == $kuisCount && $kuisCount > 0 ? 'text-green-600' : ($kuisDone == 0 && $kuisCount > 0 ? 'text-red-500' : 'text-orange-500')); ?> bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                            <?php echo e($kuisDone); ?>/<?php echo e($kuisCount); ?>

                                        </span>
                                    </td>
                                    <td class="p-2">
                                        <select name="records[<?php echo e($member->id); ?>]" class="w-full text-sm border rounded-lg px-2 py-1.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                                            <option value="hadir">Hadir</option>
                                            <option value="izin">Izin</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="alpa" <?php echo e(($tugasDone == 0 && $kuisDone == 0 && ($tugasCount > 0 || $kuisCount > 0)) ? 'selected' : ''); ?>>Alpa</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <button class="w-full bg-blue-600 text-white rounded-xl py-3 font-medium hover:bg-blue-700 transition-colors">Simpan Presensi</button>
            </form>
        </div>
    </div>
    <?php $__currentLoopData = $classroom->groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- Modal Edit Kelompok -->
    <div id="modal-edit-kelompok-<?php echo e($group->id); ?>" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-xl relative">
            <button onclick="document.getElementById('modal-edit-kelompok-<?php echo e($group->id); ?>').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Kelompok</h3>
            <form method="POST" action="<?php echo e(route('guru.kelompok.update', ['classroom' => $classroom, 'group' => $group])); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kelompok</label>
                    <input name="name" value="<?php echo e($group->name); ?>" required class="w-full border border-gray-200 rounded-xl px-4 py-2 bg-gray-50 focus:bg-white transition-colors">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Anggota Kelompok</label>
                    <div class="max-h-48 overflow-y-auto space-y-2 pr-2">
                        <?php $__currentLoopData = $classroom->members->where('role', 'siswa'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer border border-transparent hover:border-gray-100 transition-colors">
                                <input type="checkbox" name="members[]" value="<?php echo e($siswa->id); ?>" 
                                    <?php echo e($group->members->contains($siswa->id) ? 'checked' : ''); ?>

                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700 font-medium"><?php echo e($siswa->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-3 font-bold hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $classroom->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- Modal Edit Materi -->
    <div id="modal-edit-materi-<?php echo e($materi->id); ?>" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl relative">
            <button onclick="document.getElementById('modal-edit-materi-<?php echo e($materi->id); ?>').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Materi</h3>
            <form method="POST" action="<?php echo e(route('guru.materi.update', $materi)); ?>" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Materi</label>
                        <input name="title" value="<?php echo e($materi->title); ?>" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Segmen / Pertemuan</label>
                        <input name="segment" value="<?php echo e($materi->segment); ?>" placeholder="Misal: Pertemuan 1" class="w-full border rounded-xl px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="description" class="w-full border rounded-xl px-3 py-2" rows="2"><?php echo e($materi->description); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link URL Video / Referensi (Opsional)</label>
                        <input name="link_url" type="url" value="<?php echo e($materi->link_url); ?>" placeholder="https://youtube.com/..." class="w-full border rounded-xl px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ganti File (PDF/DOC/DOCX)</label>
                        <input type="file" name="file" class="w-full border rounded-xl px-3 py-2 text-sm">
                        <?php if($materi->file_path): ?>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti file. File saat ini: <a href="<?php echo e(Storage::url($materi->file_path)); ?>" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                        <?php else: ?>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada file (hanya link URL).</p>
                        <?php endif; ?>
                    </div>
                    <button :disabled="submitting" class="w-full bg-blue-600 text-white rounded-xl py-2 font-medium disabled:opacity-70">
                        <span x-show="!submitting">Simpan Perubahan</span>
                        <span x-show="submitting">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function confirmDelete(formId, text = 'Anda yakin ingin menghapus data ini?') {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 font-medium',
                    cancelButton: 'rounded-xl px-4 py-2 font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\Users\user\ClassTrackRepo\resources\views/kelas/show-guru.blade.php ENDPATH**/ ?>