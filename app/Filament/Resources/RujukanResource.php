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
                Tables\Columns\TextColumn::make('pasien.name')->label('Pasien'),
                Tables\Columns\TextColumn::make('rumahSakitSumber.name')->label('Asal Rujukan'),
                Tables\Columns\TextColumn::make('dokter.nama_lengkap')->label('Dokter Perujuk'),
                Tables\Columns\TextColumn::make('alasan_rujukan')->label('Alasan')->limit(30),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match($state) {
                        'pending_rs_approval' => 'Menunggu Persetujuan RS',
                        'pending_patient_approval' => 'Menunggu Persetujuan Pasien',
                        'approved' => 'Disetujui',
                        'rejected_by_rs' => 'Ditolak RS',
                        'cancelled_by_patient' => 'Dibatalkan Pasien',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'pending_rs_approval' => 'warning',
                        'pending_patient_approval' => 'info',
                        'approved' => 'success',
                        'rejected_by_rs' => 'danger',
                        'cancelled_by_patient' => 'gray',
                        default => 'secondary',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending_rs_approval' => 'Menunggu Persetujuan RS',
                        'pending_patient_approval' => 'Menunggu Persetujuan Pasien',
                        'approved' => 'Disetujui',
                        'rejected_by_rs' => 'Ditolak RS',
                        'cancelled_by_patient' => 'Dibatalkan Pasien',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'pending_rs_approval')
                    ->action(fn($record) => $record->update(['status' => 'pending_patient_approval'])),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->color('danger')
                    ->visible(fn($record) => $record->status === 'pending_rs_approval')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('catatan_balasan')->label('Alasan Penolakan')->required(),
                    ])
                    ->action(function($record, array $data) {
                        $record->update([
                            'status' => 'rejected_by_rs',
                            'catatan_balasan' => $data['catatan_balasan'],
                        ]);
                    }),
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

    public static function getNavigationLabel(): string
    {
        return 'Rujukan Masuk';
    }

    public static function getModelLabel(): string
    {
        return 'Rujukan Masuk';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Rujukan Masuk';
    }
}
