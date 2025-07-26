<?php

namespace App\Filament\Resources\PurchaseorderResource\Pages;

use App\Filament\Resources\PurchaseorderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchaseorder extends ViewRecord
{
    protected static string $resource = PurchaseorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
