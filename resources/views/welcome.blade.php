<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Akademik - SMA Bina Nusantara</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            h1, h2, h3, .font-outfit { font-family: 'Outfit', sans-serif; }
            .bg-grid-pattern {
                background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px),
                                linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
                background-size: 40px 40px;
                background-position: center center;
            }
            .floating-img-1 { animation: float 6s ease-in-out infinite; }
            .floating-img-2 { animation: float 8s ease-in-out infinite reverse; }
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(2deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
        </style>
    </head>
    <body class="antialiased bg-[#f4f7fb] text-gray-800 overflow-x-hidden">
        
        <!-- Navbar -->
        <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 20)"
             :class="{ 'bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100': scrolled, 'bg-transparent': !scrolled }"
             class="fixed w-full z-50 top-0 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-blue-500/30 transform hover:rotate-12 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        </div>
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 font-outfit">SMA Bina Nusantara</span>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium transition-colors hover:-translate-y-0.5 transform">Fitur</a>
                        <a href="#about" class="text-gray-600 hover:text-blue-600 font-medium transition-colors hover:-translate-y-0.5 transform">Tentang</a>
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-xl bg-blue-50 text-blue-600 font-semibold hover:bg-blue-100 transition-all transform hover:scale-105">Dashboard Saya</a>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-2.5 font-medium text-gray-600 hover:text-blue-600 transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 hover:scale-105">Daftar Sekarang</a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Mobile Hamburger -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-blue-600 focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full">
                <div class="px-4 pt-2 pb-6 space-y-2">
                    <a href="#features" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Fitur</a>
                    <a href="#about" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Tentang</a>
                    <div class="border-t border-gray-100 pt-4 mt-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-blue-600 text-white font-bold">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 font-medium text-gray-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="mt-2 block w-full text-center px-4 py-3 rounded-xl bg-blue-600 text-white font-bold">Daftar Sekarang</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden flex items-center min-h-[90vh]">
            <div class="absolute inset-0 bg-grid-pattern opacity-[0.04]"></div>
            
            <!-- Animated Background Blobs -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 -left-40 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob" style="animation-delay: 2s"></div>
            <div class="absolute -bottom-40 left-20 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob" style="animation-delay: 4s"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-center lg:text-left z-10">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur border border-blue-100 text-blue-600 font-medium text-sm mb-6 shadow-sm hover:shadow-md transition-shadow cursor-default">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            Portal Akademik Resmi
                        </div>
                        
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-900 mb-6 leading-[1.1]">
                            Sistem Informasi Terpadu <br class="hidden md:block" />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500 relative inline-block">
                                SMA Bina Nusantara
                                <svg class="absolute w-full h-3 -bottom-1 left-0 text-indigo-300 opacity-50" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3" fill="none"/></svg>
                            </span>
                        </h1>
                        
                        <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
                            Akses mudah untuk seluruh aktivitas akademik, tugas, kuis, presensi, dan pemantauan perkembangan belajar siswa di satu pintu.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-lg hover:shadow-xl hover:shadow-blue-500/40 transition-all transform hover:-translate-y-1">
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="#login-roles" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-lg hover:shadow-xl hover:shadow-blue-500/40 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 group">
                                    Masuk Portal
                                    <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Images / Graphics -->
                    <div class="hidden lg:block relative h-[500px] w-full">
                        <!-- Main Image -->
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-80 h-[400px] rounded-3xl overflow-hidden shadow-2xl border-4 border-white floating-img-1 z-20">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Students learning" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <p class="font-bold text-lg">Kolaborasi Aktif</p>
                                <p class="text-sm opacity-80">Siswa & Guru Terhubung</p>
                            </div>
                        </div>
                        
