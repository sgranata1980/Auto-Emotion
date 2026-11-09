<?php
/**
 * Website-Feedback-Popup (nach VW-Vorbild: "Wir bitten um Ihr
 * Feedback"), siehe template-parts/feedback-popup.php. Keine
 * dauerhafte Speicherung personenbezogener Daten nötig - die
 * Rückmeldung geht direkt per Mail an Auto Emotion, wie bereits bei
 * Kontakt- und Probefahrt-Formular (inc/testdrive.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_handle_feedback() {
	if ( ! isset( $_POST['auto_emotion_feedback_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_feedback_nonce'] ) ), 'auto_emotion_feedback' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	// Honeypot: Für Menschen unsichtbares Feld, das leer bleiben muss.
	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'feedback', 'ok', $redirect_base ) );
		exit;
	}

	$nachricht = isset( $_POST['feedback_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['feedback_nachricht'] ) ) : '';
	$email     = isset( $_POST['feedback_email'] ) ? sanitize_email( wp_unslash( $_POST['feedback_email'] ) ) : '';
	$seite     = isset( $_POST['feedback_seite'] ) ? esc_url_raw( wp_unslash( $_POST['feedback_seite'] ) ) : '';
	$consent   = ! empty( $_POST['feedback_dsgvo'] );

	if ( ! $nachricht || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'feedback', 'fehler', $redirect_base ) );
		exit;
	}

	$body = "Neues Website-Feedback:\n\n" . $nachricht . "\n\n";
	$body .= 'Seite: ' . ( $seite ? $seite : '-' ) . "\n";
	$body .= 'Antwort-Adresse: ' . ( $email ? $email : 'nicht angegeben' ) . "\n";

	$headers = array();
	if ( $email && is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . $email;
	}

	wp_mail(
		auto_emotion_contact( 'email' ),
		__( 'Neues Website-Feedback', 'auto-emotion' ),
		$body,
		$headers
	);

	wp_safe_redirect( add_query_arg( 'feedback', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_feedback', 'auto_emotion_handle_feedback' );
add_action( 'admin_post_nopriv_auto_emotion_feedback', 'auto_emotion_handle_feedback' );
