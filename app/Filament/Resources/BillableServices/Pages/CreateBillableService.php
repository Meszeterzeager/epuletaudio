<?php

namespace App\Filament\Resources\BillableServices\Pages;

use App\Filament\Resources\BillableServices\BillableServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBillableService extends CreateRecord
{
    protected static string $resource = BillableServiceResource::class;
}
