<?php
/**
 * Bewerbungen im Mitarbeiterbereich: speichert eingehende Bewerbungen
 * (aus inc/recruiting.php) intern, damit Kollegen sie unter
 * /mitarbeiter/bewerbungen/ einsehen, hochgeladene Unterlagen öffnen
 * und Bewerbungen an weitere Kollegen per E-Mail weiterleiten können.
 *
 * Löst die frühere "keine Speicherung"-Regel bewusst ab – auf
 * ausdrücklichen Wunsch, siehe Formular-Zusage "Löschung spätestens
 * 6 Monate nach Absage" (page-karriere-*.php). Diese Frist wird über
 * einen täglichen Cron-Job automatisch durchgesetzt (siehe unten).
 *
 * Dateien liegen in einem eigenen, nicht öffentlich verlinkten
 * Upload-Ordner (siehe inc/recruiting.php) und sind ausschließlich über
 * den authentifizierten Mitarbeiterbereich abrufbar, niemals über eine
 * direkte, indexierbare URL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_bewerbung_cpt() {
	register_post_type(
		'bewerbung',
		array(
			'labels'              => array(
				'name'          => __( 'Bewerbungen', 'auto-emotion' ),
				'singular_name' => __( 'Bewerbung', 'auto-emotion' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'        => false,
			'show_ui'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => array( 'title' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_bewerbung_cpt' );

/**
 * Legt eine eingegangene Bewerbung als internen Datensatz an. Wird von
 * inc/recruiting.php direkt nach dem E-Mail-Versand aufgerufen.
 */
function auto_emotion_speichere_bewerbung( $daten ) {
	$titel = trim( ( ! empty( $daten['position'] ) ? $daten['position'] . ' – ' : '' ) . $daten['name'] );

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'bewerbung',
			'post_title'  => $titel,
			'post_status' => 'publish',
		)
	);

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_bewerbung_name', $daten['name'] );
	update_post_meta( $post_id, '_bewerbung_telefon', $daten['telefon'] );
	update_post_meta( $post_id, '_bewerbung_email', isset( $daten['email'] ) ? $daten['email'] : '' );
	update_post_meta( $post_id, '_bewerbung_kontakt_pref', $daten['kontakt_pref'] );
	update_post_meta( $post_id, '_bewerbung_position', $daten['position'] );
	update_post_meta( $post_id, '_bewerbung_nachricht', $daten['nachricht'] );
	update_post_meta( $post_id, '_bewerbung_status', 'neu' );
	update_post_meta( $post_id, '_bewerbung_dateien', $daten['dateien'] );
}

/**
 * Entfernt beim endgültigen Löschen (Papierkorb-Auto-Leerung nach 30
 * Tagen oder manuell) auch die zugehörigen Dateien auf der Festplatte –
 * ein "Löschen" soll die Unterlagen wirklich entfernen, nicht nur den
 * Datensatz.
 */
function auto_emotion_delete_bewerbung_dateien( $post_id ) {
	if ( 'bewerbung' !== get_post_type( $post_id ) ) {
		return;
	}

	$dateien = get_post_meta( $post_id, '_bewerbung_dateien', true );
	if ( ! is_array( $dateien ) ) {
		return;
	}

	foreach ( $dateien as $datei ) {
		if ( ! empty( $datei['pfad'] ) && file_exists( $datei['pfad'] ) ) {
			wp_delete_file( $datei['pfad'] );
		}
	}
}
add_action( 'before_delete_post', 'auto_emotion_delete_bewerbung_dateien' );

/**
 * Setzt die im Formular zugesagte Frist ("Löschung spätestens 6 Monate
 * nach Absage") automatisch durch: verschiebt Bewerbungen, die älter
 * als 180 Tage sind, in den Papierkorb (reversibel, 30 Tage Frist bis
 * zur endgültigen Löschung). Ohne separat erfasstes Absage-Datum ist
 * das Einreichungsdatum + 180 Tage die konservativere, mindestens
 * ebenso schützende Auslegung.
 */
