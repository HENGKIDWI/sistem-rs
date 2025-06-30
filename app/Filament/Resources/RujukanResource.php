<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RujukanResource\Pages;
use App\Filament\Resources\RujukanResource\RelationManagers;
use App\Models\Rujukan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RujukanResource extends Resource
{
    protected static ?string $model = Rujukan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

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
            'index' => Pages\ListRujukans::route('/'),
            'create' => Pages\CreateRujukan::route('/create'),
            'edit' => Pages\EditRujukan::route('/{record}/edit'),
        ];
    }
}
