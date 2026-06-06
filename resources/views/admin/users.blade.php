<x-layouts.app :title="'Manajemen User'">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data seluruh pengguna sistem (Admin, Guru, Siswa, Wali).</p>
        </div>
        <button onclick="document.getElementById('modal-tambah-user').classList.remove('hidden')" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pengguna
        </button>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna Aktif</h3>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">{{ count($users) }} Total Pengguna</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Profil Pengguna</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peran (Role)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-gray-100 to-gray-200 text-gray-600 flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-red-50 text-red-600 border-red-100',
                                        'guru' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'siswa' => 'bg-green-50 text-green-600 border-green-100',
                                        'wali' => 'bg-purple-50 text-purple-600 border-purple-100'
                                    ];
                                    $color = $roleColors[$user->role] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $color }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" id="form-delete-user-{{ $user->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete('form-delete-user-{{ $user->id }}', 'Yakin ingin menghapus pengguna ini secara permanen?')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors tooltip" title="Hapus Pengguna">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">Anda (Aktif)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-gray-500">Tidak ada data pengguna ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div id="modal-tambah-user" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-lg p-8 shadow-xl relative my-8">
            <button onclick="document.getElementById('modal-tambah-user').classList.add('hidden')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Pengguna Baru</h3>

            <form method="POST" action="{{ route('admin.users.create') }}">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input name="name" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Peran Sistem</label>
                            <select name="role" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                                <option value="admin">Administrator</option>
                                <option value="guru">Guru Pengajar</option>
                                <option value="siswa" selected>Siswa</option>
                                <option value="wali">Wali Murid</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                        <input name="email" type="email" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <input name="password" type="password" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" required>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl py-3 font-bold hover:shadow-lg transition-all">
                            Simpan Pengguna
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
