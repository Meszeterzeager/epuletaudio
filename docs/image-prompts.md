# Hiányzó képek — Nano Banana 2 promptok

Ez a lista minden olyan képhelyet tartalmaz, ami jelenleg **üres** az oldalon (`hero_image`, `og_image`, `cover_image` mezők). Minden ponthoz van egy kész, angol nyelvű prompt — a képgeneráló modellek angol prompttal adnak megbízhatóbb, részletesebb eredményt, még magyar nyelvű oldalhoz is.

**Hogyan használd:**
1. Másold ki a promptot a Nano Banana 2-be (vagy bármelyik Gemini image modellbe).
2. A generált képet töltsd fel a Filament adminban a megfelelő mezőbe (`/admin/services`, `/admin/solutions`, `/admin/blog-posts`).
3. A feltöltés automatikusan átméretezi és WebP-re konvertálja — nem kell külön optimalizálnod.
4. Az `og_image` mezőhöz **nem kötelező külön képet generálni** — a hero-képet is feltölthetitő 1200×630-ra vágva, vagy elhagyhatod, ekkor az oldal az alap `og-default.jpg`-t használja.

Minden promptban szándékosan **nincs látható arc/emberi karakter közelről** (AI-generált arcok gyakran hamisan hatnak, és nem akarunk valódi embereket sem imitálni) — ehelyett hangulatos, üres vagy elmosott hátterű enteriőr-fotókat kérünk, ahogy egy prémium arculati weboldalon szokás.

---

## Szolgáltatások (`/admin/services` → `hero_image`, ajánlott: 1920×1080)

### 1. Épülethangosítás
```
Professional architectural interior photography of a modern, elegant public building lobby with a high ceiling and warm ambient lighting. Several sleek, minimalist white ceiling-mounted speakers are subtly visible, professionally installed and unobtrusive. Warm cream and deep petrol-teal color grading with a soft gold accent light. Wide-angle lens, shallow depth of field, no visible people, no text or logos, photorealistic, high-end commercial architecture photography, natural daylight through large windows.
```

### 2. Konferenciarendszerek
```
Photorealistic interior photography of a modern, minimalist conference room with a large wooden table, comfortable chairs, a large display screen on the wall, a small table microphone in the foreground, and a discreet ceiling-mounted speaker visible in the corner. Warm cream walls, petrol-teal accent furniture, soft natural light from a window, no visible people, clean corporate aesthetic, shallow depth of field, high-end commercial photography.
```

### 3. Tourguide-rendszerek
```
Wide-angle photorealistic photo inside a bright, modern museum or historic building interior, taken from behind a small group of visitors wearing small wireless tour-guide receiver headsets, walking through an exhibition hall. Warm, elegant lighting, petrol-teal and cream color palette, no visible faces, soft focus on the people, sharp focus on the architecture and exhibits, commercial editorial photography style.
```

### 4. Mobil hangosítás
```
Photorealistic photo of a pair of modern, compact portable PA speakers on stands, set up in an elegant event venue (an indoor hall with string lights or an outdoor terrace at golden hour). Warm gold and petrol-teal lighting accents, shallow depth of field with a softly blurred empty venue in the background, no people, no text, high-end event photography style.
```

---

## Megoldások (`/admin/solutions` → `hero_image`, ajánlott: 1920×1080)

### 5. Templomok
```
Photorealistic architectural photography of a beautiful, historic church interior with high vaulted ceilings, warm light streaming through stained glass windows, tasteful wooden pews. A small, unobtrusive speaker is subtly visible mounted on a stone column, blending with the architecture. Warm golden light, petrol-teal shadow tones, no visible people, respectful and serene atmosphere, wide-angle lens, high dynamic range.
```

### 6. Fogászatok, rendelők
```
Photorealistic interior photo of a calm, modern dental or medical clinic waiting room, soft neutral tones with cream walls and petrol-teal accent chairs, a small discreet ceiling speaker visible, plants and soft natural light, no visible people, minimalist and reassuring atmosphere, shallow depth of field, editorial healthcare interior photography style.
```

