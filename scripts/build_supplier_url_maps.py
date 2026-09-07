"""One-off helper: creates verified supplier product URL mappings from supplied sources."""

from __future__ import annotations

import argparse
import csv
import json
import re
import time
import xml.etree.ElementTree as et
from concurrent.futures import ThreadPoolExecutor, as_completed
from pathlib import Path
from urllib.parse import quote
from urllib.request import Request, urlopen


def normalize(value: str) -> str:
    return re.sub(r"[^a-z0-9]", "", value.lower())


def audioseed_map(sitemap: Path, source: Path) -> dict[str, str]:
    root = et.parse(sitemap).getroot()
    ns = {"s": "http://www.sitemaps.org/schemas/sitemap/0.9"}
    candidates: dict[str, list[str]] = {}
    for node in root.findall("s:url", ns):
        url = node.findtext("s:loc", default="", namespaces=ns)
        slug = url.rstrip("/").rsplit("/", 1)[-1]
        candidates.setdefault(normalize(slug), []).append(url)

    mapped: dict[str, str] = {}
    with source.open(encoding="utf-8", newline="") as handle:
        for index, row in enumerate(csv.reader(handle, delimiter=";")):
            if index == 0 or not row or not row[0].strip():
                continue
            sku = row[0].strip()
            urls = candidates.get(normalize(sku), [])
            if len(urls) == 1:
                mapped[sku] = urls[0]
    return mapped


def elimex_url(sku: str) -> tuple[str, str | None]:
    url = "https://elimex.hu/livesearch?q=" + quote(sku)
    request = Request(url, headers={"User-Agent": "Epuletaudio product catalogue updater/1.0"})
    try:
        with urlopen(request, timeout=25) as response:
            payload = json.load(response)
        target = normalize(sku)
        for item in payload.get("data", []):
            if normalize(str(item.get("sku", ""))) == target and item.get("url"):
                return sku, "https://elimex.hu" + item["url"]
    except Exception:
        pass
    return sku, None


def elimex_map(source: Path, workers: int) -> dict[str, str]:
    skus: list[str] = []
    with source.open(encoding="utf-8-sig", newline="") as handle:
        for row in csv.reader(handle, delimiter=";"):
            if row and row[0].strip() and row[0].strip() != "Rendelési kód":
                skus.append(row[0].strip())

    mapped: dict[str, str] = {}
    with ThreadPoolExecutor(max_workers=workers) as executor:
        futures = [executor.submit(elimex_url, sku) for sku in skus]
        for index, future in enumerate(as_completed(futures), start=1):
            sku, url = future.result()
            if url:
                mapped[sku] = url
            if index % 250 == 0:
                print(f"Elimex: {index}/{len(skus)}", flush=True)
    return mapped


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("--elimex-csv", required=True, type=Path)
    parser.add_argument("--audioseed-csv", required=True, type=Path)
    parser.add_argument("--audioseed-sitemap", required=True, type=Path)
    parser.add_argument("--output", required=True, type=Path)
    parser.add_argument("--workers", type=int, default=6)
    args = parser.parse_args()

    audioseed = audioseed_map(args.audioseed_sitemap, args.audioseed_csv)
    print(f"Audioseed: {len(audioseed)} URL párosítva", flush=True)
    elimex = elimex_map(args.elimex_csv, args.workers)
    args.output.write_text(json.dumps({"audioseed": audioseed, "elimex": elimex}, ensure_ascii=False), encoding="utf-8")
    print(f"Elimex: {len(elimex)} URL párosítva", flush=True)


if __name__ == "__main__":
    main()
