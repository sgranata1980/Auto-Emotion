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
	update_post_meta( $post_id, '_bewerbung_herkunft', isset( $daten['herkunft'] ) ? $daten['herkunft'] : '' );
	auto_emotion_bewerbung_status_historie_eintrag_hinzufuegen( $post_id, 'neu' );

	$auto_emotion_dubletten = auto_emotion_bewerbung_dubletten_finden( $post_id, $daten['email'], $daten['telefon'] );
	if ( $auto_emotion_dubletten ) {
		update_post_meta( $post_id, '_bewerbung_dubletten', $auto_emotion_dubletten );
	}
}

/**
 * Sucht unter den bereits gespeicherten Bewerbungen nach möglichen
 * Dubletten (exakte E-Mail-Übereinstimmung oder auf Ziffern reduziertes
 * Telefon) – markiert sie nur zur Prüfung durch Kollegen, führt nie
 * automatisch Datensätze zusammen.
 */
function auto_emotion_bewerbung_dubletten_finden( $neue_id, $email, $telefon ) {
	$email_normalisiert   = $email ? strtolower( trim( $email ) ) : '';
	$telefon_normalisiert = $telefon ? preg_replace( '/\D+/', '', $telefon ) : '';

	if ( ! $email_normalisiert && ! $telefon_normalisiert ) {
		return array();
	}

	$andere_bewerbungen = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'exclude'        => array( $neue_id ),
		)
	);

	$treffer = array();
	foreach ( $andere_bewerbungen as $andere_id ) {
		$passt = false;

		if ( $email_normalisiert ) {
			$andere_email = strtolower( trim( get_post_meta( $andere_id, '_bewerbung_email', true ) ) );
			if ( $andere_email && $andere_email === $email_normalisiert ) {
				$passt = true;
			}
		}

		if ( ! $passt && $telefon_normalisiert ) {
			$andere_telefon = preg_replace( '/\D+/', '', get_post_meta( $andere_id, '_bewerbung_telefon', true ) );
			// Mind. 6 Ziffern, damit kurze/leere Reste nicht fälschlich matchen.
			if ( $andere_telefon && strlen( $andere_telefon ) >= 6 && $andere_telefon === $telefon_normalisiert ) {
				$passt = true;
			}
		}

		if ( $passt ) {
			$treffer[] = $andere_id;
		}
	}

	return $treffer;
}

/**
 * Protokolliert einen Statuswechsel einer Bewerbung mit Zeitpunkt und
 * Bearbeiter – wie man es von gängigen Bewerbermanagement-Systemen
 * kennt. Läuft auch beim Anlegen der Bewerbung (Status "neu") als
 * erster Eintrag.
 */
function auto_emotion_bewerbung_status_historie_eintrag_hinzufuegen( $post_id, $status ) {
	$historie = get_post_meta( $post_id, '_bewerbung_status_historie', true );
	if ( ! is_array( $historie ) ) {
		$historie = array();
	}

	$benutzer = wp_get_current_user();

	$historie[] = array(
		'status' => $status,
		'datum'  => current_time( 'mysql' ),
		'user'   => ( $benutzer && $benutzer->exists() ) ? $benutzer->display_name : __( 'Bewerber (online)', 'auto-emotion' ),
	);

	update_post_meta( $post_id, '_bewerbung_status_historie', $historie );
}

/**
 * Liefert den gespeicherten Statusverlauf einer Bewerbung (chronologisch,
 * ältester Eintrag zuerst).
 */
