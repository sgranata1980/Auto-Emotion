# Auto-Emotion

Website-Projekt für „Auto-Emotion“. Aufgebaut mit [Astro](https://astro.build) –
statisches HTML als Default, minimales JavaScript, gut geeignet für Google SEO und
AI Search / GEO (klares semantisches HTML, schnelle Ladezeiten, strukturierte Daten).

## Struktur

```
src/
  assets/images/   Bilder, werden von Astro automatisch optimiert (Image-Komponente)
  components/      Wiederverwendbare Bausteine (Header, Footer, SEO, JSON-LD)
  layouts/         Seiten-Grundgerüst (BaseLayout.astro)
  pages/           Eine Datei/ein Ordner = eine Route (file-based routing)
  styles/          Globales Basis-Designsystem (Custom Properties, Reset)
public/            Statische Dateien ohne Verarbeitung (robots.txt, Favicons, …)
```

Seiten aktuell angelegt: Start (`/`), Leistungen (`/leistungen/`), Kontakt
(`/kontakt/`), Impressum (`/impressum/`), Datenschutz (`/datenschutz/`).

## SEO / AI Search – was schon eingebaut ist

- Pro Seite: `<title>`, Meta Description, Canonical-URL, Open-Graph- und
  Twitter-Tags (`src/components/SEO.astro`)
- `Organization`-JSON-LD als Basis für strukturierte Daten
  (`src/components/OrganizationSchema.astro`) – bewusst minimal, bis reale
  Unternehmensdaten bestätigt sind
- `robots.txt` (`public/robots.txt`) und automatisch generierte XML-Sitemap
  (`@astrojs/sitemap`, entsteht beim Build)
- Semantisches HTML (header/nav/main/section/footer), Skip-Link, sichtbare
  Fokuszustände, `prefers-reduced-motion` berücksichtigt
- Statischer Output, automatisch optimierte Bilder (WebP, richtige Maße) für
  gute Core Web Vitals

Diese Basis folgt dem internen `stefano-web-standard` (Google SEO, Local SEO,
AI Search/GEO, semantisches HTML, Performance, Accessibility).

## Offene Fakten (bewusst nicht erfunden)

Damit nichts Falsches veröffentlicht wird, enthalten folgende Stellen `TODO`-
Platzhalter, bis die echten Angaben bestätigt sind:

- **Angebot & Zielgruppe**: Was genau bietet Auto-Emotion an, für wen?
  (`src/pages/index.astro`, `src/pages/leistungen/index.astro`)
- **Standort & Kontakt**: Adresse, Telefon, E-Mail – relevant für Local SEO
  und das Kontakt-/Impressum-Schema (`src/pages/kontakt/index.astro`)
- **Rechtliche Anbieterkennzeichnung**: Firmierung, Rechtsform, Vertretung,
  ggf. Handelsregister/USt-IdNr. (`src/pages/impressum/index.astro`) –
  **rechtlich bindend, vor Launch zwingend ergänzen**
- **Datenschutzerklärung**: abhängig von eingesetzten Diensten (Hosting,
  Analytics, Formulare) (`src/pages/datenschutz/index.astro`)
- **Produktions-Domain**: aktuell Platzhalter in `astro.config.mjs` und
  `public/robots.txt` (`https://www.auto-emotion.example`)
- **Bild-Alt-Texte**: Platzhalter im Hero-Bild, sobald der reale Kontext
  (Marke, Anlass) feststeht

## Design

Aktuell ein reduziertes Basis-Designsystem (dunkel, editorial, an die
Bildsprache der Hero-Aufnahmen angelehnt) in `src/styles/global.css`. Das ist
ein Ausgangspunkt, keine finale Designentscheidung – wird in der
Design-Phase verfeinert.

## Entwicklung

```bash
npm install
npm run dev       # lokaler Dev-Server
npm run build     # Typecheck (astro check) + Produktions-Build
npm run preview   # Produktions-Build lokal ansehen
```
