<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Dokter
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Pesan Sukses -->
            @if(session()->has('message'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Janji Temu Akan Datang -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-4">Janji Temu Akan Datang</h3>
                <div class="mt-4 space-y-4">
                    @forelse($janjiMendatang as $appointment)
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-grow">
                                <p class="text-lg font-bold text-gray-900">{{ $appointment->user->name }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="font-semibold">Keluhan:</span> {{ $appointment->keluhan }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 mt-4 md:mt-0 md:ml-6 text-left md:text-right">
                                <p class="text-sm font-medium text-gray-800">{{ $appointment->tanggal_kunjungan->format('d M Y') }} - {{ $appointment->jam_kunjungan->format('H:i') }}</p>
                                <div class="flex items-center space-x-2 mt-2">
                                    <button wire:click="$dispatch('open-medical-record-modal', { appointmentId: {{ $appointment->id }} })" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                                        Isi Rekam Medis
                                    </button>
                                    @if($appointment->rujukan)
                                        <span class="text-sm font-semibold text-gray-700 bg-gray-200 py-2 px-4 rounded-lg">
                                            Sudah Dirujuk
                                        </span>
                                    @else
                                        <button wire:click="$dispatch('open-create-rujukan-modal', { appointmentId: {{ $appointment->id }} })"
                                            class="text-sm font-semibold text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                                            Buat Rujukan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada janji temu yang akan datang.</p>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Janji Temu -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-4">Riwayat Janji Temu</h3>
                <div class="mt-4 space-y-4">
                     @forelse($riwayatJanji as $appointment)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <p class="font-semibold">{{ $appointment->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->tanggal_kunjungan->format('d M Y') }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Diagnosa: {{ $appointment->medicalRecord->diagnosis ?? 'Belum ada diagnosa' }}
                                </p>
                            </div>
                            <div>
                                @if($appointment->medicalRecord)
                                    <a href="{{ route('dokter.appointments.medical-records.show', ['appointment' => $appointment->id, 'medical_record' => $appointment->medicalRecord->id]) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                        Lihat Detail
                                    </a>
                                @else
                                     <span class="text-sm text-gray-400">Belum diproses</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada riwayat janji temu.</p>
                    @endforelse
                </div>
                 <div class="mt-6">
                    {{ $riwayatJanji->links() }}
                </div>
            </div>

        </div>
    </div>
    @livewire('dokter.create-rujukan')
    @livewire('dokter.create-medical-record')
</x-app-layout>
