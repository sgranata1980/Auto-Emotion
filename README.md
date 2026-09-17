# Auto Emotion

Digitaloffensive für Auto Emotion (Cupra/Seat/Nissan-Vertragspartner, Offenbach) —
Website-Relaunch- und Recruiting-Konzepte, umgesetzt als WordPress-Seiten unter
[autoemotion.stefanogranata.de](https://autoemotion.stefanogranata.de).

Jede Seite ist ein eigenständiges, statisches HTML/CSS/JS-Dokument (dunkles,
monochromes „Ferrari"-Designsystem, Rosso Corsa nur als Hover-Akzent), das per
WordPress-REST-API als Rohinhalt in eine Page gepusht wird — kein Theme-Setup,
kein Page-Builder, kein Plugin-Ballast.

## Struktur

```
site/                    Seitenquellen (jede Datei = eine WordPress-Page)
  start.html                Startseite            /
  businessplan.html         Businessplan          /businessplan/
  recruiting-handbuch.html  Recruiting-Handbuch    /recruiting-handbuch/
  cupra.html                Cupra-Markenseite      /cupra/
  website-relaunch.html     Website & KI-Konzept   /website-relaunch/

scripts/
  deploy.py                 Seite aus site/ nach WordPress pushen
  upload_media.py            Bild in die Media Library hochladen
  _wp_client.py              gemeinsames Credential-Handling (aus .env)
  one-off/                    bereits angewendete, einmalige Setup-Fixes
    fix_template.py            page-no-title-Template: layout "default" statt "constrained"
    fix_footer.py               eigener, schlanker Footer statt Theme-Standard

social-media-recruiting-autohaus.md   Leitfaden Social-Media-Recruiting (Kontext-Dokument)
```

## Setup

```
cp .env.example .env
# WP_USER + WP_APP_PASSWORD eintragen (WordPress-Anwendungspasswort,
# nicht das Account-Passwort — Profil -> Anwendungspasswörter)
```

`.env` ist gitignored. Es darf nie ein echtes Passwort in einer Datei landen,
die committet wird.

## Deploy

```
cd scripts
python3 deploy.py ../site/cupra.html "Cupra bei Auto Emotion" cupra publish 2
```

Argumente: `<datei> <titel> <slug> [status] [page_id]`. `status` ist `draft`
oder `publish` (Standard: `draft`). `page_id` nur angeben, wenn eine
bestehende Page aktualisiert wird (siehe Seiten-Tabelle) — ohne `page_id`
legt der Aufruf eine neue Page an.

| Seite | WordPress Page-ID | Slug |
|---|---|---|
| Startseite | 9 | `start` (Frontpage) |
| Businessplan | 6 | `businessplan` |
| Recruiting-Handbuch | 7 | `recruiting-handbuch` |
| Cupra | 2 | `cupra` |
| Website & KI-Konzept | 41 | `website-relaunch` |

Bilder zuerst optimieren (WebP/JPEG, sinnvolle Auflösung), dann hochladen:

```
python3 upload_media.py ../pfad/zum/bild.jpg zielname.jpg
```

Die zurückgegebene `SOURCE URL` wird direkt im HTML der jeweiligen Seite
referenziert.

## Designsystem

Alle Seiten teilen sich dieselben CSS-Tokens (`--bg`, `--ink`, `--accent` = Rosso
Corsa `#da291c`, 0px Radius außer einzelner Ausnahmen, keine Schatten/Gradients
als Dekoration, Interaktion nur über Hover-Farbwechsel). Neue Seiten sollten
dieselben Tokens und Komponenten (`.subnav`, `.chapter`, `.callout`, `.spec-row` …)
wiederverwenden statt neue Muster einzuführen — siehe `recruiting-handbuch.html`
für den vollständigen Komponentensatz eines Konzeptdokuments.

Die Navigation (`.subnav`) ist auf jeder Seite identisch und muss bei einer
neuen Seite auf **allen** anderen Seiten ergänzt werden.
