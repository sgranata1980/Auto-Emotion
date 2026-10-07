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
