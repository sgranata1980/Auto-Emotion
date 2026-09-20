<?php
/**
 * Anfragen für Finanzierung/Leasing und Fahrzeugankauf (Inzahlungnahme).
 * Gleiches Muster wie inc/b2b.php: admin-post-Handler mit Honeypot und
 * Nonce, Weiterleitung mit Status-Query statt AJAX.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_handle_finanzierung_anfrage() {
	if ( ! isset( $_POST['auto_emotion_finanzierung_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_finanzierung_nonce'] ) ), 'auto_emotion_finanzierung' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$name      = isset( $_POST['fin_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fin_name'] ) ) : '';
	$telefon   = isset( $_POST['fin_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['fin_telefon'] ) ) : '';
	$email     = isset( $_POST['fin_email'] ) ? sanitize_email( wp_unslash( $_POST['fin_email'] ) ) : '';
	$fahrzeug  = isset( $_POST['fin_fahrzeug'] ) ? sanitize_text_field( wp_unslash( $_POST['fin_fahrzeug'] ) ) : '';
	$art       = isset( $_POST['fin_art'] ) ? sanitize_text_field( wp_unslash( $_POST['fin_art'] ) ) : '';
	$nachricht = isset( $_POST['fin_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['fin_nachricht'] ) ) : '';
	$consent   = ! empty( $_POST['fin_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $telefon || ! $email || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'fehler', $redirect_base ) );
		exit;
	}

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Finanzierungsanfrage] %s', $name );
	$body    = "Neue Finanzierungs-/Leasing-Anfrage über die Website:\n\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon: ' . $telefon . "\n"
		. 'E-Mail: ' . $email . "\n"
		. 'Interesse: ' . ( $art ? $art : '-' ) . "\n"
		. 'Fahrzeug: ' . ( $fahrzeug ? $fahrzeug : '-' ) . "\n";

	if ( $nachricht ) {
		$body .= "\nNachricht:\n" . $nachricht . "\n";
	}

	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_safe_redirect( add_query_arg( 'anfrage', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_finanzierung_anfrage', 'auto_emotion_handle_finanzierung_anfrage' );
add_action( 'admin_post_nopriv_auto_emotion_finanzierung_anfrage', 'auto_emotion_handle_finanzierung_anfrage' );

function auto_emotion_handle_ankauf_anfrage() {
	if ( ! isset( $_POST['auto_emotion_ankauf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_ankauf_nonce'] ) ), 'auto_emotion_ankauf' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$name       = isset( $_POST['ankauf_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ankauf_name'] ) ) : '';
	$telefon    = isset( $_POST['ankauf_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['ankauf_telefon'] ) ) : '';
	$email      = isset( $_POST['ankauf_email'] ) ? sanitize_email( wp_unslash( $_POST['ankauf_email'] ) ) : '';
	$marke      = isset( $_POST['ankauf_marke'] ) ? sanitize_text_field( wp_unslash( $_POST['ankauf_marke'] ) ) : '';
	$modell     = isset( $_POST['ankauf_modell'] ) ? sanitize_text_field( wp_unslash( $_POST['ankauf_modell'] ) ) : '';
	$baujahr    = isset( $_POST['ankauf_baujahr'] ) ? sanitize_text_field( wp_unslash( $_POST['ankauf_baujahr'] ) ) : '';
	$kilometer  = isset( $_POST['ankauf_kilometer'] ) ? sanitize_text_field( wp_unslash( $_POST['ankauf_kilometer'] ) ) : '';
	$nachricht  = isset( $_POST['ankauf_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ankauf_nachricht'] ) ) : '';
	$consent    = ! empty( $_POST['ankauf_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $telefon || ! $email || ! $marke || ! $modell || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'anfrage', 'fehler', $redirect_base ) );
		exit;
	}

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Fahrzeugankauf] %s %s', $marke, $modell );
	$body    = "Neue Ankauf-/Inzahlungnahme-Anfrage über die Website:\n\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon: ' . $telefon . "\n"
		. 'E-Mail: ' . $email . "\n"
		. 'Marke: ' . $marke . "\n"
		. 'Modell: ' . $modell . "\n"
		. 'Baujahr: ' . ( $baujahr ? $baujahr : '-' ) . "\n"
		. 'Kilometerstand: ' . ( $kilometer ? $kilometer : '-' ) . "\n";

	if ( $nachricht ) {
		$body .= "\nNachricht:\n" . $nachricht . "\n";
	}

	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_safe_redirect( add_query_arg( 'anfrage', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_ankauf_anfrage', 'auto_emotion_handle_ankauf_anfrage' );
add_action( 'admin_post_nopriv_auto_emotion_ankauf_anfrage', 'auto_emotion_handle_ankauf_anfrage' );
