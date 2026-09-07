<?php

namespace App\Filament\Resources\Quotes\Pages;

use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use App\Filament\Resources\Quotes\QuoteResource;
use App\Models\QuoteRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')->label('Ajánlat PDF letöltése')->icon('heroicon-o-arrow-down-tray')->color('gray')
                ->action(function (QuoteRequest $record) {
                    $record->offerNumber();
                    $record->loadMissing('items.supplierProduct');
                    return response()->streamDownload(fn () => print Pdf::loadView('pdf.quote-offer', ['quoteRequest' => $record, 'items' => $record->items])->output(), $record->offerNumber().'.pdf');
                }),
            QuoteRequestResource::sendOfferAction(),
            QuoteRequestResource::markAsOrderedAction(),
            QuoteRequestResource::editInternalNotesAction(),
            EditAction::make(),
        ];
    }
}
