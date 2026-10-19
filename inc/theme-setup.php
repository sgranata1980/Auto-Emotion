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

/**
 * Site-Icon (Browser-Tab-Favicon) einmalig auf das echte Auto-Emotion-
 * Logo setzen, statt des WordPress-Standard-"W", das vorher im Tab
 * zu sehen war. Läuft nur, solange noch kein Site-Icon gesetzt ist -
 * ein späteres eigenes Icon über Design > Customizer > Website-Icon
 * wird dadurch nie überschrieben.
 */
function auto_emotion_set_default_site_icon() {
	if ( get_option( 'auto_emotion_site_icon_set' ) || get_option( 'site_icon' ) ) {
		return;
	}

	$file_path = AUTO_EMOTION_DIR . '/assets/images/logo-icon-red.png';

	if ( ! file_exists( $file_path ) ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$filetype = wp_check_filetype( basename( $file_path ), null );
	$upload   = wp_upload_bits( basename( $file_path ), null, file_get_contents( $file_path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- lokale Theme-Datei, kein Remote-Request.

	if ( ! empty( $upload['error'] ) ) {
		return;
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'      => 'Auto Emotion Site Icon',
			'post_status'     => 'inherit',
		),
		$upload['file']
	);

	if ( ! $attachment_id || is_wp_error( $attachment_id ) ) {
		return;
	}

	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );
	update_option( 'site_icon', $attachment_id );
	update_option( 'auto_emotion_site_icon_set', '1' );
}
add_action( 'init', 'auto_emotion_set_default_site_icon', 20 );

/**
 * Seiteninhalte werden ausschließlich als fertiges HTML gepflegt (nie über
 * den klassischen Editor), Absätze stehen also immer schon explizit in
 * eigenen <p>-Tags. wpautop zerschießt dabei verschachteltes Markup wie
 * <div>-Karten mit <img> (fügt </p> ohne öffnendes <p> ein), sobald
 * Block-Elemente ohne Leerzeilen aufeinanderfolgen.
 */
remove_filter( 'the_content', 'wpautop' );

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
