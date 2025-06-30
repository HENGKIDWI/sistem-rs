<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermintaanTransferResource\Pages;
use App\Filament\Resources\PermintaanTransferResource\RelationManagers;
use App\Models\PermintaanTransfer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermintaanTransferResource extends Resource
{
    protected static ?string $model = PermintaanTransfer::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermintaanTransfers::route('/'),
            'create' => Pages\CreatePermintaanTransfer::route('/create'),
            'edit' => Pages\EditPermintaanTransfer::route('/{record}/edit'),
        ];
    }
}
