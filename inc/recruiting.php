<?php
/**
 * Bewerbungsformular-Handler für die Karriere-Landingpage(s).
 *
 * Bewusst ohne Datenbank-Speicherung: Bewerbungen werden per E-Mail an
 * die reale Kontaktadresse (inc/contact-info.php) weitergeleitet, es
 * wird nichts zusätzlich in der WP-Datenbank abgelegt. Passt zur
 * Datenschutz-Linie aus dem Recruiting-Handbuch (Aufbewahrung minimal
 * halten), lässt sich bei Bedarf später um eine echte Speicherung
 * (Custom Post Type oder CRM-Anbindung) erweitern.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_handle_bewerbung() {
	if ( ! isset( $_POST['auto_emotion_bewerbung_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_nonce'] ) ), 'auto_emotion_bewerbung' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	// Honeypot: Für Menschen unsichtbares Feld, das leer bleiben muss.
	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'bewerbung', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$name        = isset( $_POST['bewerbung_name'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_name'] ) ) : '';
	$phone       = isset( $_POST['bewerbung_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_telefon'] ) ) : '';
	$contact_pref = isset( $_POST['bewerbung_kontakt'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_kontakt'] ) ) : '';
	$position    = isset( $_POST['bewerbung_stelle'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_stelle'] ) ) : '';
	$consent     = ! empty( $_POST['bewerbung_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $phone || ! $contact_pref || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'bewerbung', 'fehler', $redirect_base ) );
		exit;
	}

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Bewerbung] %s – %s', $position ? $position : 'Karriere', $name );
	$body    = "Neue Bewerbung über die Website:\n\n"
		. 'Stelle: ' . $position . "\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon/WhatsApp: ' . $phone . "\n"
		. 'Bevorzugter Kontakt: ' . $contact_pref . "\n"
		. 'DSGVO-Einwilligung: erteilt' . "\n";

	$headers = array( 'Reply-To: ' . $name . ' <' . $to . '>' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'bewerbung', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung', 'auto_emotion_handle_bewerbung' );
add_action( 'admin_post_nopriv_auto_emotion_bewerbung', 'auto_emotion_handle_bewerbung' );
