<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Rumah Sakit: {{ $rumahSakit->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
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

                    <form action="{{ route('superadmin.tenants.update', $rumahSakit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama Rumah Sakit --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Rumah Sakit</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $rumahSakit->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            {{-- Domain --}}
                            <div>
                                <label for="domain" class="block text-sm font-medium text-gray-700">Domain</label>
                                <input type="text" name="domain" id="domain" value="{{ old('domain', $rumahSakit->domain) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('alamat', $rumahSakit->alamat) }}</textarea>
                            </div>
                            {{-- Deskripsi --}}
                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $rumahSakit->deskripsi) }}</textarea>
                            </div>
                            {{-- Telepon --}}
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                                <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $rumahSakit->telepon) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            {{-- Jam Operasional --}}
                            <div>
                                <label for="jam_operasional" class="block text-sm font-medium text-gray-700">Jam Operasional</label>
                                <input type="text" name="jam_operasional" id="jam_operasional" value="{{ old('jam_operasional', $rumahSakit->jam_operasional) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            {{-- Logo --}}
                            <div class="md:col-span-2">
                                <label for="logo_url" class="block text-sm font--medium text-gray-700">Logo</label>
                                @if($rumahSakit->logo_url)
                                    <div class="mt-2 mb-2">
                                        <img src="{{ Storage::url($rumahSakit->logo_url) }}" alt="Logo" class="h-20 object-contain">
                                        <p class="mt-1 text-xs text-gray-500">Logo saat ini. Unggah file baru untuk mengganti.</p>
                                    </div>
                                @endif
                                <input type="file" name="logo_url" id="logo_url" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <p class="mt-1 text-xs text-gray-500">Tipe file: JPG, PNG, SVG (Maks. 2MB)</p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('superadmin.dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 