function auto_emotion_bewerbung_auto_trash_cron() {
	$alte_bewerbungen = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'date_query'     => array(
				array( 'before' => '180 days ago' ),
			),
		)
	);

	foreach ( $alte_bewerbungen as $post_id ) {
		wp_trash_post( $post_id );
	}
}
add_action( 'auto_emotion_bewerbung_auto_trash', 'auto_emotion_bewerbung_auto_trash_cron' );

function auto_emotion_schedule_bewerbung_auto_trash() {
	if ( ! wp_next_scheduled( 'auto_emotion_bewerbung_auto_trash' ) ) {
		wp_schedule_event( time(), 'daily', 'auto_emotion_bewerbung_auto_trash' );
	}
}
add_action( 'init', 'auto_emotion_schedule_bewerbung_auto_trash' );

/**
 * Eigene Rewrite-Routen unter /mitarbeiter/bewerbungen/.
 */
function auto_emotion_bewerbungen_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/bewerbungen/?$', 'index.php?ae_staff_route=bewerbungen', 'top' );
	add_rewrite_rule( '^mitarbeiter/bewerbungen/([0-9]+)/?$', 'index.php?ae_staff_route=bewerbung_detail&ae_staff_id=$matches[1]', 'top' );
	add_rewrite_rule( '^mitarbeiter/bewerbungen/([0-9]+)/datei/([0-9]+)/?$', 'index.php?ae_staff_route=bewerbung_datei&ae_staff_id=$matches[1]&ae_staff_datei=$matches[2]', 'top' );
}
add_action( 'init', 'auto_emotion_bewerbungen_rewrite_rules' );

function auto_emotion_bewerbungen_query_vars( $vars ) {
	$vars[] = 'ae_staff_datei';
	return $vars;
}
add_filter( 'query_vars', 'auto_emotion_bewerbungen_query_vars' );

function auto_emotion_maybe_flush_bewerbungen_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_bewerbungen_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_bewerbungen_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_bewerbungen_rewrite_rules', 20 );

