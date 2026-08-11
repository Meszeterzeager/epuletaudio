<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\QuoteRequest;
use Illuminate\Support\Collection;

class PurchaseOrderGenerator
{
    /**
     * Beszállítónként külön beszerzési rendelést generál az ajánlat
     * termék-tételeiből. Idempotens: ha már vannak beszerzési rendelések
     * ehhez az ajánlathoz, nem hoz létre újakat.
     *
     * @return Collection<int, PurchaseOrder>
     */
    public function generateForQuoteRequest(QuoteRequest $quoteRequest): Collection
    {
        if ($quoteRequest->purchaseOrders()->exists()) {
            return $quoteRequest->purchaseOrders;
        }

        $productItems = $quoteRequest->items()
            ->where('item_type', 'product')
            ->whereNotNull('supplier_product_id')
            ->with('supplierProduct.supplier')
            ->get()
            ->filter(fn ($item) => $item->supplierProduct?->supplier_id !== null);

        $bySupplier = $productItems->groupBy(fn ($item) => $item->supplierProduct->supplier_id);

        $purchaseOrders = new Collection;

        foreach ($bySupplier as $supplierId => $items) {
            $purchaseOrder = PurchaseOrder::create([
                'quote_request_id' => $quoteRequest->id,
                'supplier_id' => $supplierId,
                'status' => 'draft',
            ]);

            foreach ($items as $item) {
                $purchaseOrder->items()->create([
                    'supplier_product_id' => $item->supplier_product_id,
                    'title' => $item->title,
                    'sku' => $item->supplierProduct?->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->supplierProduct?->purchase_price,
                ]);
            }

            $purchaseOrders->push($purchaseOrder);
        }

        return $purchaseOrders;
    }
}
