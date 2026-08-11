<?php

namespace App\Filament\Resources\BillableServices\Pages;

use App\Filament\Resources\BillableServices\BillableServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBillableServices extends ListRecords
{
    protected static string $resource = BillableServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
