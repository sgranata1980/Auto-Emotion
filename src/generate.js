import { mkdir, writeFile } from "node:fs/promises";
import { join } from "node:path";
import { buildPrompt } from "./promptBuilder.js";
import { generateImage } from "./providers/gemini.js";
import { config } from "./config.js";

const [car, emotion, extra] = process.argv.slice(2);

if (!car || !emotion) {
  console.error('Nutzung: npm run generate -- "<Auto>" "<emotion>" ["<zusätzliche Bildregie>"]');
  console.error('Beispiel: npm run generate -- "Cupra Formentor" kraft');
  process.exit(1);
}

const prompt = buildPrompt({ car, emotion, extra });
console.log(`Prompt: ${prompt}`);

const image = await generateImage(prompt);
await mkdir(config.outputDir, { recursive: true });
const filename = join(config.outputDir, `${Date.now()}_${emotion}.png`);
await writeFile(filename, image);
console.log(`Gespeichert: ${filename}`);
