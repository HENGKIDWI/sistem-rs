<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Super Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                            <h4 class="text-lg font-semibold">Total Rumah Sakit</h4>
                            <p class="text-3xl font-bold">{{ count($daftarRumahSakit) }}</p>
                        </div>
                        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
                            <h4 class="text-lg font-semibold">Total Pasien</h4>
                            <p class="text-3xl font-bold">{{ $totalPasien }}</p>
                        </div>
                        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg">
                            <h4 class="text-lg font-semibold">Total Dokter</h4>
                            <p class="text-3xl font-bold">{{ $totalDokter }}</p>
                        </div>
                    </div>

                    <div class="mb-6 p-4 border rounded-md bg-gray-50">
                        <h3 class="text-lg font-bold mb-2">Tambah Rumah Sakit Baru</h3>
                        <form method="POST" action="{{ route('superadmin.rs.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="name" :value="__('Nama Rumah Sakit')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="domain" :value="__('Subdomain')" />
                                    <div class="flex items-center mt-1">
                                        <x-text-input id="domain" class="block w-full rounded-r-none" type="text" name="domain" :value="old('domain')" required placeholder="rsharapan" />
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md">
                                            .{{ config('app.domain', 'rumahsakit.test') }}
                                        </span>
                                    </div>
                                    <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="database_name" :value="__('Nama Database (Otomatis)')" />
                                    <x-text-input id="database_name" class="block mt-1 w-full bg-gray-200" type="text" name="database_name" disabled />
                                    <p class="text-xs text-gray-500 mt-1">Nama database dibuat otomatis.</p>
                                </div>
                                
                                <div>
                                    <x-input-label for="logo" :value="__('Logo Rumah Sakit')" />
                                    <x-text-input id="logo" class="block mt-1 w-full" type="file" name="logo" />
                                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6">
                                <x-primary-button>
                                    {{ __('Simpan Rumah Sakit') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <h3 class="text-lg font-bold mb-4">Daftar Rumah Sakit (Tenant)</h3>
                     @if(session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">Logo</th>
                                    <th scope="col" class="px-6 py-3">Nama Rumah Sakit</th>
                                    <th scope="col" class="px-6 py-3">Domain</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarRumahSakit as $rs)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $rs->id }}</td>
                                    <td class="px-6 py-4">
                                        @if ($rs->logo)
                                            <img src="{{ Storage::url($rs->logo) }}" alt="Logo" class="h-10 w-10 object-cover rounded-full">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $rs->name }}</td>
                                    <td class="px-6 py-4">{{ $rs->domain }}</td>
                                    <td class="px-6 py-4">
                                        @if ($rs->status)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <a href="{{-- route('superadmin.rs.edit', $rs->id) --}}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form method="POST" action="{{ route('superadmin.rs.destroy', $rs->id) }}" onsubmit="return confirm('Anda yakin ingin menghapus rumah sakit ini? Semua datanya akan hilang permanen.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">Belum ada rumah sakit yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const domainInput = document.getElementById('domain');
            const dbNameInput = document.getElementById('database_name');

            domainInput.addEventListener('input', function () {
                const domainValue = this.value.trim().toLowerCase().replace(/[^a-z0-9_]/g, '');
                this.value = domainValue; // Bersihkan input secara live
                
                if (domainValue) {
                    dbNameInput.value = 'tenant_' + domainValue;
                } else {
                    dbNameInput.value = '';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>