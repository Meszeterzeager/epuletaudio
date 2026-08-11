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

### 5. Ablaküveg-átbeszélő rendszer recepciókra
```
Photorealistic close-up interior photo of a modern reception or service desk with a glass or acrylic protective partition, showing a small discreet talk-through intercom grille/microphone unit built into the glass. Warm cream and petrol-teal color palette with a soft gold accent light, clean minimalist desk surface, no visible people or faces, shallow depth of field, professional commercial interior photography style, no text or logos.
```

### 6. Vészhangosítás & Evakuáció (EVAC)
```
Photorealistic photo of a modern office or public building corridor with a discreet white ceiling-mounted speaker paired with a small illuminated emergency exit sign visible down the hallway. Clean, reassuring, professional atmosphere, warm cream walls with petrol-teal and a subtle red/amber emergency-light accent, soft daylight, no visible people, no readable text on any signage, high-end commercial architecture photography style.
```

---

## Megoldások (`/admin/solutions` → `hero_image`, ajánlott: 1920×1080)

### 7. Ipari csarnokok & Raktárak
```
Photorealistic wide-angle interior photo of a large, clean industrial warehouse or logistics hall with high ceilings, steel racking in soft focus in the background, a rugged horn speaker and a weatherproof wall speaker visible mounted high on a steel column. Cool industrial grey tones with petrol-teal and warm gold accent lighting, no visible people, no text or logos, professional industrial architecture photography style.
```

### 8. Vendéglátás & Hotelek
```
Photorealistic photo of an elegant hotel lobby or restaurant lounge interior with warm wood tones, cream and petrol-teal accents, a small design ceiling or wall-mounted speaker blending into the décor, soft ambient light through large windows, a couple of empty lounge chairs and tables in soft focus foreground, no visible people, warm inviting atmosphere, commercial hospitality photography style.
```

### 9. Egészségügy & Magánrendelők
```
Photorealistic interior photo of a calm, modern dental or medical clinic waiting room, soft neutral tones with cream walls and petrol-teal accent chairs, a small discreet ceiling speaker visible, plants and soft natural light, no visible people, minimalist and reassuring atmosphere, shallow depth of field, editorial healthcare interior photography style.
```

### 10. Irodák & Konferenciatermek
```
Photorealistic interior photography of a modern, minimalist conference room with a large wooden table, comfortable chairs, a large display screen on the wall, a small ceiling-mounted microphone array visible, and a discreet ceiling speaker in the corner. Warm cream walls, petrol-teal accent furniture, soft natural light from a window, no visible people, clean corporate aesthetic, shallow depth of field, high-end commercial photography.
```

### 11. Kereskedelem & Showroomok
```
Photorealistic wide-angle photo of a bright, modern retail store or car showroom interior, clean minimalist architecture, cream and petrol-teal color palette with a soft gold accent light, a discreet dome ceiling speaker visible, softly blurred product displays in the background, no visible people, no readable text or logos, professional retail architecture photography style.
```

### 12. Oktatás & Közintézmények
```
Photorealistic wide-angle photo of a modern school or institutional building corridor, clean minimalist architecture, cream and petrol-teal color palette, a discreet ceiling-mounted speaker and a small wall-mounted zone control panel visible, soft daylight from large windows, no visible people, professional corporate architecture photography style.
```

### 13. Templomok & Műemlékek
```
Photorealistic architectural photography of a beautiful, historic church interior with high vaulted ceilings, warm light streaming through stained glass windows, tasteful wooden pews. A slim column speaker is subtly visible mounted on a stone column, blending with the architecture. Warm golden light, petrol-teal shadow tones, no visible people, respectful and serene atmosphere, wide-angle lens, high dynamic range.
```

### 14. Sport & Szabadidő
```
Photorealistic wide-angle photo of a modern indoor sports hall or fitness studio, bright and clean, a rugged weatherproof speaker visible mounted high on the wall, soft daylight through high windows, petrol-teal and cream color palette with a warm gold accent, no visible people, no text or logos, professional sports architecture photography style.
```

---

## Tudástár cikkek (`/admin/blog-posts` → `cover_image`, ajánlott: 1920×1080, 16:9)

A cikkek szövege bővült, ezért az alábbi promptok frissítve lettek, hogy pontosabban illeszkedjenek az egyes cikkek tartalmi hangsúlyához (mérési folyamat, műszaki részletek, higiénia stb.).

