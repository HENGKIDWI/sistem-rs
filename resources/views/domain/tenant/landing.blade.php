<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di {{ $tenant->name }}</title>
    
    {{-- Memuat Tailwind CSS dari proyek Anda --}}
    @vite('resources/css/app.css')

    {{-- Font Inter --}}
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    {{-- Menambahkan sedikit style kustom jika diperlukan --}}
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    {{-- Navigasi Pojok Kanan Atas --}}
    <nav class="absolute top-0 right-0 p-6 z-20">
        @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
            @endif
        @endauth
    </nav>

    <div class="container mx-auto p-4 sm:p-6 md:p-10">
        
        <header id="hero" class="text-center pt-20 pb-16 bg-white dark:bg-gray-800 shadow-xl rounded-lg mb-12">
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-4">
                {{-- Bagian Logo --}}
                @if(isset($tenant->logo_url) && $tenant->logo_url)
                    <img src="{{ $tenant->logo_url }}" alt="Logo {{ $tenant->name }}" class="h-20 w-20 object-contain">
                @endif
                <h1 class="text-4xl md:text-5xl font-extrabold text-blue-600 dark:text-blue-400">{{ $tenant->name }}</h1>
            </div>
            <p class="text-xl text-gray-500 dark:text-gray-400 mt-2 mb-8 max-w-2xl mx-auto">Solusi Kesehatan Terpercaya untuk Anda dan Keluarga.</p>

            {{-- Info Penting: Jam & Kontak --}}
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 text-left text-gray-600 dark:text-gray-300 mb-10 border-t border-b dark:border-gray-700 py-6 px-6">
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-lg">Jam Operasional</h3>
                    <p>{{ $tenant->jam_operasional ?? 'Senin - Sabtu: 08:00 - 21:00' }}</p>
                    <p class="font-medium text-red-500">Instalasi Gawat Darurat (IGD) 24 Jam</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-lg">Kontak Kami</h3>
                    <p><strong>Alamat:</strong> {{ $tenant->alamat ?? 'N/A' }}</p>
                    <p><strong>Telepon:</strong> {{ $tenant->telepon ?? 'N/A' }}</p>
                </div>
            </div>
            
            {{-- Tombol Call-to-Action --}}
            <div>
                <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white font-bold text-lg px-8 py-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                    Daftar Sebagai Pasien Sekarang
                </a>
            </div>
        </header>

        <main class="space-y-12">
            
            <section id="informasi" class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-100">Profil Rumah Sakit</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    {{ $tenant->deskripsi ?? 'Informasi detail tentang rumah sakit ini akan segera tersedia. Kami berkomitmen untuk memberikan pelayanan terbaik bagi kesehatan Anda dan keluarga.' }}
                </p>

                {{-- Fasilitas Tersedia --}}
                <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100 border-t dark:border-gray-700 pt-6">Fasilitas & Layanan</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 text-center mb-8">
                    
                    {{-- ================= PERBAIKAN DI SINI ================= --}}
                    {{-- Loop untuk setiap fasilitas yang didapat dari database --}}
                    @forelse($fasilitas as $item)
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        {{-- Menampilkan nama fasilitas dari database --}}
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $item->nama }}</span>
                    </div>
                    @empty
                    {{-- Pesan ini akan tampil jika tidak ada data fasilitas --}}
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400">
                        Informasi fasilitas untuk rumah sakit ini belum tersedia.
                    </p>
                    @endforelse
                    {{-- ======================================================= --}}

                </div>

                {{-- Galeri Foto --}}
                <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100 border-t dark:border-gray-700 pt-6">Galeri Kami</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse ($galeri as $foto)
                        <div class="rounded-lg overflow-hidden shadow-lg group">
                            <img src="{{ $foto->foto_url }}" alt="{{ $foto->judul ?? 'Foto Fasilitas' }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500 dark:text-gray-400">
                            Belum ada foto di galeri untuk rumah sakit ini.
                        </p>
                    @endforelse
                </div>
            </section>

            <section id="dokter" class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold mb-6 border-b dark:border-gray-700 pb-4 text-gray-800 dark:text-gray-100">Tim Dokter Kami</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @forelse ($dokters as $dokter)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                            {{-- Foto Dokter --}}
                            <img src="{{ $dokter->foto_url }}" alt="Foto {{ $dokter->nama_lengkap }}" class="w-full h-56 object-cover">
                            
                            <div class="p-4 flex-grow flex flex-col">
                                <div class="flex-grow">
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $dokter->nama_lengkap }}</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Spesialis {{ $dokter->spesialisasi }}</p>
                                
                                    {{-- Jadwal Praktek --}}
                                    <div class="mt-4 text-sm border-t dark:border-gray-600 pt-3">
                                        <h4 class="font-semibold text-gray-600 dark:text-gray-300 mb-1">Jadwal Praktek:</h4>
                                        <p class="text-gray-500 dark:text-gray-400">Senin & Rabu: 09:00 - 12:00</p>
                                        <p class="text-gray-500 dark:text-gray-400">Jumat: 14:00 - 17:00</p>
                                    </div>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="mt-4 pt-4 border-t dark:border-gray-600">
                                    <a href="{{ route('pasien.appointment.form', ['dokter_id' => $dokter->id]) }}" class="w-full block text-center bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition-colors duration-300">
                                        Buat Janji Temu
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500 dark:text-gray-400">Informasi dokter untuk rumah sakit ini belum tersedia.</p>
                    @endforelse
                </div>
            </section>

            <section id="pengumuman" class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Pengumuman & Berita</h2>
                <div class="space-y-6">
                    @forelse ($announcements as $announcement)
                        <div class="p-6 border dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $announcement->judul }}</h3>
                            @if ($announcement->tanggal)
                                <p class="text-sm text-gray-400 mt-1">Diterbitkan: {{ \Carbon\Carbon::parse($announcement->tanggal)->format('d F Y') }}</p>
                            @endif
                            <div class="text-gray-600 dark:text-gray-300 mt-2 prose dark:prose-invert max-w-none">{!! $announcement->isi !!}</div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Belum ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </section>

        </main>

        <footer class="text-center mt-12 py-6 border-t dark:border-gray-700">
            <p class="text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} {{ $tenant->name }}. Semua Hak Cipta Dilindungi.</p>
        </footer>

    </div>
</body>
</html>
