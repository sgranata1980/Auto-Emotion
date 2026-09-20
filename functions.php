<?php
/**
 * Auto Emotion theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manche Nginx/PHP-FPM-Hosting-Setups reichen den Authorization-Header
 * nicht automatisch an PHP durch. Ohne diesen Fallback kommen
 * REST-API-Anmeldungen per Anwendungspasswort nie an (401
 * rest_not_logged_in), obwohl das Feature aktiv ist.
 */
if ( ! isset( $_SERVER['HTTP_AUTHORIZATION'] ) && isset( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) ) {
	$_SERVER['HTTP_AUTHORIZATION'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
}

if ( ! isset( $_SERVER['PHP_AUTH_USER'] ) && isset( $_SERVER['HTTP_AUTHORIZATION'] ) && 0 === stripos( $_SERVER['HTTP_AUTHORIZATION'], 'basic ' ) ) {
	$auto_emotion_basic_auth = base64_decode( substr( $_SERVER['HTTP_AUTHORIZATION'], 6 ) );
	if ( false !== $auto_emotion_basic_auth && false !== strpos( $auto_emotion_basic_auth, ':' ) ) {
		list( $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'] ) = explode( ':', $auto_emotion_basic_auth, 2 );
	}
}

define( 'AUTO_EMOTION_VERSION', '1.0.3' );
define( 'AUTO_EMOTION_DIR', get_template_directory() );
define( 'AUTO_EMOTION_URI', get_template_directory_uri() );

require AUTO_EMOTION_DIR . '/inc/contact-info.php';
require AUTO_EMOTION_DIR . '/inc/theme-setup.php';
require AUTO_EMOTION_DIR . '/inc/nav-walker.php';
require AUTO_EMOTION_DIR . '/inc/enqueue.php';
require AUTO_EMOTION_DIR . '/inc/customizer.php';
require AUTO_EMOTION_DIR . '/inc/cpt.php';
require AUTO_EMOTION_DIR . '/inc/seo.php';
require AUTO_EMOTION_DIR . '/inc/schema.php';
require AUTO_EMOTION_DIR . '/inc/recruiting.php';
require AUTO_EMOTION_DIR . '/inc/b2b.php';
require AUTO_EMOTION_DIR . '/inc/finance-trade-in.php';
require AUTO_EMOTION_DIR . '/inc/testdrive.php';
require AUTO_EMOTION_DIR . '/inc/chatbot.php';

/**
 * Emo-Avatar-Video ermitteln: Mediathek-Datei mit passendem Namen
 * (z.B. "emo-greeting.mp4" hochladen) schlägt den Customizer-Wert,
 * der wiederum das im Theme gebündelte Standardvideo schlägt. So
 * lässt sich das Video jederzeit per Mediathek-Upload austauschen,
 * ganz ohne Theme-Update.
 */
function auto_emotion_emo_video_url( $slug ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'title'          => 'emo-' . $slug . '.mp4',
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);
	if ( $query->have_posts() ) {
		$url = wp_get_attachment_url( $query->posts[0]->ID );
		if ( $url ) {
			return $url;
		}
	}

	$mod = get_theme_mod( 'ae_emo_' . $slug . '_video' );
	if ( $mod ) {
		return $mod;
	}

	return AUTO_EMOTION_URI . '/assets/videos/emo-' . $slug . '.mp4?ver=' . AUTO_EMOTION_VERSION;
}
