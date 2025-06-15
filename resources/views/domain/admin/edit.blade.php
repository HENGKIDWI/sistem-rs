<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Rumah Sakit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('superadmin.rs.update', $rumahSakit->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" :value="__('Nama Rumah Sakit')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $rumahSakit->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="domain" :value="__('Domain (tanpa .rumahsakit.test)')" />
                                <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain', $rumahSakit->domain)" required />
                                <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                                <a href="{{ route('superadmin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>