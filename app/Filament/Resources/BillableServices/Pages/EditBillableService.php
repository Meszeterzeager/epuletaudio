<?php

namespace App\Filament\Resources\BillableServices\Pages;

use App\Filament\Resources\BillableServices\BillableServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBillableService extends EditRecord
{
    protected static string $resource = BillableServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
