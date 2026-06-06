<x-layouts.app :title="'Kelola Tugas - ' . $classroom->name">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('guru.kelas.show', $classroom) }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Kelola Tugas</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100">{{ $classroom->name }}</span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Buat tugas baru dan berikan penilaian kepada siswa.</p>
        </div>
        <button onclick="document.getElementById('modal-buat-tugas').classList.remove('hidden')" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Tugas Baru
        </button>
    </div>

    <div class="space-y-6">
        @forelse(($assignments ?? []) as $tugas)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div class="w-full flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $tugas->title }}</h3>
                                <div class="flex items-center gap-2 text-xs font-medium text-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="document.getElementById('modal-edit-tugas-{{ $tugas->id }}').classList.remove('hidden')" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('guru.tugas.delete', $tugas) }}" method="POST" id="form-delete-tugas-{{ $tugas->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('form-delete-tugas-{{ $tugas->id }}', 'Yakin ingin menghapus tugas ini? Semua data pengumpulan siswa akan ikut terhapus.')" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ $tugas->description }}</p>
                    @if($tugas->file_path)
                        <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat File Lampiran Soal
                        </a>
                    @endif

                    @if(($tugas->questionBankReferences ?? collect())->count() > 0)
                        <div class="mt-3 p-3 bg-gray-50 border border-gray-100 rounded-xl">
                            <p class="text-xs font-semibold text-gray-700">Referensi Bank Soal ({{ $tugas->questionBankReferences->count() }})</p>
                            <ul class="mt-2 space-y-1 text-xs text-gray-600 list-disc list-inside">
                                @foreach($tugas->questionBankReferences->take(3) as $ref)
                                    <li>{{ \Illuminate\Support\Str::limit($ref->question_text, 120) }}</li>
                                @endforeach
                            </ul>
                            @if($tugas->questionBankReferences->count() > 3)
                                <p class="text-[10px] text-gray-500 mt-2">+ {{ $tugas->questionBankReferences->count() - 3 }} soal lainnya</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Submissions Area -->
                <div class="w-full lg:w-1/2 bg-gray-50/50 rounded-2xl p-5 border border-gray-100">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Pengumpulan ({{ $tugas->submissions->count() }} Siswa)
                    </h4>
                    
                    <div class="max-h-60 overflow-y-auto pr-2 space-y-3">
                        @forelse($tugas->submissions as $sub)
                            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $sub->student->name ?? 'Siswa' }}</p>
                                        <p class="text-xs text-gray-500">Waktu Kumpul: {{ \Carbon\Carbon::parse($sub->submitted_at)->format('d M Y H:i') }}</p>
                                        @if($sub->status == 'TERLAMBAT')
                                            <span class="inline-block px-2 py-0.5 mt-1 bg-red-50 text-red-600 rounded text-[10px] font-bold">TERLAMBAT</span>
                                        @endif
                                    </div>
                                    <a href="{{ Storage::url($sub->file_path) }}" target="_blank" class="text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline">Cek Jawaban</a>
                                </div>
                                
                                <form method="POST" action="{{ route('guru.nilai', $sub) }}" class="mt-3 flex gap-2">
                                    @csrf
                                    <div class="flex-1">
                                        <input type="number" name="grade" placeholder="Nilai (0-100)" value="{{ $sub->grade }}" class="w-full text-xs border rounded-lg px-3 py-2 bg-gray-50 focus:bg-white" required min="0" max="100">
                                    </div>
                                    <div class="flex-2">
                                        <input type="text" name="feedback" placeholder="Komentar singkat..." value="{{ $sub->feedback }}" class="w-full text-xs border rounded-lg px-3 py-2 bg-gray-50 focus:bg-white">
                                    </div>
                                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-medium hover:bg-indigo-700">Simpan</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500 text-center py-4">Belum ada siswa yang mengumpulkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 border border-dashed border-gray-200 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Tugas</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6 text-sm">Anda belum membuat tugas untuk kelas ini. Klik tombol di atas untuk membuat tugas baru.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Create Tugas -->
    <div id="modal-buat-tugas" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-lg p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-buat-tugas').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Buat Tugas Baru</h3>

            <form method="POST" action="{{ route('guru.tugas', $classroom) }}" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
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

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Referensi Bank Soal (Opsional)</label>
                        @if(count($bankQuestions ?? []) > 0)
                            <select name="question_bank_ids[]" multiple class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-sm">
                                @foreach(($bankQuestions ?? []) as $qb)
                                    <option value="{{ $qb->id }}">#{{ $qb->id }} — {{ \Illuminate\Support\Str::limit($qb->question_text, 80) }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Soal ini hanya sebagai referensi di tugas (bukan auto-grading).</p>
                        @else
                            <div class="w-full border border-gray-200 border-dashed rounded-xl px-4 py-6 bg-gray-50 text-center text-sm text-gray-500">
                                Belum ada soal di Bank Soal. Silakan tambahkan soal terlebih dahulu di menu <a href="{{ route('guru.bank-soal.index', $classroom) }}" class="text-blue-600 hover:underline">Bank Soal</a>.
                            </div>
                        @endif
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
    @foreach(($assignments ?? []) as $tugas)
    <!-- Modal Edit Tugas -->
    <div id="modal-edit-tugas-{{ $tugas->id }}" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-lg p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-edit-tugas-{{ $tugas->id }}').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Tugas</h3>
            <form method="POST" action="{{ route('guru.tugas.update', $tugas) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Tugas <span class="text-red-500">*</span></label>
                        <input name="title" value="{{ $tugas->title }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Segmen / Pertemuan</label>
                        <input name="segment" value="{{ $tugas->segment }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi / Instruksi</label>
                        <textarea name="description" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50" rows="3">{{ $tugas->description }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batas Waktu (Deadline) <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" value="{{ \Carbon\Carbon::parse($tugas->deadline)->format('Y-m-d\TH:i') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">File Lampiran Baru (Opsional)</label>
                        <input type="file" name="file" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah file lama.</p>
                    </div>
                    <button class="w-full bg-blue-600 text-white rounded-xl py-3.5 font-bold hover:shadow-lg transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</x-layouts.app>
