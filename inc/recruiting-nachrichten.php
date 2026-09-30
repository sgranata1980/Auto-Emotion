<?php
/**
 * Interne Team-Kommunikation: ein gemeinsames Nachrichten-Board für
 * alle Mitarbeiter mit Recruiting-Zugriff – z. B. um sich über eine
 * Bewerbung oder ein Suchprofil kurzzuschließen, ohne dafür E-Mail zu
 * brauchen. Bewusst kein 1:1-Chat, sondern eine geteilte Pinnwand –
 * einfacher zu bauen, passt zur kleinen Teamgröße.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_nachricht_cpt() {
	register_post_type(
		'nachricht',
		array(
			'labels'              => array(
				'name'          => __( 'Nachrichten', 'auto-emotion' ),
				'singular_name' => __( 'Nachricht', 'auto-emotion' ),
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
			'supports'            => array( 'editor', 'author' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_nachricht_cpt' );

function auto_emotion_nachrichten_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/nachrichten/?$', 'index.php?ae_staff_route=nachrichten', 'top' );
}
add_action( 'init', 'auto_emotion_nachrichten_rewrite_rules' );

function auto_emotion_maybe_flush_nachrichten_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_nachrichten_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_nachrichten_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_nachrichten_rewrite_rules', 20 );

function auto_emotion_nachrichten_template_redirect() {
	if ( 'nachrichten' !== get_query_var( 'ae_staff_route' ) ) {
		return;
	}

	auto_emotion_staff_require_login();

	$nachrichten = get_posts(
		array(
			'post_type'      => 'nachricht',
			'post_status'    => 'publish',
			'posts_per_page' => 100,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	$vorausgefuellt = '';
	if ( isset( $_GET['bewerbung_id'] ) ) {
		$bewerbung_id = absint( $_GET['bewerbung_id'] );
		$bewerbung    = get_post( $bewerbung_id );
		if ( $bewerbung && 'bewerbung' === $bewerbung->post_type ) {
			$vorausgefuellt = sprintf(
				/* translators: 1: Bewerber-Name, 2: Link zur Bewerbung */
				__( 'Zu Bewerbung "%1$s": %2$s' . "\n\n", 'auto-emotion' ),
				get_post_meta( $bewerbung_id, '_bewerbung_name', true ),
				home_url( '/mitarbeiter/bewerbungen/' . $bewerbung_id . '/' )
			);
		}
	} elseif ( isset( $_GET['suchprofil_id'] ) ) {
		$suchprofil_id = absint( $_GET['suchprofil_id'] );
		$suchprofil     = get_post( $suchprofil_id );
		if ( $suchprofil && 'suchprofil' === $suchprofil->post_type ) {
			$vorausgefuellt = sprintf(
				/* translators: 1: Positions-Titel, 2: Link zum Suchprofil */
				__( 'Zu Suchprofil "%1$s": %2$s' . "\n\n", 'auto-emotion' ),
				$suchprofil->post_title,
				home_url( '/mitarbeiter/recruiting/' . $suchprofil_id . '/' )
			);
		}
	}

	auto_emotion_render_template_part(
		'nachrichten.php',
		array(
			'auto_emotion_nachrichten'     => $nachrichten,
			'auto_emotion_vorausgefuellt'  => $vorausgefuellt,
		)
	);
	exit;
}
add_action( 'template_redirect', 'auto_emotion_nachrichten_template_redirect' );

function auto_emotion_handle_nachricht_senden() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_nachricht_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_nachricht_nonce'] ) ), 'auto_emotion_nachricht_senden' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$text = isset( $_POST['ae_nachricht_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_nachricht_text'] ) ) : '';

	if ( $text ) {
		wp_insert_post(
			array(
				'post_type'    => 'nachricht',
				'post_content' => $text,
				'post_title'   => wp_trim_words( $text, 8, '…' ),
				'post_status'  => 'publish',
				'post_author'  => get_current_user_id(),
			)
		);
		auto_emotion_nachricht_benachrichtigen( $text );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/nachrichten/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_nachricht_senden', 'auto_emotion_handle_nachricht_senden' );

/**
 * Benachrichtigt per E-Mail über eine neue interne Nachricht. Eine echte
 * WhatsApp-Zustellung bräuchte einen eigenen WhatsApp-Business-API- oder
 * Twilio-Zugang (Zugangsdaten, die es in diesem Projekt nicht gibt) –
 * E-Mail läuft dagegen bereits über die vorhandene wp_mail()-Konfiguration
 * und lässt sich auf praktisch jedem Handy sofort als Push-Benachrichtigung
 * empfangen (z. B. über die Mail-App oder eine Weiterleitungsregel zu
 * WhatsApp/Telegram, falls gewünscht).
 */
function auto_emotion_nachricht_benachrichtigen( $text ) {
	$empfaenger = auto_emotion_contact( 'email' );
	if ( ! $empfaenger ) {
		return;
	}

	$absender = wp_get_current_user()->display_name;
	$betreff  = sprintf( '[%1$s] Neue Nachricht von %2$s', get_bloginfo( 'name' ), $absender );
	$body     = $text . "\n\n---\n" . home_url( '/mitarbeiter/nachrichten/' );

	wp_mail( $empfaenger, $betreff, $body );
}

function auto_emotion_handle_nachricht_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_nachricht_id'] ) ? absint( $_GET['ae_nachricht_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_nachricht_delete_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'nachricht' === $post->post_type ) {
		wp_trash_post( $post_id );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/nachrichten/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_nachricht_delete', 'auto_emotion_handle_nachricht_delete' );
