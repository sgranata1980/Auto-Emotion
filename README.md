# Auto Emotion

Custom WordPress-Theme für **Auto Emotion GmbH & Co. KG**, Autohaus für
Cupra, Seat und Nissan in Offenbach.

## Struktur

```
.
├── style.css                  # Theme-Header (Name, Version, Text-Domain)
├── functions.php              # Bootstrap, lädt inc/
├── header.php / footer.php
├── index.php                  # Fallback-Template (Blog/News-Liste)
├── page.php / single.php / archive.php / search.php / 404.php
├── front-page.php             # Startseite: Hero, Marken, Angebote, News, Service
├── page-kontakt.php           # Kontaktseite (Template: „Kontakt“)
├── page-impressum.php         # Impressum (Template: „Impressum“)
├── page-datenschutz.php       # Datenschutzerklärung (Template: „Datenschutz“)
├── archive-angebot.php        # Übersicht aller Angebote
├── single-angebot.php         # Einzelnes Angebot
├── taxonomy-marke.php         # Marken-Archiv (Cupra/Seat/Nissan)
├── template-parts/            # content.php, hero.php
├── inc/
│   ├── contact-info.php       # Zentrale Geschäftsdaten (echte Werte, s. u.)
│   ├── theme-setup.php        # Theme-Support, Menüs, Sidebars
│   ├── enqueue.php            # Styles, Fonts & Scripts
│   ├── customizer.php         # Theme Customizer (inkl. Kontaktdaten-Sektion)
│   ├── cpt.php                # Post Type „Angebot“ + Taxonomie „Marke“
│   ├── seo.php                # Meta Description, Open Graph, Canonical
│   └── schema.php             # JSON-LD (AutoDealer, WebSite)
└── assets/
    ├── css/tokens.css         # Design-Tokens (Farben, Typografie, Spacing)
    ├── css/main.css           # Basisstile & Komponenten
    ├── js/main.js             # Nav-/Such-Toggle
    └── images/                # Hero-Bilder
```

## Geschäftsdaten – Quelle & Status

Alle in `inc/contact-info.php` hinterlegten Angaben (Adresse, Telefon,
Öffnungszeiten, Handelsregister, USt-ID, Vertretungsberechtigte) stammen aus
den öffentlich auf **auto-emotion.de** veröffentlichten Seiten (Start,
Impressum, Datenschutz), abgerufen am 2026-09-17. Es wurde nichts erfunden.

Alle Werte sind zusätzlich im WP-Admin unter **Design → Customizer →
Kontaktdaten** editierbar, ohne Code anzufassen.

**Offene Punkte, die NICHT automatisch übernommen wurden** (bewusst, um
nichts zu erfinden):

- **Datenschutzerklärung** (`page-datenschutz.php`): Nur der Verantwortliche
  ist ausgefüllt. Die eigentlichen Rechtstexte (Cookies, eingesetzte Dienste,
  Rechtsgrundlagen) hängen von der finalen technischen Umsetzung ab und
  müssen vor Livegang mit einer datenschutzkundigen Person ergänzt werden.
- **Impressum** (`page-impressum.php`): Haftungsausschluss ist als
  Platzhalter markiert und sollte juristisch geprüft werden.
- **Fahrzeugbestand**: Die echte Website verlinkt auf Marken-Portale
  (Cupra/Seat/Nissan) statt ein eigenes Inventar zu führen. Dieses Theme
  bildet stattdessen einen einfachen Post Type **„Angebot“** ab (für
  redaktionell gepflegte Leasing-/Aktionsangebote wie „ab 59,– € mtl.“) –
  keine Live-Anbindung an mobile.de o. ä. Falls ein echtes Bestands-Widget
  gewünscht ist, sollte das über ein dediziertes DSGVO-konformes Plugin
  erfolgen (Theme liefert dafür bereits die passenden CSS-Komponenten:
  `.product-tile`, `.story-grid`).

## WP-Admin-Setup nach Theme-Aktivierung

1. **Seiten anlegen** mit Slug/Template:
   - `kontakt` → Template „Kontakt“
   - `impressum` → Template „Impressum“
   - `datenschutz` → Template „Datenschutz“
2. **Menüs** (Design → Menüs) erstellen und den Positionen „Hauptmenü“ und
   „Footer-Menü“ zuweisen. Empfohlene Hauptpunkte entsprechend der echten IA:
   Marken (Cupra/Seat/Nissan), Service, Unternehmen, News, Kontakt.
3. **Tagline** (Einstellungen → Allgemein) setzen, falls gewünscht – wird
   aktuell nicht mehr für den Hero verwendet (siehe unten), fließt aber in
   die Meta-Description ein, falls kein Beitragsauszug vorhanden ist.
