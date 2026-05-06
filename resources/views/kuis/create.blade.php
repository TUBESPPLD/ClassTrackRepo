<form method="POST" action="{{ route('guru.kuis', $classroom) }}" class="bg-white p-4 rounded shadow grid gap-2">
    @csrf
    <input name="title" class="border p-2 rounded" placeholder="Judul kuis" required>
    <input name="duration_minutes" type="number" min="1" class="border p-2 rounded" placeholder="Durasi (menit)" required>
    <p class="text-sm text-gray-600">Contoh 1 soal bank soal</p>
    <textarea name="questions[0][question_text]" class="border p-2 rounded" placeholder="Pertanyaan"></textarea>
    <input name="questions[0][option_a]" class="border p-2 rounded" placeholder="Opsi A">
    <input name="questions[0][option_b]" class="border p-2 rounded" placeholder="Opsi B">
    <input name="questions[0][option_c]" class="border p-2 rounded" placeholder="Opsi C">
    <input name="questions[0][option_d]" class="border p-2 rounded" placeholder="Opsi D">
    <select name="questions[0][correct_answer]" class="border p-2 rounded">
        <option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option>
    </select>
    <button class="bg-indigo-600 text-white p-2 rounded">Simpan Kuis</button>
</form>
