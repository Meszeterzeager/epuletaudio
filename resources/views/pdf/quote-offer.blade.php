<!doctype html>
<html lang="hu">
<head><meta charset="utf-8"><style>
@page { margin: 30px 32px; } body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color:#1f2937; line-height:1.45; }
h1 { font-size:23px; margin:0 0 16px; color:#111827; } h2 { font-size:14px; margin:22px 0 8px; color:#111827; } p { margin:0 0 9px; }
.meta { width:100%; margin-bottom:20px; } .meta td { vertical-align:top; width:50%; } .label { color:#6b7280; font-size:9px; }
table.offer { width:100%; border-collapse:collapse; } .offer th { background:#1f2937; color:#fff; padding:7px 5px; text-align:left; font-size:8px; }
.offer td { padding:7px 5px; border-bottom:1px solid #d1d5db; vertical-align:top; } .offer .number { text-align:right; white-space:nowrap; }
.group td { background:#f3f4f6; font-weight:bold; padding:6px 5px; } .summary { width:42%; margin-left:auto; margin-top:12px; } .summary td { padding:4px; } .summary .total { font-weight:bold; border-top:1px solid #374151; }
.terms { margin-top:20px; } .terms dt { font-weight:bold; margin-top:9px; } .terms dd { margin:2px 0 0; }
</style></head>
<body>
@php
  $net = $items->sum(fn ($item) => $item->quantity * (float) $item->unit_price); $gross = $net * 1.27;
  $groups = $items->groupBy(fn ($item) => $item->group_name ?: 'Csoport 1');
@endphp
<table class="meta"><tr><td><strong>Épületaudió</strong><br>{{ config('company.legal_name') }}<br>{{ config('company.address') }}<br>Adószám: {{ config('company.tax_number') }}<br>{{ config('company.email') }}</td><td style="text-align:right"><span class="label">AJÁNLATSZÁM</span><br><strong>{{ $quoteRequest->offerNumber() }}</strong><br><br><span class="label">DÁTUM</span><br>{{ now()->format('Y.m.d.') }}</td></tr></table>
<h1>Ajánlat</h1>
<table class="meta"><tr><td><span class="label">AJÁNLATKÉRŐ</span><br><strong>{{ $quoteRequest->company ?: $quoteRequest->name }}</strong><br>{{ $quoteRequest->name }}<br>{{ $quoteRequest->email }}<br>{{ $quoteRequest->phone }}</td></tr></table>
<p>Tisztelt {{ $quoteRequest->name }}!</p>
<p>Köszönettel megkaptuk ajánlatkérését {{ $quoteRequest->created_at->format('Y.m.d.') }} napon, melyre az alábbiakban elkészítettük a megadott igények alapján ajánlatunkat.</p>
<p>Kérjük a javasolt megoldásokat tekintse át, és kérdés esetén keressen bizalommal minket elérhetőségeinken.</p>
<h2>Ajánlat</h2>
<table class="offer"><thead><tr><th>Cikkszám</th><th>Megnevezés</th><th>Mennyiség</th><th>Nettó egységár</th><th>Nettó összesen</th><th>Bruttó ár</th></tr></thead><tbody>
@foreach ($groups as $group => $groupItems)<tr class="group"><td colspan="6">{{ $group }}</td></tr>@foreach ($groupItems as $item)<tr><td>{{ $item->supplierProduct?->sku ?: '-' }}</td><td><strong>{{ $item->title }}</strong>@if($item->description)<br><span>{{ $item->description }}</span>@endif</td><td class="number">{{ rtrim(rtrim(number_format((float) $item->quantity, 2, ',', ' '), '0'), ',') }} {{ $item->unit }}</td><td class="number">{{ number_format((float) $item->unit_price, 0, ',', ' ') }} Ft</td><td class="number">{{ number_format($item->quantity * (float) $item->unit_price, 0, ',', ' ') }} Ft</td><td class="number">{{ number_format($item->quantity * (float) $item->unit_price * 1.27, 0, ',', ' ') }} Ft</td></tr>@endforeach @endforeach
</tbody></table>
<table class="summary"><tr><td>Nettó összesen</td><td class="number">{{ number_format($net, 0, ',', ' ') }} Ft</td></tr><tr class="total"><td>Bruttó összesen</td><td class="number">{{ number_format($gross, 0, ',', ' ') }} Ft</td></tr></table>
<h2>Ügyfél igénye</h2><p>Az Ön által megadott adatokat és igényeket az ajánlatkérő visszaigazoló levelével együtt csatolmányként mellékeljük.</p>
@if($quoteRequest->system_description)<h2>Rendszerleírás</h2><p>{!! nl2br(e($quoteRequest->system_description)) !!}</p>@endif
<h2>Feltételek</h2><dl class="terms"><dt>Ajánlat érvényessége</dt><dd>30 nap, illetve gyártói árváltozásig és az aktuális napi MNB EUR/HUF árfolyam + 5 Ft.</dd><dt>Szállítási feltételek</dt><dd>Megrendeléstől számítottan átlagosan {{ $quoteRequest->delivery_weeks ?: '2-3 hét' }} alatt, mely függ a gyártói és beszállítói készletek elérhetőségétől és aktuális raktárkészletétől.</dd><dt>Fizetési feltételek</dt><dd>A termékek és a szállítási díj fizetése 100% előreutalás díjbekérő alapján megrendeléskor.</dd><dt>Telepítés</dt><dd>A rendszerek telepítését alvállalkozóval végezzük, melynek díja xy Ft. A telepítés költségéről a számlát partnerünk állítja ki a teljesítést követően.</dd><dt>Garancia</dt><dd>A termékekre a hatályos jogszabályok szerint 2 év garanciát vállalunk. A garancia nem vonatkozik a nem rendeltetésszerű használatból eredő károkra.</dd></dl>
</body></html>
