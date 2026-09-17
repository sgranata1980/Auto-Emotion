# Auto Emotion

Custom WordPress-Theme.

## Struktur

```
.
├── style.css              # Theme-Header (Name, Version, Text-Domain)
├── functions.php          # Bootstrap, lädt inc/
├── header.php / footer.php
├── index.php               # Fallback-Template
├── page.php / single.php / archive.php / search.php / 404.php
├── front-page.php          # Startseite: Hero + Section-Heading + Story-Grid
├── template-parts/         # Wiederverwendbare Teil-Templates (content, hero)
├── inc/
│   ├── theme-setup.php     # Theme-Support, Menüs, Sidebars
│   ├── enqueue.php         # Styles, Fonts & Scripts
│   └── customizer.php      # Theme Customizer
└── assets/
    ├── css/tokens.css      # Design-Tokens (Farben, Typografie, Spacing)
    ├── css/main.css        # Basisstile & Komponenten
    ├── js/main.js
    └── images/             # Hero-Bilder etc.
```

## Design-System

Das visuelle System orientiert sich am Lamborghini.com-Style-Reference: dunkle,
kinoreife Bühnen (`#202020`/`#000`) im Wechsel mit hellen Editorial-Flächen
(`#fff`/`#f5f5f5`), UPPERCASE-Typografie mit einheitlichem Letter-Spacing
(0.023em) und genau einem Farbakzent (`--color-giallo-vivo: #ffc000`) für die
primäre Handlung pro Screen. Keine abgerundeten Ecken, keine Schatten –
Trennung entsteht ausschließlich durch Flächenkontrast.

- Tokens: `assets/css/tokens.css` (Farben, Typo-Skala, Spacing, Radii, Surfaces)
- Komponenten in `assets/css/main.css`: `.hero-stage`, `.btn-giallo`,
  `.btn-ghost`, `.btn-outline`, `.section-heading`, `.story-grid`, `.date-card`
- Schriftart: LamboType ist proprietär und nicht verfügbar – als offener
  Ersatz wird **Barlow Condensed** (Google Fonts) geladen, siehe
  `inc/enqueue.php`.

## Lokale Entwicklung

Theme-Ordner nach `wp-content/themes/auto-emotion` in eine lokale WordPress-Installation verlinken oder kopieren und im Backend aktivieren.

## MCP-Server-Konfiguration

`mcp-config.toml` enthält die Server-Definition für den Refero-MCP-Server, ohne echtes Token (Platzhalter `${REFERO_API_KEY}`).

Für die lokale Nutzung:

1. Umgebungsvariable setzen: `export REFERO_API_KEY="<dein-token>"`, sofern das konsumierende Tool `${...}`-Platzhalter aus der Umgebung auflöst.
2. Alternativ eine Kopie `mcp-config.local.toml` mit dem echten Token anlegen – diese Datei ist in `.gitignore` und wird nie committed.

Der bestehende Token darf nicht mehr als gültig angenommen werden, sobald er einmal im Klartext geteilt wurde – im Zweifel im Refero-Dashboard rotieren.
