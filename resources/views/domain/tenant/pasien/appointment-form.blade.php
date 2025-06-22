<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Janji Temu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Rumah Sakit: <span class="font-medium">{{ $rumahSakit ?? '-' }}</span></p>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4" role="alert">
                            <p class="font-bold">Terjadi kesalahan:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pasien.appointment.store') }}">
                        @csrf

                        <!-- Pilih Dokter -->
                        <div class="mb-6">
                            <x-input-label for="dokter_id" :value="__('Pilih Dokter')" />
                            @if($dokters->isEmpty())
                                <div class="mt-1 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-300 p-4">
                                    <p>Tidak ada dokter yang tersedia saat ini. Silakan hubungi administrasi rumah sakit.</p>
                                </div>
                            @else
                                <select name="dokter_id" id="dokter_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                            {{ $dokter->nama_lengkap }} - {{ $dokter->spesialisasi }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <!-- Tanggal & Jam -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="tanggal_kunjungan" :value="__('Tanggal Kunjungan')" />
                                <x-text-input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" 
                                    :value="old('tanggal_kunjungan')"
                                    min="{{ date('Y-m-d') }}" 
                                    class="mt-1 block w-full"
                                    required />
                            </div>
                            
                            <div>
                                <x-input-label for="jam_kunjungan" :value="__('Jam Kunjungan')" />
                                <select name="jam_kunjungan" id="jam_kunjungan" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required disabled>
                                    <option value="">-- Pilih Dokter & Tanggal Dahulu --</option>
                                </select>
                                <div id="slot-error" class="text-sm text-red-500 mt-1" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-6">
                            <x-input-label for="keluhan" :value="__('Keluhan')" />
                            <textarea name="keluhan" id="keluhan" rows="4" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Jelaskan keluhan Anda..." required>{{ old('keluhan') }}</textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pasien.dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline me-4">
                                Batalkan
                            </a>

                            <x-primary-button>
                                {{ __('Ajukan Janji') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dokterSelect = document.getElementById('dokter_id');
            const tanggalInput = document.getElementById('tanggal_kunjungan');
            const slotSelect = document.getElementById('jam_kunjungan');
            const slotError = document.getElementById('slot-error');

            function fetchSlots() {
                const dokterId = dokterSelect.value;
                const tanggal = tanggalInput.value;

                // Kosongkan dan nonaktifkan dropdown jam jika dokter atau tanggal belum dipilih
                if (!dokterId || !tanggal) {
                    slotSelect.innerHTML = '<option value="">-- Pilih Dokter & Tanggal Dahulu --</option>';
                    slotSelect.disabled = true;
                    return;
                }

                // Tampilkan status loading
                slotSelect.innerHTML = '<option value="">Memuat slot...</option>';
                slotSelect.disabled = true;
                slotError.style.display = 'none';

                // Ambil data dari API
                fetch(`/api/slots/${dokterId}/${tanggal}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengambil data jadwal.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        slotSelect.innerHTML = ''; // Kosongkan pilihan
                        if (data.length > 0) {
                            slotSelect.disabled = false;
                            data.forEach(slot => {
                                const option = document.createElement('option');
                                option.value = slot;
                                option.textContent = slot;
                                slotSelect.appendChild(option);
                            });
                        } else {
                            slotSelect.innerHTML = '<option value="">-- Tidak ada slot tersedia --</option>';
                            slotSelect.disabled = true;
                            slotError.textContent = 'Jadwal tidak tersedia untuk tanggal ini. Silakan pilih tanggal lain.';
                            slotError.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        slotSelect.innerHTML = '<option value="">-- Gagal memuat --</option>';
                        slotSelect.disabled = true;
                        slotError.textContent = 'Terjadi kesalahan saat memuat jadwal. Coba lagi nanti.';
                        slotError.style.display = 'block';
                    });
            }

            dokterSelect.addEventListener('change', fetchSlots);
            tanggalInput.addEventListener('change', fetchSlots);
            
            // Panggil sekali saat halaman dimuat jika ada nilai lama (misal dari error validasi)
            if(dokterSelect.value && tanggalInput.value) {
                fetchSlots();
            }
        });
    </script>
    @endpush
</x-app-layout>
