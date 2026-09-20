<?php
/**
 * Scripts and styles.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_assets() {
	$main_deps = array( 'auto-emotion-style' );

	// Google Fonts nur nachladen, wenn per Cookie-Banner zugestimmt wurde
	// (überträgt sonst ungefragt die IP-Adresse an Google).
	$consent = isset( $_COOKIE['ae_consent'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ae_consent'] ) ) : '';
	if ( 'all' === $consent ) {
		wp_enqueue_style(
			'auto-emotion-fonts',
			'https://fonts.googleapis.com/css2?family=Archivo:wght@300;400;500;700;900&family=Open+Sans:wght@400&display=swap',
			array(),
			null
		);
		$main_deps[] = 'auto-emotion-fonts';
	}

	wp_enqueue_style( 'auto-emotion-tokens', AUTO_EMOTION_URI . '/assets/css/tokens.css', array(), AUTO_EMOTION_VERSION );
	wp_enqueue_style( 'auto-emotion-style', get_stylesheet_uri(), array( 'auto-emotion-tokens' ), AUTO_EMOTION_VERSION );
	wp_enqueue_style( 'auto-emotion-main', AUTO_EMOTION_URI . '/assets/css/main.css', $main_deps, AUTO_EMOTION_VERSION );
	wp_enqueue_script( 'auto-emotion-main', AUTO_EMOTION_URI . '/assets/js/main.js', array(), AUTO_EMOTION_VERSION, true );
	wp_enqueue_script( 'auto-emotion-cookie-banner', AUTO_EMOTION_URI . '/assets/js/cookie-banner.js', array(), AUTO_EMOTION_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'auto-emotion-chat', AUTO_EMOTION_URI . '/assets/js/chat-widget.js', array(), AUTO_EMOTION_VERSION, true );
	wp_localize_script(
		'auto-emotion-chat',
		'autoEmotionChat',
		array(
			'endpoint' => esc_url_raw( rest_url( 'auto-emotion/v1/chat' ) ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'auto_emotion_assets' );
