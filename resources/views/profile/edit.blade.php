<x-layouts.app title="Edit Profil">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Profil</h1>
        
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col items-center mb-8">
                    <div class="relative group cursor-pointer" onclick="document.getElementById('foto').click()">
                        @if($user->foto)
                            <img src="{{ Storage::url($user->foto) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover shadow-sm border-4 border-white group-hover:opacity-75 transition-opacity">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-gray-700 to-gray-900 flex items-center justify-center text-white text-3xl font-bold shadow-sm border-4 border-white group-hover:opacity-75 transition-opacity">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="bg-black/50 p-2 rounded-full text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <input type="file" id="foto" name="foto" class="hidden" accept=".jpg,.jpeg,.png">
                    <p class="text-xs text-gray-500 mt-3 text-center">Klik pada gambar untuk mengubah foto profil.<br>Maks. 2MB (JPG/PNG).</p>
                </div>

                <div class="space-y-5">
                    @if(in_array($user->role, ['siswa', 'guru']))
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">ID {{ ucfirst($user->role) }}</label>
                        <input type="text" value="{{ $user->student_code ?? 'Belum ada ID' }}" disabled class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-100 text-gray-500 font-mono text-center tracking-widest text-lg cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1 text-center">
                            {{ $user->role === 'siswa' ? 'Gunakan ID ini untuk diberikan kepada Wali Murid.' : 'Gunakan ID ini sebagai identitas Anda.' }}
                        </p>
                    </div>
                    <hr class="border-gray-100 my-4">
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800 mb-4">Ubah Password <span class="text-xs font-normal text-gray-500">(Kosongkan jika tidak ingin mengubah)</span></h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                                <input type="password" name="password" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Simple preview image logic
        document.getElementById('foto').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.group img');
                    if(img) {
                        img.src = e.target.result;
                    } else {
                        // If replacing the initials div with image
                        const container = document.querySelector('.group');
                        const imgEl = document.createElement('img');
                        imgEl.src = e.target.result;
                        imgEl.className = "w-24 h-24 rounded-full object-cover shadow-sm border-4 border-white group-hover:opacity-75 transition-opacity";
                        
                        // Replace the first child (which is the div)
                        container.insertBefore(imgEl, container.firstChild);
                        container.removeChild(container.children[1]);
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
    @endpush
</x-layouts.app>
