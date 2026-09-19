# Auto-Emotion

KI-Pipeline zur Erzeugung emotionaler Auto-Bilder (cinematic hero shots) über die Gemini Image Generation ("Nano Banana").

## Struktur

```
assets/references/   Referenzbilder
output/               generierte Bilder (lokal, nicht versioniert)
prompts/emotions.json Emotion-Presets für die Prompt-Erzeugung
prompts/details.json  Detail-Shot-Presets (Bild-zu-Bild mit Referenzbild)
src/                  Generierungs-Pipeline (Node)
viewer/               Vite-App zum Durchsehen der Referenzbilder
scripts/              Hilfsskripte (Manifest-Erzeugung)
```

## Setup

```bash
npm install
cp .env.example .env   # GEMINI_API_KEY eintragen
```

## Nutzung

Bild generieren:

```bash
npm run generate -- "Cupra Formentor" kraft
```

Verfügbare Emotion-Presets stehen in `prompts/emotions.json`.

Detail-Shot mit Referenzbild generieren (Bild-zu-Bild):

```bash
npm run generate -- --detail cupra-born-light-detail --reference assets/references/<Datei>
```

Verfügbare Detail-Presets stehen in `prompts/details.json`.

Viewer starten (zeigt die Referenzbilder in `assets/references`):

```bash
npm run dev
```
