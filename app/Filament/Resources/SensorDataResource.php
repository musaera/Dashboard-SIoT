<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SensorDataResource\Pages;
use App\Filament\Resources\SensorDataResource\RelationManagers;
use App\Models\SensorData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SensorDataResource extends Resource
{
    protected static ?string $model = SensorData::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

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
                Tables\Columns\TextColumn::make('topic')
                    ->label('Topik')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('temperature')
                    ->label('Suhu (°C)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('humidity')
                    ->label('Kelembapan (%)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([])
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
            'index' => Pages\ListSensorData::route('/'),
            // 'create' => Pages\CreateSensorData::route('/create'),
            'edit' => Pages\EditSensorData::route('/{record}/edit'),
        ];
    }
}
