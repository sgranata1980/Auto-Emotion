# Auto-Emotion

KI-Pipeline zur Erzeugung emotionaler Auto-Bilder (cinematic hero shots) über die Gemini Image Generation ("Nano Banana").

## Struktur

```
assets/references/   Referenzbilder
output/               generierte Bilder (lokal, nicht versioniert)
prompts/emotions.json Emotion-Presets für die Prompt-Erzeugung
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

Viewer starten (zeigt die Referenzbilder in `assets/references`):

```bash
npm run dev
```
