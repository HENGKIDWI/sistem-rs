<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AntrianResource\Pages;
use App\Filament\Resources\AntrianResource\RelationManagers;
use App\Models\Antrian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AntrianResource extends Resource
{
    protected static ?string $model = Antrian::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

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
                // Tidak ada aksi edit
            ])
            ->bulkActions([
                // Tidak ada aksi delete
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
        return [];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
