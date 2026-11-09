<?php
/**
 * Gewerbekunden-Anfrage (B2B) – z. B. Nissan-Nutzfahrzeuge für den
 * Fuhrpark. Eigener Handler statt Wiederverwendung von
 * inc/recruiting.php, weil es sich um eine Verkaufsanfrage handelt,
 * keine Bewerbung – andere Felder, andere Betreffzeile.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_handle_b2b_anfrage() {
	if ( ! isset( $_POST['auto_emotion_b2b_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_b2b_nonce'] ) ), 'auto_emotion_b2b' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	// Honeypot: Für Menschen unsichtbares Feld, das leer bleiben muss.
	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$firma       = isset( $_POST['b2b_firma'] ) ? sanitize_text_field( wp_unslash( $_POST['b2b_firma'] ) ) : '';
	$ansprechpartner = isset( $_POST['b2b_ansprechpartner'] ) ? sanitize_text_field( wp_unslash( $_POST['b2b_ansprechpartner'] ) ) : '';
	$telefon     = isset( $_POST['b2b_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['b2b_telefon'] ) ) : '';
	$email       = isset( $_POST['b2b_email'] ) ? sanitize_email( wp_unslash( $_POST['b2b_email'] ) ) : '';
	$fuhrpark    = isset( $_POST['b2b_fuhrpark'] ) ? sanitize_text_field( wp_unslash( $_POST['b2b_fuhrpark'] ) ) : '';
	$nachricht   = isset( $_POST['b2b_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['b2b_nachricht'] ) ) : '';
	$consent     = ! empty( $_POST['b2b_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $firma || ! $ansprechpartner || ! $telefon || ! $email || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'fehler', $redirect_base ) );
		exit;
	}

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Gewerbekunden-Anfrage] %s', $firma );
	$body    = "Neue Gewerbekunden-Anfrage über die Website:\n\n"
		. 'Firma: ' . $firma . "\n"
		. 'Ansprechpartner: ' . $ansprechpartner . "\n"
		. 'Telefon: ' . $telefon . "\n"
		. 'E-Mail: ' . $email . "\n"
		. 'Fuhrpark-Interesse: ' . ( $fuhrpark ? $fuhrpark : '-' ) . "\n";

	if ( $nachricht ) {
		$body .= "\nNachricht:\n" . $nachricht . "\n";
	}

	$headers = array( 'Reply-To: ' . $ansprechpartner . ' <' . $email . '>' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'anfrage', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_b2b_anfrage', 'auto_emotion_handle_b2b_anfrage' );
add_action( 'admin_post_nopriv_auto_emotion_b2b_anfrage', 'auto_emotion_handle_b2b_anfrage' );