<<<<<<< HEAD
=======
                        <!-- Floating Card 1 -->
                        <div class="absolute right-64 top-10 bg-white p-4 rounded-2xl shadow-xl border border-gray-100 flex items-center gap-4 floating-img-2 z-30">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Tugas Terkumpul</p>
                                <p class="text-xs text-gray-500">Baru saja</p>
                            </div>
                        </div>
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a

                        <!-- Secondary Image -->
                        <div class="absolute right-40 bottom-0 w-48 h-48 rounded-3xl overflow-hidden shadow-xl border-4 border-white floating-img-2 z-10 opacity-90">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Teacher" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Based Login Selection -->
        <div id="login-roles" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Pilih Peran Anda</span>
                    <h2 class="mt-2 text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-outfit">Masuk Sesuai Hak Akses</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Silakan pilih akses masuk sesuai dengan peran Anda di SMA Bina Nusantara.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Siswa -->
                    <a href="{{ route('login') }}?role=siswa" class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-blue-200 shadow-sm hover:shadow-xl hover:shadow-blue-100 transition-all duration-300 hover:-translate-y-2 group text-center block">
                        <div class="w-20 h-20 mx-auto rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-outfit">Siswa</h3>
                        <p class="text-gray-500 text-sm">Akses kelas, tugas, dan kuis Anda di sini.</p>
                    </a>

                    <!-- Guru -->
                    <a href="{{ route('login') }}?role=guru" class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-indigo-200 shadow-sm hover:shadow-xl hover:shadow-indigo-100 transition-all duration-300 hover:-translate-y-2 group text-center block">
                        <div class="w-20 h-20 mx-auto rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-outfit">Guru</h3>
                        <p class="text-gray-500 text-sm">Kelola kelas, evaluasi, dan pantau siswa.</p>
                    </a>

                    <!-- Wali Murid -->
                    <a href="{{ route('login') }}?role=wali" class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-purple-200 shadow-sm hover:shadow-xl hover:shadow-purple-100 transition-all duration-300 hover:-translate-y-2 group text-center block">
                        <div class="w-20 h-20 mx-auto rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-outfit">Wali Murid</h3>
                        <p class="text-gray-500 text-sm">Pantau nilai dan kehadiran anak Anda.</p>
                    </a>

                    <!-- Admin -->
                    <a href="{{ route('login') }}?role=admin" class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-orange-200 shadow-sm hover:shadow-xl hover:shadow-orange-100 transition-all duration-300 hover:-translate-y-2 group text-center block">
                        <div class="w-20 h-20 mx-auto rounded-full bg-orange-50 text-orange-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-orange-600 group-hover:text-white transition-all">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-outfit">Admin Sekolah</h3>
                        <p class="text-gray-500 text-sm">Kelola sistem, pengguna, dan data master.</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Kemampuan Utama</span>
                    <h2 class="mt-2 text-3xl md:text-4xl font-bold text-gray-900 mb-4">Satu Platform, Semua Terkendali</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">ClassTrack menyediakan alat komprehensif dari pencatatan nilai hingga otomatisasi peringatan dini untuk wali murid.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-blue-50/40 rounded-3xl p-8 border border-blue-100 hover:shadow-xl hover:shadow-blue-100 transition-all duration-300 hover:-translate-y-2 group cursor-default">
                        <div class="w-14 h-14 rounded-2xl bg-white text-blue-600 flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-outfit">Kelas & Materi Terstruktur</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">Unggah materi berdasarkan segmen, bagikan video pembelajaran, dan bentuk kelompok acak otomatis dalam hitungan detik.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-indigo-50/40 rounded-3xl p-8 border border-indigo-100 hover:shadow-xl hover:shadow-indigo-100 transition-all duration-300 hover:-translate-y-2 group cursor-default">
                        <div class="w-14 h-14 rounded-2xl bg-white text-indigo-600 flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-outfit">Kuis Interaktif</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">Sistem evaluasi bawaan yang dapat menghitung nilai otomatis, dilengkapi dengan batas waktu (timer) pengerjaan yang ketat.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-purple-50/40 rounded-3xl p-8 border border-purple-100 hover:shadow-xl hover:shadow-purple-100 transition-all duration-300 hover:-translate-y-2 group cursor-default">
                        <div class="w-14 h-14 rounded-2xl bg-white text-purple-600 flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-outfit">Early Warning System (EWS)</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">Peringatan dinamis jika kehadiran siswa kurang dari 75% atau nilai anjlok, memicu aksi Modul Remedial langsung dari dashboard guru.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
                <h2 class="text-3xl font-bold text-white mb-6 font-outfit">Butuh Bantuan Akses?</h2>
                <p class="text-blue-100 mb-8 text-lg">Jika Anda belum mendapatkan akun atau mengalami kendala, silakan hubungi Administrator IT Sekolah.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12 text-gray-400">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                    </div>
                    <span class="text-xl font-bold text-white font-outfit">SMA Bina Nusantara</span>
                </div>
                <p class="text-sm">
                    &copy; {{ date('Y') }} Portal Akademik. Developed for Internal School Use.
                </p>
            </div>
        </footer>

<<<<<<< HEAD
    <script>
        // Global Cleanup Script for Overlays and Modals
        function forceCleanup() {
            document.body.classList.remove('overflow-hidden', 'modal-open');
            document.body.style.overflow = '';
            document.body.style.pointerEvents = '';
            document.querySelectorAll('.bg-gray-900\\/50, .bg-black\\/50, .backdrop-blur').forEach(el => {
                if (el.children.length === 0 && !el.hasAttribute('x-show') && !el.classList.contains('hidden')) {
                    el.remove();
                }
            });
        }
        window.addEventListener('pageshow', forceCleanup);
        document.addEventListener('DOMContentLoaded', forceCleanup);
    </script>
</body>
=======
    </body>
>>>>>>> 9cab5579c573740aa9ce54d14c8f9974147f128a
</html>
