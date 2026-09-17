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
├── template-parts/         # Wiederverwendbare Teil-Templates
├── inc/
│   ├── theme-setup.php     # Theme-Support, Menüs, Sidebars
│   ├── enqueue.php         # Styles & Scripts
│   └── customizer.php      # Theme Customizer
└── assets/
    ├── css/main.css
    ├── js/main.js
    └── images/             # Hero-Bilder etc.
```

## Lokale Entwicklung

Theme-Ordner nach `wp-content/themes/auto-emotion` in eine lokale WordPress-Installation verlinken oder kopieren und im Backend aktivieren.

## MCP-Server-Konfiguration

`mcp-config.toml` enthält die Server-Definition für den Refero-MCP-Server, ohne echtes Token (Platzhalter `${REFERO_API_KEY}`).

Für die lokale Nutzung:

1. Umgebungsvariable setzen: `export REFERO_API_KEY="<dein-token>"`, sofern das konsumierende Tool `${...}`-Platzhalter aus der Umgebung auflöst.
2. Alternativ eine Kopie `mcp-config.local.toml` mit dem echten Token anlegen – diese Datei ist in `.gitignore` und wird nie committed.

Der bestehende Token darf nicht mehr als gültig angenommen werden, sobald er einmal im Klartext geteilt wurde – im Zweifel im Refero-Dashboard rotieren.
