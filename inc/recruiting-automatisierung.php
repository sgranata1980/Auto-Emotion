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
			'status'      => 'live',
			'beschreibung' => __( 'Suchprofil anlegen – daraus wird automatisch ein fertiger Anzeigentext fürs Portal sowie eine Social-Media-Caption generiert.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/recruiting/',
			'link_label'  => __( 'Zu den Suchprofilen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Multiposting auf Jobportalen', 'auto-emotion' ),
			'status'      => 'teilweise',
			'beschreibung' => __( 'Vorausgefüllte Direktlinks zu Indeed, StepStone, der Arbeitsagentur, LinkedIn und Xing je Position. Echtes automatisches Multiposting (ein Klick, alle Portale gleichzeitig) bräuchte kostenpflichtige API-Partnerschaften mit jedem einzelnen Portal – die gibt es hier nicht.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/recruiting/',
			'link_label'  => __( 'Position wählen → Anzeige & Links', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Social-Recruiting-Kampagnen', 'auto-emotion' ),
			'status'      => 'teilweise',
			'beschreibung' => __( 'Fertige Social-Caption je Stellenanzeige zum Kopieren. Automatisches Posten/Kampagnen-Steuerung auf Instagram, TikTok & Co. bräuchte eigene Business-API-Zugänge je Plattform.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/recruiting/',
			'link_label'  => __( 'Position wählen → Social-Text', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Bewerber-Funnel & Bewerbermanagement', 'auto-emotion' ),
			'status'      => 'live',
			'beschreibung' => __( 'Status-Pipeline (Neu → Eingestellt/Abgesagt), Kanban-Board, Filter, Bewertung und interne Notizen je Bewerbung.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/',
			'link_label'  => __( 'Zu den Bewerbungen', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'Automatisierter Erstkontakt', 'auto-emotion' ),
			'status'      => 'live',
			'beschreibung' => __( 'Bewerber:innen erhalten sofort nach dem Absenden des Formulars automatisch eine Eingangsbestätigung per E-Mail (sofern eine E-Mail-Adresse angegeben wurde).', 'auto-emotion' ),
			'link'        => '',
			'link_label'  => '',
		),
		array(
			'titel'       => __( 'WhatsApp-Kommunikation', 'auto-emotion' ),
			'status'      => 'geplant',
			'beschreibung' => __( 'Bräuchte einen eigenen WhatsApp-Business-API- oder Twilio-Zugang – den gibt es hier noch nicht. Als Zwischenlösung läuft die interne Team-Benachrichtigung bereits per E-Mail (siehe "Nachrichten").', 'auto-emotion' ),
			'link'        => '/mitarbeiter/nachrichten/',
			'link_label'  => __( 'Zur E-Mail-Zwischenlösung', 'auto-emotion' ),
		),
		array(
			'titel'       => __( 'KI-Telefoninterviews', 'auto-emotion' ),
			'status'      => 'geplant',
			'beschreibung' => __( 'Bräuchte eine Telefonie-/Voice-KI-Anbindung (z. B. Twilio plus Sprachmodell) – bisher nicht angebunden und mit laufenden Kosten pro Anruf verbunden. Noch keine Entscheidung dafür getroffen.', 'auto-emotion' ),
			'link'        => '',
			'link_label'  => '',
		),
		array(
			'titel'       => __( 'Vorqualifizierung & Match-Scores', 'auto-emotion' ),
			'status'      => 'geplant',
			'beschreibung' => __( 'Bräuchte eine bewusste Entscheidung für einen KI-/LLM-Anbieter samt Kosten. Es werden hier keine erfundenen "Match-Werte" ohne echte Grundlage angezeigt.', 'auto-emotion' ),
			'link'        => '',
			'link_label'  => '',
		),
		array(
			'titel'       => __( 'Terminierung', 'auto-emotion' ),
			'status'      => 'teilweise',
			'beschreibung' => __( 'Fertige E-Mail-Vorlage "Einladung zum Vorstellungsgespräch" mit Terminvorschlag-Platzhaltern bei jeder Bewerbung. Ein eigenes Kalender-/Terminbuchungssystem (automatische Terminfindung) gibt es noch nicht.', 'auto-emotion' ),
			'link'        => '/mitarbeiter/bewerbungen/',
			'link_label'  => __( 'Zu den Bewerbungen', 'auto-emotion' ),
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
		)
	);
	exit;
}
add_action( 'template_redirect', 'auto_emotion_automatisierung_template_redirect' );
