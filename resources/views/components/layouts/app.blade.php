<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ClassTrack' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        /* Toast Animation */
        .toast-enter { animation: slideIn 0.5s cubic-bezier(0.23, 1, 0.32, 1) forwards; }
        .toast-leave { animation: slideOut 0.4s cubic-bezier(0.23, 1, 0.32, 1) forwards; }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</head>
<body class="bg-[#f4f7fb] text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    <!-- Global Toast Notification Container -->
    <div class="fixed top-6 right-6 z-[60] flex flex-col gap-3 pointer-events-none w-full max-w-sm">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:enter="toast-enter" x-transition:leave="toast-leave"
                 class="bg-white border-l-4 border-green-500 rounded-xl p-4 shadow-xl pointer-events-auto flex gap-3 items-start relative overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Berhasil!</h4>
                    <p class="text-xs text-gray-500 mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
            </div>
        @endif
        
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" 
                 x-transition:enter="toast-enter" x-transition:leave="toast-leave"
                 class="bg-white border-l-4 border-red-500 rounded-xl p-4 shadow-xl pointer-events-auto flex gap-3 items-start relative overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Terdapat Kesalahan</h4>
                    <ul class="list-disc list-inside text-xs mt-1 text-gray-500 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
            </div>
        @endif
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col">
            <div class="flex items-center justify-center h-20 border-b border-gray-50 shrink-0">
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-500 tracking-wider font-outfit">ClassTrack</span>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard Admin
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('admin.users') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Kelola User
                        </a>
                    @elseif(auth()->user()->role === 'guru')
                        <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('guru.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('guru.kelas') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('guru.kelas') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Daftar Kelas
                        </a>
                        
                        <!-- Contextual Menu for Guru -->
                        @if(isset($classroom) && request()->routeIs('guru.*') && !request()->routeIs('guru.kelas') && !request()->routeIs('guru.dashboard'))
                            <div class="mt-6 mb-2">
                                <p class="px-4 text-[10px] font-bold text-indigo-500 uppercase tracking-wider mb-2 truncate" title="{{ $classroom->name }}">KELAS: {{ $classroom->name }}</p>
                                <div class="space-y-1 pl-2 border-l-2 border-indigo-100 ml-4">
                                    <a href="{{ route('guru.kelas.show', $classroom) }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-r-xl hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ request()->routeIs('guru.kelas.show') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600' }}">Detail Kelas</a>
                                    <a href="{{ route('guru.tugas', $classroom) }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-r-xl hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ request()->routeIs('guru.tugas') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600' }}">Kelola Tugas</a>
                                    <a href="{{ route('guru.kuis', $classroom) }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-r-xl hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ request()->routeIs('guru.kuis') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600' }}">Kelola Kuis</a>
                                    <a href="{{ route('guru.monitoring', $classroom) }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-r-xl hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ request()->routeIs('guru.monitoring') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600' }}">Monitoring EWS</a>
                                </div>
                            </div>
                        @endif

                    @elseif(auth()->user()->role === 'siswa')
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('siswa.nilai') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('siswa.nilai') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Rekap Nilai
                        </a>
                        
                        <!-- Contextual Menu for Siswa -->
                        @if(isset($classroom) && request()->routeIs('siswa.kelas.show'))
                            <div class="mt-6 mb-2">
                                <p class="px-4 text-[10px] font-bold text-green-600 uppercase tracking-wider mb-2 truncate" title="{{ $classroom->name }}">KELAS: {{ $classroom->name }}</p>
                                <div class="space-y-1 pl-2 border-l-2 border-green-100 ml-4">
                                    <a href="{{ route('siswa.kelas.show', $classroom) }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-r-xl bg-green-50 text-green-700">Ruang Kelas Utama</a>
                                </div>
                            </div>
                        @endif

                    @elseif(auth()->user()->role === 'wali')
                        <a href="{{ route('wali.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all {{ request()->routeIs('wali.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard Pemantauan
                        </a>
                    @endif
                @endauth
            </nav>

            <div class="p-4 border-t border-gray-50 bg-gray-50/50 shrink-0">
                @auth
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-gray-700 to-gray-900 flex items-center justify-center text-white font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 bg-white border border-red-100 rounded-xl hover:bg-red-50 hover:border-red-200 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar -->
            <header class="h-20 bg-white/80 backdrop-blur-md flex items-center justify-between px-6 lg:px-10 z-10 border-b border-gray-100 shrink-0">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-blue-600 focus:outline-none mr-4 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <!-- Breadcrumbs could go here if needed -->
                </div>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-500 bg-gray-50 px-4 py-2 rounded-full border border-gray-100 shadow-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </header>

            <!-- Backdrop for mobile sidebar -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/40 backdrop-blur-sm lg:hidden" x-transition.opacity></div>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-transparent p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
