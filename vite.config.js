import { defineConfig } from "vite";

export default defineConfig({
  root: "viewer",
  publicDir: "../assets",
  build: {
    outDir: "../dist",
    emptyOutDir: true,
  },
});
