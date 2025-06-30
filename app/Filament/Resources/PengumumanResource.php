<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengumumanResource\Pages;
use App\Filament\Resources\PengumumanResource\RelationManagers;
use App\Models\Pengumuman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Pengumuman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id')->default(fn () => app('currentTenant')->id ?? null),
                Forms\Components\TextInput::make('judul')->label('Judul')->required(),
                Forms\Components\Textarea::make('isi')->label('Isi')->required(),
                Forms\Components\DatePicker::make('tanggal')->label('Tanggal')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('isi')->label('Isi')->limit(50),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->date(),
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
            'index' => Pages\ListPengumumen::route('/'),
            'create' => Pages\CreatePengumuman::route('/create'),
            'edit' => Pages\EditPengumuman::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Manajemen Pengumuman';
    }

    public static function getModelLabel(): string
    {
        return 'Pengumuman';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pengumuman';
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = 2; // Hardcode ke RS Harapan Kita, ganti sesuai kebutuhan
        return $data;
    }
}
