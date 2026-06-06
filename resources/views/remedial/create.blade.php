<x-layouts.app :title="'Beri Remedial'">
    <h1 class="text-xl font-semibold mb-4">Beri Tugas Remedial</h1>
    <form method="POST" action="{{ route('guru.remedial') }}" class="bg-white p-4 rounded shadow grid gap-2">
        @csrf
        <input name="class_id" class="border p-2 rounded" placeholder="ID Kelas" required>
        <input name="student_id" class="border p-2 rounded" placeholder="ID Siswa" required>
        <input name="assignment_ids[]" class="border p-2 rounded" placeholder="ID Tugas (bisa banyak, ulangi input)" />
        <input name="deadline" type="datetime-local" class="border p-2 rounded" required>
        <textarea name="note" class="border p-2 rounded" placeholder="Catatan (opsional)"></textarea>
        <button class="bg-indigo-600 text-white p-2 rounded">Assign Remedial</button>
    </form>
</x-layouts.app>
