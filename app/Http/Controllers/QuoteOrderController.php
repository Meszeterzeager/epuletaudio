<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\View\View;

class QuoteOrderController extends Controller
{
    /**
     * Az ajánlat-emailben lévő, aláírt (signed) "Megrendelem" linkre kattintva
     * ide érkezik az ügyfél — ez zökkenőmentesen 'ordered' státuszba állítja
     * az ajánlatkérést, ami automatikusan elindítja a beszerzést
     * (QuoteRequest::booted() -> PurchaseOrderGenerator).
     */
    public function __invoke(QuoteRequest $quoteRequest): View
    {
        $alreadyOrdered = $quoteRequest->status === 'ordered';

        if (! $alreadyOrdered) {
            $quoteRequest->update(['status' => 'ordered']);
        }

        return view('quote-order-confirmation', [
            'quoteRequest' => $quoteRequest,
            'alreadyOrdered' => $alreadyOrdered,
        ]);
    }
}
