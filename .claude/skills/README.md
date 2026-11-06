# WordPress Agent Skills (importiert)

Quelle: [github.com/WordPress/agent-skills](https://github.com/WordPress/agent-skills)
(offizielles WordPress/Automattic-Repo, GPL-lizenziert, kompatibel mit der
Theme-Lizenz). Reiner Datei-Kopiervorgang, kein Remote-Code wurde
ausgeführt.

## Enthalten

- `wp-performance/` – Profiling, DB-Queries, Autoload-Optionen, Object
  Cache, Cron, HTTP-API
- `wp-phpstan/` – PHPStan-Setup und WordPress-typisierte Fixes
- `wp-plugin-development/` – Architektur, Hooks, Security, Settings API
  (für Plugins geschrieben, Prinzipien gelten aber auch für Theme-Code)

## Einschränkung in diesem Projekt

`wp-performance` und `wp-phpstan` setzen in ihren SKILL.md-Prozeduren
Werkzeuge voraus, die hier (Stand Oktober 2026) nicht verfügbar sind:

- **wp-performance**: WP-CLI-Shell-Zugriff auf die Live-Installation
  (`wp doctor`, `wp profile --path=...`). Dieses Projekt deployt nur per
  Git-Push über WP Pusher, ohne SSH/CLI-Zugriff auf den Live-Server.
- **wp-phpstan**: Composer-basiertes PHPStan-Setup. Das Theme hat aktuell
  kein `composer.json`.

Die Referenz-Dokumente (`references/*.md`) sind trotzdem als reines
Nachschlagewissen nutzbar (z. B. Query-Optimierung, Autoload-Options,
Object-Cache-Patterns, Security-Praktiken), auch ohne die CLI-gestützten
Prozeduren ausführen zu können. Falls das Projekt später WP-CLI-Zugriff
oder ein Composer/PHPStan-Setup bekommt, funktionieren die vollständigen
Workflows ohne weitere Anpassung.

## Design-/UI-Skills (importiert, Stand Oktober 2026)

Ausgangspunkt: Artikel
[8 Top Skills für Claude Code](https://blog.andreas-stricker.at/8-top-skills-fuer-claude-code-zur-erstellung-von-websites/).
Von den dort genannten 8 Skills war der Großteil für React/Next.js/
Vue/Tailwind geschrieben (UI UX Pro Max, shadcn/ui, Vercel Skills Hub)
und damit für dieses klassische PHP/Vanilla-CSS-Theme nicht einschlägig
– nicht importiert.

Zwei Quellen wurden geprüft, als reiner Markdown-Inhalt kopiert (kein
Skript ausgeführt, kein Binary heruntergeladen) und eingebunden:

- `web-interface-guidelines/` – Quelle:
  [github.com/vercel-labs/web-interface-guidelines](https://github.com/vercel-labs/web-interface-guidelines)
  (Vercel Labs, MIT, 944★). Framework-unabhängige Regeln zu Interaktion,
  Animation, Layout, Content, Formularen, Performance, Design.
- `emil-design-eng/`, `animate/`, `review-animations/`,
  `improve-animations/`, `find-animation-opportunities/`,
  `animation-vocabulary/`, `apple-design/`, `break-ui/`, `mobile-native/`
  – Quelle: [github.com/emilkowalski/skill](https://github.com/emilkowalski/skill)
  (Emil Kowalski, MIT, 44k★; Autor u. a. von Sonner/Vaul, früher
  Vercel/Linear). Nur die framework-unabhängigen Teile übernommen.

**Bewusst NICHT importiert:**

- **Impeccable** (pbakaus/impeccable, 78k★): lädt bei erstem Gebrauch
  einen kompilierten Binary herunter, führt bei jeder Datei-Änderung
  automatisch einen Hook aus und startet einen lokalen Server. Auf
  einer Maschine mit Schreibzugriff aufs Repo und automatischem
  Live-Deploy (WP Pusher) ist "automatisch Binaries nachladen und
  ausführen" ein bewusst vermiedenes Risiko – konsistent mit der
  bereits früher in diesem Projekt getroffenen Entscheidung, keine
  `npx skills add <fremdes-repo>`-Installationen ungeprüft laufen zu
  lassen.
- **wshobson/agents** (interaction-design) und **Dammyjay93/interface-design**:
  aus einem sehr großen, unübersichtlichen Sammel-Repo (146 Skills) bzw.
  explizit auf Dashboards/Admin-Panels/SaaS-Apps zugeschnitten – für
  eine öffentliche Marketing-Website wie Auto Emotion wenig einschlägig,
  und inhaltlich größtenteils durch Emil Kowalskis Animation-Skills
  bereits abgedeckt.
- `animate-expo` (React Native), `write-swift` (natives iOS),
  `ask-sonner` (React-Toast-Library), `pick-ui-library`/`prototype`
  (Komponent-Bibliotheks-Auswahl) aus demselben Repo: nicht einschlägig
  für ein serverseitig gerendertes PHP-Theme ohne Komponenten-Framework.
