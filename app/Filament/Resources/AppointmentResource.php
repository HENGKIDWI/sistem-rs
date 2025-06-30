<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

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
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\TextColumn::make('user.name')->label('Pasien'),
                Tables\Columns\TextColumn::make('dokter.nama_lengkap')->label('Dokter'),
                Tables\Columns\TextColumn::make('tanggal_kunjungan')->label('Tanggal')->date('d-m-Y'),
                Tables\Columns\TextColumn::make('jam_kunjungan')->label('Jam')->time('H:i'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ])
            ->actions([
                // Tidak ada aksi edit/delete
            ])
            ->bulkActions([
                // Tidak ada aksi bulk
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
            'index' => Pages\ListAppointments::route('/'),
            // Hapus route create dan edit
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Manajemen Janji Temu';
    }

    public static function getModelLabel(): string
    {
        return 'Janji Temu';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Janji Temu';
    }
}
