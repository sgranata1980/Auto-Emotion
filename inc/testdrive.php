<?php
/**
 * Probefahrt-Anfrage auf der Angebots-Einzelseite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_handle_probefahrt() {
	if ( ! isset( $_POST['auto_emotion_probefahrt_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_probefahrt_nonce'] ) ), 'auto_emotion_probefahrt' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	// Honeypot: Für Menschen unsichtbares Feld, das leer bleiben muss.
	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'probefahrt', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$name      = isset( $_POST['probefahrt_name'] ) ? sanitize_text_field( wp_unslash( $_POST['probefahrt_name'] ) ) : '';
	$telefon   = isset( $_POST['probefahrt_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['probefahrt_telefon'] ) ) : '';
	$fahrzeug  = isset( $_POST['probefahrt_fahrzeug'] ) ? sanitize_text_field( wp_unslash( $_POST['probefahrt_fahrzeug'] ) ) : '';
	$termin    = isset( $_POST['probefahrt_termin'] ) ? sanitize_text_field( wp_unslash( $_POST['probefahrt_termin'] ) ) : '';
	$nachricht = isset( $_POST['probefahrt_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['probefahrt_nachricht'] ) ) : '';
	$consent   = ! empty( $_POST['probefahrt_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $telefon || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'probefahrt', 'fehler', $redirect_base ) );
		exit;
	}

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Probefahrt] %s – %s', $fahrzeug ? $fahrzeug : 'Anfrage', $name );
	$body    = "Neue Probefahrt-Anfrage über die Website:\n\n"
		. 'Fahrzeug: ' . ( $fahrzeug ? $fahrzeug : '-' ) . "\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon: ' . $telefon . "\n"
		. 'Wunschtermin: ' . ( $termin ? $termin : '-' ) . "\n";

	if ( $nachricht ) {
		$body .= "\nNachricht:\n" . $nachricht . "\n";
	}

	wp_mail( $to, $subject, $body );

	wp_safe_redirect( add_query_arg( 'probefahrt', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_probefahrt', 'auto_emotion_handle_probefahrt' );
add_action( 'admin_post_nopriv_auto_emotion_probefahrt', 'auto_emotion_handle_probefahrt' );
