import { readdir, writeFile } from "node:fs/promises";
import { fileURLToPath } from "node:url";

const referencesDir = fileURLToPath(new URL("../assets/references/", import.meta.url));
const manifestPath = fileURLToPath(new URL("../assets/manifest.json", import.meta.url));

const files = (await readdir(referencesDir)).filter((f) => /\.(png|jpe?g)$/i.test(f));
await writeFile(manifestPath, JSON.stringify(files, null, 2));
console.log(`Manifest geschrieben: ${files.length} Bild(er)`);
