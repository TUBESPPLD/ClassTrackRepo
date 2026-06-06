<form method="POST" action="{{ route('guru.kelas') }}" class="bg-white p-4 rounded shadow grid md:grid-cols-2 gap-2">
    @csrf
    <input name="name" class="border p-2 rounded" placeholder="Nama kelas" required>
    <input name="description" class="border p-2 rounded" placeholder="Deskripsi">
    <button class="bg-indigo-600 text-white px-3 py-2 rounded md:col-span-2">Buat Kelas</button>
</form>
