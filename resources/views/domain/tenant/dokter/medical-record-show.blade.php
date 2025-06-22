<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Informasi Janji Temu</h3>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pasien</p>
                                <p class="mt-1 text-md text-gray-900 dark:text-gray-100">{{ $appointment->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kunjungan</p>
                                <p class="mt-1 text-md text-gray-900 dark:text-gray-100">{{ $appointment->tanggal_kunjungan->format('d F Y') }} - {{ $appointment->jam_kunjungan->format('H:i') }}</p>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Keluhan Awal</p>
                                <p class="mt-1 text-md text-gray-900 dark:text-gray-100">{{ $appointment->keluhan }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Hasil Pemeriksaan</h3>
                        <dl class="mt-4 space-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diagnosis</dt>
                                <dd class="mt-1 text-md text-gray-900 dark:text-gray-100">{{ $medicalRecord->diagnosis }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Resep Obat</dt>
                                <dd class="mt-1 text-md text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $medicalRecord->resep_obat }}</dd>
                            </div>
                            @if($medicalRecord->catatan_dokter)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan Tambahan</dt>
                                <dd class="mt-1 text-md text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $medicalRecord->catatan_dokter }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <div class="mt-8 border-t pt-6 flex justify-end">
                        <a href="{{ route('dokter.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 