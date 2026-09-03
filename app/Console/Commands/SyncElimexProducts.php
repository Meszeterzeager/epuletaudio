<?php

namespace App\Console\Commands;

use App\Models\Supplier;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SyncElimexProducts extends Command
{
    protected $signature = 'elimex:sync';

    protected $description = 'Az Elimex árlista API-ból frissíti a beszállítói termékeket (ár, kategória, készlet)';

    public function handle(): int
    {
        $username = config('services.elimex.username');
        $password = config('services.elimex.password');

        if (! $username || ! $password) {
            $this->error('Az ELIMEX_API_USERNAME / ELIMEX_API_PASSWORD nincs beállítva.');

            return self::FAILURE;
        }

        $supplier = Supplier::where('email', 'info@elimex.hu')->first();

        if (! $supplier) {
            $this->error('Az Elimex beszállító nem található (email: info@elimex.hu).');

            return self::FAILURE;
        }

        $this->info('Elimex árlista letöltése...');

        $response = Http::timeout(120)->get(config('services.elimex.url'), [
            'username' => $username,
            'password' => $password,
            'currency' => 'HUF',
        ]);

        if ($response->failed()) {
            $this->error('Az Elimex API hívás sikertelen: HTTP '.$response->status());

            return self::FAILURE;
        }

        $body = iconv('Windows-1250', 'UTF-8//TRANSLIT', $response->body());
        $lines = preg_split('/\r\n|\r|\n/', $body);

        $headerIndex = null;
        foreach ($lines as $index => $line) {
            if (str_starts_with($line, '"Rendelési kód"')) {
                $headerIndex = $index;
                break;
            }
        }

        if ($headerIndex === null) {
            $this->error('Nem található a fejléc sor az Elimex válaszban.');

            return self::FAILURE;
        }

        $now = now();
        $rows = [];
        $skipped = 0;

        foreach (array_slice($lines, $headerIndex + 1) as $line) {
            if (trim($line) === '') {
                continue;
            }

            $fields = str_getcsv($line, ';', '"');

            $sku = trim($fields[0] ?? '');

            if ($sku === '') {
                $skipped++;

                continue;
            }

            $name = trim($fields[1] ?? '');
            $purchasePrice = trim($fields[7] ?? '');
            $unit = trim($fields[8] ?? '');
            $lastPriceChange = trim($fields[10] ?? '');
            $stockStatus = trim($fields[12] ?? '');
            $category = trim($fields[13] ?? '');

            $lastPriceUpdatedAt = null;
            if ($lastPriceChange !== '') {
                $parsed = \DateTime::createFromFormat('!Y.m.d', $lastPriceChange);
                if ($parsed !== false) {
                    $lastPriceUpdatedAt = $parsed->format('Y-m-d H:i:s');
                }
            }

            $rows[] = [
                'supplier_id' => $supplier->id,
                'sku' => $sku,
                'name' => $name !== '' ? $name : $sku,
                'category' => $category !== '' ? Str::replace('/', ' - ', $category) : null,
                'purchase_price' => $purchasePrice !== '' ? $purchasePrice : null,
                'currency' => 'HUF',
                'unit' => $unit !== '' ? $unit : null,
                'stock_status' => $stockStatus !== '' ? $stockStatus : null,
                'stock_checked_at' => $now,
                'last_price_updated_at' => $lastPriceUpdatedAt,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->info(sprintf('%d termék sor feldolgozva, %d kihagyva (üres SKU).', count($rows), $skipped));

        $updated = 0;

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('supplier_products')->upsert(
                $chunk,
                ['supplier_id', 'sku'],
                ['name', 'category', 'purchase_price', 'currency', 'unit', 'stock_status', 'stock_checked_at', 'last_price_updated_at', 'updated_at']
            );
            $updated += count($chunk);
        }

        $this->info("Kész: {$updated} Elimex termék szinkronizálva.");

        return self::SUCCESS;
    }
}