4. Bei Theme-Aktivierung werden die drei Marken-Begriffe **Cupra, Seat,
   Nissan** automatisch als Taxonomie-Terms angelegt (`inc/cpt.php`).

## Design-System

Das visuelle System folgt dem Lamborghini.com-Style-Reference: dunkle,
kinoreife Bühnen (`#202020`/`#000`) im Wechsel mit hellen Editorial-Flächen
(`#fff`/`#f5f5f5`), UPPERCASE-Typografie mit einheitlichem Letter-Spacing
(0.023em) und genau einem Farbakzent (`--color-giallo-vivo: #ffc000`) für die
primäre Handlung pro Screen. Keine abgerundeten Ecken, keine Schatten –
Trennung entsteht ausschließlich durch Flächenkontrast.

- Tokens: `assets/css/tokens.css` (Farben, Typo-Skala, Spacing, Radii, Surfaces)
- Komponenten in `assets/css/main.css`: `.hero-stage`, `.btn-giallo`,
  `.btn-ghost`, `.btn-outline`, `.section-heading`, `.story-grid`,
  `.date-card`, `.brand-tile`, `.event-banner`, `.contact-grid`

### Schriftart

Die reale Lamborghini.com-Site nutzt **Interstate** (Font Bureau, via
Webtype) – eine kommerziell lizenzierte Schrift, siehe
[fontsinuse.com/uses/1996](https://fontsinuse.com/uses/1996/lamborghini-com-website).
Ohne Lizenz wird stattdessen **Barlow Condensed** (Google Fonts) geladen –
das ist auch der im ursprünglichen Style-Reference-Dokument selbst genannte
offene Ersatz („closest open equivalent for the tall industrial feel“).

### Bekannte Abweichung vom Referenzdokument: Kontrast

Die Referenz spezifiziert weißen Text auf dem Giallo-Button (`#ffc000`).
Das ergibt nur ~1.6:1 Kontrast (WCAG AA verlangt 4.5:1) und ist damit für
viele Nutzer nicht lesbar. `.btn-giallo` verwendet deshalb **schwarzen**
Text (Kontrast ~12.8:1) – Accessibility hat hier Vorrang vor der wörtlichen
Farbangabe. Die Datumsstempel (`#7d7d7d` auf Weiß, ~4.1:1) liegen knapp
unter AA für Fließtext; das ist im Referenzdokument so vorgegeben und für
sekundäre Metadaten (nicht der Haupttext) ein vertretbarer, aber bekannter
Kompromiss – bei Bedarf auf `--color-anvil` (#313131) umstellen.

## SEO & Structured Data

- `inc/seo.php`: Meta Description (aus Excerpt/Term-Description/Tagline),
  Open Graph, Twitter Card, Canonical, Preconnect für Google Fonts.
- `inc/schema.php`: JSON-LD `AutoDealer` (echte Adresse, Telefon,
  Öffnungszeiten Verkauf, Marken Cupra/Seat/Nissan, Social-Profile) auf
  jeder Seite, zusätzlich `WebSite` auf der Startseite.
- Kein SEO-Plugin vorausgesetzt. Falls später Yoast/Rank Math ergänzt wird:
  die `wp_head`-Hooks in `inc/seo.php` deaktivieren, um doppelte Tags zu
  vermeiden.

## Accessibility

Skip-Link („Zum Inhalt springen“), sichtbare Fokus-Zustände
(`:focus-visible`), `prefers-reduced-motion`-Unterstützung, semantisches
HTML (`header`/`nav`/`main`/`footer`), `aria-current` auf aktiven
Menüpunkten (WP-Core-Standard).

## Lokale Entwicklung

Theme-Ordner nach `wp-content/themes/auto-emotion` in eine lokale
WordPress-Installation verlinken oder kopieren und im Backend aktivieren.

## MCP-Server-Konfiguration

`mcp-config.toml` enthält die Server-Definition für den Refero-MCP-Server, ohne echtes Token (Platzhalter `${REFERO_API_KEY}`).

Für die lokale Nutzung:

1. Umgebungsvariable setzen: `export REFERO_API_KEY="<dein-token>"`, sofern das konsumierende Tool `${...}`-Platzhalter aus der Umgebung auflöst.
2. Alternativ eine Kopie `mcp-config.local.toml` mit dem echten Token anlegen – diese Datei ist in `.gitignore` und wird nie committed.

Der bestehende Token darf nicht mehr als gültig angenommen werden, sobald er einmal im Klartext geteilt wurde – im Zweifel im Refero-Dashboard rotieren.