### 15. Miért fontos a helyszíni akusztikai felmérés hangosítás előtt?
```
Photorealistic wide shot of an acoustic engineer, shown from behind or from the side with face not visible, holding a tablet and standing next to a measurement microphone on a tripod, in the center of a large, empty, elegant hall with high ceilings and tall windows. A faint, subtle waveform or level-meter graphic is visible on the tablet screen. Warm petrol-teal and cream color grading, soft natural light, professional documentary photography style, no readable text on any screens, no visible faces.
```

### 16. 100V rendszer vagy alacsony impedanciás hangosítás
```
Photorealistic close-up photo of a professional audio amplifier rack with neatly organized cables, terminal blocks, and a small visible step-up transformer unit near a speaker cable connector, warm studio lighting, shallow depth of field, petrol-teal and gold color accents reflecting off the metal surfaces, clean and technical aesthetic, no visible text or brand logos, commercial technical photography style.
```

### 17. Konferenciateremek hangtechnikája
```
Photorealistic photo of a modern conference room table with a small ceiling-mounted microphone array visible above, and a compact digital mixer/DSP unit with a few illuminated indicator lights visible on a side credenza, a large display screen softly blurred in the background. Warm cream and petrol-teal interior tones, soft daylight, no visible people, clean corporate technology photography style.
```

### 18. Tourguide rendszerek: mikor éri meg vezetett túrákhoz beruházni?
```
Photorealistic close-up product-style photo of a small wireless tour-guide receiver device with a compact headset, resting next to an open charging case with several more receivers neatly docked inside, on a wooden surface with a blurred, warmly lit museum interior in the background. Petrol-teal and gold color accents, soft studio lighting, shallow depth of field, no people, elegant product photography style.
```

### 19. 5 gyakori hiba épülethangosítási projekteknél
```
Photorealistic overhead flat-lay photo of architectural building blueprints with a highlighted speaker-placement sketch, a coil of speaker cable, a measuring tape, and a pencil, arranged on a wooden desk with warm natural window light from the side. Petrol-teal and cream tones with a soft gold accent, no visible people or readable text, professional flat-lay photography style.
```

---

## Főkategória oldalak — OG-megosztási kép (1200×630, banner formátum)

Ezek a `/szolgaltatasok`, `/megoldasok`, `/rolunk` és `/tudastar` listaoldalak jelenleg **nem** rendelkeznek saját `og_image`-dzsel — ha valaki megosztja ezeket a linkeket (Messenger, WhatsApp, Facebook), mindegyik ugyanazt az általános `og-default.jpg`-t és egy hosszú, generikus leírást mutatja, ami levágva/csonkolva jelenik meg a megosztási kártyán. Egyedi, banner-formátumú kép mindegyikhez sokkal jobb megosztási kártyát ad.

### 20. Szolgáltatások (listaoldal)
```
Wide banner-format photorealistic image of a professional audio installer's tool table, featuring a small selection of ceiling speakers, a coil of neatly wound cable, and a compact amplifier, arranged on a clean wooden surface. Warm cream and petrol-teal color grading with a soft gold accent light, shallow depth of field, no visible people, no text or logos, composition with visual interest concentrated on the left two-thirds to leave clean space on the right for a title overlay.
```

### 21. Megoldások (listaoldal)
```
Wide banner-format photorealistic overhead flat-lay image of architectural building blueprints for several different building types (a church floor plan, an office floor plan) laid side by side on a desk, with a small speaker icon sketch and a measuring tape. Warm petrol-teal and cream tones with a soft gold accent light, no visible people or readable text, professional flat-lay photography style, composition weighted to the left two-thirds to leave clean space on the right for a title overlay.
```

### 22. Rólunk
```
Wide banner-format photorealistic photo of a clean, organized professional audio workshop or rack room, with a technician's hands (no face visible) adjusting a rack-mounted amplifier, neatly labeled cables in the foreground. Warm cream and petrol-teal color grading with a soft gold accent light, shallow depth of field, no visible faces, professional documentary photography style, composition weighted to the left two-thirds to leave clean space on the right for a title overlay.
```

### 23. Tudástár (listaoldal)
```
Wide banner-format photorealistic overhead flat-lay image of an open notebook with technical sketches, a pair of reading glasses, and a small measurement microphone on a tripod, resting on a wooden desk with warm natural window light from the side. Petrol-teal and cream tones with a soft gold accent, no visible people or readable text, professional flat-lay photography style, composition weighted to the left two-thirds to leave clean space on the right for a title overlay.
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
