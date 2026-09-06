<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuoteOrderController;
use App\Http\Controllers\ResendInboundWebhookController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Külön, navigáció nélküli hero-előnézet. A főoldalt nem érinti.
Route::view('/templomos', 'templomos')->name('templomos.preview');
Route::view('/templom', 'templomos')->name('templom.preview');
Route::view('/targyalo', 'targyalo')->name('targyalo.preview');
Route::view('/etterem', 'etterem')->name('etterem.preview');

Route::post('/webhooks/resend/inbound', [ResendInboundWebhookController::class, 'handle'])
    ->middleware('throttle:60,1')
    ->name('webhooks.resend.inbound');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::prefix('szolgaltatasok')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
});

Route::prefix('megoldasok')->group(function () {
    Route::get('/', [SolutionController::class, 'index'])->name('solutions.index');
    Route::get('/{solution:slug}', [SolutionController::class, 'show'])->name('solutions.show');
});

Route::prefix('referenciak')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
});

Route::get('/rolunk', [PageController::class, 'about'])->name('about');
Route::get('/kapcsolat', [PageController::class, 'contact'])->name('contact');
Route::view('/markaink', 'brands')->name('brands');

Route::view('/ajanlatkeres', 'quote')->name('quote.create');

Route::get('/ajanlat/megrendelem/{quoteRequest}', QuoteOrderController::class)
    ->middleware('signed')
    ->name('quote.order');

Route::view('/aszf', 'legal.terms')->name('legal.terms');
Route::view('/adatkezelesi-tajekoztato', 'legal.privacy')->name('legal.privacy');

Route::prefix('tudastar')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
});
