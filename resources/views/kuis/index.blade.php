<x-layouts.app :title="'Kelola Kuis - ' . $classroom->name">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('guru.kelas.show', $classroom) }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Kelola Kuis</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100">{{ $classroom->name }}</span>
            </div>
            <p class="text-sm text-gray-500 ml-9">Buat kuis pilihan ganda dan pantau hasilnya.</p>
        </div>
        <button onclick="document.getElementById('modal-buat-kuis').classList.remove('hidden')" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Kuis Baru
        </button>
    </div>

    <div class="space-y-6">
        @forelse(($quizzes ?? []) as $kuis)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row gap-6">
                <!-- Kuis Info -->
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $kuis->title }}</h3>
                                <div class="flex items-center gap-2 text-xs font-medium text-purple-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Durasi: {{ $kuis->duration_minutes }} Menit
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="document.getElementById('modal-edit-kuis-{{ $kuis->id }}').classList.remove('hidden')" class="p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('guru.kuis.delete', $kuis) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kuis ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Daftar Soal ({{ $kuis->questions->count() }})
                        </h4>
                        <div class="space-y-3 max-h-40 overflow-y-auto pr-2">
                            @foreach($kuis->questions as $index => $q)
                                <div class="text-sm">
                                    <p class="font-medium text-gray-800">
                                        {{ $index+1 }}. {{ $q->question_text }}
                                        @if($q->question_bank_question_id)
                                            <span class="ml-2 text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700">Bank Soal</span>
                                        @endif
                                    </p>
                                    <ul class="ml-4 mt-1 space-y-1 text-xs text-gray-500">
                                        @foreach(['a','b','c','d'] as $opt)
                                            <li class="{{ $q->correct_answer == $opt ? 'text-green-600 font-semibold' : '' }}">
                                                {{ strtoupper($opt) }}. {{ $q->{'option_'.$opt} }}
                                                @if($q->correct_answer == $opt) ✓ @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Attempts Area -->
                <div class="w-full lg:w-1/3 bg-blue-50/30 rounded-2xl p-5 border border-blue-100/50 flex flex-col">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Hasil Siswa ({{ $kuis->attempts->count() }})
                    </h4>
                    
                    <div class="flex-1 overflow-y-auto pr-2 space-y-2">
                        @forelse($kuis->attempts as $attempt)
                            <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ $attempt->student->name ?? 'Siswa' }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($attempt->created_at)->format('d M H:i') }}</p>
                                </div>
                                <div class="px-3 py-1 bg-{{ $attempt->score >= 70 ? 'green' : 'red' }}-50 text-{{ $attempt->score >= 70 ? 'green' : 'red' }}-600 font-bold rounded-lg text-sm">
                                    {{ $attempt->score }}
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500 text-center py-4">Belum ada siswa yang mengerjakan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 border border-dashed border-purple-200 text-center">
                <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Kuis</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6 text-sm">Anda belum membuat kuis untuk kelas ini. Klik tombol di atas untuk membuat kuis interaktif.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Create Kuis -->
    <div id="modal-buat-kuis" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-2xl p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-buat-kuis').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Buat Kuis Baru</h3>

            <form method="POST" action="{{ route('guru.kuis', $classroom) }}" enctype="multipart/form-data" x-data="{ submitting: false, questions: [ { q: '', a:'', b:'', c:'', d:'', correct:'a' } ] }" @submit="submitting = true">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Kuis <span class="text-red-500">*</span></label>
                        <input name="title" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Durasi (Menit) <span class="text-red-500">*</span></label>
                        <input type="number" name="duration_minutes" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm" required value="30" min="5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batas Waktu <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ambil Soal dari Bank Soal (Opsional)</label>
                    @if(count($bankQuestions ?? []) > 0)
                        <select name="question_bank_ids[]" multiple class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-sm">
                            @foreach(($bankQuestions ?? []) as $qb)
                                <option value="{{ $qb->id }}">#{{ $qb->id }} — {{ \Illuminate\Support\Str::limit($qb->question_text, 80) }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Soal yang dipilih akan disalin ke kuis sebagai referensi dari bank soal.</p>
                    @else
                        <div class="w-full border border-gray-200 border-dashed rounded-xl px-4 py-6 bg-gray-50 text-center text-sm text-gray-500">
                            Belum ada soal di Bank Soal. Silakan tambahkan soal terlebih dahulu di menu <a href="{{ route('guru.bank-soal.index', $classroom) }}" class="text-blue-600 hover:underline">Bank Soal</a>.
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 border-b pb-2">Daftar Pertanyaan (Manual)</h4>
                </div>

                <div class="space-y-6 max-h-96 overflow-y-auto pr-2">
                    <template x-for="(item, index) in questions" :key="index">
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50 relative">
                            <button type="button" @click="questions.splice(index, 1)" x-show="questions.length > 1" class="absolute top-3 right-3 text-red-500 hover:bg-red-50 p-1 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pertanyaan <span x-text="index + 1"></span></label>
                            <textarea :name="'questions['+index+'][question]'" x-model="item.q" class="w-full border rounded-lg px-3 py-2 text-sm mb-3" rows="2" required></textarea>
                            
                            <div class="mb-3">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Upload Gambar Soal (Opsional, JPG/PNG)</label>
                                <input type="file" :name="'questions['+index+'][image]'" accept=".jpg,.jpeg,.png" class="w-full border rounded-lg px-3 py-2 text-sm bg-white">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi A</label>
                                    <input type="text" :name="'questions['+index+'][options][a]'" x-model="item.a" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi B</label>
                                    <input type="text" :name="'questions['+index+'][options][b]'" x-model="item.b" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi C</label>
                                    <input type="text" :name="'questions['+index+'][options][c]'" x-model="item.c" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi D</label>
                                    <input type="text" :name="'questions['+index+'][options][d]'" x-model="item.d" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jawaban Benar</label>
                                <select :name="'questions['+index+'][correct]'" x-model="item.correct" class="w-full md:w-1/2 border rounded-lg px-3 py-2 text-sm">
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                </select>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-4 flex gap-3">
                    <button type="button" @click="questions.push({ q: '', a:'', b:'', c:'', d:'', correct:'a' })" class="px-4 py-2 bg-purple-50 text-purple-600 rounded-xl font-medium text-sm hover:bg-purple-100">
                        + Tambah Soal
                    </button>
                    <button type="submit" :disabled="submitting" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-2 font-bold hover:shadow-lg transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan Kuis</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @foreach(($quizzes ?? []) as $kuis)
    <!-- Modal Edit Kuis -->
    <div id="modal-edit-kuis-{{ $kuis->id }}" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-2xl p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-edit-kuis-{{ $kuis->id }}').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Kuis: {{ $kuis->title }}</h3>
            @php
                $quizQuestions = $kuis->questions->map(function($q) {
                    return [
                        'id' => $q->id,
                        'q' => $q->question_text,
                        'a' => $q->option_a,
                        'b' => $q->option_b,
                        'c' => $q->option_c,
                        'd' => $q->option_d,
                        'correct' => $q->correct_answer,
                        'image' => $q->image_path ? \Illuminate\Support\Facades\Storage::url($q->image_path) : null
                    ];
                })->toArray();
                if(empty($quizQuestions)) {
                    $quizQuestions = [['q' => '', 'a'=>'', 'b'=>'', 'c'=>'', 'd'=>'', 'correct'=>'a']];
                }
            @endphp
            <form method="POST" action="{{ route('guru.kuis.update', $kuis) }}" enctype="multipart/form-data" x-data="{ submitting: false, questions: {{ json_encode($quizQuestions) }} }" @submit="submitting = true">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Kuis <span class="text-red-500">*</span></label>
                        <input name="title" value="{{ $kuis->title }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Durasi (Menit) <span class="text-red-500">*</span></label>
                        <input type="number" name="duration_minutes" value="{{ $kuis->duration_minutes }}" min="5" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batas Waktu <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" value="{{ $kuis->deadline ? \Carbon\Carbon::parse($kuis->deadline)->format('Y-m-d\TH:i') : '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 border-b pb-2">Daftar Pertanyaan</h4>
                </div>

                <div class="space-y-6 max-h-96 overflow-y-auto pr-2 mb-6">
                    <template x-for="(item, index) in questions" :key="index">
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50 relative">
                            <button type="button" @click="questions.splice(index, 1)" x-show="questions.length > 1" class="absolute top-3 right-3 text-red-500 hover:bg-red-50 p-1 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            
                            <input type="hidden" :name="'questions['+index+'][id]'" x-model="item.id">

                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pertanyaan <span x-text="index + 1"></span></label>
                            <textarea :name="'questions['+index+'][question]'" x-model="item.q" class="w-full border rounded-lg px-3 py-2 text-sm mb-3" rows="2" required></textarea>
                            
                            <div class="mb-3">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Upload Gambar Soal (Opsional, timpa gambar lama)</label>
                                <div class="flex items-center gap-3">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="h-12 w-12 object-cover rounded border">
                                    </template>
                                    <input type="file" :name="'questions['+index+'][image]'" accept=".jpg,.jpeg,.png" class="flex-1 border rounded-lg px-3 py-2 text-sm bg-white">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi A</label>
                                    <input type="text" :name="'questions['+index+'][options][a]'" x-model="item.a" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi B</label>
                                    <input type="text" :name="'questions['+index+'][options][b]'" x-model="item.b" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi C</label>
                                    <input type="text" :name="'questions['+index+'][options][c]'" x-model="item.c" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 block mb-1">Opsi D</label>
                                    <input type="text" :name="'questions['+index+'][options][d]'" x-model="item.d" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jawaban Benar</label>
                                <select :name="'questions['+index+'][correct]'" x-model="item.correct" class="w-full md:w-1/2 border rounded-lg px-3 py-2 text-sm">
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                </select>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div class="mt-4 flex gap-3">
                    <button type="button" @click="questions.push({ id: null, q: '', a:'', b:'', c:'', d:'', correct:'a', image: null })" class="px-4 py-2 bg-purple-50 text-purple-600 rounded-xl font-medium text-sm hover:bg-purple-100">
                        + Tambah Soal
                    </button>
                    <button type="submit" :disabled="submitting" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-2 font-bold hover:shadow-lg transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan Perubahan</span>
                        <span x-show="submitting">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</x-layouts.app>
