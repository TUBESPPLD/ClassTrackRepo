<x-layouts.app :title="'Kerjakan Kuis'">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -z-10"></div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-100 pb-6 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 font-outfit">{{ $quiz->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Jawablah pertanyaan di bawah ini dengan tepat.</p>
                </div>
                <div class="px-4 py-2 bg-yellow-50 border border-yellow-100 rounded-xl text-yellow-800 font-bold flex items-center gap-2 shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-yellow-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Sisa Waktu: <span id="timer" class="tracking-widest"></span>
                </div>
            </div>

            <form id="quiz-form" method="POST" action="{{ route('siswa.kuis', $quiz) }}" class="space-y-8">
                @csrf
                
                @php
                    // Pastikan questions sudah berupa collection Model Question atau Array
                    // Di backend SiswaController, load('questions') berarti relasi.
                @endphp

                @foreach($quiz->questions as $index => $question)
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 mb-4 text-base">{{ $question->question_text }}</p>
                                @if($question->image_path)
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($question->image_path) }}" alt="Gambar Soal" class="rounded-xl border border-gray-200 max-h-64 object-contain">
                                    </div>
                                @endif
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach(['a','b','c','d'] as $opt)
                                        <label class="flex items-start gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-200 transition-colors">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}" class="mt-1 text-purple-600 focus:ring-purple-500" required>
                                            <span class="text-sm text-gray-700 leading-tight">
                                                <span class="font-bold mr-1">{{ strtoupper($opt) }}.</span> 
                                                {{ $question['option_'.$opt] }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="pt-4 flex justify-end border-t border-gray-100">
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengumpulkan kuis ini? Jawaban tidak dapat diubah setelah dikumpulkan.')" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-500/30 transition-all transform hover:-translate-y-0.5">
                        Kumpulkan Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let seconds = {{ $quiz->duration_minutes }} * 60;
        const timerEl = document.getElementById('timer');
        const formEl = document.getElementById('quiz-form');
        
        function tick() {
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            timerEl.textContent = `${m}:${s}`;
            
            if (seconds <= 300) { // 5 menit terakhir
                timerEl.parentElement.classList.add('bg-red-50', 'text-red-800', 'border-red-100');
                timerEl.parentElement.classList.remove('bg-yellow-50', 'text-yellow-800', 'border-yellow-100');
            }

            if (seconds <= 0) {
                alert('Waktu habis! Kuis akan otomatis dikumpulkan.');
                formEl.submit();
                return;
            }
            seconds--;
            setTimeout(tick, 1000);
        }
        tick();
    </script>
</x-layouts.app>
