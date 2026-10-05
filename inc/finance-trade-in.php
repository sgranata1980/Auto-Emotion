<?php
/**
 * Anfragen für Finanzierung/Leasing und Fahrzeugankauf (Inzahlungnahme).
 * Gleiches Muster wie inc/b2b.php: admin-post-Handler mit Honeypot und
 * Nonce, Weiterleitung mit Status-Query statt AJAX.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Leitet Fahrzeugankauf-Fotos in einen eigenen, nicht öffentlich
 * verlinkten Ordner um – gleiches Sicherheitsmuster wie bei
 * Bewerbungsunterlagen (inc/recruiting.php), eigener Ordner, da es
 * sich inhaltlich und datenschutzrechtlich um einen anderen Vorgang
 * handelt (keine Bewerbung).
 */
function auto_emotion_ankauf_private_upload_dir( $dirs ) {
	$dirs['subdir'] = '/ankauf-privat' . $dirs['subdir'];
	$dirs['path']   = $dirs['basedir'] . $dirs['subdir'];
	$dirs['url']    = $dirs['baseurl'] . $dirs['subdir'];
	return $dirs;
}

function auto_emotion_ankauf_sichere_upload_ordner() {
	$upload_dir = wp_upload_dir();
	$ordner     = $upload_dir['basedir'] . '/ankauf-privat';

	if ( ! file_exists( $ordner ) ) {
		wp_mkdir_p( $ordner );
	}

	$htaccess = $ordner . '/.htaccess';
	if ( ! file_exists( $htaccess ) ) {
		file_put_contents( $htaccess, "Deny from all\n" );
	}

	$index = $ordner . '/index.php';
	if ( ! file_exists( $index ) ) {
		file_put_contents( $index, "<?php\n// Silence is golden.\n" );
	}
}

/**
 * Verarbeitet die hochgeladenen Fahrzeugfotos (max. 8 MB je Datei,
 * nur Bilddateien). Ungültige oder zu große Dateien werden
 * übersprungen, damit die Anfrage trotzdem ankommt. Gibt eine Liste
 * mit gespeichertem Pfad und MIME-Typ je Datei zurück.
 */
function auto_emotion_ankauf_handle_uploads( $field_name ) {
	if ( empty( $_FILES[ $field_name ] ) ) {
		return array();
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';

	$erlaubte_mimes = array(
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png',
		'webp' => 'image/webp',
		'heic' => 'image/heic',
	);
	$max_bytes = 8 * MB_IN_BYTES;
	$files     = $_FILES[ $field_name ];
	$count     = is_array( $files['name'] ) ? count( $files['name'] ) : 1;
	$ergebnis  = array();

	add_filter( 'upload_dir', 'auto_emotion_ankauf_private_upload_dir' );
	auto_emotion_ankauf_sichere_upload_ordner();

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
			'mimes'     => $erlaubte_mimes,
		);

		$moved = wp_handle_upload( $file, $overrides );

		if ( ! empty( $moved['file'] ) ) {
			$ergebnis[] = array(
				'pfad' => $moved['file'],
				'mime' => isset( $moved['type'] ) ? $moved['type'] : 'application/octet-stream',
			);
		}
	}

	remove_filter( 'upload_dir', 'auto_emotion_ankauf_private_upload_dir' );

	return $ergebnis;
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

	$fotos = auto_emotion_ankauf_handle_uploads( 'ankauf_fotos' );

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Fahrzeugankauf] %s %s', $marke, $modell );
	$body    = "Neue Ankauf-/Inzahlungnahme-Anfrage über die Website:\n\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon: ' . $telefon . "\n"
		. 'E-Mail: ' . $email . "\n"
		. 'Marke: ' . $marke . "\n"
		. 'Modell: ' . $modell . "\n"
		. 'Baujahr: ' . ( $baujahr ? $baujahr : '-' ) . "\n"
		. 'Kilometerstand: ' . ( $kilometer ? $kilometer : '-' ) . "\n"
		. 'Fotos: ' . ( $fotos ? count( $fotos ) . ' Datei(en) im Anhang' : 'keine hochgeladen' ) . "\n";

	if ( $nachricht ) {
		$body .= "\nNachricht:\n" . $nachricht . "\n";
	}

	$anhaenge = wp_list_pluck( $fotos, 'pfad' );

	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ), $anhaenge );

	foreach ( $anhaenge as $anhang_pfad ) {
		wp_delete_file( $anhang_pfad );
	}

	wp_safe_redirect( add_query_arg( 'anfrage', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_ankauf_anfrage', 'auto_emotion_handle_ankauf_anfrage' );
add_action( 'admin_post_nopriv_auto_emotion_ankauf_anfrage', 'auto_emotion_handle_ankauf_anfrage' );
