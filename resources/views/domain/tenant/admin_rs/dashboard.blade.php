<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">{{ __("Selamat datang, Admin Rumah Sakit!") }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Gunakan menu di bawah untuk mengelola konten dan operasional rumah sakit Anda.") }}
                    </p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Manajemen Dokter -->
                <a href="{{ route('admin.dokter.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Manajemen Dokter</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola data, jadwal, dan akun untuk semua dokter.</p>
                    </div>
                </a>

                <!-- Placeholder untuk menu lain -->
                <div class="bg-white dark:bg-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-400">Manajemen Pasien</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-500">(Segera Hadir)</p>
                    </div>
                </div>
                 <div class="bg-white dark:bg-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-400">Manajemen Janji Temu</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-500">(Segera Hadir)</p>
                    </div>
                </div>
                 <div class="bg-white dark:bg-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-400">Manajemen Pengumuman</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-500">(Segera Hadir)</p>
                    </div>
                </div>
                 <div class="bg-white dark:bg-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-400">Profil Rumah Sakit</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-500">(Segera Hadir)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
