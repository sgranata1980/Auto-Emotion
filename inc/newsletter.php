<?php
/**
 * Newsletter-Anmeldung im Footer: echtes Double-Opt-in (Pflicht nach
 * DSGVO/UWG für E-Mail-Werbung) statt eines bloßen "abgeschickt"-
 * Formulars ohne Bestätigung. Kein Drittanbieter-Versanddienst
 * angebunden (dafür fehlen Zugangsdaten) - Anmeldungen landen intern
 * als eigener Datensatz (im WP-Admin unter "Newsletter-Abos"
 * einsehbar) und werden bei Bestätigung zusätzlich per Mail gemeldet,
 * damit nichts übersehen wird.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_newsletter_cpt() {
	register_post_type(
		'newsletter_abo',
		array(
			'labels'              => array(
				'name'          => __( 'Newsletter-Abos', 'auto-emotion' ),
				'singular_name' => __( 'Newsletter-Abo', 'auto-emotion' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-email-alt',
			'capability_type'     => 'post',
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => array( 'title' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_newsletter_cpt' );

/**
 * Zeigt den Bestätigungsstatus als eigene Spalte in der
 * WP-Admin-Liste, damit auf einen Blick klar ist, welche Anmeldungen
 * tatsächlich bestätigt (= aktive Abonnenten) sind.
 */
function auto_emotion_newsletter_admin_columns( $columns ) {
	$columns['ae_status'] = __( 'Status', 'auto-emotion' );
	return $columns;
}
add_filter( 'manage_newsletter_abo_posts_columns', 'auto_emotion_newsletter_admin_columns' );

function auto_emotion_newsletter_admin_column_content( $column, $post_id ) {
	if ( 'ae_status' === $column ) {
		$status = get_post_meta( $post_id, '_newsletter_status', true );
		echo esc_html( 'bestaetigt' === $status ? __( 'Bestätigt', 'auto-emotion' ) : __( 'Wartet auf Bestätigung', 'auto-emotion' ) );
	}
}
add_action( 'manage_newsletter_abo_posts_custom_column', 'auto_emotion_newsletter_admin_column_content', 10, 2 );

/**
 * Schritt 1: Anmeldung über das Footer-Formular - legt einen
 * "wartet auf Bestätigung"-Datensatz an und verschickt die
 * Double-Opt-in-Mail mit Bestätigungslink. Noch kein aktives Abo.
 */
function auto_emotion_handle_newsletter_signup() {
	if ( ! isset( $_POST['auto_emotion_newsletter_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_newsletter_nonce'] ) ), 'auto_emotion_newsletter' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte Seite neu laden und erneut versuchen.', 'auto-emotion' ) );
	}

	$redirect_base = wp_get_referer() ?: home_url( '/' );

	// Honeypot: Für Menschen unsichtbares Feld, das leer bleiben muss.
	if ( ! empty( $_POST['auto_emotion_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'ok', $redirect_base ) );
		exit;
	}

	$email = isset( $_POST['newsletter_email'] ) ? sanitize_email( wp_unslash( $_POST['newsletter_email'] ) ) : '';

	if ( ! $email || ! is_email( $email ) || empty( $_POST['newsletter_dsgvo'] ) ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'fehler', $redirect_base ) );
		exit;
	}

	$existing_query = new WP_Query(
		array(
			'post_type'      => 'newsletter_abo',
			'post_status'    => 'publish',
			'title'          => $email,
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);
	$existing = $existing_query->have_posts() ? $existing_query->posts[0] : null;

	if ( $existing && 'bestaetigt' === get_post_meta( $existing->ID, '_newsletter_status', true ) ) {
		// Bereits aktives Abo - keine neue Bestätigungsmail nötig.
		wp_safe_redirect( add_query_arg( 'newsletter', 'bereits-abonniert', $redirect_base ) );
		exit;
	}

	$token = wp_generate_password( 32, false );

	if ( $existing ) {
		$post_id = $existing->ID;
	} else {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'newsletter_abo',
				'post_title'  => $email,
				'post_status' => 'publish',
			)
		);
	}

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'fehler', $redirect_base ) );
		exit;
	}

	update_post_meta( $post_id, '_newsletter_status', 'wartet' );
	update_post_meta( $post_id, '_newsletter_token', $token );
	update_post_meta( $post_id, '_newsletter_angemeldet_am', current_time( 'mysql' ) );

	$confirm_url = add_query_arg(
		array(
			'action' => 'auto_emotion_newsletter_confirm',
			'token'  => $token,
		),
		admin_url( 'admin-post.php' )
	);

	wp_mail(
		$email,
		__( 'Bitte bestätigen Sie Ihre Newsletter-Anmeldung – Auto Emotion', 'auto-emotion' ),
		sprintf(
			/* translators: %s: confirmation link */
			__( "Fast geschafft!\n\nBitte bestätigen Sie Ihre Anmeldung zum Auto Emotion Newsletter über diesen Link:\n%s\n\nFalls Sie sich nicht angemeldet haben, ignorieren Sie diese E-Mail einfach.", 'auto-emotion' ),
			$confirm_url
		)
	);

	wp_safe_redirect( add_query_arg( 'newsletter', 'bestaetigung-gesendet', $redirect_base ) );
	exit;
}
add_action( 'admin_post_auto_emotion_newsletter_signup', 'auto_emotion_handle_newsletter_signup' );
add_action( 'admin_post_nopriv_auto_emotion_newsletter_signup', 'auto_emotion_handle_newsletter_signup' );

/**
 * Schritt 2: Klick auf den Bestätigungslink aus der E-Mail - erst
 * jetzt wird aus der Anmeldung ein aktives Abo.
 */
function auto_emotion_handle_newsletter_confirm() {
	$token = isset( $_GET['token'] ) ? sanitize_text_field( wp_unslash( $_GET['token'] ) ) : '';

	$query = new WP_Query(
		array(
			'post_type'      => 'newsletter_abo',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_newsletter_token',
			'meta_value'     => $token,
			'no_found_rows'  => true,
		)
	);

	if ( ! $token || ! $query->have_posts() ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'fehler', home_url( '/' ) ) );
		exit;
	}

	$post_id = $query->posts[0]->ID;

	update_post_meta( $post_id, '_newsletter_status', 'bestaetigt' );
	update_post_meta( $post_id, '_newsletter_bestaetigt_am', current_time( 'mysql' ) );
	delete_post_meta( $post_id, '_newsletter_token' );

	wp_mail(
		auto_emotion_contact( 'email' ),
		__( 'Neuer bestätigter Newsletter-Abonnent', 'auto-emotion' ),
		sprintf(
			/* translators: %s: subscriber email */
			__( '%s hat die Newsletter-Anmeldung bestätigt.', 'auto-emotion' ),
			get_the_title( $post_id )
		)
	);

	wp_safe_redirect( add_query_arg( 'newsletter', 'bestaetigt', home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_newsletter_confirm', 'auto_emotion_handle_newsletter_confirm' );
add_action( 'admin_post_nopriv_auto_emotion_newsletter_confirm', 'auto_emotion_handle_newsletter_confirm' );
