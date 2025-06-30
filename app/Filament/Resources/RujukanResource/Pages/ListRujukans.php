<?php

namespace App\Filament\Resources\RujukanResource\Pages;

use App\Filament\Resources\RujukanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRujukans extends ListRecords
{
    protected static string $resource = RujukanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada tombol create
        ];
    }
}
