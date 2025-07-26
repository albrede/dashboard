<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseorderResource\Pages;
use App\Filament\Resources\PurchaseorderResource\RelationManagers;
use App\Models\Purchaseorder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseorderResource extends Resource
{
    protected static ?string $model = Purchaseorder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier' , 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                // Forms\Components\Select::make('pharmacy_id')
                //     ->required()
                //     ->numeric(),
                Forms\Components\DateTimePicker::make('order_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('delivery_date'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('pharmacy_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
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
            'index' => Pages\ListPurchaseorders::route('/'),
            'create' => Pages\CreatePurchaseorder::route('/create'),
            'view' => Pages\ViewPurchaseorder::route('/{record}'),
            'edit' => Pages\EditPurchaseorder::route('/{record}/edit'),
        ];
    }
}
