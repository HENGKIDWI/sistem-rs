<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Rujukan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Daftar Rujukan</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Di bawah ini adalah riwayat dan status rujukan Anda. Jika ada rujukan yang menunggu persetujuan Anda, Anda dapat menyetujui atau membatalkannya.
                    </p>

                    @if (session()->has('message'))
                        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="mt-6 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Asal Rujukan</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tujuan Rujukan</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Tindakan</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @forelse ($rujukans as $rujukan)
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                        <div class="font-medium text-gray-900">{{ $rujukan->rumahSakitSumber->name ?? 'N/A' }}</div>
                                                        <div class="text-gray-500">Dr. {{ $rujukan->dokter->nama_lengkap ?? 'N/A' }}</div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <div class="font-medium text-gray-900">{{ $rujukan->rumahSakitTujuan->name ?? 'N/A' }}</div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @switch($rujukan->status)
                                                                @case('pending_patient_approval') bg-yellow-100 text-yellow-800 @break
                                                                @case('approved') bg-green-100 text-green-800 @break
                                                                @case('rejected_by_rs') bg-red-100 text-red-800 @break
                                                                @case('cancelled_by_patient') bg-gray-100 text-gray-800 @break
                                                                @default bg-blue-100 text-blue-800
                                                            @endswitch">
                                                            {{ str_replace('_', ' ', Str::title($rujukan->status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        @if($rujukan->status == 'pending_patient_approval')
                                                            <button wire:click="approve({{ $rujukan->id }})" wire:confirm="Anda yakin ingin menyetujui rujukan ini?" class="text-indigo-600 hover:text-indigo-900">Setujui</button>
                                                            <button wire:click="cancel({{ $rujukan->id }})" wire:confirm="Anda yakin ingin membatalkan rujukan ini?" class="ml-4 text-red-600 hover:text-red-900">Batalkan</button>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                        Anda belum memiliki riwayat rujukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $rujukans->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
