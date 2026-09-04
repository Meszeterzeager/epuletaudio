<?php

namespace App\Console\Commands;

use App\Models\Supplier;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportAudioseedProducts extends Command
{
    protected $signature = 'audioseed:import {path : A UnasShop export nyers CSV-je (pontosvesszővel tagolt)}';

    protected $description = 'Egyszeri import: Audioseed termékek betöltése egy UnasShop exportból (nettó kisker ár, 15% beszerzési kedvezménnyel)';

    /**
     * Az Audioseed 15% kedvezményt ad a nettó kisker árból.
     */
    private const SUPPLIER_DISCOUNT = 0.85;

    private const MAX_NAME_LENGTH = 250;

    public function handle(): int
    {
        $path = $this->argument('path');

        if (! is_file($path)) {
            $this->error("A fájl nem található: {$path}");

            return self::FAILURE;
        }

        $supplier = Supplier::where('email', 'info@audioseed.hu')->first();

        if (! $supplier) {
            $this->error('Az Audioseed beszállító nem található (email: info@audioseed.hu).');

            return self::FAILURE;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle, 0, ';', '"');

        if ($header === false) {
            $this->error('A CSV üres vagy nem olvasható.');

            return self::FAILURE;
        }

        $now = now();
        $rows = [];
        $skipped = 0;

        while (($fields = fgetcsv($handle, 0, ';', '"')) !== false) {
            $sku = trim($fields[0] ?? '');

            if ($sku === '') {
                $skipped++;

                continue;
            }

            $priceRaw = trim($fields[2] ?? '');
            $description = trim($fields[3] ?? '');

            $cleanDescription = $this->cleanDescription($description);
            $name = $cleanDescription !== '' ? "{$sku} {$cleanDescription}" : $sku;
            $name = $this->fitToColumn($name);

            $sellingPrice = null;
            $purchasePrice = null;

            if ($priceRaw !== '' && is_numeric($priceRaw)) {
                $sellingPrice = number_format((float) $priceRaw, 2, '.', '');
                $purchasePrice = number_format(((float) $priceRaw) * self::SUPPLIER_DISCOUNT, 2, '.', '');
            }

            $rows[] = [
                'supplier_id' => $supplier->id,
                'sku' => $sku,
                'name' => $name,
                'purchase_price' => $purchasePrice,
                'selling_price' => $sellingPrice,
                'currency' => 'HUF',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        fclose($handle);

        $this->info(sprintf('%d termék sor feldolgozva, %d kihagyva (üres SKU).', count($rows), $skipped));

        $imported = 0;

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('supplier_products')->upsert(
                $chunk,
                ['supplier_id', 'sku'],
                ['name', 'purchase_price', 'selling_price', 'currency', 'updated_at']
            );
            $imported += count($chunk);
        }

        $this->info("Kész: {$imported} Audioseed termék importálva/frissítve.");

        return self::SUCCESS;
    }

    private function cleanDescription(string $description): string
    {
        if ($description === '') {
            return '';
        }

        $text = preg_replace('/<[^>]*>/', ' ', $description);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    private function fitToColumn(string $name): string
    {
        if (mb_strlen($name) <= self::MAX_NAME_LENGTH) {
            return $name;
        }

        $truncated = mb_substr($name, 0, self::MAX_NAME_LENGTH);
        $lastSpace = mb_strrpos($truncated, ' ');

        if ($lastSpace !== false && $lastSpace > 0) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, " \t\n\r\0\x0B,.;-");
    }
}
