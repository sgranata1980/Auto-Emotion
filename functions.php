<?php
/**
 * Auto Emotion theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AUTO_EMOTION_VERSION', '0.3.2' );
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
