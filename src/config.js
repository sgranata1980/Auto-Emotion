import "dotenv/config";
import { fileURLToPath } from "node:url";

export const config = {
  geminiApiKey: process.env.GEMINI_API_KEY,
  outputDir: fileURLToPath(new URL("../output/", import.meta.url)),
};
