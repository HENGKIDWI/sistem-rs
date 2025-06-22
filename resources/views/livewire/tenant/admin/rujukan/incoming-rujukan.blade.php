<div>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Permintaan Rujukan Masuk</h1>
                <p class="mt-2 text-sm text-gray-700">Tinjau dan tanggapi permintaan rujukan dari rumah sakit lain.</p>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    @if (session()->has('message'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Pasien</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Asal Rujukan</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Alasan</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Tindakan</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($rujukans as $rujukan)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $rujukan->pasien->name ?? 'N/A' }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            <div class="font-medium text-gray-900">{{ $rujukan->rumahSakitSumber->name ?? 'N/A' }}</div>
                                            <div class="text-gray-500">Dr. {{ $rujukan->dokter->nama_lengkap ?? 'N/A' }}</div>
                                        </td>
                                        <td class="whitespace-normal px-3 py-4 text-sm text-gray-500">{{ $rujukan->alasan_rujukan }}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <button wire:click="approve({{ $rujukan->id }})" wire:confirm="Anda yakin ingin menyetujui rujukan ini?" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">Setujui</button>
                                            <button wire:click="openRejectModal({{ $rujukan->id }})" class="ml-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">Tolak</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                            Tidak ada permintaan rujukan masuk.
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

    {{-- Modal Alasan Penolakan --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity">
            <div class="relative bg-white rounded-lg shadow-xl p-6 w-full max-w-lg mx-auto my-10" @click.outside="$wire.closeModal()">
                <h3 class="text-lg font-medium mb-4">Tolak Rujukan</h3>
                <p class="text-sm text-gray-600 mb-4">Mohon berikan alasan penolakan rujukan untuk pasien <span class="font-bold">{{ $rujukanToReject->pasien->name ?? '' }}</span>.</p>
                <form wire:submit.prevent="reject">
                    <div>
                        <label for="rejectionReason" class="block text-sm font-medium text-gray-700 sr-only">Alasan Penolakan</label>
                        <textarea id="rejectionReason" wire:model.defer="rejectionReason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('rejectionReason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" wire:click="closeModal()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            Kirim Penolakan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