### 7. Kávézók, vendéglátás
```
Photorealistic photo of a cozy, stylish café interior with warm wood tones, cream and petrol-teal accents, a small design ceiling or wall-mounted speaker blending into the décor, soft ambient afternoon light through large windows, a couple of empty tables in soft focus foreground, no visible people, warm inviting atmosphere, commercial hospitality photography style.
```

### 8. Közületek, intézmények
```
Photorealistic wide-angle photo of a modern office or institutional building corridor, clean minimalist architecture, cream and petrol-teal color palette, a discreet ceiling-mounted speaker and a small wall-mounted zone control panel visible, soft daylight from large windows, no visible people, professional corporate architecture photography style.
```

---

## Tudástár cikkek (`/admin/blog-posts` → `cover_image`, ajánlott: 1920×1080, 16:9)

### 9. Miért fontos a helyszíni akusztikai felmérés hangosítás előtt?
```
Photorealistic wide shot of an acoustic engineer, shown from behind with face not visible, using a laptop and a small measurement microphone on a tripod, standing in the center of a large, empty, elegant hall with high ceilings. Warm petrol-teal and cream color grading, soft natural light, professional documentary photography style, no readable text on any screens.
```

### 10. 100V rendszer vagy alacsony impedanciás hangosítás
```
Photorealistic close-up photo of a professional audio amplifier rack with neatly organized cables and connectors, warm studio lighting, shallow depth of field, petrol-teal and gold color accents reflecting off the metal surfaces, clean and technical aesthetic, no visible text or brand logos, commercial technical photography style.
```

### 11. Konferenciateremek hangtechnikája
```
Photorealistic photo of a modern conference room table with a small ceiling-mounted microphone array and a compact digital mixer/DSP unit visible on a side table, warm cream and petrol-teal interior tones, soft daylight, no visible people, clean corporate technology photography style.
```

### 12. Tourguide rendszerek: mikor éri meg vezetett túrákhoz beruházni?
```
Photorealistic close-up product-style photo of a small wireless tour-guide receiver device with a compact headset, resting on a wooden surface next to a blurred, warmly lit museum interior in the background. Petrol-teal and gold color accents, soft studio lighting, shallow depth of field, no people, elegant product photography style.
```

### 13. 5 gyakori hiba épülethangosítási projekteknél
```
Photorealistic overhead flat-lay photo of architectural building blueprints and a small speaker/audio equipment sketch on a wooden desk, alongside a measuring tape and a pencil, warm natural window light from the side, petrol-teal and cream tones, no visible people or readable text, professional flat-lay photography style.
```

---

## Bónusz — továbbfejlesztett közösségimédia-megosztási kép (opcionális)

Jelenleg egy egyszerű, programmatikusan generált (GD) grafika szolgál alapértelmezett OG-képként (`public/images/og-default.jpg`). Ha szeretnétek egy polírozottabb, AI-generált verziót helyette:

```
Wide banner-format photorealistic image combining a modern building interior with subtly visible audio speakers, warm petrol-teal and cream color grading with a soft gold light accent in the corner, elegant and professional mood, no text, no logos, suitable as a website social-share background image, composition with visual interest concentrated on the left two-thirds to leave clean space on the right for a logo overlay.
```

Ezt `public/images/og-default.jpg` néven kell elmenteni (1200×630, JPG), felülírva a jelenlegi fájlt.

---

## Amit szándékosan kihagytam

A **referencia-projektek** (`/referenciak`) fotóit nem vettem fel ide. Azok jelenleg egyértelműen **"DEMO"** feliratú helykitöltők — ha AI-generált "fotórealisztikus telepítési képeket" tennénk be helyettük, az azt a látszatot kelthetné, hogy valódi, megvalósult munkákról van szó, ami félrevezető lenne a látogatóknak. Amint lesznek valódi projektfotóid, azokat kell feltölteni a `/admin/projects` alatt.
