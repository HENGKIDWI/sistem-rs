<?php

namespace App\Filament\Resources\PermintaanTransferResource\Pages;

use App\Filament\Resources\PermintaanTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermintaanTransfers extends ListRecords
{
    protected static string $resource = PermintaanTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