function auto_emotion_bewerbungen_template_redirect() {
	$route = get_query_var( 'ae_staff_route' );

	if ( ! $route || ! in_array( $route, array( 'bewerbungen', 'bewerbung_detail', 'bewerbung_datei' ), true ) ) {
		return;
	}

	auto_emotion_staff_require_login();

	if ( 'bewerbungen' === $route ) {
		$auto_emotion_filter_status   = isset( $_GET['status'] ) ? sanitize_key( wp_unslash( $_GET['status'] ) ) : '';
		$auto_emotion_filter_position = isset( $_GET['position'] ) ? sanitize_text_field( wp_unslash( $_GET['position'] ) ) : '';
		$auto_emotion_query_args      = array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$auto_emotion_meta_query = array();
		if ( $auto_emotion_filter_status && array_key_exists( $auto_emotion_filter_status, auto_emotion_bewerbung_status_labels() ) ) {
			$auto_emotion_meta_query[] = array(
				'key'   => '_bewerbung_status',
				'value' => $auto_emotion_filter_status,
			);
		}
		if ( $auto_emotion_filter_position ) {
			$auto_emotion_meta_query[] = array(
				'key'   => '_bewerbung_position',
				'value' => $auto_emotion_filter_position,
			);
		}
		if ( $auto_emotion_meta_query ) {
			$auto_emotion_query_args['meta_query'] = $auto_emotion_meta_query;
		}

		$auto_emotion_bewerbungen = get_posts( $auto_emotion_query_args );
		$auto_emotion_view        = isset( $_GET['view'] ) && 'board' === $_GET['view'] ? 'board' : 'liste';

		$auto_emotion_alle_bewerbungen = 'board' === $auto_emotion_view
			? get_posts(
				array(
					'post_type'      => 'bewerbung',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			)
			: array();

		auto_emotion_render_template_part(
			'bewerbungen-liste.php',
			array(
				'auto_emotion_bewerbungen'      => $auto_emotion_bewerbungen,
				'auto_emotion_filter_status'    => $auto_emotion_filter_status,
				'auto_emotion_filter_position'  => $auto_emotion_filter_position,
				'auto_emotion_view'             => $auto_emotion_view,
				'auto_emotion_alle_bewerbungen' => $auto_emotion_alle_bewerbungen,
			)
		);
		exit;
	}

	$auto_emotion_id   = absint( get_query_var( 'ae_staff_id' ) );
	$auto_emotion_post = get_post( $auto_emotion_id );

	if ( ! $auto_emotion_post || 'bewerbung' !== $auto_emotion_post->post_type ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' ) );
		exit;
	}

	if ( 'bewerbung_detail' === $route ) {
		auto_emotion_render_template_part( 'bewerbung-detail.php', array( 'auto_emotion_bewerbung_post' => $auto_emotion_post ) );
		exit;
	}

	if ( 'bewerbung_datei' === $route ) {
		$index   = absint( get_query_var( 'ae_staff_datei' ) );
		$dateien = get_post_meta( $auto_emotion_id, '_bewerbung_dateien', true );

		if ( ! is_array( $dateien ) || ! isset( $dateien[ $index ] ) || empty( $dateien[ $index ]['pfad'] ) || ! file_exists( $dateien[ $index ]['pfad'] ) ) {
			wp_die( esc_html__( 'Datei nicht gefunden.', 'auto-emotion' ), '', array( 'response' => 404 ) );
		}

		$datei = $dateien[ $index ];
		nocache_headers();
		header( 'Content-Type: ' . $datei['mime'] );
		header( 'Content-Disposition: inline; filename="' . sanitize_file_name( $datei['original'] ) . '"' );
		header( 'Content-Length: ' . filesize( $datei['pfad'] ) );
		header( 'X-Robots-Tag: noindex' );
		readfile( $datei['pfad'] ); // phpcs:ignore -- gezielter, authentifizierter Datei-Stream, kein WP_Filesystem nötig.
		exit;
	}
}
add_action( 'template_redirect', 'auto_emotion_bewerbungen_template_redirect' );

/**
 * Leitet eine gespeicherte Bewerbung samt Anhängen an eine weitere
 * E-Mail-Adresse (z. B. einen Kollegen) weiter.
 */
function auto_emotion_handle_bewerbung_weiterleiten() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_weiterleiten_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_weiterleiten_nonce'] ) ), 'auto_emotion_bewerbung_weiterleiten_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	$ziel_email = isset( $_POST['ae_weiterleiten_email'] ) ? sanitize_email( wp_unslash( $_POST['ae_weiterleiten_email'] ) ) : '';

	if ( ! $post || 'bewerbung' !== $post->post_type || ! is_email( $ziel_email ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) );
		exit;
	}

	$dateien          = get_post_meta( $post_id, '_bewerbung_dateien', true );
	$mail_attachments = is_array( $dateien ) ? wp_list_pluck( $dateien, 'pfad' ) : array();
	$name             = get_post_meta( $post_id, '_bewerbung_name', true );
	$position         = get_post_meta( $post_id, '_bewerbung_position', true );
	$telefon          = get_post_meta( $post_id, '_bewerbung_telefon', true );
	$nachricht        = get_post_meta( $post_id, '_bewerbung_nachricht', true );

	$aktueller_nutzer = wp_get_current_user();

	$subject = sprintf( '[Weiterleitung] Bewerbung: %s – %s', $position ? $position : 'Karriere', $name );
	$body    = sprintf( "%s hat dir diese Bewerbung aus dem Mitarbeiterbereich weitergeleitet:\n\n", $aktueller_nutzer->display_name )
		. 'Stelle: ' . $position . "\n"
		. 'Name: ' . $name . "\n"
		. 'Telefon/WhatsApp: ' . $telefon . "\n";

	if ( $nachricht ) {
		$body .= "\nNachricht:\n" . $nachricht . "\n";
	}

	$body .= "\nVollständige Ansicht: " . home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) . "\n";

	wp_mail( $ziel_email, $subject, $body, array(), $mail_attachments );

	wp_safe_redirect( add_query_arg( 'weitergeleitet', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_weiterleiten', 'auto_emotion_handle_bewerbung_weiterleiten' );

/**
 * Vorgefertigte, editierbare E-Mail-Vorlagen an Bewerber – Einladung
 * zum Interview oder Absage. Wird nur angeboten, wenn im Formular eine
 * E-Mail-Adresse angegeben wurde (das Formular fragt sie optional ab).
 */
function auto_emotion_bewerbung_email_vorlagen( $name, $position ) {
	$anschrift = trim( 'Liebe/r ' . $name . ',' );

	return array(
		'einladung' => array(
			'label'   => __( 'Einladung zum Interview', 'auto-emotion' ),
			'betreff' => sprintf( __( 'Einladung zum Vorstellungsgespräch – %s', 'auto-emotion' ), $position ),
			'text'    => $anschrift . "\n\n" . sprintf(
				__( 'vielen Dank für Ihre Bewerbung als %s bei Auto Emotion. Wir würden Sie gerne persönlich kennenlernen und laden Sie herzlich zu einem Vorstellungsgespräch ein.', 'auto-emotion' ),
				$position
			) . "\n\n" . __( 'Bitte teilen Sie uns mit, welcher Termin Ihnen passt, oder schlagen Sie gerne einen Alternativtermin vor:', 'auto-emotion' ) . "\n– [Terminvorschlag 1]\n– [Terminvorschlag 2]\n\n"
			. __( 'Das Gespräch findet statt bei:', 'auto-emotion' ) . "\nAuto Emotion GmbH & Co. KG\nSprendlinger Landstraße 166, 63069 Offenbach am Main\n\n"
			. __( 'Wir freuen uns auf das Gespräch mit Ihnen!', 'auto-emotion' ) . "\n\n" . __( 'Mit freundlichen Grüßen', 'auto-emotion' ) . "\nIhr Auto Emotion Team",
		),
		'absage'    => array(
			'label'   => __( 'Absage', 'auto-emotion' ),
			'betreff' => sprintf( __( 'Ihre Bewerbung als %s bei Auto Emotion', 'auto-emotion' ), $position ),
			'text'    => $anschrift . "\n\n" . sprintf(
				__( 'vielen Dank für Ihr Interesse an einer Tätigkeit als %s bei Auto Emotion und die Zeit, die Sie in Ihre Bewerbung investiert haben.', 'auto-emotion' ),
				$position
			) . "\n\n" . __( 'Nach sorgfältiger Prüfung müssen wir Ihnen leider mitteilen, dass wir uns in diesem Auswahlprozess für eine andere Kandidatin bzw. einen anderen Kandidaten entschieden haben.', 'auto-emotion' ) . "\n\n"
			. __( 'Wir bedanken uns herzlich für Ihr Interesse an Auto Emotion und wünschen Ihnen für Ihren weiteren beruflichen Weg alles Gute.', 'auto-emotion' ) . "\n\n" . __( 'Mit freundlichen Grüßen', 'auto-emotion' ) . "\nIhr Auto Emotion Team",
		),
	);
}

function auto_emotion_handle_bewerbung_email_senden() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_email_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_email_nonce'] ) ), 'auto_emotion_bewerbung_email_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post           = get_post( $post_id );
	$bewerber_email = $post ? get_post_meta( $post_id, '_bewerbung_email', true ) : '';

	if ( ! $post || 'bewerbung' !== $post->post_type || ! is_email( $bewerber_email ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) );
		exit;
	}

	$betreff = isset( $_POST['ae_email_betreff'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_email_betreff'] ) ) : '';
	$text    = isset( $_POST['ae_email_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_email_text'] ) ) : '';

	if ( $betreff && $text ) {
		$eigener_absender = auto_emotion_contact( 'email' );
		$headers          = array( 'Reply-To: ' . $eigener_absender );
		wp_mail( $bewerber_email, $betreff, $text, $headers );

		$bisherige_notiz = get_post_meta( $post_id, '_bewerbung_notiz', true );
		$protokoll_zeile = sprintf( '[%s] %s: "%s" an %s gesendet.', current_time( 'd.m.Y H:i' ), wp_get_current_user()->display_name, $betreff, $bewerber_email );
		update_post_meta( $post_id, '_bewerbung_notiz', trim( $bisherige_notiz . "\n" . $protokoll_zeile ) );
	}

	wp_safe_redirect( add_query_arg( 'email_gesendet', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_email_senden', 'auto_emotion_handle_bewerbung_email_senden' );

/**
 * Zählt echte eingegangene Bewerbungen zu einer Position – das
 * Gegenstück zur "Klicks/Bewerbungen pro Anzeige"-Ansicht, die man aus
 * dem Indeed-/StepStone-Arbeitgeber-Dashboard kennt. Bewusst nur mit
 * echten, selbst eingegangenen Daten (Abgleich über den exakten
 * Positions-Titel, wie ihn die Karriere-Formulare als "Stelle"
 * mitschicken) – keine erfundenen Kennzahlen wie Impressions/Klicks,
 * die wir mangels eigener Anzeigenschaltung gar nicht hätten.
 */
function auto_emotion_bewerbungen_fuer_position( $position_titel ) {
	if ( ! $position_titel ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_query'      => array(
				array(
					'key'   => '_bewerbung_position',
					'value' => $position_titel,
				),
			),
		)
	);
}

/**
 * Status-Pipeline wie bei gängigen Bewerbermanagement-Systemen
 * (Personio, Indeed & Co.): von "Neu" bis "Eingestellt"/"Abgesagt".
 */
function auto_emotion_bewerbung_status_labels() {
	return array(
		'neu'         => __( 'Neu', 'auto-emotion' ),
		'pruefung'    => __( 'In Prüfung', 'auto-emotion' ),
		'interview'   => __( 'Interview', 'auto-emotion' ),
		'angebot'     => __( 'Angebot', 'auto-emotion' ),
		'eingestellt' => __( 'Eingestellt', 'auto-emotion' ),
		'abgesagt'    => __( 'Abgesagt', 'auto-emotion' ),
	);
}

/**
 * Speichert Status, Sterne-Bewertung (0–5) und interne Notiz zu einer
 * Bewerbung – die eigentliche "Bewertung" der Bewerber, wie man sie von
 * Recruiting-Tools kennt. Bleibt intern, geht nie an den Bewerber raus.
 */
function auto_emotion_handle_bewerbung_bewerten() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_bewerten_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_bewerten_nonce'] ) ), 'auto_emotion_bewerbung_bewerten_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || 'bewerbung' !== $post->post_type ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' ) );
		exit;
	}

	$status     = isset( $_POST['ae_bewerbung_status'] ) ? sanitize_key( wp_unslash( $_POST['ae_bewerbung_status'] ) ) : 'neu';
	$bewertung  = isset( $_POST['ae_bewerbung_bewertung'] ) ? absint( $_POST['ae_bewerbung_bewertung'] ) : 0;
	$notiz      = isset( $_POST['ae_bewerbung_notiz'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_bewerbung_notiz'] ) ) : '';

	if ( ! array_key_exists( $status, auto_emotion_bewerbung_status_labels() ) ) {
		$status = 'neu';
	}
	$bewertung = min( 5, max( 0, $bewertung ) );

	update_post_meta( $post_id, '_bewerbung_status', $status );
	update_post_meta( $post_id, '_bewerbung_bewertung', $bewertung );
	update_post_meta( $post_id, '_bewerbung_notiz', $notiz );

	wp_safe_redirect( add_query_arg( 'gespeichert', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_bewerten', 'auto_emotion_handle_bewerbung_bewerten' );

/**
 * Verschiebt eine Bewerbung in den Papierkorb (reversibel).
 */
function auto_emotion_handle_bewerbung_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_bewerbung_id'] ) ? absint( $_GET['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_bewerbung_delete_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'bewerbung' === $post->post_type ) {
		wp_trash_post( $post_id );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_delete', 'auto_emotion_handle_bewerbung_delete' );
