<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="utf-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1c2321; margin: 0; padding: 0; }
    .header { background-color: #002828; color: #faf7f2; padding: 20px 32px; }
    .header table { width: 100%; border-collapse: collapse; }
    .header td { vertical-align: middle; }
    .header img { height: 30px; }
    .header h1 { margin: 0; font-size: 18px; }
    .header p { margin: 4px 0 0; font-size: 11px; color: #cdd8d8; }
    .content { padding: 24px 32px; }
    .cols { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .cols td { vertical-align: top; width: 50%; padding: 0; }
    .box-title { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #8a8478; margin-bottom: 4px; }
    .box-name { font-size: 13px; font-weight: bold; color: #002828; margin-bottom: 2px; }
    .box-line { font-size: 11px; color: #4b5563; line-height: 1.5; }
    table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table.items th { text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.04em; color: #002828; border-bottom: 2px solid #f0ebe1; padding: 6px 4px; }
    table.items td { font-size: 12px; padding: 8px 4px; border-bottom: 1px solid #f0ebe1; }
    table.items td.num, table.items th.num { text-align: right; }
    .total-row td { font-weight: bold; border-bottom: none; padding-top: 12px; }
    .footer { padding: 16px 32px; font-size: 10px; color: #8a8478; border-top: 1px solid #f0ebe1; margin-top: 24px; }
</style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 44px;">
                    <img src="{{ public_path('images/logo-icon.png') }}" alt="Épületaudio">
                </td>
                <td>
                    <h1>Megrendelő — {{ $purchaseOrder->poNumber() }}</h1>
                    <p>{{ config('app.name') }} &middot; Kelt: {{ $purchaseOrder->created_at?->format('Y. m. d.') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table class="cols">
            <tr>
                <td>
                    <div class="box-title">Megrendelő</div>
                    <div class="box-name">{{ config('company.legal_name') }}</div>
                    <div class="box-line">
                        {{ config('company.address') }}<br>
                        Adószám: {{ config('company.tax_number') }}<br>
                        {{ config('company.email') }}
                        @if (config('company.phone'))
                            &middot; {{ config('company.phone') }}
                        @endif
                    </div>
                </td>
                <td>
                    <div class="box-title">Szállító</div>
                    <div class="box-name">{{ $purchaseOrder->supplier->name }}</div>
                    <div class="box-line">
                        @if ($purchaseOrder->supplier->contact_person)
                            {{ $purchaseOrder->supplier->contact_person }}<br>
                        @endif
                        @if ($purchaseOrder->supplier->email)
                            {{ $purchaseOrder->supplier->email }}<br>
                        @endif
                        @if ($purchaseOrder->supplier->phone)
                            {{ $purchaseOrder->supplier->phone }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Termék</th>
                    <th>Cikkszám</th>
                    <th class="num">Menny.</th>
                    <th class="num">Egységár</th>
                    <th class="num">Összesen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->items as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->sku }}</td>
                        <td class="num">{{ rtrim(rtrim(number_format((float) $item->quantity, 2, ',', ' '), '0'), ',') }}</td>
                        <td class="num">{{ number_format((float) $item->unit_price, 0, ',', ' ') }} Ft</td>
                        <td class="num">{{ number_format($item->quantity * (float) $item->unit_price, 0, ',', ' ') }} Ft</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4">Összesen</td>
                    <td class="num">{{ number_format($purchaseOrder->totalAmount(), 0, ',', ' ') }} Ft</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        {{ config('company.legal_name') }} &middot; {{ config('company.address') }} &middot; Adószám: {{ config('company.tax_number') }} &middot; Cégjegyzékszám: {{ config('company.registration_number') }}
    </div>
</body>
</html>
