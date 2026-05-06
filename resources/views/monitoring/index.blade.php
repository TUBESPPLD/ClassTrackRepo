<x-layouts.app :title="'Monitoring Kelas - ' . $classroom->name">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('guru.kelas.show', $classroom) }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Monitoring & EWS</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100">{{ $classroom->name }}</span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Pantau rata-rata nilai, persentase kehadiran, dan siswa berisiko.</p>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Siswa Terdaftar</p>
                <p class="text-3xl font-bold text-gray-900">{{ count($data) }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        @php
            $totalNilai = 0;
            $totalPresensi = 0;
            $siswaBerisiko = 0;
            foreach($data as $d) {
                $totalNilai += $d['avgNilai'];
                $totalPresensi += $d['presensi'];
                if($d['avgNilai'] < 70 || $d['presensi'] < 75) {
                    $siswaBerisiko++;
                }
            }
            $avgKelasNilai = count($data) > 0 ? round($totalNilai / count($data), 2) : 0;
            $avgKelasPresensi = count($data) > 0 ? round($totalPresensi / count($data), 2) : 0;
        @endphp

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Rata-rata Nilai Kelas</p>
                <p class="text-3xl font-bold {{ $avgKelasNilai < 70 ? 'text-red-600' : 'text-green-600' }}">{{ $avgKelasNilai }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between relative overflow-hidden">
            @if($siswaBerisiko > 0)
                <div class="absolute top-0 right-0 w-2 h-full bg-red-500"></div>
            @endif
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Siswa Berisiko (EWS)</p>
                <p class="text-3xl font-bold {{ $siswaBerisiko > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $siswaBerisiko }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Chart Nilai -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Rata-rata Nilai Siswa</h3>
            <canvas id="nilaiChart" height="200"></canvas>
        </div>

        <!-- Chart Kehadiran -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Persentase Kehadiran</h3>
            <canvas id="presensiChart" height="200"></canvas>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Detail Laporan Siswa</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 font-semibold text-center">Rata-rata Nilai</th>
                        <th class="px-6 py-4 font-semibold text-center">Persentase Kehadiran</th>
                        <th class="px-6 py-4 font-semibold text-center">Status (EWS)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($data as $d)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $d['student']->name }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="{{ $d['avgNilai'] < 70 ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                    {{ $d['avgNilai'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="{{ $d['presensi'] < 75 ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                    {{ $d['presensi'] }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($d['avgNilai'] < 70 || $d['presensi'] < 75)
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Berisiko
                                        </span>
                                        <button onclick="openRemedialModal({{ $d['student']->id }}, '{{ addslashes($d['student']->name) }}')" class="p-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm tooltip" title="Tindak Lanjut Akademik (Remedial)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-bold">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data siswa di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Remedial -->
    <div id="modal-remedial" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-xl relative">
            <button onclick="document.getElementById('modal-remedial').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">Modul Tindak Lanjut Akademik</h3>
                <p class="text-sm text-gray-500 mt-1">Berikan tugas remedial untuk siswa <strong id="remedial-student-name"></strong>.</p>
            </div>

            <form method="POST" action="{{ route('guru.remedial') }}" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                <input type="hidden" name="student_id" id="remedial-student-id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Tugas Asli (Opsional)</label>
                        <select name="assignment_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-sm">
                            <option value="">-- Hanya Remedial Umum --</option>
                            @foreach($classroom->assignments as $assignment)
                                <option value="{{ $assignment->id }}">{{ $assignment->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batas Waktu (Deadline)</label>
                        <input type="datetime-local" name="deadline" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-sm" required>
                    </div>
                    <button :disabled="submitting" class="w-full bg-red-600 text-white rounded-xl py-3 font-bold hover:bg-red-700 transition-all disabled:opacity-70">
                        <span x-show="!submitting">Beri Remedial</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Chart Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = {!! json_encode(array_map(function($i) { return $i['student']->name; }, $data)) !!};
            const nilaiData = {!! json_encode(array_column($data, 'avgNilai')) !!};
            const presensiData = {!! json_encode(array_column($data, 'presensi')) !!};

            // Chart Nilai
            new Chart(document.getElementById('nilaiChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: nilaiData,
                        backgroundColor: nilaiData.map(val => val < 70 ? 'rgba(239, 68, 68, 0.7)' : 'rgba(59, 130, 246, 0.7)'),
                        borderColor: nilaiData.map(val => val < 70 ? 'rgb(239, 68, 68)' : 'rgb(59, 130, 246)'),
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 100 }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Chart Presensi
            new Chart(document.getElementById('presensiChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Persentase Kehadiran (%)',
                        data: presensiData,
                        backgroundColor: presensiData.map(val => val < 75 ? 'rgba(239, 68, 68, 0.7)' : 'rgba(16, 185, 129, 0.7)'),
                        borderColor: presensiData.map(val => val < 75 ? 'rgb(239, 68, 68)' : 'rgb(16, 185, 129)'),
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 100 }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });

        function openRemedialModal(studentId, studentName) {
            document.getElementById('remedial-student-id').value = studentId;
            document.getElementById('remedial-student-name').textContent = studentName;
            document.getElementById('modal-remedial').classList.remove('hidden');
        }
    </script>
</x-layouts.app>
