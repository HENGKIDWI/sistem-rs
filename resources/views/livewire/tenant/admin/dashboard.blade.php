<div>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Selamat Datang, Admin {{ app('currentTenant')->name }}!
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Pilih salah satu menu di bawah untuk mulai mengelola sistem.
            </p>
        </div>
    </div>

    <div class="p-4 sm:p-8 mt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card Manajemen Pengguna -->
            <a href="{{ route('admin.users.index') }}" class="transform hover:scale-105 transition-transform duration-300 bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Pengguna</h3>
                    <p class="mt-2 text-sm text-gray-600">Kelola akun dan peran pengguna (admin, dokter).</p>
                </div>
                <div class="mt-4 text-yellow-500 font-bold">Kelola Sekarang &rarr;</div>
            </a>

            <!-- Card Manajemen Janji Temu -->
            <a href="{{ route('admin.appointments.index') }}" class="transform hover:scale-105 transition-transform duration-300 bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Janji Temu</h3>
                    <p class="mt-2 text-sm text-gray-600">Lihat dan kelola semua janji temu pasien.</p>
                </div>
                <div class="mt-4 text-blue-500 font-bold">Kelola Sekarang &rarr;</div>
            </a>

            <!-- Card Manajemen Dokter -->
            <a href="{{ route('admin.dokter.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Manajemen Dokter</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Kelola data dokter di rumah sakit Anda.</p>
            </a>

            <!-- Card Manajemen Pengumuman -->
            <a href="{{ route('admin.pengumuman.index') }}" class="transform hover:scale-105 transition-transform duration-300 bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Pengumuman</h3>
                    <p class="mt-2 text-sm text-gray-600">Buat dan publikasikan pengumuman untuk pasien & staf.</p>
                </div>
                <div class="mt-4 text-green-500 font-bold">Kelola Sekarang &rarr;</div>
            </a>

            <!-- Card Manajemen Rujukan Masuk -->
            <a href="{{ route('admin.rujukan.incoming') }}" class="transform hover:scale-105 transition-transform duration-300 bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Rujukan Masuk</h3>
                    <p class="mt-2 text-sm text-gray-600">Tinjau dan proses permintaan rujukan yang masuk.</p>
                </div>
                <div class="mt-4 text-purple-500 font-bold">Kelola Sekarang &rarr;</div>
            </a>
        </div>
    </div>
</div> 