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
