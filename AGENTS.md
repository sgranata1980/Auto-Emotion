# AGENTS.md

Konventionen für Agenten (z. B. Claude Code), die in diesem Repo arbeiten.

## Zweck des Repos

`Auto-Emotion` sammelt KI-generierte, emotional aufgeladene Automotive-Visuals
(Hero-Shots, Kampagnenmotive). Es ist ein Asset-Repo, kein Software-Projekt –
es gibt keinen Build, keine Tests, keine Abhängigkeiten.

## Struktur

- `assets/hero-shots/` – fertige Hero-Shot-Bilder, ein Fahrzeug/Motiv pro Datei
- Weitere Kategorien (z. B. `assets/detail-shots/`, `assets/campaigns/`) bei
  Bedarf nach demselben Muster anlegen

## Namenskonvention für Assets

`<marke>-<motiv>-<laufnummer>.<ext>`, z. B. `cupra-hero-01.png`.
Keine Leerzeichen, keine Tool-Namen (z. B. "Nano Banana") oder generischen
Upload-Bezeichnungen ("Kopie") im Dateinamen – die Herkunft/das Tool gehört,
falls relevant, in die Bildmetadaten oder eine begleitende Notiz, nicht in
den Dateinamen.

## Arbeitsweise für Agenten

- Neue Bilder immer in die passende Unterkategorie unter `assets/` einsortieren,
  nicht ins Repo-Root legen.
- Beim Hinzufügen mehrerer Assets in einem Rutsch: konsistente Laufnummern
  vergeben, keine Lücken.
- Große Binärdateien (Bilder) werden direkt versioniert; falls das Repo
  merklich wächst, Git LFS für `assets/**` in Betracht ziehen.
- README.md bei strukturellen Änderungen (neue Ordner, neue Konventionen)
  aktuell halten.
