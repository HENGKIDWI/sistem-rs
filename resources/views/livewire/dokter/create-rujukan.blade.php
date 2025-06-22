<div>
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity">
            <div class="relative bg-white rounded-lg shadow-xl p-6 w-full max-w-lg mx-auto my-10" @click.outside="$wire.closeModal()">
                <h3 class="text-lg font-medium mb-4">Buat Rujukan untuk: {{ $pasien->name ?? '' }}</h3>
                <form wire:submit.prevent="store">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Rumah Sakit Tujuan -->
                        <div>
                            <label for="rumahSakitTujuanId" class="block text-sm font-medium text-gray-700">Rumah Sakit Tujuan</label>
                            <select id="rumahSakitTujuanId" wire:model.defer="rumahSakitTujuanId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Pilih Rumah Sakit</option>
                                @if($rumahSakitList)
                                    @foreach($rumahSakitList as $rs)
                                        <option value="{{ $rs->id }}">{{ $rs->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('rumahSakitTujuanId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alasan Rujukan -->
                        <div>
                            <label for="alasan_rujukan" class="block text-sm font-medium text-gray-700">Alasan Rujukan</label>
                            <textarea id="alasan_rujukan" wire:model.defer="alasan_rujukan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            @error('alasan_rujukan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Catatan Tambahan -->
                        <div>
                            <label for="catatan_dokter" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                            <textarea id="catatan_dokter" wire:model.defer="catatan_dokter" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            @error('catatan_dokter') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" wire:click="closeModal()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Kirim Rujukan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
