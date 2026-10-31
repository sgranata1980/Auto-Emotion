<?php
/**
 * Automatisierung & KI: ehrliche Statusübersicht der Recruiting-
 * Funktionen, die auf dem Markt unter Begriffen wie "Hiring
 * Automation" oder "Recruiter AI" beworben werden (Multiposting,
 * Social-Recruiting, automatisierter Erstkontakt, WhatsApp, KI-
 * Telefoninterviews, Match-Scores, Terminierung). Zeigt pro Punkt, was
 * bei Auto Emotion bereits läuft, was manuell/teilweise geht und was
 * echte, bisher fehlende Voraussetzungen bräuchte (API-Zugänge,
 * Portal-Partnerschaften, eine bewusste Entscheidung für einen
 * LLM-Anbieter). Bewusst keine erfundenen "Live"-Status für Dinge, die
 * es nicht gibt – nur Platzhalter mit echter Erklärung.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_automatisierung_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/automatisierung/?$', 'index.php?ae_staff_route=automatisierung', 'top' );
}
add_action( 'init', 'auto_emotion_automatisierung_rewrite_rules' );

function auto_emotion_maybe_flush_automatisierung_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_automatisierung_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_automatisierung_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_automatisierung_rewrite_rules', 20 );

/**
 * Die eigentliche Funktionsliste. 'status' ist eine von 'live',
 * 'teilweise', 'geplant'. 'link' ist optional (home_url()-Pfad).
 */
