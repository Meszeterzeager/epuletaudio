<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchaseOrder extends ViewRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('PDF letöltése')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(fn (PurchaseOrder $record) => response()->streamDownload(
                    fn () => print (Pdf::loadView('pdf.purchase-order', ['purchaseOrder' => $record])->output()),
                    $record->poNumber().'.pdf',
                )),

            PurchaseOrderResource::sendAction(),
        ];
    }
}
