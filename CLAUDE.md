# Projektregeln für Auto Emotion

## Fahrzeuge in generierten Bildern

Wenn Fahrzeuge für diese Website generiert werden (Fotos, Prompts für
Bildgeneratoren, Illustrationen), immer eine der drei echten Marken
verwenden, die Auto Emotion tatsächlich verkauft: **Seat, Cupra oder
Nissan**. Keine generischen oder anderen Marken-Fahrzeuge.

## Kennzeichen auf generierten Fahrzeugbildern

Das Nummernschild des Fahrzeugs muss immer **„AUTOEMOTION"** zeigen (sauber
lesbar, wie ein reguläres Kennzeichen gestaltet), keine erfundene
Zulassungsnummer. Kein verwaschener/unleserlicher EU-Sternenkreis oder
sonstiger Schriftmatsch auf dem Schild – sauberes, cleanes Design.

## Bearbeitung echter Standort-/Showroom-Fotos

Wenn echte Fotos vom Auto Emotion Standort (Werkstatt, Showroom, Fassade
etc.) für die Website aufbereitet werden, immer mit Artlist (Bild-zu-Bild)
nachbearbeiten – Ziel ist ein heller, cleaner „Apple-Campus"-Look:

- **Boden komplett sauber**: alle Flecken, Verfärbungen und Gebrauchsspuren
  entfernen, gleichmäßige Bodenfarbe im gesamten Bild.
- **Geometrie korrigieren**: Horizontlinien/Dachkanten exakt horizontal,
  senkrechte Elemente (Säulen, Hebebühnen, Türrahmen) exakt vertikal
  ausrichten – Weitwinkel-Verzerrung rausrechnen.
- **Belichtung – immer viel Tageslicht-Helligkeit reinbringen**: deutlich
  heller als das Originalfoto, so als stünden alle Türen/Tore offen und
  die Sonne würde reinscheinen. Gleichmäßig ausgeleuchtet, keine harten
  Schatten oder dunklen Ecken, neutral-helle Farbgebung statt warmstichig.
  Das Bild muss auf den ersten Blick ganz klar und licht wirken, nicht nur
  leicht aufgehellt.
- **Mülleimer/Papierkörbe entfernen**: sichtbare Mülleimer, Papierkörbe
  und ähnlicher Wegwerf-Krimskrams gehören nicht ins Bild und werden
  wegretuschiert.
- **Fahrzeuge dürfen nicht zu dunkel wirken**: besonders schwarze/dunkle
  Autos schlucken Licht und sehen dann trotz insgesamt hellem Bild
  unterbelichtet aus. Gezielt aufhellen (Schatten/Tiefen anheben), bis
  Lack, Konturen und Details der Fahrzeuge klar erkennbar sind – nicht
  nur Boden und Wände hell, auch die Autos selbst.
- **Texte/Beschriftungen im Hintergrund (auch durch Fenster/Scheiben
  sichtbar) niemals verändern**: KI-Bildkorrektur neigt dazu, kleine
  Schilder, Fensterbeschriftungen oder Werbeaufsteller im Hintergrund in
  bedeutungslosen Buchstabensalat zu verwandeln. Das zählt als
  Regelverstoß, auch wenn der Text im Original schon unscharf/klein war.
  Vor jeder Freigabe gezielt auf Hintergrundtext prüfen (nicht nur auf
  den offensichtlichen Haupttext im Bildzentrum). Bei Bildern mit viel
  Text im Hintergrund (Wandbeschriftungen, Bildschirme, Poster,
  Schaufenster-Aufkleber) lieber die nicht-generative Korrektur
  (Geometrie/Belichtung ohne Neuzeichnen) verwenden statt der
  KI-Bild-zu-Bild-Korrektur, da diese Text zuverlässiger unangetastet
  lässt.
- Ansonsten **niemals reale Objekte, Personen, Fahrzeuge, Beschriftungen/
  Texte oder das Layout des Raums verändern** – nur Geometrie,
  Bodenreinigung, Mülleimer-Entfernung und Belichtung, das Foto muss
  ein echtes, unverfälschtes Abbild des Orts bleiben.

Bei Bedarf mehrere Korrektur-Durchgänge (z. B. erst Geometrie/Belichtung,
dann gezielt nur noch den Boden nachschärfen), bis das Ergebnis diesem
Standard entspricht, bevor es auf der Seite verwendet wird. Nach jedem
Durchgang das Ergebnis in voller Auflösung prüfen – speziell Fahrzeuglack
auf Dunkelheit und jeden sichtbaren Hintergrundtext auf Lesbarkeit/
Unverändertheit.

## Prompt-Vorlage: Cinematic-Showroom-Set (Bilder + Werbespot)

Bewährte, funktionierende Prompt-Vorlage für ein Referenzbilder-Set aus
mehreren Perspektiven plus daraus geschnittenen Werbespot für ein
Fahrzeug (Seat, Cupra oder Nissan). Erstmals eingesetzt für den CUPRA-
Hero-Spot der Startseite (Oktober 2026) – bei Bedarf für andere Modelle/
Marken wiederverwenden, einfach `[Marke/Modell]` ersetzen und das
Ausgangsbild austauschen.

