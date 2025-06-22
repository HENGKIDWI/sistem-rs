<x-app-layout>
    {{-- Konten untuk bagian 'header' akan dimasukkan ke variabel $header di layout --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Pasien') }}
            </h2>
            
            <div class="flex items-center space-x-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $rumahSakit ?? 'Rumah Sakit' }}
                </span>
            </div>
        </div>
    </x-slot>

    {{-- Semua konten di bawah ini akan secara otomatis dimasukkan ke variabel $slot di layout --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Menampilkan pesan sukses atau peringatan jika ada --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('warning'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p>{{ session('warning') }}</p>
                </div>
            @endif

            <div class="space-y-8">
                <!-- Antrian Hari Ini -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-3 mb-4">Antrian Hari Ini</h3>
                    @if($antrian)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $antrian->dokter->nama_lengkap ?? 'N/A' }}</p>
                            <p class="text-gray-600 dark:text-gray-400">Jam: {{ optional($antrian->jam_kunjungan)->format('H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">No. {{ $antrian->id }}</p>
                            <span class="mt-1 inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold capitalize">
                                {{ $antrian->status }}
                            </span>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">Anda tidak memiliki jadwal kunjungan hari ini.</p>
                    @endif
                </div>

                <!-- Statistik & Aksi Cepat -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kunjungan</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $totalKunjungan }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kunjungan Bulan Ini</h4>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $kunjunganBulanIni }}</p>
                    </div>
                    <a href="{{ route('pasien.appointment.form') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm flex items-center justify-center text-center transition duration-300 col-span-1 md:col-span-2 lg:col-span-1">
                        Buat Janji Baru
                    </a>
                    <a href="{{ route('profile.edit') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm flex items-center justify-center text-center transition duration-300 col-span-1 md:col-span-2 lg:col-span-1">
                        Edit Profil
                    </a>
                </div>

                <!-- Janji Mendatang -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-3 mb-4">Janji Mendatang</h3>
                    <div class="space-y-4">
                        @forelse($janjiMendatang as $kunjungan)
                        <div class="flex flex-col sm:flex-row justify-between items-start p-4 border rounded-lg dark:border-gray-700">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $kunjungan->dokter->nama_lengkap }} ({{ $kunjungan->dokter->spesialisasi }})</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Keluhan: {{ Str::limit($kunjungan->keluhan, 50) }}</p>
                            </div>
                            <div class="text-left sm:text-right mt-2 sm:mt-0 flex-shrink-0">
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $kunjungan->jam_kunjungan->format('H:i') }}</p>
                                <span class="mt-1 inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold capitalize">
                                    {{ $kunjungan->status }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki jadwal kunjungan mendatang.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Riwayat Kunjungan -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-3 mb-4">Riwayat Kunjungan</h3>
                    <div class="space-y-4">
                        @forelse($riwayatKunjungan as $kunjungan)
                        <div class="flex flex-col sm:flex-row justify-between items-start p-4 border rounded-lg dark:border-gray-700">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $kunjungan->dokter->nama_lengkap }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Diagnosa: {{ Str::limit($kunjungan->medicalRecord->diagnosis ?? 'Menunggu hasil', 50) }}
                                </p>
                            </div>
                            <div class="text-left sm:text-right mt-2 sm:mt-0 flex-shrink-0">
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</p>
                                @if($kunjungan->medicalRecord)
                                    <a href="{{ route('pasien.medical-record.show', $kunjungan) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 text-sm font-semibold">
                                        Lihat Detail
                                    </a>
                                @else
                                    <span class="text-sm text-gray-500">Belum diproses</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki riwayat kunjungan.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Buat Janji Temu -->
                <a href="{{ route('pasien.appointment.form') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-600 transition-colors duration-300 flex flex-col items-center justify-center text-center">
                    <h4 class="text-xl font-semibold">Buat Janji Temu Baru</h4>
                    <p class="mt-2">Jadwalkan konsultasi dengan dokter pilihan Anda.</p>
                </a>

                <!-- Lihat Status Rujukan -->
                <a href="{{ route('pasien.rujukan') }}" class="bg-purple-500 text-white p-6 rounded-lg shadow-md hover:bg-purple-600 transition-colors duration-300 flex flex-col items-center justify-center text-center">
                    <h4 class="text-xl font-semibold">Status Rujukan Saya</h4>
                    <p class="mt-2">Lihat dan kelola status rujukan medis Anda.</p>
                </a>
            </div>

            <div class="mt-8 space-y-6">
                <!-- Janji Mendatang -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b pb-3 mb-4">Janji Mendatang</h3>
                    <div class="space-y-4">
                        @forelse($janjiMendatang as $kunjungan)
                        <div class="flex flex-col sm:flex-row justify-between items-start p-4 border rounded-lg dark:border-gray-700">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $kunjungan->dokter->nama_lengkap }} ({{ $kunjungan->dokter->spesialisasi }})</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Keluhan: {{ Str::limit($kunjungan->keluhan, 50) }}</p>
                            </div>
                            <div class="text-left sm:text-right mt-2 sm:mt-0 flex-shrink-0">
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $kunjungan->jam_kunjungan->format('H:i') }}</p>
                                <span class="mt-1 inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold capitalize">
                                    {{ $kunjungan->status }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki jadwal kunjungan mendatang.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
