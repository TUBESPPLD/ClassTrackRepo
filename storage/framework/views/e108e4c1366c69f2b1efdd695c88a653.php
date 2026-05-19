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
    <div class="mb-6 flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 font-outfit">Pemantauan Akademik (Wali Murid)</h1>
            <p class="text-sm text-gray-500 mt-2">Pantau perkembangan akademik, kehadiran, dan kedisiplinan anak Anda.</p>
        </div>
        
        <form action="<?php echo e(route('wali.link-student')); ?>" method="POST" class="flex items-center gap-2">
            <?php echo csrf_field(); ?>
            <input type="text" name="student_code" placeholder="ID Siswa (Contoh: STU-ABC123)" required class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-full sm:w-64">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors shrink-0">
                + Tautkan Anak
            </button>
        </form>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php $__empty_1 = true; $__currentLoopData = ($reports ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            // EWS Logic Triggers
            $isNilaiRendah = $report['avgNilai'] < 70;
            $isPresensiBuruk = $report['presensi'] < 80;
            $hasMissedAssignments = $report['missedAssignments'] > 0;
            $hasWarning = $isNilaiRendah || $isPresensiBuruk || $hasMissedAssignments;
        ?>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 relative overflow-hidden">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 border-b border-gray-100 pb-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-2xl shadow-lg shadow-blue-500/30">
                        <?php echo e(strtoupper(substr($report['student']->name, 0, 1))); ?>

                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900 text-2xl font-outfit"><?php echo e($report['student']->name); ?></h2>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Siswa Aktif</span>
                            <?php if($hasWarning): ?>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600 animate-pulse">Butuh Perhatian</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">Performa Baik</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="flex gap-4 w-full md:w-auto mt-4 md:mt-0">
                    <div class="bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100 flex-1 md:flex-none text-center">
                        <p class="text-xs text-gray-500 font-medium mb-1">Rata-rata Nilai</p>
                        <p class="text-xl font-bold <?php echo e($isNilaiRendah ? 'text-red-600' : 'text-gray-900'); ?>"><?php echo e($report['avgNilai']); ?></p>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100 flex-1 md:flex-none text-center">
                        <p class="text-xs text-gray-500 font-medium mb-1">Kehadiran</p>
                        <p class="text-xl font-bold <?php echo e($isPresensiBuruk ? 'text-red-600' : 'text-gray-900'); ?>"><?php echo e($report['presensi']); ?>%</p>
                    </div>
                </div>
            </div>

            <!-- EWS Alerts -->
            <?php if($hasWarning): ?>
                <div class="mb-8 space-y-3">
                    <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Early Warning System (EWS)
                    </h3>
                    
                    <?php if($hasMissedAssignments): ?>
                    <div class="p-4 bg-orange-50 border border-orange-200 rounded-2xl flex items-start gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg text-orange-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-orange-900">Tugas Terlambat / Belum Dikerjakan</h4>
                            <p class="text-sm text-orange-700 mt-1">Siswa ini memiliki <strong><?php echo e($report['missedAssignments']); ?> tugas</strong> yang sudah melewati tenggat waktu (deadline) namun belum dikumpulkan. Mohon ingatkan anak Anda untuk segera menyelesaikan tugasnya.</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($isNilaiRendah): ?>
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
                        <div class="p-2 bg-red-100 rounded-lg text-red-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-900">Penurunan Performa Akademik</h4>
                            <p class="text-sm text-red-700 mt-1">Rata-rata nilai secara keseluruhan berada di bawah standar minimum (70). Evaluasi lebih lanjut mungkin diperlukan.</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($isPresensiBuruk): ?>
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-2xl flex items-start gap-3">
                        <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-yellow-900">Masalah Kehadiran</h4>
                            <p class="text-sm text-yellow-700 mt-1">Tingkat kehadiran siswa berada di angka <?php echo e($report['presensi']); ?>% (< 80%). Banyak absen dapat berdampak pada penyerapan materi pelajaran.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Bar Chart: Nilai -->
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 font-outfit">Grafik Rata-rata Nilai</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="gradeChart_<?php echo e($index); ?>"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart: Kehadiran -->
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 font-outfit">Distribusi Kehadiran</h3>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="attendanceChart_<?php echo e($index); ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full bg-white rounded-3xl p-12 border border-dashed border-gray-300 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Anak</h3>
            <p class="text-gray-500 font-medium max-w-md mx-auto mb-4">Akun Anda belum ditautkan dengan akun siswa manapun.</p>
            <p class="text-sm text-gray-400">Silakan masukkan ID Siswa pada kolom di atas untuk menautkan akun. Siswa dapat melihat ID mereka pada menu Edit Profil.</p>
        </div>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reports = <?php echo json_encode($reports ?? [], 15, 512) ?>;

            reports.forEach((report, index) => {
                // Konfigurasi Chart Nilai (Bar)
                const ctxGrade = document.getElementById('gradeChart_' + index);
                if (ctxGrade) {
                    new Chart(ctxGrade, {
                        type: 'bar',
                        data: {
                            labels: ['Tugas Harian', 'Kuis/Ujian'],
                            datasets: [{
                                label: 'Nilai Rata-rata',
                                data: [report.nilaiTugas, report.nilaiKuis],
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.8)', // blue-500
                                    'rgba(99, 102, 241, 0.8)'  // indigo-500
                                ],
                                borderRadius: 8,
                                barThickness: 40
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    grid: { color: '#f3f4f6' }
                                },
                                x: {
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    padding: 12,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function(context) {
                                            return ' Nilai: ' + context.parsed.y;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Konfigurasi Chart Kehadiran (Doughnut)
                const ctxAtt = document.getElementById('attendanceChart_' + index);
                if (ctxAtt) {
                    const attData = report.attendanceData; // [hadir, sakit, izin, alpa]
                    const totalAtt = attData.reduce((a, b) => a + b, 0);

                    if (totalAtt > 0) {
                        new Chart(ctxAtt, {
                            type: 'doughnut',
                            data: {
                                labels: ['Hadir', 'Sakit', 'Izin', 'Alpa'],
                                datasets: [{
                                    data: attData,
                                    backgroundColor: [
                                        '#10b981', // green-500
                                        '#f59e0b', // amber-500
                                        '#3b82f6', // blue-500
                                        '#ef4444'  // red-500
                                    ],
                                    borderWidth: 0,
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '70%',
                                plugins: {
                                    legend: {
                                        position: 'right',
                                        labels: {
                                            usePointStyle: true,
                                            padding: 20,
                                            font: { family: "'Inter', sans-serif" }
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        // Tampilkan pesan kosong jika belum ada data presensi
                        const container = ctxAtt.parentElement;
                        container.innerHTML = '<div class="flex flex-col items-center justify-center h-full text-gray-400"><svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><p class="text-sm">Belum ada data presensi</p></div>';
                    }
                }
            });
        });
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
<?php /**PATH C:\Users\user\ClassTrackRepo\resources\views/dashboard-wali.blade.php ENDPATH**/ ?>