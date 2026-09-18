<?php
/**
 * Bewerbungsformular-Handler für die Karriere-Landingpage(s).
 *
 * Bewusst ohne Datenbank-Speicherung: Bewerbungen werden per E-Mail an
 * die reale Kontaktadresse (inc/contact-info.php) weitergeleitet, es
 * wird nichts zusätzlich in der WP-Datenbank abgelegt. Hochgeladene
 * Dateien (Lebenslauf/Zeugnisse) werden nur für die Dauer des Mail-
 * Versands temporär abgelegt und danach sofort wieder gelöscht – passt
 * zur Datenschutz-Linie aus dem Recruiting-Handbuch (Aufbewahrung
 * minimal halten).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_bewerbung_allowed_mimes() {
	return array(
		'pdf'  => 'application/pdf',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	);
}

/**
 * Verarbeitet ein einzelnes hochgeladenes Anhang-Feld (kann bei
 * Mehrfach-Uploads mehrere Dateien enthalten) und gibt eine Liste von
 * wp_mail-Attachment-Pfaden zurück. Ungültige oder zu große Dateien
 * werden stillschweigend übersprungen, damit der Rest der Bewerbung
 * trotzdem ankommt.
 */
function auto_emotion_bewerbung_handle_uploads( $field_name ) {
	if ( empty( $_FILES[ $field_name ] ) ) {
		return array();
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';

	$max_bytes = 8 * MB_IN_BYTES;
	$files     = $_FILES[ $field_name ];
	$count     = is_array( $files['name'] ) ? count( $files['name'] ) : 1;
	$paths     = array();

	for ( $i = 0; $i < $count; $i++ ) {
		$file = is_array( $files['name'] )
			? array(
				'name'     => $files['name'][ $i ],
				'type'     => $files['type'][ $i ],
				'tmp_name' => $files['tmp_name'][ $i ],
				'error'    => $files['error'][ $i ],
				'size'     => $files['size'][ $i ],
			)
			: $files;

		if ( empty( $file['name'] ) || UPLOAD_ERR_NO_FILE === $file['error'] ) {
			continue;
		}

		if ( UPLOAD_ERR_OK !== $file['error'] || $file['size'] > $max_bytes ) {
			continue;
		}

		$overrides = array(
			'test_form' => false,
			'mimes'     => auto_emotion_bewerbung_allowed_mimes(),
		);

		$moved = wp_handle_upload( $file, $overrides );

		if ( ! empty( $moved['file'] ) ) {
			$paths[] = $moved['file'];
		}
	}

	return $paths;
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

	$name         = isset( $_POST['bewerbung_name'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_name'] ) ) : '';
	$phone        = isset( $_POST['bewerbung_telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_telefon'] ) ) : '';
	$contact_pref = isset( $_POST['bewerbung_kontakt'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_kontakt'] ) ) : '';
	$position     = isset( $_POST['bewerbung_stelle'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_stelle'] ) ) : '';
	$message      = isset( $_POST['bewerbung_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['bewerbung_nachricht'] ) ) : '';
	$consent      = ! empty( $_POST['bewerbung_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $phone || ! $contact_pref || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'bewerbung', 'fehler', $redirect_base ) );
		exit;
	}

	$attachments   = array_merge(
		auto_emotion_bewerbung_handle_uploads( 'bewerbung_lebenslauf' ),
		auto_emotion_bewerbung_handle_uploads( 'bewerbung_zeugnisse' )
	);

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Bewerbung] %s – %s', $position ? $position : 'Karriere', $name );
	$body    = "Neue Bewerbung über die Website:\n\n"
		. 'Stelle: ' . $position . "\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon/WhatsApp: ' . $phone . "\n"
		. 'Bevorzugter Kontakt: ' . $contact_pref . "\n"
		. 'DSGVO-Einwilligung: erteilt' . "\n";

	if ( $message ) {
		$body .= "\nNachricht:\n" . $message . "\n";
	}

	if ( $attachments ) {
		$body .= "\nAnhänge: " . count( $attachments ) . " Datei(en), siehe Anhang dieser Mail.\n";
	}

	$headers = array( 'Reply-To: ' . $name . ' <' . $to . '>' );

	wp_mail( $to, $subject, $body, $headers, $attachments );

	foreach ( $attachments as $path ) {
		if ( file_exists( $path ) ) {
			wp_delete_file( $path );
		}
	}

	wp_safe_redirect( add_query_arg( 'bewerbung', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung', 'auto_emotion_handle_bewerbung' );
add_action( 'admin_post_nopriv_auto_emotion_bewerbung', 'auto_emotion_handle_bewerbung' );
