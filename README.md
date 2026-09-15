# Auto-Emotion

Statisches Grundgerüst für eine B2B-Website. Kein Build-Tool, kein Framework – reines HTML/CSS/JS.

## Struktur

```
.
├── index.html          # Einstiegsseite (Grundgerüst, Inhalte teils als TODO markiert)
├── assets/
│   ├── css/style.css   # Basis-Styling
│   ├── js/main.js      # Basis-Skript
│   └── images/         # Bildmaterial (u. a. Cupra-Hero-Shots)
└── README.md
```

## Offene Punkte

Folgende Inhalte sind bewusst als Platzhalter markiert und noch nicht befüllt, da die
zugrunde liegenden Fakten (Angebot, Zielgruppe, Standort, Kontaktdaten, konkrete
Referenzen) noch nicht bestätigt sind:

- Meta Title/Description in `index.html`
- Headline und Einleitungstext im Hero
- Leistungsbeschreibung im Abschnitt „Angebot“
- Referenz-/Projektbeschreibung im Abschnitt „Arbeiten“
- Kontaktdaten und Standort
- Alt-Texte der Bilder

## Lokal ansehen

Da es sich um reines HTML/CSS/JS handelt, genügt ein einfacher lokaler Server, z. B.:

```
python3 -m http.server
```

Danach `index.html` im Browser öffnen.
