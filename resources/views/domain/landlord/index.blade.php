<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Layanan Pasien Terintegrasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="container mx-auto px-4 py-8">
        
        <section class="text-center py-12">
            <h1 class="text-4xl font-bold text-gray-800">Sistem Layanan Pasien Terintegrasi</h1>
            <p class="text-xl text-gray-600 mt-4">Pilih rumah sakit tujuan Anda di bawah ini.</p>
        </section>

        <section class="mb-8">
            <form action="{{ url('/') }}" method="GET" class="max-w-xl mx-auto">
                <div class="flex items-center border-b-2 border-teal-500 py-2">
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Cari Nama Rumah Sakit..." name="search" value="{{ request('search') }}">
                    <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($tenants as $tenant)
                <a href="http://{{ $tenant->domain }}" class="block bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            @if ($tenant->logo_url)
                                <img src="{{ Storage::url($tenant->logo_url) }}" alt="Logo {{ $tenant->name }}" class="h-16 w-16 object-contain mr-4">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded-md flex items-center justify-center mr-4">
                                    <span class="text-gray-500">No Logo</span>
                                </div>
                            @endif
                            <h2 class="text-xl font-bold text-gray-900">{{ $tenant->name }}</h2>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-center col-span-full text-gray-500">Rumah sakit tidak ditemukan.</p>
            @endforelse
        </section>

        <section class="mt-16 text-center text-gray-600">
            <h3 class="text-2xl font-bold mb-4">Butuh Bantuan?</h3>
            <p>Hubungi administrator sistem untuk informasi lebih lanjut.</p>
        </section>
        
    </div>
</body>
</html>