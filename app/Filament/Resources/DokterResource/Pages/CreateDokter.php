<?php

namespace App\Filament\Resources\DokterResource\Pages;

use App\Filament\Resources\DokterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDokter extends CreateRecord
{
    protected static string $resource = DokterResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $email = strtolower(str_replace(' ', '', $data['nama_lengkap'])) . '@rs.test';
        $user = \App\Models\User::create([
            'name' => $data['nama_lengkap'],
            'email' => $email,
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('dokter');
        $data['user_id'] = $user->id;
        $data['tenant_id'] = app('currentTenant')->id ?? null;
        return $data;
    }
}
