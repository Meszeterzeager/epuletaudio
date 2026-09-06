<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            OrderResource::sendPaymentRequestAction(),
            QuoteRequestResource::editInternalNotesAction(),
            EditAction::make(),
        ];
    }
}
