<x-layouts.app :title="'Edit Kelas'">
    <h1 class="text-xl font-semibold mb-4">Edit Kelas</h1>
    <form method="POST" action="{{ route('guru.kelas.update', $classroom) }}" class="bg-white p-4 rounded shadow grid gap-2">
        @csrf
        @method('PUT')
        <input name="name" value="{{ $classroom->name ?? '' }}" class="border p-2 rounded" required>
        <textarea name="description" class="border p-2 rounded">{{ $classroom->description ?? '' }}</textarea>
        <button class="bg-indigo-600 text-white p-2 rounded">Simpan</button>
    </form>
</x-layouts.app>
