<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('pharmacy_id')
                //     ->required()
                //     ->numeric(),
                Forms\Components\TextInput::make('customer_name')
                    ->maxLength(191),
                Forms\Components\DateTimePicker::make('sale_date')
                    ->required(),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_mode')
                    ->required()
                    ->maxLength(191),
                    Forms\Components\Section::make('items')
                    ->description('Medicines on this bill')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Repeater::make('medicine')
                            ->relationship('saleitems')
                            ->label('medicines')
                            ->schema([
                                Forms\Components\Select::make('medicine_id')
                                    ->label('medicine')
                                    ->options(\App\Models\Medicine::all()->mapWithKeys(fn($record) => [
                                        $record->id => $record->name
                                    ]))
                                    ->searchable()
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')->label('quantity')->numeric()->required(),
                                Forms\Components\TextInput::make('unit_price')->label('unit price')->numeric()->required(),
                            ])->columns(3)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('pharmacy_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sale_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_mode')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
