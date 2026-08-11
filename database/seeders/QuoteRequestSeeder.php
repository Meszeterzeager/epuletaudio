<?php

namespace Database\Seeders;

use App\Models\BillableService;
use App\Models\QuoteRequest;
use App\Models\SupplierProduct;
use Illuminate\Database\Seeder;

class QuoteRequestSeeder extends Seeder
{
    public function run(): void
    {
        $quoteRequests = [
            [
                'name' => 'Kovács Béla',
                'email' => 'kovacs.bela@example.com',
                'phone' => '+36 20 111 2222',
                'company' => 'Belvárosi Fogászat Kft.',
                'building_type' => 'fogaszat_rendelo',
                'requested_systems' => ['epulethangositas'],
                'space_character' => 'zart',
                'room_count' => 4,
                'existing_system' => false,
                'wants_installation' => true,
                'wants_site_survey' => true,
                'message' => 'Nyugtató háttérzenét szeretnénk a váróba és a recepcióra, minél diszkrétebb kivitelben.',
                'gdpr_consent' => true,
                'status' => 'quote_issued',
                'internal_notes' => 'Árajánlat kiküldve emailben, visszajelzést várunk.',
            ],
            [
                'name' => 'Nagy Katalin',
                'email' => 'nagy.katalin@example.com',
                'phone' => '+36 30 333 4444',
                'company' => 'Napfény Kávézó',
                'building_type' => 'kavezo_vendeglatas',
                'requested_systems' => ['epulethangositas', 'mobil_hangositas'],
                'space_character' => 'felig_nyitott_vedett',
                'room_count' => 2,
                'existing_system' => true,
                'existing_system_notes' => 'Régi, egyzónás Bluetooth hangszóró, nem elégséges.',
                'wants_installation' => true,
                'wants_site_survey' => false,
                'message' => 'A teraszra és a belső térbe is szeretnénk külön vezérelt hangzást.',
                'gdpr_consent' => true,
                'status' => 'ordered',
                'internal_notes' => 'Megrendelve, telepítés időpontja egyeztetés alatt.',
            ],
            [
                'name' => 'Szabó Márton',
                'email' => 'szabo.marton@example.com',
                'phone' => '+36 70 555 6666',
                'company' => null,
                'building_type' => 'oktatasi_intezmeny',
                'requested_systems' => ['epulethangositas', 'konferenciarendszer'],
                'space_character' => 'zart',
                'room_count' => 12,
                'existing_system' => false,
                'wants_installation' => true,
                'wants_site_survey' => true,
                'message' => 'Iskolai csengetési rend és aulai rendezvényhangosítás lenne a cél, de a költségvetés még nincs elfogadva.',
                'gdpr_consent' => true,
                'status' => 'postponed',
                'internal_notes' => 'Az intézmény jövő évre halasztotta a beruházást, keresztféléves újraegyeztetés szükséges.',
            ],
        ];

        foreach ($quoteRequests as $data) {
            $quoteRequest = QuoteRequest::updateOrCreate(
                ['email' => $data['email'], 'name' => $data['name']],
                $data
            );

            $quoteRequest->items()->delete();
        }

        $this->attachSampleItems();
    }

    private function attachSampleItems(): void
    {
        $installation = BillableService::where('name', 'Hangrendszer telepítés')->first();
        $callOut = BillableService::where('name', 'Kiszállási díj')->first();
        $product = SupplierProduct::first();

        $quoted = QuoteRequest::where('email', 'kovacs.bela@example.com')->first();
        if ($quoted) {
            $quoted->items()->create([
                'item_type' => 'product',
                'supplier_product_id' => $product?->id,
                'title' => $product?->name ?? 'Mennyezeti hangfal',
                'quantity' => 4,
                'unit_price' => $product?->selling_price ?? $product?->purchase_price ?? 25000,
                'order' => 1,
            ]);
            $quoted->items()->create([
                'item_type' => 'service',
                'billable_service_id' => $installation?->id,
                'title' => $installation?->name ?? 'Hangrendszer telepítés',
                'quantity' => 1,
                'unit_price' => 45000,
                'order' => 2,
            ]);
        }

        $ordered = QuoteRequest::where('email', 'nagy.katalin@example.com')->first();
        if ($ordered) {
            $ordered->items()->create([
                'item_type' => 'service',
                'billable_service_id' => $callOut?->id,
                'title' => $callOut?->name ?? 'Kiszállási díj',
                'quantity' => 1,
                'unit_price' => 15000,
                'order' => 1,
            ]);
        }
    }
}
