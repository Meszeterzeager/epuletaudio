<?php

namespace App\Filament\Resources\Quotes\Pages;

use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use App\Filament\Resources\Quotes\QuoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            QuoteRequestResource::sendOfferAction(),
            QuoteRequestResource::markAsOrderedAction(),
            QuoteRequestResource::editInternalNotesAction(),
            EditAction::make(),
        ];
    }
}
