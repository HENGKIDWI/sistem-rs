<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Rumah Sakit
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('superadmin.rumahsakit.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        + Tambah Rumah Sakit
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border rounded">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Nama Rumah Sakit</th>
                                <th class="py-2 px-4 border-b text-left">Alamat</th>
                                <th class="py-2 px-4 border-b text-left">Telepon</th>
                                <th class="py-2 px-4 border-b text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rumahSakits as $rs)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $rs->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $rs->alamat }}</td>
                                <td class="py-2 px-4 border-b">{{ $rs->telepon }}</td>
                                <td class="py-2 px-4 border-b">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('superadmin.rumahsakit.edit', $rs->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('superadmin.rumahsakit.destroy', $rs->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus rumah sakit ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 