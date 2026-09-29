<?php
/**
 * Recruiting-Backend: eigenständiger Mitarbeiterbereich unter /mitarbeiter/
 * für "Suchprofile" – Positionen, die Auto Emotion aktiv besetzen möchte,
 * mit fertigen Such-Links für LinkedIn, Xing & Co.
 *
 * Bewusst KEIN wp-admin-Bereich: eigene Login-Seite, eigenes Dashboard,
 * eigenes Design – nicht die WordPress-Optik. Technisch läuft es über
 * dieses Theme (eigene Rewrite-Routen + eigene Templates), aber ohne
 * jede sichtbare WordPress-Oberfläche.
 *
 * Bewusst ohne Speicherung von Bewerber-Daten: hier werden nur die
 * eigenen Such-Kriterien des Unternehmens gepflegt, nie Kandidaten-
 * Datensätze. Die bestehende E-Mail-only-Bewerbungsstrecke
 * (inc/recruiting.php) bleibt davon komplett unberührt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Eigene, klar benannte Berechtigung statt der generischen "kann
 * Inhalte bearbeiten"-Fähigkeit – Zugriff auf den Recruiting-Bereich
 * ist dadurch unabhängig von sonstigen Redaktionsrechten auf der
 * Website steuerbar. Wird automatisch an Administrator und Redakteur
 * vergeben; weitere Nutzer erhalten sie, indem man ihnen die Rolle
 * "Redakteur" gibt, oder gezielt einzeln über die Nutzerverwaltung.
 */
function auto_emotion_grant_recruiting_capability() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_recruiting_cap_version' ) === $needed_version ) {
		return;
	}

	foreach ( array( 'administrator', 'editor' ) as $role_name ) {
		$role = get_role( $role_name );
		if ( $role ) {
			$role->add_cap( 'ae_recruiting_zugriff' );
		}
	}

	update_option( 'auto_emotion_recruiting_cap_version', $needed_version );
}
add_action( 'init', 'auto_emotion_grant_recruiting_capability' );

/**
 * Custom Post Type als reiner Datenspeicher für Suchprofile – kein
 * wp-admin-UI, keine öffentliche URL, kein Archiv.
 */
