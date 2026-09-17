import { defineConfig } from "astro/config";
import sitemap from "@astrojs/sitemap";

// TODO: finale Produktions-Domain eintragen, sobald bestätigt.
const site = "https://www.auto-emotion.example";

export default defineConfig({
  site,
  integrations: [sitemap()],
  compressHTML: true,
});