**Werkzeuge**: Artlist MCP. Bildwinkel per `generate_image` mit Modell
„GPT Image 2.5 Flare Edit High 2K" (modelId 3390, Bild-zu-Bild aus einem
echten Pressefoto als `input: { assetId }`), Settings
`{"aspect_ratio": "16:9", "resolution": "high", "output_resolution": "2K"}`.
Spot per `generate_video` mit Modell „Seedance 2.5 – R2V – Image – 1080p"
(modelId 3108, Multi-Referenz aus den vier generierten Bildern via
`input: [{generationId}, ...]`), Settings `{"duration": "12", "resolution":
"1080p", "aspect_ratio": "16:9", "generate_audio": true}`. Seedance 2.5 in
1080p ist teuer (bei 4 Referenzbildern ca. 12.000 Credits für 12 Sekunden) –
Kosten vor dem Start mit `get_generation_cost` prüfen und beim Nutzer
freigeben lassen, güns­tigere Alternativen (720p/480p-Entwurf) anbieten.

**Szenen-Grundlage** (für alle vier Bildwinkel identisch, nur die
Kamera-Anweisung ändert sich):

> Using the exact same [Marke/Modell] car from the reference image —
> identical color, wheels, badges, trim — and the same dark cinematic
> underground location with stone arches and the same dramatic lighting
> style, generate a new shot from a [KAMERAWINKEL]. Keep the car's
> design, color and wheels exactly identical to the reference.

Vier Kamerawinkel, jeweils mit Kennzeichen-Anweisung wo ein Schild
sichtbar ist (siehe „Kennzeichen auf generierten Fahrzeugbildern" oben):

1. **Front 3/4 (Hero)** – meist nur ein minimaler Edit des
   Ausgangsbilds nötig (Kennzeichen korrigieren, sonst nichts ändern):
   „Keep this exact car and scene completely unchanged — same color,
   wheels, lighting, dark underground stone-arches background, same
   camera framing and angle. The ONLY change: replace the text on the
   front license plate with 'AUTOEMOTION' in clean, sharp, legible black
   lettering on a white plate, with a simple clean blue EU strip (no
   blurry stars or letter mess), standard European plate proportions."
2. **Seite** – „a full side-profile view: camera perpendicular to the
   car, car facing left, entire car visible in profile." Kein Kennzeichen
   in dieser Einstellung sichtbar.
3. **Heck 3/4** – „a rear three-quarter angle, showing the back of the
   car and taillights clearly." Plus Kennzeichen-Anweisung (Heckschild
   „AUTOEMOTION").
4. **Front gerade** – „a straight-on front view: camera directly in
   front of the car, symmetrical framing." Plus Kennzeichen-Anweisung.

**Werbespot-Prompt** (alle vier Bilder als Multi-Referenz):

> Premium automotive commercial for a [Marke/Modell] car, dark moody
> cinematic underground location with stone arches and wet reflective
> floor, dramatic rim lighting and amber light strips along the walls.
> Dynamic sequence: start with a slow establishing push-in on the car's
> front three-quarter hero angle, smooth camera orbit around to the full
> side profile revealing the silhouette and wheel design, cut to a rear
> three-quarter reveal as the taillights ignite in sequence, finish on a
> slow symmetrical push-in on the straight front view with the grille
> and badge in focus. Smooth, elegant, high-end car-commercial camera
> movement throughout — no fast cuts, no shaky motion, no text overlays,
> no logos added. Keep the car's color, wheels, trim and design
> completely consistent across the whole sequence, exactly as in the
> reference images. Subtle ambient cinematic score, low engine hum, no
> voiceover.

**Nach der Generierung, vor dem Einbinden als Website-Video** immer:

- Mit `ffmpeg` zu H.264 (`-c:v libx264 -pix_fmt yuv420p -crf 20 -preset
  slow -movflags +faststart`) transkodieren – das von Seedance gelieferte
  HEVC/H.265 spielt in vielen Browsern/Testumgebungen nicht zuverlässig.
  Für einen stummen Hintergrund-Loop die Audiospur mit `-an` entfernen.
- Zusätzlich eine WebM/VP9-Variante erzeugen (`-c:v libvpx-vp9 -crf 32
  -b:v 0`) und im `<video>`-Tag als erste `<source>` vor dem MP4 anbieten
  (kleinere Datei für Browser mit VP9-Unterstützung, MP4 bleibt
  Fallback).
- Alle Winkel und Frames in voller Auflösung sichtprüfen: Marke korrekt
  (kein fremdes Logo), Kennzeichen auf jedem sichtbaren Schild lesbar
  „AUTOEMOTION", Wagen über alle Einstellungen hinweg identisch (Farbe,
  Felgen, Details).
