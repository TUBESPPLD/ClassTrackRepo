<form method="POST" action="{{ route('guru.tugas', $classroom) }}" enctype="multipart/form-data" class="bg-white p-4 rounded shadow grid gap-2">
    @csrf
    <input name="title" class="border p-2 rounded" placeholder="Judul tugas" required>
    <textarea name="description" class="border p-2 rounded" placeholder="Deskripsi"></textarea>
    <input name="deadline" type="datetime-local" class="border p-2 rounded" required>
    <input name="file" type="file" class="border p-2 rounded">
    <button class="bg-indigo-600 text-white p-2 rounded">Simpan Tugas</button>
</form>
