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
                    
                    {{-- Form untuk menambah RS baru --}}
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Tambah Rumah Sakit Baru</h3>

                        {{-- Menampilkan pesan sukses --}}
                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Menampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="mb-4">
                                <ul class="list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('superadmin.tenants.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Nama Rumah Sakit --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Rumah Sakit</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>
                                {{-- Domain --}}
                                <div>
                                    <label for="domain" class="block text-sm font-medium text-gray-700">Domain</label>
                                    <input type="text" name="domain" id="domain" value="{{ old('domain') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="contoh: rscipto" required>
                                    <p class="mt-1 text-xs text-gray-500">Contoh: 'rscipto' akan menjadi 'rscipto.rumahsakit.test'</p>
                                </div>
                                {{-- Alamat --}}
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('alamat') }}</textarea>
                                </div>
                                {{-- Deskripsi --}}
                                <div class="md:col-span-2">
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                    <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi') }}</textarea>
                                </div>
                                {{-- Telepon --}}
                                <div>
                                    <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                {{-- Jam Operasional --}}
                                <div class="md:col-span-2">
                                    <label for="jam_operasional" class="block text-sm font-medium text-gray-700">Jam Operasional</label>
                                    <input type="text" name="jam_operasional" id="jam_operasional" value="{{ old('jam_operasional') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Senin - Jumat, 08:00 - 17:00">
                                </div>
                                {{-- Logo --}}
                                <div class="md:col-span-2">
                                    <label for="logo_url" class="block text-sm font-medium text-gray-700">Logo</label>
                                    <input type="file" name="logo_url" id="logo_url" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                    <p class="mt-1 text-xs text-gray-500">Tipe file: JPG, PNG, SVG (Maks. 2MB)</p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Tambah Rumah Sakit
                                </button>
                            </div>
                        </form>
                    </div>

                    <h3 class="text-lg font-medium">Daftar Rumah Sakit (Tenant)</h3>

                    {{-- Di sini kita akan menambahkan form untuk menambah RS baru --}}
                    
                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Rumah Sakit</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($daftarRumahSakit as $rs)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($rs->logo_url)
                                                <img src="{{ Storage::url($rs->logo_url) }}" alt="Logo" class="h-10 w-10 object-contain">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center">
                                                    <span class="text-xs text-gray-500">No Logo</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $rs->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $rs->domain }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('superadmin.tenants.edit', $rs->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('superadmin.tenants.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rumah sakit ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data rumah sakit.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>