function auto_emotion_register_suchprofil_cpt() {
	register_post_type(
		'suchprofil',
		array(
			'labels'             => array(
				'name'          => __( 'Suchprofile', 'auto-emotion' ),
				'singular_name' => __( 'Suchprofil', 'auto-emotion' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'  => false,
			'show_in_admin_bar'  => false,
			'show_in_rest'       => false,
			'show_ui'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'rewrite'            => false,
			'supports'           => array( 'title' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_suchprofil_cpt' );

/**
 * Reine Such-Links (keine Datenabfrage, keine Kandidaten-Daten) für
 * LinkedIn, Xing und eine Google-X-Ray-Suche aus Titel, Stichworten und
 * Standort eines Suchprofils.
 */
function auto_emotion_suchprofil_links( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		return array();
	}

	$standort   = get_post_meta( $post_id, '_suchprofil_standort', true );
	$stichworte = get_post_meta( $post_id, '_suchprofil_stichworte', true );
	$suchbegriffe = trim( $post->post_title . ' ' . $stichworte );

	if ( ! $suchbegriffe ) {
		return array();
	}

	return array(
		'linkedin' => array(
			'label' => __( 'LinkedIn – Personensuche', 'auto-emotion' ),
			'url'   => add_query_arg(
				array(
					'keywords' => rawurlencode( $suchbegriffe ),
					'location' => $standort ? rawurlencode( $standort ) : false,
				),
				'https://www.linkedin.com/search/results/people/'
			),
		),
		'xing'     => array(
			'label' => __( 'Xing – Mitgliedersuche', 'auto-emotion' ),
			'url'   => add_query_arg(
				array( 'keywords' => rawurlencode( $suchbegriffe ) ),
				'https://www.xing.com/search/members'
			),
		),
		'google'   => array(
			'label' => __( 'Google X-Ray-Suche (LinkedIn-Profile)', 'auto-emotion' ),
			'url'   => 'https://www.google.com/search?q=' . rawurlencode(
				'site:linkedin.com/in ' . $suchbegriffe . ( $standort ? ' ' . $standort : '' )
			),
		),
	);
}

/**
 * Eigene Rewrite-Routen unter /mitarbeiter/ – bewusst ohne
 * WordPress-Seiten/Templates im üblichen Sinn, damit der Bereich sich
 * wie eine eigenständige Anwendung anfühlt, nicht wie eine WP-Seite.
 */
function auto_emotion_recruiting_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/?$', 'index.php?ae_staff_route=login', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/?$', 'index.php?ae_staff_route=dashboard', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/neu/?$', 'index.php?ae_staff_route=neu', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/([0-9]+)/?$', 'index.php?ae_staff_route=bearbeiten&ae_staff_id=$matches[1]', 'top' );
}
add_action( 'init', 'auto_emotion_recruiting_rewrite_rules' );

function auto_emotion_recruiting_query_vars( $vars ) {
	$vars[] = 'ae_staff_route';
	$vars[] = 'ae_staff_id';
	return $vars;
}
add_filter( 'query_vars', 'auto_emotion_recruiting_query_vars' );

/**
 * Rewrite-Regeln ändern sich nur mit Theme-Updates, nicht bei jedem
 * Request – ohne wp-admin-Zugriff kann hier niemand manuell auf
 * "Permalinks speichern" klicken, daher automatischer Flush bei
 * Versionswechsel.
 */
function auto_emotion_maybe_flush_recruiting_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_staff_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_staff_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_recruiting_rewrite_rules', 20 );

/**
 * Zugriffsschutz: nur eingeloggte Mitarbeiter mit Bearbeitungsrecht
 * dürfen Dashboard/Formulare sehen, alle anderen landen beim Login.
 */
function auto_emotion_staff_require_login() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}
}

function auto_emotion_render_template_part( $relative_path, $vars = array() ) {
	extract( $vars ); // phpcs:ignore -- gezielt für die drei bekannten Template-Variablen dieser Datei.
	include AUTO_EMOTION_DIR . '/template-parts/recruiting/' . $relative_path;
}

/**
 * Router für die /mitarbeiter/-Routen. Gibt komplett eigenständiges
 * HTML aus (kein get_header()/get_footer(), keine WP-Theme-Chrome).
 */
function auto_emotion_recruiting_template_redirect() {
	$route = get_query_var( 'ae_staff_route' );

	if ( ! $route ) {
		return;
	}

	switch ( $route ) {

		case 'login':
			if ( is_user_logged_in() && current_user_can( 'ae_recruiting_zugriff' ) ) {
				wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
				exit;
			}
			$auto_emotion_login_error = isset( $_GET['login_failed'] );
			auto_emotion_render_template_part( 'login.php', array( 'auto_emotion_login_error' => $auto_emotion_login_error ) );
			exit;

		case 'dashboard':
			auto_emotion_staff_require_login();
			$auto_emotion_profiles = get_posts(
				array(
					'post_type'      => 'suchprofil',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				)
			);
			auto_emotion_render_template_part( 'dashboard.php', array( 'auto_emotion_profiles' => $auto_emotion_profiles ) );
			exit;

		case 'neu':
			auto_emotion_staff_require_login();
			auto_emotion_render_template_part( 'form.php', array( 'auto_emotion_form_post' => null ) );
			exit;

		case 'bearbeiten':
			auto_emotion_staff_require_login();
			$auto_emotion_id   = absint( get_query_var( 'ae_staff_id' ) );
			$auto_emotion_post = get_post( $auto_emotion_id );
			if ( ! $auto_emotion_post || 'suchprofil' !== $auto_emotion_post->post_type ) {
				wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
				exit;
			}
			auto_emotion_render_template_part( 'form.php', array( 'auto_emotion_form_post' => $auto_emotion_post ) );
			exit;
	}
}
add_action( 'template_redirect', 'auto_emotion_recruiting_template_redirect' );

/**
 * Login-Handler: authentifiziert gegen die bestehenden WordPress-
 * Benutzerkonten (wp_signon) – kein separates Zugangssystem nötig.
 */
function auto_emotion_handle_recruiting_login() {
	if ( ! isset( $_POST['auto_emotion_recruiting_login_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_recruiting_login_nonce'] ) ), 'auto_emotion_recruiting_login' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/?login_failed=1' ) );
		exit;
	}

	$creds = array(
		'user_login'    => isset( $_POST['ae_login_user'] ) ? sanitize_user( wp_unslash( $_POST['ae_login_user'] ) ) : '',
		'user_password' => isset( $_POST['ae_login_pass'] ) ? (string) wp_unslash( $_POST['ae_login_pass'] ) : '',
		'remember'      => true,
	);

	$user = wp_signon( $creds, is_ssl() );

	if ( is_wp_error( $user ) || ! user_can( $user, 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/?login_failed=1' ) );
		exit;
	}

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
	exit;
}
add_action( 'admin_post_nopriv_auto_emotion_recruiting_login', 'auto_emotion_handle_recruiting_login' );
add_action( 'admin_post_auto_emotion_recruiting_login', 'auto_emotion_handle_recruiting_login' );

function auto_emotion_handle_recruiting_logout() {
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_recruiting_logout' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	wp_logout();
	wp_safe_redirect( home_url( '/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_recruiting_logout', 'auto_emotion_handle_recruiting_logout' );

/**
 * Speichert ein Suchprofil (neu oder bestehend).
 */
function auto_emotion_handle_recruiting_save() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_recruiting_save_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_recruiting_save_nonce'] ) ), 'auto_emotion_recruiting_save' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte zurückgehen und erneut versuchen.', 'auto-emotion' ) );
	}

	$post_id = isset( $_POST['ae_profile_id'] ) ? absint( $_POST['ae_profile_id'] ) : 0;
	$titel   = isset( $_POST['ae_titel'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_titel'] ) ) : '';

	if ( ! $titel ) {
		wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
		exit;
	}

	$post_data = array(
		'post_title'  => $titel,
		'post_type'   => 'suchprofil',
		'post_status' => 'publish',
	);

	if ( $post_id ) {
		$existing = get_post( $post_id );
		if ( ! $existing || 'suchprofil' !== $existing->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
			exit;
		}
		$post_data['ID'] = $post_id;
		wp_update_post( $post_data );
	} else {
		$post_id = wp_insert_post( $post_data );
	}

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		$felder = array(
			'ae_standort'       => '_suchprofil_standort',
			'ae_anstellungsart' => '_suchprofil_anstellungsart',
			'ae_status'         => '_suchprofil_status',
			'ae_stichworte'     => '_suchprofil_stichworte',
		);
		foreach ( $felder as $feld_name => $meta_key ) {
			if ( isset( $_POST[ $feld_name ] ) ) {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $feld_name ] ) ) );
			}
		}
	}

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_recruiting_save', 'auto_emotion_handle_recruiting_save' );

/**
 * Verschiebt ein Suchprofil in den Papierkorb (reversibel, kein
 * endgültiges Löschen).
 */
function auto_emotion_handle_recruiting_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_profile_id'] ) ? absint( $_GET['ae_profile_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_recruiting_delete_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'suchprofil' === $post->post_type && current_user_can( 'edit_post', $post_id ) ) {
		wp_trash_post( $post_id );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_recruiting_delete', 'auto_emotion_handle_recruiting_delete' );

/**
 * Sichtbarer, aber schlichter Einstiegspunkt im Footer – führt zur
 * eigenen Login-Seite des Mitarbeiterbereichs (nicht wp-login.php).
 */
function auto_emotion_staff_login_url() {
	return home_url( '/mitarbeiter/' );
}
