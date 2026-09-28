<?php
/**
 * Servicetermin-Anfrage (Werkstatt) – eigener Handler, da eigene
 * Felder (Fahrzeugdaten, Wunschtermin) und eigene Betreffzeile.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_handle_servicetermin() {
	if ( ! isset( $_POST['auto_emotion_servicetermin_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_servicetermin_nonce'] ) ), 'auto_emotion_servicetermin' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	// Honeypot: Für Menschen unsichtbares Feld, das leer bleiben muss.
	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$name      = isset( $_POST['service_name'] ) ? sanitize_text_field( wp_unslash( $_POST['service_name'] ) ) : '';
	$telefon   = isset( $_POST['service_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['service_telefon'] ) ) : '';
	$email     = isset( $_POST['service_email'] ) ? sanitize_email( wp_unslash( $_POST['service_email'] ) ) : '';
	$hersteller = isset( $_POST['service_hersteller'] ) ? sanitize_text_field( wp_unslash( $_POST['service_hersteller'] ) ) : '';
	$modell    = isset( $_POST['service_modell'] ) ? sanitize_text_field( wp_unslash( $_POST['service_modell'] ) ) : '';
	$kennzeichen = isset( $_POST['service_kennzeichen'] ) ? sanitize_text_field( wp_unslash( $_POST['service_kennzeichen'] ) ) : '';
	$termin    = isset( $_POST['service_termin'] ) ? sanitize_text_field( wp_unslash( $_POST['service_termin'] ) ) : '';
	$nachricht = isset( $_POST['service_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['service_nachricht'] ) ) : '';
	$consent   = ! empty( $_POST['service_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $telefon || ! $email || ! $hersteller || ! $modell || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'fehler', $redirect_base ) );
		exit;
	}

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Servicetermin] %s %s – %s', $hersteller, $modell, $name );
	$body    = "Neue Servicetermin-Anfrage über die Website:\n\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon: ' . $telefon . "\n"
		. 'E-Mail: ' . $email . "\n"
		. 'Hersteller: ' . $hersteller . "\n"
		. 'Modell: ' . $modell . "\n"
		. 'Kennzeichen: ' . ( $kennzeichen ? $kennzeichen : '-' ) . "\n"
		. 'Wunschtermin: ' . ( $termin ? $termin : '-' ) . "\n";

	if ( $nachricht ) {
		$body .= "\nAnmerkungen:\n" . $nachricht . "\n";
	}

	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'anfrage', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_servicetermin', 'auto_emotion_handle_servicetermin' );
add_action( 'admin_post_nopriv_auto_emotion_servicetermin', 'auto_emotion_handle_servicetermin' );
