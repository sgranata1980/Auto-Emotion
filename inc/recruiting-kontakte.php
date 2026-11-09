<?php
/**
 * Adressbuch: interne Kontaktverwaltung für den Recruiting-Bereich –
 * z. B. Ansprechpartner bei Jobportalen, Personalvermittlern oder der
 * Arbeitsagentur. Kein CRM für Bewerber-Daten (die laufen weiterhin
 * ausschließlich über inc/recruiting-bewerbungen.php), sondern für die
 * eigenen Geschäftskontakte rund ums Recruiting.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_kontakt_cpt() {
	register_post_type(
		'kontakt',
		array(
			'labels'              => array(
				'name'          => __( 'Kontakte', 'auto-emotion' ),
				'singular_name' => __( 'Kontakt', 'auto-emotion' ),
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
add_action( 'init', 'auto_emotion_register_kontakt_cpt' );

function auto_emotion_kontakte_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/kontakte/?$', 'index.php?ae_staff_route=kontakte', 'top' );
	add_rewrite_rule( '^mitarbeiter/kontakte/neu/?$', 'index.php?ae_staff_route=kontakt_neu', 'top' );
	add_rewrite_rule( '^mitarbeiter/kontakte/([0-9]+)/?$', 'index.php?ae_staff_route=kontakt_bearbeiten&ae_staff_id=$matches[1]', 'top' );
}
add_action( 'init', 'auto_emotion_kontakte_rewrite_rules' );

function auto_emotion_maybe_flush_kontakte_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_kontakte_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_kontakte_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_kontakte_rewrite_rules', 20 );

function auto_emotion_kontakte_template_redirect() {
	$route = get_query_var( 'ae_staff_route' );

	if ( ! in_array( $route, array( 'kontakte', 'kontakt_neu', 'kontakt_bearbeiten' ), true ) ) {
		return;
	}

	auto_emotion_staff_require_login();

	if ( 'kontakte' === $route ) {
		$kontakte = get_posts(
			array(
				'post_type'      => 'kontakt',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		auto_emotion_render_template_part( 'kontakte.php', array( 'auto_emotion_kontakte' => $kontakte ) );
		exit;
	}

	if ( 'kontakt_neu' === $route ) {
		auto_emotion_render_template_part( 'kontakt-form.php', array( 'auto_emotion_kontakt_post' => null ) );
		exit;
	}

	if ( 'kontakt_bearbeiten' === $route ) {
		$id   = absint( get_query_var( 'ae_staff_id' ) );
		$post = get_post( $id );
		if ( ! $post || 'kontakt' !== $post->post_type ) {
			wp_safe_redirect( home_url( '/mitarbeiter/kontakte/' ) );
			exit;
		}
		auto_emotion_render_template_part( 'kontakt-form.php', array( 'auto_emotion_kontakt_post' => $post ) );
		exit;
	}
}
add_action( 'template_redirect', 'auto_emotion_kontakte_template_redirect' );

function auto_emotion_handle_kontakt_speichern() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_kontakt_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_kontakt_nonce'] ) ), 'auto_emotion_kontakt_speichern' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post_id = isset( $_POST['ae_kontakt_id'] ) ? absint( $_POST['ae_kontakt_id'] ) : 0;
	$name    = isset( $_POST['ae_kontakt_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_kontakt_name'] ) ) : '';

	if ( ! $name ) {
		wp_safe_redirect( home_url( '/mitarbeiter/kontakte/' ) );
		exit;
	}

	$post_data = array(
		'post_title'  => $name,
		'post_type'   => 'kontakt',
		'post_status' => 'publish',
	);

	if ( $post_id ) {
		$existing = get_post( $post_id );
		if ( ! $existing || 'kontakt' !== $existing->post_type ) {
			wp_safe_redirect( home_url( '/mitarbeiter/kontakte/' ) );
			exit;
		}
		$post_data['ID'] = $post_id;
		wp_update_post( $post_data );
	} else {
		$post_id = wp_insert_post( $post_data );
	}

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		$felder = array(
			'ae_kontakt_firma'   => '_kontakt_firma',
			'ae_kontakt_rolle'   => '_kontakt_rolle',
			'ae_kontakt_telefon' => '_kontakt_telefon',
			'ae_kontakt_email'   => '_kontakt_email',
			'ae_kontakt_notiz'   => '_kontakt_notiz',
		);
		foreach ( $felder as $feld_name => $meta_key ) {
			if ( isset( $_POST[ $feld_name ] ) ) {
				$wert = '_kontakt_notiz' === $meta_key ? sanitize_textarea_field( wp_unslash( $_POST[ $feld_name ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $feld_name ] ) );
				update_post_meta( $post_id, $meta_key, $wert );
			}
		}
	}

	wp_safe_redirect( home_url( '/mitarbeiter/kontakte/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_kontakt_speichern', 'auto_emotion_handle_kontakt_speichern' );

function auto_emotion_handle_kontakt_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_kontakt_id'] ) ? absint( $_GET['ae_kontakt_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_kontakt_delete_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'kontakt' === $post->post_type ) {
		wp_trash_post( $post_id );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/kontakte/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_kontakt_delete', 'auto_emotion_handle_kontakt_delete' );
