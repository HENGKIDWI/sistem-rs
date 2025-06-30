<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleriFotoResource\Pages;
use App\Filament\Resources\GaleriFotoResource\RelationManagers;
use App\Models\GaleriFoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GaleriFotoResource extends Resource
{
    protected static ?string $model = GaleriFoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

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
            'index' => Pages\ListGaleriFotos::route('/'),
            'create' => Pages\CreateGaleriFoto::route('/create'),
            'edit' => Pages\EditGaleriFoto::route('/{record}/edit'),
        ];
    }
}
