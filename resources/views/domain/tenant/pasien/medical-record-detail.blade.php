<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Rekam Medis') }}
            </h2>
            <a href="{{ route('pasien.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 space-y-6">

                    <!-- Detail Kunjungan -->
                    <div class="pb-4 border-b dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-base font-medium text-gray-500 dark:text-gray-400">Tanggal Kunjungan</h3>
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $appointment->tanggal_kunjungan->format('d F Y') }}</p>
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-gray-500 dark:text-gray-400">Dokter</h3>
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $appointment->dokter->nama_lengkap }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $appointment->dokter->spesialisasi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Pemeriksaan -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Keluhan Utama</h4>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $appointment->keluhan }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Hasil Diagnosis</h4>
                            <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $appointment->medicalRecord->diagnosis }}</p>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Resep Obat</h4>
                            <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $appointment->medicalRecord->resep_obat }}</p>
                        </div>

                        @if($appointment->medicalRecord->catatan_dokter)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Catatan & Anjuran Dokter</h4>
                            <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $appointment->medicalRecord->catatan_dokter }}</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 