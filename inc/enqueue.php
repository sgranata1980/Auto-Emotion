<?php
/**
 * Scripts and styles.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_assets() {
	wp_enqueue_style( 'auto-emotion-style', get_stylesheet_uri(), array(), AUTO_EMOTION_VERSION );
	wp_enqueue_style( 'auto-emotion-main', AUTO_EMOTION_URI . '/assets/css/main.css', array( 'auto-emotion-style' ), AUTO_EMOTION_VERSION );
	wp_enqueue_script( 'auto-emotion-main', AUTO_EMOTION_URI . '/assets/js/main.js', array(), AUTO_EMOTION_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'auto_emotion_assets' );
