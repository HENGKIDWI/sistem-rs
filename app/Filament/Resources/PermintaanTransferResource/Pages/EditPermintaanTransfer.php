<?php

namespace App\Filament\Resources\PermintaanTransferResource\Pages;

use App\Filament\Resources\PermintaanTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermintaanTransfer extends EditRecord
{
    protected static string $resource = PermintaanTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
