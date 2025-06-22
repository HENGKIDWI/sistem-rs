<div>
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity">
            <div class="relative bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl mx-auto my-10" @click.outside="$wire.closeModal()">
                <h3 class="text-lg font-medium mb-4">Isi Rekam Medis untuk: {{ $appointment->user->name ?? '' }}</h3>
                <p class="text-sm text-gray-500 mb-4">Janji Temu: {{ $appointment->tanggal_kunjungan->format('d M Y') }} - Keluhan: {{ $appointment->keluhan }}</p>
                <form wire:submit.prevent="store">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Diagnosis -->
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                            <textarea id="diagnosis" wire:model.defer="diagnosis" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tindakan -->
                        <div>
                            <label for="tindakan" class="block text-sm font-medium text-gray-700">Tindakan</label>
                            <textarea id="tindakan" wire:model.defer="tindakan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            @error('tindakan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Resep Obat -->
                        <div>
                            <label for="resep_obat" class="block text-sm font-medium text-gray-700">Resep Obat (Opsional)</label>
                            <textarea id="resep_obat" wire:model.defer="resep_obat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            @error('resep_obat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Catatan Tambahan -->
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                            <textarea id="catatan" wire:model.defer="catatan" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            @error('catatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" wire:click="closeModal()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Simpan Rekam Medis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
