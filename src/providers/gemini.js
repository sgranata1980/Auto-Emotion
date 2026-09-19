import { readFile } from "node:fs/promises";
import { extname } from "node:path";
import { GoogleGenAI } from "@google/genai";
import { config } from "../config.js";

const MIME_TYPES = { ".png": "image/png", ".jpg": "image/jpeg", ".jpeg": "image/jpeg" };

export async function generateImage(prompt, referenceImagePath) {
  if (!config.geminiApiKey) {
    throw new Error("GEMINI_API_KEY fehlt. Siehe .env.example.");
  }

  const parts = [{ text: prompt }];
  if (referenceImagePath) {
    const mimeType = MIME_TYPES[extname(referenceImagePath).toLowerCase()];
    if (!mimeType) {
      throw new Error(`Nicht unterstütztes Referenzbild-Format: ${referenceImagePath}`);
    }
    const data = await readFile(referenceImagePath);
    parts.push({ inlineData: { mimeType, data: data.toString("base64") } });
  }

  const client = new GoogleGenAI({ apiKey: config.geminiApiKey });
  const response = await client.models.generateContent({
    model: "gemini-2.5-flash-image",
    contents: [{ role: "user", parts }],
  });

  const part = response.candidates[0].content.parts.find((p) => p.inlineData);
  if (!part) {
    throw new Error("Die Antwort enthielt kein Bild.");
  }
  return Buffer.from(part.inlineData.data, "base64");
}
