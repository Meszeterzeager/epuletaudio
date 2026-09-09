<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class QuoteOrderController extends Controller
{
    /**
     * Az ajánlat-emailben lévő, aláírt (signed) "Megrendelem" linkre kattintva
     * ide érkezik az ügyfél. Ez a lépés önmagában NEM módosít semmit — csak egy
     * megerősítő oldalt mutat egy külön, rövid élettartamú aláírt POST linkkel,
     * hogy egy levélszűrő/linkelőnézet-bot automatikus GET-lekérése ne tudja
     * véletlenül megrendelni a rendszert az ügyfél kattintása nélkül.
     */
    public function show(QuoteRequest $quoteRequest): View
    {
        $alreadyOrdered = $quoteRequest->status === 'ordered';

        return view('quote-order-confirmation', [
            'quoteRequest' => $quoteRequest,
            'alreadyOrdered' => $alreadyOrdered,
            'confirmed' => false,
            'confirmUrl' => $alreadyOrdered ? null : URL::temporarySignedRoute(
                'quote.order.confirm',
                now()->addMinutes(30),
                ['quoteRequest' => $quoteRequest],
            ),
        ]);
    }

    /**
     * A megerősítő oldalon lévő gombra kattintva ide érkezik POST-tal — ez
     * állítja csak ténylegesen 'ordered' státuszba az ajánlatkérést, ami
     * automatikusan elindítja a beszerzést (QuoteRequest::booted() ->
     * PurchaseOrderGenerator).
     */
    public function confirm(QuoteRequest $quoteRequest): View
    {
        $alreadyOrdered = $quoteRequest->status === 'ordered';

        if (! $alreadyOrdered) {
            $quoteRequest->update(['status' => 'ordered']);
        }

        return view('quote-order-confirmation', [
            'quoteRequest' => $quoteRequest,
            'alreadyOrdered' => $alreadyOrdered,
            'confirmed' => true,
            'confirmUrl' => null,
        ]);
    }
}
