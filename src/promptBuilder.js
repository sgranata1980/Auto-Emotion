import { readFileSync } from "node:fs";
import { fileURLToPath } from "node:url";

const emotions = JSON.parse(
  readFileSync(fileURLToPath(new URL("../prompts/emotions.json", import.meta.url)), "utf-8"),
);

export function buildPrompt({ car, emotion, extra = "" }) {
  const descriptor = emotions[emotion];
  if (!descriptor) {
    throw new Error(`Unbekanntes Emotion-Preset: "${emotion}". Verfügbar: ${Object.keys(emotions).join(", ")}`);
  }
  return `Cinematic hero shot of a ${car}. ${descriptor}. ${extra}`.trim();
}
