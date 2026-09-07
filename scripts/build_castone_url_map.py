"""Build a verified Castone SKU-to-product-page URL map from an annotated price-list PDF."""

from __future__ import annotations

import json
import re
import ssl
import sys
from urllib.request import Request, urlopen

from pypdf import PdfReader


def normalize(value: str) -> str:
    return re.sub(r"[^a-z0-9]", "", value.lower())


def main(pdf_path: str, output_path: str) -> None:
    reader = PdfReader(pdf_path)
    urls = {
        str(annotation.get_object()["/A"]["/URI"])
        for page in reader.pages
        for annotation in page.get("/Annots", [])
        if annotation.get_object().get("/A", {}).get("/URI")
    }
    products: dict[str, str] = {}
    for url in urls:
        try:
            request = Request(url, headers={"User-Agent": "Epuletaudio product catalogue updater/1.0"})
            with urlopen(request, timeout=25, context=ssl._create_unverified_context()) as response:
                html = response.read().decode("utf-8", errors="replace")
            match = re.search(r"<title>\s*([^<]+?)\s*</title>", html, re.I)
            if match:
                products[normalize(match.group(1))] = url
        except Exception:
            continue
    with open(output_path, "w", encoding="utf-8") as handle:
        json.dump(products, handle, ensure_ascii=False)
    print(f"{len(products)} Castone URL párosítva")


if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2])
