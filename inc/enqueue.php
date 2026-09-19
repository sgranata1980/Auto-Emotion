<?php
/**
 * Scripts and styles.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_assets() {
	wp_enqueue_style(
		'auto-emotion-fonts',
		'https://fonts.googleapis.com/css2?family=Archivo:wght@300;400;500;700;900&family=Open+Sans:wght@400&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'auto-emotion-tokens', AUTO_EMOTION_URI . '/assets/css/tokens.css', array(), AUTO_EMOTION_VERSION );
	wp_enqueue_style( 'auto-emotion-style', get_stylesheet_uri(), array( 'auto-emotion-tokens' ), AUTO_EMOTION_VERSION );
	wp_enqueue_style( 'auto-emotion-main', AUTO_EMOTION_URI . '/assets/css/main.css', array( 'auto-emotion-style', 'auto-emotion-fonts' ), AUTO_EMOTION_VERSION );
	wp_enqueue_script( 'auto-emotion-main', AUTO_EMOTION_URI . '/assets/js/main.js', array(), AUTO_EMOTION_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( function_exists( 'auto_emotion_chat_is_configured' ) && auto_emotion_chat_is_configured() ) {
		wp_enqueue_script( 'auto-emotion-chat', AUTO_EMOTION_URI . '/assets/js/chat-widget.js', array(), AUTO_EMOTION_VERSION, true );
		wp_localize_script(
			'auto-emotion-chat',
			'autoEmotionChat',
			array(
				'endpoint' => esc_url_raw( rest_url( 'auto-emotion/v1/chat' ) ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'auto_emotion_assets' );
