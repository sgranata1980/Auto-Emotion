import { GoogleGenAI } from "@google/genai";
import { config } from "../config.js";

export async function generateImage(prompt) {
  if (!config.geminiApiKey) {
    throw new Error("GEMINI_API_KEY fehlt. Siehe .env.example.");
  }

  const client = new GoogleGenAI({ apiKey: config.geminiApiKey });
  const response = await client.models.generateContent({
    model: "gemini-2.5-flash-image",
    contents: prompt,
  });

  const part = response.candidates[0].content.parts.find((p) => p.inlineData);
  if (!part) {
    throw new Error("Die Antwort enthielt kein Bild.");
  }
  return Buffer.from(part.inlineData.data, "base64");
}
