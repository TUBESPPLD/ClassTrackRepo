<x-layouts.app :title="'Dashboard Wali'">
    <div class="mb-6 flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 font-outfit">Pemantauan Akademik (Wali Murid)</h1>
            <p class="text-sm text-gray-500 mt-2">Pantau perkembangan akademik, kehadiran, dan kedisiplinan anak Anda.</p>
        </div>
        
        <form action="{{ route('wali.link-student') }}" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="email" name="email" placeholder="Email Siswa" required class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-full sm:w-auto">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors shrink-0">
                + Tautkan Anak
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    @forelse(($reports ?? []) as $index => $report)
        @php
            // EWS Logic Triggers
            $isNilaiRendah = $report['avgNilai'] < 70;
            $isPresensiBuruk = $report['presensi'] < 80;
            $hasMissedAssignments = $report['missedAssignments'] > 0;
            $hasWarning = $isNilaiRendah || $isPresensiBuruk || $hasMissedAssignments;
        @endphp

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 relative overflow-hidden">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 border-b border-gray-100 pb-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-2xl shadow-lg shadow-blue-500/30">
                        {{ strtoupper(substr($report['student']->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900 text-2xl font-outfit">{{ $report['student']->name }}</h2>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Siswa Aktif</span>
                            @if($hasWarning)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600 animate-pulse">Butuh Perhatian</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">Performa Baik</span>
                            @endif
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 font-outfit">Pemantauan Wali Murid</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau perkembangan akademik dan kehadiran anak Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse(($reports ?? []) as $report)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all relative overflow-hidden">
                <!-- Status Indicator -->
                @if($report['avgNilai'] < 70 || $report['presensi'] < 75)
                    <div class="absolute top-0 right-0 w-2 h-full bg-red-500"></div>
                @else
                    <div class="absolute top-0 right-0 w-2 h-full bg-green-500"></div>
                @endif

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-blue-100 to-indigo-100 text-blue-600 flex items-center justify-center font-bold text-xl border-2 border-white shadow-sm">
                        {{ strtoupper(substr($report['student']->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $report['student']->name }}</h3>
                        <p class="text-xs text-gray-500">Siswa Terdaftar</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-600">Rata-rata Nilai</span>
                            <span class="font-bold {{ $report['avgNilai'] < 70 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $report['avgNilai'] }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="{{ $report['avgNilai'] < 70 ? 'bg-red-500' : 'bg-green-500' }} h-1.5 rounded-full" style="width: {{ min(100, $report['avgNilai']) }}%"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-600">Kehadiran</span>
                            <span class="font-bold {{ $report['presensi'] < 75 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $report['presensi'] }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="{{ $report['presensi'] < 75 ? 'bg-red-500' : 'bg-green-500' }} h-1.5 rounded-full" style="width: {{ min(100, $report['presensi']) }}%"></div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <!-- Quick Stats -->
                <div class="flex gap-4 w-full md:w-auto">
                    <div class="bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100 flex-1 md:flex-none text-center">
                        <p class="text-xs text-gray-500 font-medium mb-1">Rata-rata Nilai</p>
                        <p class="text-xl font-bold {{ $isNilaiRendah ? 'text-red-600' : 'text-gray-900' }}">{{ $report['avgNilai'] }}</p>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100 flex-1 md:flex-none text-center">
                        <p class="text-xs text-gray-500 font-medium mb-1">Kehadiran</p>
                        <p class="text-xl font-bold {{ $isPresensiBuruk ? 'text-red-600' : 'text-gray-900' }}">{{ $report['presensi'] }}%</p>
                    </div>
                </div>
            </div>

            <!-- EWS Alerts -->
            @if($hasWarning)
                <div class="mb-8 space-y-3">
                    <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Early Warning System (EWS)
                    </h3>
                    
                    @if($hasMissedAssignments)
                    <div class="p-4 bg-orange-50 border border-orange-200 rounded-2xl flex items-start gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg text-orange-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-orange-900">Tugas Terlambat / Belum Dikerjakan</h4>
                            <p class="text-sm text-orange-700 mt-1">Siswa ini memiliki <strong>{{ $report['missedAssignments'] }} tugas</strong> yang sudah melewati tenggat waktu (deadline) namun belum dikumpulkan. Mohon ingatkan anak Anda untuk segera menyelesaikan tugasnya.</p>
                        </div>
                    </div>
                    @endif

                    @if($isNilaiRendah)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
                        <div class="p-2 bg-red-100 rounded-lg text-red-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-900">Penurunan Performa Akademik</h4>
                            <p class="text-sm text-red-700 mt-1">Rata-rata nilai secara keseluruhan berada di bawah standar minimum (70). Evaluasi lebih lanjut mungkin diperlukan.</p>
                        </div>
                    </div>
                    @endif

                    @if($isPresensiBuruk)
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-2xl flex items-start gap-3">
                        <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-yellow-900">Masalah Kehadiran</h4>
                            <p class="text-sm text-yellow-700 mt-1">Tingkat kehadiran siswa berada di angka {{ $report['presensi'] }}% (< 80%). Banyak absen dapat berdampak pada penyerapan materi pelajaran.</p>
                        </div>
                    </div>
                    @endif
                </div>
            @endif

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Bar Chart: Nilai -->
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 font-outfit">Grafik Rata-rata Nilai</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="gradeChart_{{ $index }}"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart: Kehadiran -->
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 font-outfit">Distribusi Kehadiran</h3>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="attendanceChart_{{ $index }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-3xl p-12 border border-dashed border-gray-300 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Anak</h3>
            <p class="text-gray-500 font-medium max-w-md mx-auto mb-4">Akun Anda belum ditautkan dengan akun siswa manapun.</p>
            <p class="text-sm text-gray-400">Silakan masukkan email akun anak Anda pada kolom di atas untuk menautkan akun.</p>
        </div>
    @endforelse

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reports = @json($reports ?? []);

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
    @endpush
=======
                @if($report['avgNilai'] < 70 || $report['presensi'] < 75)
                    <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-xl flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-xs text-red-700 font-medium">Perhatian: Nilai atau kehadiran anak Anda berada di bawah batas standar (Nilai: 70, Kehadiran: 75%).</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-8 border border-dashed border-gray-300 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="text-gray-500 font-medium">Belum ada data siswa yang terkait dengan akun Anda.</p>
                <p class="text-sm text-gray-400 mt-1">Silakan hubungi administrator sekolah untuk menautkan akun siswa.</p>
            </div>
        @endforelse
    </div>
>>>>>>> 3840a17ecb839c4d9177fdfa81cff35aeea9ac9e
</x-layouts.app>
