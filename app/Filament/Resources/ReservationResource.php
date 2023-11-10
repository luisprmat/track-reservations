<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Services\ReservationService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square-stack';

    public static function getModelLabel(): string
    {
        return __('reservation');
    }

    public static function form(Form $form): Form
    {
        $dateFormat = 'Y-m-d';

        return $form
            ->schema([
                DatePicker::make('date')
                    ->translateLabel()
                    ->native(false)
                    ->minDate(now()->format($dateFormat))
                    ->maxDate(now()->addWeeks(2)->format($dateFormat))
                    ->format($dateFormat)
                    ->required()
                    ->live(),
                Radio::make('track')
                    ->translateLabel()
                    ->options(fn (Get $get) => (new ReservationService())->getAvailableReservations($get('date')))
                    ->hidden(fn (Get $get) => ! $get('date'))
                    ->required()
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->translateLabel(),
                TextColumn::make('track.title')
                    ->translateLabel(),
                TextColumn::make('start_time')
                    ->translateLabel()
                    ->dateTime('Y-m-d H:i'),
                TextColumn::make('end_time')
                    ->translateLabel()
                    ->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('start_time', 'desc');
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
        ];
    }
}
