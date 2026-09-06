<?php

namespace App\Filament\Resources\QuoteRequests\Pages;

use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuoteRequest extends ViewRecord
{
    protected static string $resource = QuoteRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            QuoteRequestResource::sendProcessingNotificationAction(),
            QuoteRequestResource::sendClarificationNeededAction(),
            QuoteRequestResource::sendOfferAction(),
            QuoteRequestResource::markAsOrderedAction(),
            QuoteRequestResource::editInternalNotesAction(),
        ];
    }
}
