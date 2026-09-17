<?php
/**
 * Auto Emotion theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AUTO_EMOTION_VERSION', '0.1.0' );
define( 'AUTO_EMOTION_DIR', get_template_directory() );
define( 'AUTO_EMOTION_URI', get_template_directory_uri() );

require AUTO_EMOTION_DIR . '/inc/theme-setup.php';
require AUTO_EMOTION_DIR . '/inc/enqueue.php';
require AUTO_EMOTION_DIR . '/inc/customizer.php';