function auto_emotion_automatisierung_funktionen() {
	return array(
		array(
			'titel'       => __( 'Stellenanzeigen erstellen & ausspielen', 'auto-emotion' ),
			'icon'        => 'anzeige',
			'status'      => 'live',
			'beschreibung' => __( 'Suchprofil anlegen – daraus wird automatisch ein fertiger Anzeigentext fürs Portal sowie eine Social-Media-Caption generiert.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/recruiting/',
			'link_label'  => __( 'Zu den Suchprofilen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Multiposting auf Jobportalen', 'auto-emotion' ),
			'icon'        => 'multiposting',
			'status'      => 'teilweise',
			'beschreibung' => __( 'Vorausgefüllte Direktlinks zu Indeed, StepStone, der Arbeitsagentur, LinkedIn und Xing je Position. Echtes automatisches Multiposting (ein Klick, alle Portale gleichzeitig) bräuchte kostenpflichtige API-Partnerschaften mit jedem einzelnen Portal – die gibt es hier nicht.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/recruiting/',
			'link_label'  => __( 'Position wählen → Anzeige & Links', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Social-Recruiting-Kampagnen', 'auto-emotion' ),
			'icon'        => 'social',
			'status'      => 'teilweise',
			'beschreibung' => __( 'Fertige Social-Caption je Stellenanzeige zum Kopieren. Automatisches Posten/Kampagnen-Steuerung auf Instagram, TikTok & Co. bräuchte eigene Business-API-Zugänge je Plattform.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/recruiting/',
			'link_label'  => __( 'Position wählen → Social-Text', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Bewerber-Funnel & Bewerbermanagement', 'auto-emotion' ),
			'icon'        => 'funnel',
			'status'      => 'live',
			'beschreibung' => __( 'Status-Pipeline (Neu → Eingestellt/Abgesagt), Kanban-Board, Filter, Bewertung und interne Notizen je Bewerbung.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/',
			'link_label'  => __( 'Zu den Bewerbungen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Automatisierter Erstkontakt', 'auto-emotion' ),
			'icon'        => 'erstkontakt',
			'status'      => 'live',
			'beschreibung' => __( 'Bewerber:innen erhalten sofort nach dem Absenden des Formulars automatisch eine Eingangsbestätigung per E-Mail (sofern eine E-Mail-Adresse angegeben wurde).', 'auto-emotion' ),
			'link'        => '',
			'link_label'  => '',
		),
		array(
			'titel'       => __( 'WhatsApp-Kommunikation', 'auto-emotion' ),
			'icon'        => 'whatsapp',
			'status'      => 'geplant',
			'beschreibung' => __( 'Bräuchte einen eigenen WhatsApp-Business-API- oder Twilio-Zugang – den gibt es hier noch nicht. Als Zwischenlösung läuft die interne Team-Benachrichtigung bereits per E-Mail (siehe "Nachrichten").', 'auto-emotion' ),
			'link'        => '/mitarbeiter/nachrichten/',
			'link_label'  => __( 'Zur E-Mail-Zwischenlösung', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'KI-Telefoninterviews', 'auto-emotion' ),
			'icon'        => 'telefon',
			'status'      => 'geplant',
			'beschreibung' => __( 'Bräuchte eine Telefonie-/Voice-KI-Anbindung (z. B. Twilio plus Sprachmodell) – bisher nicht angebunden und mit laufenden Kosten pro Anruf verbunden. Noch keine Entscheidung dafür getroffen.', 'auto-emotion' ),
			'link'        => '',
			'link_label'  => '',
		),
		array(
			'titel'       => __( 'Vorqualifizierung & Match-Scores', 'auto-emotion' ),
			'icon'        => 'ki',
			'status'      => auto_emotion_anthropic_configured() ? 'live' : 'teilweise',
			'beschreibung' => auto_emotion_anthropic_configured()
				? __( 'Bei jeder Bewerbung per Klick abrufbar: KI vergleicht den Bewerbungstext mit dem Anforderungsprofil der Position und gibt eine begründete Einschätzung inkl. Prozentwert, Stärken, möglichen Lücken und Empfehlung – nur auf Basis des echten Textes, keine erfundenen Werte.', 'auto-emotion' )
				: __( 'Fertig programmiert, aber noch kein Anthropic-API-Key hinterlegt – Setup-Anleitung direkt bei jeder Bewerbung sichtbar. Berücksichtigt nur den Bewerbungstext, nicht hochgeladene Dateien.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/',
			'link_label'  => __( 'Zu den Bewerbungen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Terminierung', 'auto-emotion' ),
			'icon'        => 'termin',
			'status'      => 'teilweise',
			'beschreibung' => __( 'Fertige E-Mail-Vorlage "Einladung zum Vorstellungsgespräch" mit Terminvorschlag-Platzhaltern bei jeder Bewerbung, Termin mit automatischer Erinnerungs-Mail am Vortag. Ein eigenes Kalender-/Terminbuchungssystem (automatische Terminfindung mit dem Bewerber) gibt es noch nicht.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/',
			'link_label'  => __( 'Zu den Bewerbungen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Herkunfts-Auswertung', 'auto-emotion' ),
			'icon'        => 'herkunft',
			'status'      => 'live',
			'beschreibung' => __( 'Erkennt beim Formular-Aufruf automatisch aus dem Referrer, ob eine Bewerbung z. B. über Indeed, Google, StepStone oder direkt kam – ohne zusätzliches Formularfeld. Verteilung im Dashboard sichtbar.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/uebersicht/',
			'link_label'  => __( 'Zum Dashboard', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Dubletten-Erkennung', 'auto-emotion' ),
			'icon'        => 'dubletten',
			'status'      => 'live',
			'beschreibung' => __( 'Neue Bewerbungen werden automatisch mit bestehenden auf übereinstimmende E-Mail oder Telefonnummer geprüft und als mögliche Dublette markiert – zur manuellen Prüfung, nie automatisch zusammengeführt.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/',
			'link_label'  => __( 'Zu den Bewerbungen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Talent-Pool', 'auto-emotion' ),
			'icon'        => 'talentpool',
			'status'      => 'live',
			'beschreibung' => __( 'Bewerbungen lassen sich unabhängig vom Pipeline-Status (auch nach einer Absage) mit Zweck und optionaler Frist für später vormerken – eigener Filter in der Bewerbungsliste.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/?talentpool=1',
			'link_label'  => __( 'Zum Talent-Pool', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'DSGVO-Löschprozess', 'auto-emotion' ),
			'icon'        => 'dsgvo',
			'status'      => 'live',
			'beschreibung' => __( 'Eigener, von der reversiblen Papierkorb-Funktion getrennter Vorgang für den Fall eines ausdrücklichen Löschwunschs: löscht Bewerbung und Unterlagen sofort und unwiderruflich, protokolliert Datum und Bearbeiter – ohne personenbezogene Daten im Protokoll.', 'auto-emotion' ),
			'link'        => '',
			'link_label'  => '',
		),
	);
}

function auto_emotion_automatisierung_status_labels() {
	return array(
		'live'      => __( 'Live', 'auto-emotion' ),
		'teilweise' => __( 'Teilweise', 'auto-emotion' ),
		'geplant'   => __( 'Geplant', 'auto-emotion' ),
	);
}

function auto_emotion_automatisierung_template_redirect() {
	if ( 'automatisierung' !== get_query_var( 'ae_staff_route' ) ) {
		return;
	}

	auto_emotion_staff_require_login();

	auto_emotion_render_template_part(
		'automatisierung.php',
		array(
			'auto_emotion_funktionen'      => auto_emotion_automatisierung_funktionen(),
			'auto_emotion_status_labels'   => auto_emotion_automatisierung_status_labels(),
			'auto_emotion_dsgvo_log'       => function_exists( 'auto_emotion_dsgvo_loeschlog' ) ? array_reverse( auto_emotion_dsgvo_loeschlog() ) : array(),
		)
	);
	exit;
}
add_action( 'template_redirect', 'auto_emotion_automatisierung_template_redirect' );
