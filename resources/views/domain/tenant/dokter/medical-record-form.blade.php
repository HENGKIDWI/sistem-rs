<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <!-- Detail Janji Temu -->
                    <div class="mb-6 pb-4 border-b dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Detail Janji Temu</h3>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Nama Pasien</p>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $appointment->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Tanggal & Waktu</p>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $appointment->tanggal_kunjungan->format('d F Y') }} - {{ Carbon\Carbon::parse($appointment->jam_kunjungan)->format('H:i') }}</p>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Keluhan Utama</p>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $appointment->keluhan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Input Rekam Medis -->
                    <form method="POST" action="{{ route('dokter.appointments.medical-records.store', $appointment) }}">
                        @csrf
                        <div class="space-y-6">
                            <!-- Diagnosis -->
                            <div>
                                <x-input-label for="diagnosis" :value="__('Diagnosis')" />
                                <textarea id="diagnosis" name="diagnosis" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('diagnosis') }}</textarea>
                                <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                            </div>

                            <!-- Resep Obat -->
                            <div>
                                <x-input-label for="resep_obat" :value="__('Resep Obat')" />
                                <textarea id="resep_obat" name="resep_obat" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('resep_obat') }}</textarea>
                                <x-input-error :messages="$errors->get('resep_obat')" class="mt-2" />
                            </div>

                            <!-- Catatan Dokter -->
                            <div>
                                <x-input-label for="catatan_dokter" :value="__('Catatan Tambahan (Opsional)')" />
                                <textarea id="catatan_dokter" name="catatan_dokter" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('catatan_dokter') }}</textarea>
                                <x-input-error :messages="$errors->get('catatan_dokter')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('dokter.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Rekam Medis') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 