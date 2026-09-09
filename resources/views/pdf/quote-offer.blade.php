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
    h2.section { font-size: 13px; color: #002828; margin: 22px 0 8px; padding-bottom: 6px; border-bottom: 1px solid #f0ebe1; }
    p { margin: 0 0 9px; line-height: 1.5; }
    table.items { width: 100%; border-collapse: collapse; margin-top: 4px; }
    table.items th { text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.04em; color: #002828; border-bottom: 2px solid #f0ebe1; padding: 6px 4px; }
    table.items td { font-size: 11px; padding: 8px 4px; border-bottom: 1px solid #f0ebe1; vertical-align: top; }
    table.items td.num, table.items th.num { text-align: right; white-space: nowrap; }
    table.items tr.group td { background-color: #f0ebe1; color: #002828; font-weight: bold; padding: 6px 4px; border-bottom: none; }
    table.items tr.total-row td { font-weight: bold; border-bottom: none; padding-top: 10px; }
    table.items tr.total-row.grand td { font-size: 13px; color: #002828; padding-top: 4px; }
    .terms-box { background-color: #f0ebe1; border-radius: 6px; padding: 14px 18px; margin-top: 4px; }
    .terms-line { font-size: 11px; line-height: 1.9; }
    .terms-line strong { color: #002828; }
    .footer { padding: 16px 32px; font-size: 10px; color: #8a8478; border-top: 1px solid #f0ebe1; margin-top: 24px; }
</style>
</head>
<body>
@php
  $net = $items->sum(fn ($item) => $item->quantity * (float) $item->unit_price);
  $gross = $net * 1.27;
  $groups = $items->groupBy(fn ($item) => $item->group_name ?: 'Csoport 1');
@endphp
    <div class="header">
        <table>
            <tr>
                <td style="width: 44px;">
                    <img src="{{ public_path('images/logo-icon.png') }}" alt="Épületaudió">
                </td>
                <td>
                    <h1>Ajánlat — {{ $quoteRequest->offerNumber() }}</h1>
                    <p>{{ config('app.name') }} &middot; Kelt: {{ now()->format('Y. m. d.') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table class="cols">
            <tr>
                <td>
                    <div class="box-title">Ajánlat adó</div>
                    <div class="box-name">Épületaudió</div>
                    <div class="box-line">
                        {{ config('company.legal_name') }}<br>
                        {{ config('company.address') }}<br>
                        Adószám: {{ config('company.tax_number') }}<br>
                        {{ config('company.email') }}
                    </div>
                </td>
                <td>
                    <div class="box-title">Ajánlatkérő</div>
                    <div class="box-name">{{ $quoteRequest->company ?: $quoteRequest->name }}</div>
                    <div class="box-line">
                        @if ($quoteRequest->company)
                            {{ $quoteRequest->name }}<br>
                        @endif
                        {{ $quoteRequest->email }}<br>
                        {{ $quoteRequest->phone }}
                    </div>
                </td>
            </tr>
        </table>

        <p>Tisztelt {{ $quoteRequest->name }}!</p>
        <p>Köszönettel megkaptuk ajánlatkérését {{ $quoteRequest->created_at->format('Y.m.d.') }} napon, melyre az alábbiakban elkészítettük a megadott igények alapján ajánlatunkat.</p>
        <p>Kérjük a javasolt megoldásokat tekintse át, és kérdés esetén keressen bizalommal minket elérhetőségeinken.</p>

        <h2 class="section">Ajánlat</h2>
        <table class="items">
            <thead>
                <tr>
                    <th>Cikkszám</th>
                    <th>Megnevezés</th>
                    <th class="num">Mennyiség</th>
                    <th class="num">Nettó egységár</th>
                    <th class="num">Nettó összesen</th>
                    <th class="num">Bruttó ár</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group => $groupItems)
                    <tr class="group"><td colspan="6">{{ $group }}</td></tr>
                    @foreach ($groupItems as $item)
                        <tr>
                            <td>{{ $item->supplierProduct?->sku ?: '-' }}</td>
                            <td><strong>{{ $item->title }}</strong>@if($item->description)<br><span>{{ $item->description }}</span>@endif</td>
                            <td class="num">{{ rtrim(rtrim(number_format((float) $item->quantity, 2, ',', ' '), '0'), ',') }} {{ $item->unit }}</td>
                            <td class="num">{{ number_format((float) $item->unit_price, 0, ',', ' ') }} Ft</td>
                            <td class="num">{{ number_format($item->quantity * (float) $item->unit_price, 0, ',', ' ') }} Ft</td>
                            <td class="num">{{ number_format($item->quantity * (float) $item->unit_price * 1.27, 0, ',', ' ') }} Ft</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr class="total-row">
                    <td colspan="4"></td>
                    <td colspan="1">Nettó összesen</td>
                    <td class="num">{{ number_format($net, 0, ',', ' ') }} Ft</td>
                </tr>
                <tr class="total-row grand">
                    <td colspan="4"></td>
                    <td colspan="1">Bruttó összesen</td>
                    <td class="num">{{ number_format($gross, 0, ',', ' ') }} Ft</td>
                </tr>
            </tbody>
        </table>

        <h2 class="section">Ügyfél igénye</h2>
        <p>Az Ön által megadott adatokat és igényeket az ajánlatkérő visszaigazoló levelével együtt csatolmányként mellékeljük.</p>

        @if($quoteRequest->system_description)
            <h2 class="section">Rendszerleírás</h2>
            <p>{!! nl2br(e($quoteRequest->system_description)) !!}</p>
        @endif

        <h2 class="section">Feltételek</h2>
        <div class="terms-box">
            <div class="terms-line"><strong>Ajánlat érvényessége:</strong> 30 nap, illetve gyártói árváltozásig és az aktuális napi MNB EUR/HUF árfolyam + 5 Ft.</div>
            <div class="terms-line"><strong>Szállítási feltételek:</strong> Megrendeléstől számítottan átlagosan {{ $quoteRequest->delivery_weeks ?: '2-3 hét' }} alatt, mely függ a gyártói és beszállítói készletek elérhetőségétől és aktuális raktárkészletétől.</div>
            <div class="terms-line"><strong>Fizetési feltételek:</strong> A termékek és a szállítási díj fizetése 100% előreutalás díjbekérő alapján megrendeléskor.</div>
            <div class="terms-line"><strong>Telepítés:</strong> A rendszerek telepítését alvállalkozóval végezzük, melynek díja xy Ft. A telepítés költségéről a számlát partnerünk állítja ki a teljesítést követően.</div>
            <div class="terms-line"><strong>Garancia:</strong> A termékekre a hatályos jogszabályok szerint 2 év garanciát vállalunk. A garancia nem vonatkozik a nem rendeltetésszerű használatból eredő károkra.</div>
        </div>
    </div>

    <div class="footer">
        {{ config('company.legal_name') }} &middot; {{ config('company.address') }} &middot; Adószám: {{ config('company.tax_number') }} &middot; {{ config('company.email') }}
    </div>
</body>
</html>
