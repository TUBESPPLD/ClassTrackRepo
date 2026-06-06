<x-layouts.app :title="'Rekap Nilai'">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rekapitulasi Nilai</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau seluruh nilai tugas dan kuis Anda di sini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Nilai Tugas -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Nilai Tugas
            </h2>
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                @forelse(($assignmentScores ?? []) as $score)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">{{ $score->assignment->title }}</h3>
                                <p class="text-xs text-gray-500">{{ $score->assignment->classroom->name ?? 'Kelas' }}</p>
                            </div>
                            <div class="px-3 py-1 bg-{{ $score->grade >= 70 ? 'green' : 'blue' }}-50 text-{{ $score->grade >= 70 ? 'green' : 'blue' }}-600 font-bold rounded-lg text-sm">
                                {{ $score->grade ?? 'Menunggu' }}
                            </div>
                        </div>
                        @if($score->feedback)
                            <div class="mt-2 p-2 bg-white rounded text-xs text-gray-600 border border-gray-100">
                                <strong>Feedback Guru:</strong> {{ $score->feedback }}
                            </div>
                        @endif
                        <div class="mt-2 text-[10px] font-medium {{ $score->status == 'TERLAMBAT' ? 'text-red-500' : 'text-gray-400' }}">
                            Status Kumpul: {{ str_replace('_', ' ', $score->status) }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada tugas yang dikumpulkan.</div>
                @endforelse
            </div>
        </div>

        <!-- Nilai Kuis -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Nilai Kuis
            </h2>
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                @forelse(($quizScores ?? []) as $score)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">{{ $score->quiz->title }}</h3>
                                <p class="text-xs text-gray-500">{{ $score->quiz->classroom->name ?? 'Kelas' }}</p>
                            </div>
                            <div class="px-3 py-1 bg-{{ $score->score >= 70 ? 'green' : 'red' }}-50 text-{{ $score->score >= 70 ? 'green' : 'red' }}-600 font-bold rounded-lg text-sm">
                                {{ $score->score }}
                            </div>
                        </div>
                        <div class="text-[10px] text-gray-400">
                            Dikerjakan: {{ \Carbon\Carbon::parse($score->submitted_at)->format('d M Y H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-xl">Belum ada kuis yang dikerjakan.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
