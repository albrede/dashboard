<?php

namespace App\Filament\Resources\PurchaseorderResource\Pages;

use App\Filament\Resources\PurchaseorderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseorder extends EditRecord
{
    protected static string $resource = PurchaseorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
