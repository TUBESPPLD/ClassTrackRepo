<x-layouts.app :title="'Ruang Kelas - ' . $classroom->name">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('siswa.dashboard') }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">{{ $classroom->name }}</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100">{{ $classroom->class_code }}</span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Pengajar: {{ $classroom->teacher->name ?? 'Admin' }}</p>
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
                    @forelse($classroom->announcements as $announcement)
                        <div class="p-5 border border-blue-100 rounded-xl bg-blue-50/30">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <h3 class="font-semibold text-gray-800">{{ $announcement->title }}</h3>
                            </div>
                            <p class="text-gray-600 text-sm ml-7 mb-2">{{ $announcement->content }}</p>
                            <p class="text-xs text-gray-400 ml-7">{{ $announcement->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada pengumuman dari guru.</div>
                    @endforelse
                </div>
            </div>

            <!-- MATERI TAB -->
            <div x-show="tab === 'materi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Materi Pembelajaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($classroom->materials as $materi)
                        <div class="p-5 border border-gray-100 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow group">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">{{ $materi->title }}</h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $materi->description }}</p>
                            <a href="{{ Storage::url($materi->file_path) }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                Unduh Materi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada materi diunggah oleh guru.</div>
                    @endforelse
                </div>
            </div>

            <!-- TUGAS TAB -->
            <div x-show="tab === 'tugas'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Tugas -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Tugas Kelas</h2>
                        <div class="space-y-4">
                            @forelse($classroom->assignments as $tugas)
                                <div class="p-5 border border-gray-100 rounded-xl bg-white shadow-sm hover:border-blue-200 transition-colors">
                                    <h3 class="font-bold text-gray-800 mb-1">{{ $tugas->title }}</h3>
                                    <p class="text-xs text-gray-500 mb-3">{{ $tugas->description }}</p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-1 text-xs font-medium {{ \Carbon\Carbon::parse($tugas->deadline)->isPast() ? 'text-red-500' : 'text-orange-500' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}
                                        </div>
                                        @if($tugas->file_path)
                                            <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline">File Soal</a>
                                        @endif
                                    </div>

                                    @php
                                        $submission = $tugas->submissions()->where('student_id', auth()->id())->first();
                                    @endphp

                                    @if($submission)
                                        <div class="p-3 bg-green-50 rounded-lg border border-green-100 flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-green-700 font-semibold flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Telah Dikumpulkan
                                                </p>
                                                @if($submission->grade !== null)
                                                    <p class="text-sm font-bold text-gray-800 mt-1">Nilai: <span class="text-blue-600">{{ $submission->grade }}</span>/100</p>
                                                @else
                                                    <p class="text-xs text-gray-500 mt-1">Menunggu Penilaian</p>
                                                @endif
                                            </div>
                                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-xs text-green-600 hover:underline">Lihat Jawaban</a>
                                        </div>
                                    @else
                                        @if(\Carbon\Carbon::parse($tugas->deadline)->isPast())
                                            <div class="p-3 bg-red-50 text-red-600 text-xs font-semibold border border-red-100 rounded-lg text-center">
                                                Waktu Pengumpulan Telah Habis
                                            </div>
                                        @else
                                            <form method="POST" action="{{ route('siswa.submit', $tugas) }}" enctype="multipart/form-data" class="mt-2 border-t border-gray-100 pt-3">
                                                @csrf
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Unggah Jawaban (PDF/DOC)</label>
                                                <div class="flex gap-2">
                                                    <input type="file" name="file" class="w-full text-xs border rounded-lg p-1.5" required>
                                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-blue-700 shrink-0">Kirim</button>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada tugas.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Kuis -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-6">Kuis Interaktif</h2>
                        <div class="space-y-4">
                            @forelse($classroom->quizzes as $kuis)
                                <div class="p-5 border border-gray-100 rounded-xl bg-white shadow-sm hover:border-purple-200 transition-colors">
                                    <h3 class="font-bold text-gray-800 mb-1">{{ $kuis->title }}</h3>
                                    <div class="flex items-center gap-1 text-xs font-medium text-purple-600 mb-4">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Waktu: {{ $kuis->duration_minutes }} Menit
                                    </div>

                                    @php
                                        $attempt = $kuis->attempts()->where('student_id', auth()->id())->first();
                                    @endphp

                                    @if($attempt)
                                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-100 text-center">
                                            <p class="text-xs text-purple-700 font-semibold mb-1">Sudah Dikerjakan</p>
                                            <p class="text-lg font-bold text-gray-800">Nilai: <span class="text-purple-600">{{ $attempt->score }}</span>/100</p>
                                        </div>
                                    @else
                                        <a href="{{ route('siswa.kuis', $kuis) }}" class="block w-full text-center py-2 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-medium rounded-lg text-sm hover:shadow-md transition-shadow">
                                            Mulai Kerjakan
                                        </a>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada kuis.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
