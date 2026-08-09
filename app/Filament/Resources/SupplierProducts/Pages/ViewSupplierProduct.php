<?php

namespace App\Filament\Resources\SupplierProducts\Pages;

use App\Filament\Resources\SupplierProducts\SupplierProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSupplierProduct extends ViewRecord
{
    protected static string $resource = SupplierProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
