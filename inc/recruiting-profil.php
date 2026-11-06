<?php
/**
 * "Mein Profil": eingeloggte Mitarbeiter können ihren Anzeigenamen,
 * ihre E-Mail-Adresse und ihr Passwort selbst ändern, ohne den Umweg
 * über wp-admin/profile.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_profil_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/profil/?$', 'index.php?ae_staff_route=profil', 'top' );
}
add_action( 'init', 'auto_emotion_profil_rewrite_rules' );

function auto_emotion_maybe_flush_profil_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_profil_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_profil_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_profil_rewrite_rules', 20 );

function auto_emotion_profil_template_redirect() {
	if ( 'profil' !== get_query_var( 'ae_staff_route' ) ) {
		return;
	}

	auto_emotion_staff_require_login();
	auto_emotion_render_template_part( 'profil.php', array() );
	exit;
}
add_action( 'template_redirect', 'auto_emotion_profil_template_redirect' );

function auto_emotion_handle_profil_speichern() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_profil_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_profil_nonce'] ) ), 'auto_emotion_profil_speichern' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$user_id = get_current_user_id();
	$name    = isset( $_POST['ae_profil_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_profil_name'] ) ) : '';
	$email   = isset( $_POST['ae_profil_email'] ) ? sanitize_email( wp_unslash( $_POST['ae_profil_email'] ) ) : '';

	$fehler = array();

	if ( ! $name ) {
		$fehler[] = 'name';
	}
	if ( ! is_email( $email ) ) {
		$fehler[] = 'email';
	} else {
		$vorhandener = get_user_by( 'email', $email );
		if ( $vorhandener && (int) $vorhandener->ID !== (int) $user_id ) {
			$fehler[] = 'email_vergeben';
		}
	}

	if ( $fehler ) {
		wp_safe_redirect( add_query_arg( 'profil_fehler', implode( ',', $fehler ), home_url( '/mitarbeiter/profil/' ) ) );
		exit;
	}

	wp_update_user(
		array(
			'ID'           => $user_id,
			'display_name' => $name,
			'user_email'   => $email,
		)
	);

	wp_safe_redirect( add_query_arg( 'profil_gespeichert', '1', home_url( '/mitarbeiter/profil/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_profil_speichern', 'auto_emotion_handle_profil_speichern' );

function auto_emotion_handle_profil_passwort() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_profil_passwort_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_profil_passwort_nonce'] ) ), 'auto_emotion_profil_passwort' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$user            = wp_get_current_user();
	$aktuelles_passwort = isset( $_POST['ae_passwort_aktuell'] ) ? (string) wp_unslash( $_POST['ae_passwort_aktuell'] ) : '';
	$neues_passwort     = isset( $_POST['ae_passwort_neu'] ) ? (string) wp_unslash( $_POST['ae_passwort_neu'] ) : '';
	$neues_passwort_wdh = isset( $_POST['ae_passwort_neu_wiederholen'] ) ? (string) wp_unslash( $_POST['ae_passwort_neu_wiederholen'] ) : '';

	if ( ! wp_check_password( $aktuelles_passwort, $user->user_pass, $user->ID ) ) {
		wp_safe_redirect( add_query_arg( 'passwort_fehler', 'aktuell', home_url( '/mitarbeiter/profil/' ) ) );
		exit;
	}

	if ( strlen( $neues_passwort ) < 8 || $neues_passwort !== $neues_passwort_wdh ) {
		wp_safe_redirect( add_query_arg( 'passwort_fehler', 'neu', home_url( '/mitarbeiter/profil/' ) ) );
		exit;
	}

	wp_set_password( $neues_passwort, $user->ID );

	// wp_set_password invalidiert die Session – Nutzer muss sich neu anmelden.
	wp_safe_redirect( home_url( '/mitarbeiter/?passwort_geaendert=1' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_profil_passwort', 'auto_emotion_handle_profil_passwort' );
