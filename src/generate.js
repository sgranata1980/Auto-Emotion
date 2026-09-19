import { mkdir, writeFile } from "node:fs/promises";
import { readFileSync } from "node:fs";
import { join } from "node:path";
import { fileURLToPath } from "node:url";
import { buildPrompt } from "./promptBuilder.js";
import { generateImage } from "./providers/gemini.js";
import { config } from "./config.js";

const args = process.argv.slice(2);
const detailIndex = args.indexOf("--detail");

function usage() {
  console.error('Nutzung:');
  console.error('  npm run generate -- "<Auto>" "<emotion>" ["<zusätzliche Bildregie>"]');
  console.error("  npm run generate -- --detail <preset> --reference <Pfad zum Referenzbild>");
}

let prompt;
let referencePath;
let label;

if (detailIndex !== -1) {
  const key = args[detailIndex + 1];
  const referenceIndex = args.indexOf("--reference");
  referencePath = referenceIndex !== -1 ? args[referenceIndex + 1] : undefined;

  const detailsPath = fileURLToPath(new URL("../prompts/details.json", import.meta.url));
  const details = JSON.parse(readFileSync(detailsPath, "utf-8"));
  prompt = details[key];
  if (!prompt) {
    console.error(`Unbekanntes Detail-Preset: "${key}". Verfügbar: ${Object.keys(details).join(", ")}`);
    process.exit(1);
  }
  label = key;
} else {
  const [car, emotion, extra] = args;
  if (!car || !emotion) {
    usage();
    process.exit(1);
  }
  prompt = buildPrompt({ car, emotion, extra });
  label = emotion;
}

console.log(`Prompt: ${prompt}`);

const image = await generateImage(prompt, referencePath);
await mkdir(config.outputDir, { recursive: true });
const filename = join(config.outputDir, `${Date.now()}_${label}.png`);
await writeFile(filename, image);
console.log(`Gespeichert: ${filename}`);
