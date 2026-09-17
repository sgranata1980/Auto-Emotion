<?php
/**
 * Theme support and navigation menus.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_setup() {
	load_theme_textdomain( 'auto-emotion', AUTO_EMOTION_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary' => __( 'Hauptmenü', 'auto-emotion' ),
			'footer'  => __( 'Footer-Menü', 'auto-emotion' ),
		)
	);
}
add_action( 'after_setup_theme', 'auto_emotion_setup' );

function auto_emotion_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'auto-emotion' ),
			'id'            => 'footer-1',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'auto_emotion_widgets_init' );
