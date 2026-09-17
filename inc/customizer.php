<?php
/**
 * Theme Customizer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'auto_emotion_general',
		array(
			'title'    => __( 'Auto Emotion Einstellungen', 'auto-emotion' ),
			'priority' => 30,
		)
	);
}
add_action( 'customize_register', 'auto_emotion_customize_register' );
