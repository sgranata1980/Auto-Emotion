<?php
/**
 * Bewerbungsformular-Handler für die Karriere-Landingpage(s).
 *
 * Bewerbungen werden per E-Mail an die reale Kontaktadresse
 * (inc/contact-info.php) weitergeleitet UND – seit der Einführung des
 * Mitarbeiterbereichs (inc/recruiting-bewerbungen.php) – zusätzlich in
 * einem eigenen, nicht öffentlich erreichbaren Bereich gespeichert, damit
 * Kollegen sie dort einsehen und intern weiterleiten können. Hochgeladene
 * Dateien (Lebenslauf/Zeugnisse) landen dafür in einem eigenen, per
 * .htaccess/Zugriffsschutz abgeschotteten Upload-Ordner statt im normal
 * öffentlich erreichbaren Medien-Verzeichnis (siehe
 * auto_emotion_bewerbung_private_upload_dir()) und werden zusätzlich mit
 * einem zufälligen Dateinamen abgelegt. Automatische Löschung nach
 * spätestens 6 Monaten über einen täglichen Cron-Job, siehe
 * inc/recruiting-bewerbungen.php – passt zur im Formular zugesagten
 * Aufbewahrungsfrist (DSGVO/§ 26 BDSG).
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
 * Leitet Uploads in einen eigenen, nicht öffentlich verlinkten
 * Ordner um (statt in den normalen, per URL erreichbaren
 * wp-content/uploads-Bereich) – Zugriff auf Bewerbungsunterlagen soll
 * ausschließlich über den authentifizierten Mitarbeiterbereich möglich
 * sein.
 */
function auto_emotion_bewerbung_private_upload_dir( $dirs ) {
	$dirs['subdir'] = '/bewerbungen-privat' . $dirs['subdir'];
	$dirs['path']   = $dirs['basedir'] . $dirs['subdir'];
	$dirs['url']    = $dirs['baseurl'] . $dirs['subdir'];
	return $dirs;
}

/**
 * Ersetzt den (aus dem Originaldateinamen abgeleiteten und damit
 * erratbaren) Dateinamen durch einen zufälligen Token. Der echte
 * Originalname wird separat in der Bewerbungs-Metadaten gespeichert und
 * nur innerhalb des authentifizierten Bereichs wieder angezeigt.
 */
function auto_emotion_bewerbung_randomize_filename( $filepath ) {
	$ext    = pathinfo( $filepath, PATHINFO_EXTENSION );
	$dir    = dirname( $filepath );
	$random = bin2hex( random_bytes( 20 ) );
	$neuer_pfad = trailingslashit( $dir ) . $random . ( $ext ? '.' . $ext : '' );

	if ( rename( $filepath, $neuer_pfad ) ) {
		return $neuer_pfad;
	}

	return $filepath;
}

/**
 * Verarbeitet ein einzelnes hochgeladenes Anhang-Feld (kann bei
 * Mehrfach-Uploads mehrere Dateien enthalten) und gibt eine Liste mit
 * Original-Dateiname, gespeichertem (privatem) Pfad und MIME-Typ
 * zurück. Ungültige oder zu große Dateien werden stillschweigend
 * übersprungen, damit der Rest der Bewerbung trotzdem ankommt.
 */
function auto_emotion_bewerbung_handle_uploads( $field_name ) {
	if ( empty( $_FILES[ $field_name ] ) ) {
		return array();
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';

	$max_bytes = 8 * MB_IN_BYTES;
	$files     = $_FILES[ $field_name ];
	$count     = is_array( $files['name'] ) ? count( $files['name'] ) : 1;
	$ergebnis  = array();

	add_filter( 'upload_dir', 'auto_emotion_bewerbung_private_upload_dir' );
	auto_emotion_bewerbung_sichere_upload_ordner();

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
			$pfad = auto_emotion_bewerbung_randomize_filename( $moved['file'] );

			$ergebnis[] = array(
				'original' => sanitize_file_name( $file['name'] ),
				'pfad'     => $pfad,
				'mime'     => isset( $moved['type'] ) ? $moved['type'] : 'application/octet-stream',
			);
		}
	}

	remove_filter( 'upload_dir', 'auto_emotion_bewerbung_private_upload_dir' );

	return $ergebnis;
}