function auto_emotion_bewerbung_status_historie( $post_id ) {
	$historie = get_post_meta( $post_id, '_bewerbung_status_historie', true );
	return is_array( $historie ) ? $historie : array();
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
		$auto_emotion_filter_suche    = isset( $_GET['suche'] ) ? sanitize_text_field( wp_unslash( $_GET['suche'] ) ) : '';
		$auto_emotion_filter_tag      = isset( $_GET['tag'] ) ? sanitize_text_field( wp_unslash( $_GET['tag'] ) ) : '';
		$auto_emotion_filter_talentpool = ! empty( $_GET['talentpool'] );
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
		if ( $auto_emotion_filter_talentpool ) {
			$auto_emotion_meta_query[] = array(
				'key'   => '_bewerbung_talentpool',
				'value' => '1',
			);
		}
		if ( $auto_emotion_meta_query ) {
			$auto_emotion_query_args['meta_query'] = $auto_emotion_meta_query;
		}

		$auto_emotion_bewerbungen = get_posts( $auto_emotion_query_args );

		// Volltextsuche und Tag-Filter laufen bewusst in PHP statt per
		// meta_query: Tags liegen als serialisiertes Array vor, und bei der
		// überschaubaren Bewerbungsmenge eines einzelnen Autohauses ist ein
		// einfacher, korrekter Textvergleich der robustere Weg als eine
		// fehleranfällige LIKE-Suche auf serialisierten Daten.
		if ( $auto_emotion_filter_suche ) {
			$auto_emotion_suche_lower = mb_strtolower( $auto_emotion_filter_suche );
			$auto_emotion_bewerbungen = array_values(
				array_filter(
					$auto_emotion_bewerbungen,
					function ( $auto_emotion_b ) use ( $auto_emotion_suche_lower ) {
						$auto_emotion_heuhaufen = mb_strtolower(
							implode(
								' ',
								array_filter(
									array(
										get_post_meta( $auto_emotion_b->ID, '_bewerbung_name', true ),
										get_post_meta( $auto_emotion_b->ID, '_bewerbung_position', true ),
										get_post_meta( $auto_emotion_b->ID, '_bewerbung_email', true ),
										get_post_meta( $auto_emotion_b->ID, '_bewerbung_telefon', true ),
										get_post_meta( $auto_emotion_b->ID, '_bewerbung_notiz', true ),
										implode( ' ', auto_emotion_bewerbung_tags( $auto_emotion_b->ID ) ),
									)
								)
							)
						);
						return false !== mb_strpos( $auto_emotion_heuhaufen, $auto_emotion_suche_lower );
					}
				)
			);
		}

		if ( $auto_emotion_filter_tag ) {
			$auto_emotion_bewerbungen = array_values(
				array_filter(
					$auto_emotion_bewerbungen,
					function ( $auto_emotion_b ) use ( $auto_emotion_filter_tag ) {
						return in_array( $auto_emotion_filter_tag, auto_emotion_bewerbung_tags( $auto_emotion_b->ID ), true );
					}
				)
			);
		}

		$auto_emotion_view = isset( $_GET['view'] ) && 'board' === $_GET['view'] ? 'board' : 'liste';

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
				'auto_emotion_filter_suche'     => $auto_emotion_filter_suche,
				'auto_emotion_filter_tag'       => $auto_emotion_filter_tag,
				'auto_emotion_filter_talentpool' => $auto_emotion_filter_talentpool,
				'auto_emotion_alle_tags'        => auto_emotion_alle_bewerbung_tags(),
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

function auto_emotion_bewerbung_status_label( $status ) {
	$labels = auto_emotion_bewerbung_status_labels();
	return isset( $labels[ $status ] ) ? $labels[ $status ] : $status;
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
	$termin_raw = isset( $_POST['ae_bewerbung_termin'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_bewerbung_termin'] ) ) : '';
	$tags_raw   = isset( $_POST['ae_bewerbung_tags'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_bewerbung_tags'] ) ) : '';

	if ( ! array_key_exists( $status, auto_emotion_bewerbung_status_labels() ) ) {
		$status = 'neu';
	}
	$bewertung = min( 5, max( 0, $bewertung ) );

	// Erwartet das Format eines <input type="datetime-local">
	// ("Y-m-d\TH:i") – bewusst ohne Zeitzonen-Umrechnung übernommen, wie
	// auch sonst in diesem Bereich (current_time('mysql')) lokale
	// Wanduhrzeit statt UTC gespeichert wird.
	$termin = '';
	if ( $termin_raw ) {
		$termin_obj = DateTime::createFromFormat( 'Y-m-d\TH:i', $termin_raw );
		if ( $termin_obj ) {
			$termin = $termin_obj->format( 'Y-m-d H:i:s' );
		}
	}

	// Frei definierbare Tags, kommagetrennt eingegeben ("Quereinsteiger,
	// mehrsprachig") – dedupliziert, leere Einträge raus, Reihenfolge der
	// Eingabe bleibt erhalten.
	$tags = array_values(
		array_unique(
			array_filter(
				array_map( 'trim', explode( ',', $tags_raw ) )
			)
		)
	);

	$alter_status = get_post_meta( $post_id, '_bewerbung_status', true );
	$alter_termin = get_post_meta( $post_id, '_bewerbung_termin', true );

	update_post_meta( $post_id, '_bewerbung_status', $status );
	update_post_meta( $post_id, '_bewerbung_bewertung', $bewertung );
	update_post_meta( $post_id, '_bewerbung_notiz', $notiz );
	update_post_meta( $post_id, '_bewerbung_termin', $termin );
	update_post_meta( $post_id, '_bewerbung_tags', $tags );

	if ( $termin !== $alter_termin ) {
		// Bei neuem/geändertem Termin darf die Erinnerungs-Mail für den
		// (neuen) Termin wieder verschickt werden.
		delete_post_meta( $post_id, '_bewerbung_termin_erinnerung_gesendet' );
	}

	if ( $status !== $alter_status ) {
		auto_emotion_bewerbung_status_historie_eintrag_hinzufuegen( $post_id, $status );
	}

	wp_safe_redirect( add_query_arg( 'gespeichert', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_bewerten', 'auto_emotion_handle_bewerbung_bewerten' );

/**
 * Frei definierbare Tags je Bewerbung (z. B. "Quereinsteiger",
 * "mehrsprachig", "Ausbildung gesucht") – lassen sich in der Liste
 * filtern und machen aus der reinen Status-Pipeline eine durchsuchbare,
 * frei organisierbare Bewerber-Datenbank.
 */
function auto_emotion_bewerbung_tags( $post_id ) {
	$tags = get_post_meta( $post_id, '_bewerbung_tags', true );
	return is_array( $tags ) ? $tags : array();
}

/**
 * Alle im System tatsächlich vergebenen Tags, alphabetisch – Grundlage
 * für Filter-Chips und Autovervollständigung, keine erfundene Liste.
 */
function auto_emotion_alle_bewerbung_tags() {
	$alle_ids = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	$tags = array();
	foreach ( $alle_ids as $id ) {
		foreach ( auto_emotion_bewerbung_tags( $id ) as $tag ) {
			$tags[ $tag ] = true;
		}
	}

	$tags = array_keys( $tags );
	natcasesort( $tags );
	return array_values( $tags );
}

/**
 * Initialen und eine dazu deterministische Farbe aus dem Namen – für
 * die Avatar-Kreise in Liste, Board und Detailansicht. Bewusst keine
 * echten Fotos (DSGVO-Datensparsamkeit, keine Foto-Upload-Funktion).
 */
function auto_emotion_initialen( $name ) {
	$teile = array_values( array_filter( preg_split( '/\s+/', trim( (string) $name ) ) ) );
	if ( empty( $teile ) ) {
		return '?';
	}
	$erster  = mb_substr( $teile[0], 0, 1 );
	$letzter = count( $teile ) > 1 ? mb_substr( end( $teile ), 0, 1 ) : '';
	return mb_strtoupper( $erster . $letzter );
}

function auto_emotion_avatar_farbe( $name ) {
	$palette = array( '#0071e3', '#8e44ad', '#16a085', '#d35400', '#c0392b', '#2c3e50', '#2980b9', '#27ae60' );
	$index   = abs( crc32( (string) $name ) ) % count( $palette );
	return $palette[ $index ];
}

/**
 * Team-Kommentare je Bewerbung: anders als die einzelne, bei jedem
 * Speichern überschreibbare "Interne Notiz" können hier mehrere
 * Kollegen nacheinander ihre Einschätzung hinterlassen – mit Name und
 * Zeitpunkt, wie der Meinungsaustausch im Team bei gängigen
 * Bewerbermanagement-Systemen.
 */
function auto_emotion_bewerbung_kommentare( $post_id ) {
	$kommentare = get_post_meta( $post_id, '_bewerbung_kommentare', true );
	return is_array( $kommentare ) ? $kommentare : array();
}

function auto_emotion_handle_bewerbung_kommentar_hinzufuegen() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_kommentar_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_kommentar_nonce'] ) ), 'auto_emotion_bewerbung_kommentar_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	$text = isset( $_POST['ae_kommentar_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_kommentar_text'] ) ) : '';

	if ( $post && 'bewerbung' === $post->post_type && $text ) {
		$kommentare   = auto_emotion_bewerbung_kommentare( $post_id );
		$benutzer     = wp_get_current_user();
		$kommentare[] = array(
			'text'    => $text,
			'user'    => $benutzer->display_name,
			'datum'   => current_time( 'mysql' ),
		);
		update_post_meta( $post_id, '_bewerbung_kommentare', $kommentare );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/#kommentare' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_kommentar_hinzufuegen', 'auto_emotion_handle_bewerbung_kommentar_hinzufuegen' );

function auto_emotion_handle_bewerbung_kommentar_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_bewerbung_id'] ) ? absint( $_GET['ae_bewerbung_id'] ) : 0;
	$index   = isset( $_GET['ae_kommentar_index'] ) ? absint( $_GET['ae_kommentar_index'] ) : -1;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_bewerbung_kommentar_delete_' . $post_id . '_' . $index ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$kommentare = auto_emotion_bewerbung_kommentare( $post_id );
	if ( isset( $kommentare[ $index ] ) ) {
		unset( $kommentare[ $index ] );
		update_post_meta( $post_id, '_bewerbung_kommentare', array_values( $kommentare ) );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/#kommentare' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_kommentar_delete', 'auto_emotion_handle_bewerbung_kommentar_delete' );

/**
 * Anstehende Vorstellungsgespräch-Termine, chronologisch aufsteigend –
 * Grundlage für die "Anstehende Termine"-Karte im Dashboard und für die
 * automatische Erinnerungs-Mail (siehe weiter unten).
 */
function auto_emotion_anstehende_termine( $limit = 5 ) {
	return get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'meta_key'       => '_bewerbung_termin',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_bewerbung_termin',
					'value'   => current_time( 'mysql' ),
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
			),
		)
	);
}

/**
 * Prüft täglich, ob für morgen ein Vorstellungsgespräch-Termin ansteht,
 * und schickt dafür einmalig eine Erinnerungs-Mail ans Team – die
 * "automatisierten Erinnerungen", die man von einem integrierten
 * Kalender in gängigen Recruiting-Tools kennt, hier ohne eigenen
 * Kalender-Dienst, nur mit dem bereits vorhandenen E-Mail-Versand.
 */
function auto_emotion_termin_erinnerung_cron() {
	$jetzt        = current_time( 'timestamp' ); // phpcs:ignore -- lokale Pseudo-Unix-Zeit wie an anderer Stelle in diesem Projekt verwendet.
	$morgen_start = gmdate( 'Y-m-d 00:00:00', $jetzt + DAY_IN_SECONDS );
	$morgen_ende  = gmdate( 'Y-m-d 23:59:59', $jetzt + DAY_IN_SECONDS );

	$bewerbungen = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => '_bewerbung_termin',
					'value'   => array( $morgen_start, $morgen_ende ),
					'compare' => 'BETWEEN',
					'type'    => 'DATETIME',
				),
				array(
					'key'     => '_bewerbung_termin_erinnerung_gesendet',
					'compare' => 'NOT EXISTS',
				),
			),
		)
	);

	$empfaenger = auto_emotion_contact( 'email' );

	foreach ( $bewerbungen as $bewerbung ) {
		if ( $empfaenger ) {
			$name     = get_post_meta( $bewerbung->ID, '_bewerbung_name', true );
			$position = get_post_meta( $bewerbung->ID, '_bewerbung_position', true );
			$termin   = get_post_meta( $bewerbung->ID, '_bewerbung_termin', true );

			$betreff = sprintf( '[Erinnerung] Vorstellungsgespräch morgen: %s', $name );
			$body    = sprintf(
				"Erinnerung: Morgen um %s Uhr ist das Vorstellungsgespräch mit %s (%s).\n\n%s",
				mysql2date( 'H:i', $termin ),
				$name,
				$position,
				home_url( '/mitarbeiter/bewerbungen/' . $bewerbung->ID . '/' )
			);

			wp_mail( $empfaenger, $betreff, $body );
		}

		update_post_meta( $bewerbung->ID, '_bewerbung_termin_erinnerung_gesendet', '1' );
	}
}
add_action( 'auto_emotion_termin_erinnerung_pruefen', 'auto_emotion_termin_erinnerung_cron' );

function auto_emotion_schedule_termin_erinnerung() {
	if ( ! wp_next_scheduled( 'auto_emotion_termin_erinnerung_pruefen' ) ) {
		wp_schedule_event( time(), 'daily', 'auto_emotion_termin_erinnerung_pruefen' );
	}
}
add_action( 'init', 'auto_emotion_schedule_termin_erinnerung' );

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

/**
 * Talent-Pool: eine Bewerbung kann unabhängig vom Pipeline-Status (auch
 * nach "Abgesagt") als für später interessant markiert werden – mit
 * Zweck und optionaler Frist. Ersetzt nicht den Status, sondern liegt
 * quer dazu (siehe Momenti-Review: "Eine Bewerbung darf historisch
 * abgeschlossen bleiben, während der Kandidat zusätzlich im Talent Pool
 * liegt").
 */
function auto_emotion_bewerbung_im_talentpool( $post_id ) {
	return (bool) get_post_meta( $post_id, '_bewerbung_talentpool', true );
}

function auto_emotion_handle_bewerbung_talentpool() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_talentpool_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_talentpool_nonce'] ) ), 'auto_emotion_bewerbung_talentpool_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || 'bewerbung' !== $post->post_type ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' ) );
		exit;
	}

	$aktiv  = ! empty( $_POST['ae_talentpool_aktiv'] );
	$zweck  = isset( $_POST['ae_talentpool_zweck'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_talentpool_zweck'] ) ) : '';
	$frist  = isset( $_POST['ae_talentpool_frist'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_talentpool_frist'] ) ) : '';

	// Erwartet das Format eines <input type="date"> ("Y-m-d").
	$frist_valide = '';
	if ( $frist ) {
		$frist_obj = DateTime::createFromFormat( 'Y-m-d', $frist );
		if ( $frist_obj ) {
			$frist_valide = $frist_obj->format( 'Y-m-d' );
		}
	}

	update_post_meta( $post_id, '_bewerbung_talentpool', $aktiv ? '1' : '' );
	update_post_meta( $post_id, '_bewerbung_talentpool_zweck', $zweck );
	update_post_meta( $post_id, '_bewerbung_talentpool_frist', $frist_valide );

	wp_safe_redirect( add_query_arg( 'talentpool_gespeichert', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_talentpool', 'auto_emotion_handle_bewerbung_talentpool' );

/**
 * DSGVO-Löschantrag: anders als "In den Papierkorb" (reversibel, erst
 * nach 30 Tagen endgültig) löscht dies Bewerbung samt Unterlagen SOFORT
 * und UNWIDERRUFLICH – für den Fall, dass ein Bewerber ausdrücklich die
 * sofortige Löschung verlangt (DSGVO Art. 17). Protokolliert den
 * Vorgang datensparsam (Datum, bearbeitende Person, Position) – bewusst
 * ohne Name/E-Mail/Telefon der gelöschten Person, damit das Protokoll
 * selbst keine personenbezogenen Daten konserviert, die eigentlich
 * gelöscht werden sollten.
 */
function auto_emotion_dsgvo_loeschlog() {
	$log = get_option( 'auto_emotion_dsgvo_loeschlog', array() );
	return is_array( $log ) ? $log : array();
}

function auto_emotion_handle_bewerbung_dsgvo_loeschen() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_bewerbung_id'] ) ? absint( $_GET['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_bewerbung_dsgvo_loeschen_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'bewerbung' === $post->post_type ) {
		$position = get_post_meta( $post_id, '_bewerbung_position', true );

		// Löst before_delete_post aus, das die hochgeladenen Dateien von
		// der Festplatte entfernt (siehe auto_emotion_delete_bewerbung_dateien
		// weiter oben in dieser Datei) – true = kein Papierkorb, sofort
		// endgültig.
		wp_delete_post( $post_id, true );

		$log   = auto_emotion_dsgvo_loeschlog();
		$log[] = array(
			'datum'      => current_time( 'mysql' ),
			'bearbeiter' => wp_get_current_user()->display_name,
			'position'   => $position,
		);
		// Nur die letzten 100 Einträge behalten – ein Protokoll über
		// erledigte Löschungen, kein unbegrenzt wachsendes Archiv.
		$log = array_slice( $log, -100 );
		update_option( 'auto_emotion_dsgvo_loeschlog', $log, false );
	}

	wp_safe_redirect( add_query_arg( 'dsgvo_geloescht', '1', home_url( '/mitarbeiter/bewerbungen/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_dsgvo_loeschen', 'auto_emotion_handle_bewerbung_dsgvo_loeschen' );
