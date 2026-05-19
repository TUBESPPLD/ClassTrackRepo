<x-layouts.app :title="'Ruang Kelas - ' . $classroom->name">
    @if($classroom->cover_image)
        <div class="h-48 rounded-2xl mb-6 overflow-hidden relative shadow-sm">
            <img src="{{ str_starts_with($classroom->cover_image, 'http') ? $classroom->cover_image : Storage::url($classroom->cover_image) }}" alt="Cover Kelas" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="{{ route('siswa.dashboard') }}" class="text-white/80 hover:text-white transition-colors bg-black/20 p-1.5 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <h1 class="text-3xl font-bold text-white shadow-sm">{{ $classroom->name }}</h1>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white rounded-full text-xs font-semibold border border-white/30">{{ $classroom->class_code }}</span>
                    </div>
                    <p class="text-sm text-gray-200 ml-10">Pengajar: {{ $classroom->teacher->name ?? 'Admin' }}</p>
                </div>
            </div>
        </div>
    @else
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
    @endif

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
                            <div class="text-gray-700 text-sm ml-7 mb-3 prose prose-sm max-w-none trix-content">
                                {!! $announcement->content !!}
                            </div>
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
                            <button onclick="document.getElementById('modal-materi-{{ $materi->id }}').classList.remove('hidden')" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                Lihat Detail <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
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

                                    @if(method_exists($tugas, 'questionBankReferences') && $tugas->questionBankReferences->isNotEmpty())
                                        <div class="mb-3 text-xs text-gray-600">
                                            Referensi Bank Soal:
                                            <ul class="list-disc ml-5 mt-1">
                                                @foreach($tugas->questionBankReferences as $ref)
                                                    <li>{{ $ref->question_text }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    @php
                                        $submission = $tugas->submissions()->where('student_id', auth()->id())->first();
                                        $remedial = ($remedials ?? collect())->get($tugas->id);
                                        $effectiveDeadline = $remedial ? $remedial->deadline : $tugas->deadline;
                                        $effectivePast = \Carbon\Carbon::parse($effectiveDeadline)->isPast();
                                    @endphp

                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-1 text-xs font-medium {{ $effectivePast ? 'text-red-500' : 'text-orange-500' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}
                                            @if($remedial)
                                                <span class="ml-2 inline-block text-[10px] px-2 py-1 rounded bg-yellow-100 text-yellow-800">
                                                    Remedial sampai {{ \Carbon\Carbon::parse($remedial->deadline)->format('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($tugas->file_path)
                                            <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline">File Soal</a>
                                        @endif
                                    </div>

                                    @if($remedial && $remedial->note)
                                        <div class="mb-3 p-3 bg-yellow-50 text-yellow-800 text-xs border border-yellow-100 rounded-lg">
                                            Catatan remedial: {{ $remedial->note }}
                                        </div>
                                    @endif

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
                                        @if($effectivePast)
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
                                        $attempt = $kuis->attempts()->where('student_id', auth()->id())->latest('created_at')->first();
                                        $quizRemedial = ($remedialQuizzes ?? collect())->get($kuis->id);
                                        $canTakeQuiz = !$attempt || ($quizRemedial && $quizRemedial->status === 'assigned');
                                    @endphp

                                    @if($quizRemedial && $quizRemedial->note)
                                        <div class="mb-3 p-3 bg-yellow-50 text-yellow-800 text-xs border border-yellow-100 rounded-lg">
                                            Catatan remedial: {{ $quizRemedial->note }}
                                        </div>
                                    @endif

                                    @if(!$canTakeQuiz && $attempt)
                                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-100 text-center">
                                            <p class="text-xs text-purple-700 font-semibold mb-1">Sudah Dikerjakan</p>
                                            <p class="text-lg font-bold text-gray-800">Nilai: <span class="text-purple-600">{{ $attempt->score }}</span>/100</p>
                                        </div>
                                    @else
                                        @if($attempt && $quizRemedial)
                                            <div class="mb-3 p-3 bg-yellow-50 text-yellow-800 text-xs border border-yellow-100 rounded-lg text-center">
                                                Kamu mendapat Remedial. Nilai sebelumnya: {{ $attempt->score }}
                                            </div>
                                        @endif
                                        <a href="{{ route('siswa.kuis', $kuis) }}" class="block w-full text-center py-2 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-medium rounded-lg text-sm hover:shadow-md transition-shadow">
                                            {{ $attempt ? 'Kerjakan Remedial' : 'Mulai Kerjakan' }}
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
    @foreach($classroom->materials as $materi)
    <div id="modal-materi-{{ $materi->id }}" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-2xl p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-materi-{{ $materi->id }}').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ $materi->title }}</h3>
                    @if($materi->segment)
                        <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-lg mt-2">{{ $materi->segment }}</span>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-5 mb-6 text-gray-700 text-sm leading-relaxed border border-gray-100">
                {{ $materi->description ?? 'Tidak ada deskripsi.' }}
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                @if($materi->file_path)
                <a href="{{ Storage::url($materi->file_path) }}" target="_blank" class="flex-1 bg-indigo-600 text-white rounded-xl py-3 px-4 font-semibold text-center hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Dokumen
                </a>
                @endif
                @if($materi->link_url)
                <a href="{{ $materi->link_url }}" target="_blank" class="flex-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-xl py-3 px-4 font-semibold text-center hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Buka Tautan Eksternal
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @push('scripts')
    <style>
        .trix-content ul { list-style-type: disc !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
        .trix-content ol { list-style-type: decimal !important; padding-left: 2rem !important; margin-bottom: 1rem !important; }
        .trix-content a { color: #2563eb !important; text-decoration: underline !important; }
    </style>
    @endpush
</x-layouts.app>