/**
 * Legt einmalig Zugriffsschutz im privaten Upload-Ordner an: .htaccess
 * (greift bei Apache-Hosting) + leere index.php (verhindert
 * Verzeichnis-Listing bei Servern, die .htaccess ignorieren, z. B.
 * Nginx). Die eigentliche Sicherheit kommt aus dem zufälligen
 * Dateinamen plus dem authentifizierten Zugriff über den
 * Mitarbeiterbereich, nicht aus diesen Dateien allein.
 */
function auto_emotion_bewerbung_sichere_upload_ordner() {
	$upload_dir = wp_upload_dir();
	$ordner     = $upload_dir['path'];

	if ( ! file_exists( $ordner ) ) {
		wp_mkdir_p( $ordner );
	}

	$htaccess = trailingslashit( $ordner ) . '.htaccess';
	if ( ! file_exists( $htaccess ) ) {
		file_put_contents( $htaccess, "Require all denied\nDeny from all\n" ); // phpcs:ignore -- gezielt außerhalb der Medienbibliothek, kein WP_Filesystem nötig.
	}

	$index = trailingslashit( $ordner ) . 'index.php';
	if ( ! file_exists( $index ) ) {
		file_put_contents( $index, "<?php\n// Silence is golden.\n" ); // phpcs:ignore
	}
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
	$email        = isset( $_POST['bewerbung_email'] ) ? sanitize_email( wp_unslash( $_POST['bewerbung_email'] ) ) : '';
	$position     = isset( $_POST['bewerbung_stelle'] ) ? sanitize_text_field( wp_unslash( $_POST['bewerbung_stelle'] ) ) : '';
	$message      = isset( $_POST['bewerbung_nachricht'] ) ? sanitize_textarea_field( wp_unslash( $_POST['bewerbung_nachricht'] ) ) : '';
	$consent      = ! empty( $_POST['bewerbung_dsgvo'] );

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	if ( ! $name || ! $phone || ! $contact_pref || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'bewerbung', 'fehler', $redirect_base ) );
		exit;
	}

	$dateien = array_merge(
		auto_emotion_bewerbung_handle_uploads( 'bewerbung_lebenslauf' ),
		auto_emotion_bewerbung_handle_uploads( 'bewerbung_zeugnisse' )
	);

	$mail_attachments = wp_list_pluck( $dateien, 'pfad' );

	$to      = auto_emotion_contact( 'email' );
	$subject = sprintf( '[Bewerbung] %s – %s', $position ? $position : 'Karriere', $name );
	$body    = "Neue Bewerbung über die Website:\n\n"
		. 'Stelle: ' . $position . "\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon/WhatsApp: ' . $phone . "\n"
		. 'Bevorzugter Kontakt: ' . $contact_pref . "\n"
		. ( $email ? 'E-Mail: ' . $email . "\n" : '' )
		. 'DSGVO-Einwilligung: erteilt' . "\n";

	if ( $message ) {
		$body .= "\nNachricht:\n" . $message . "\n";
	}

	if ( $dateien ) {
		$body .= "\nAnhänge: " . count( $dateien ) . " Datei(en), siehe Anhang dieser Mail.\n";
	}

	$body .= "\nDiese Bewerbung ist zusätzlich im Mitarbeiterbereich einsehbar: " . home_url( '/mitarbeiter/bewerbungen/' ) . "\n";

	$headers = array( 'Reply-To: ' . $name . ' <' . $to . '>' );

	wp_mail( $to, $subject, $body, $headers, $mail_attachments );

	if ( function_exists( 'auto_emotion_speichere_bewerbung' ) ) {
		auto_emotion_speichere_bewerbung(
			array(
				'name'         => $name,
				'telefon'      => $phone,
				'email'        => $email,
				'kontakt_pref' => $contact_pref,
				'position'     => $position,
				'nachricht'    => $message,
				'dateien'      => $dateien,
			)
		);
	}

	wp_safe_redirect( add_query_arg( 'bewerbung', 'ok', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung', 'auto_emotion_handle_bewerbung' );
add_action( 'admin_post_nopriv_auto_emotion_bewerbung', 'auto_emotion_handle_bewerbung' );
