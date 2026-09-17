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

	$wp_customize->add_section(
		'auto_emotion_contact',
		array(
			'title'    => __( 'Kontaktdaten', 'auto-emotion' ),
			'priority' => 31,
		)
	);

	$defaults = auto_emotion_contact_defaults();

	$contact_fields = array(
		'company'       => __( 'Firmenname', 'auto-emotion' ),
		'street'        => __( 'Straße & Hausnummer', 'auto-emotion' ),
		'postal_code'   => __( 'PLZ', 'auto-emotion' ),
		'city'          => __( 'Ort', 'auto-emotion' ),
		'phone'         => __( 'Telefon (Anzeige)', 'auto-emotion' ),
		'phone_href'    => __( 'Telefon (tel:-Link, z.B. +496987403340)', 'auto-emotion' ),
		'fax'           => __( 'Fax', 'auto-emotion' ),
		'email'         => __( 'E-Mail', 'auto-emotion' ),
		'hours_sales'   => __( 'Öffnungszeiten Verkauf', 'auto-emotion' ),
		'hours_service' => __( 'Öffnungszeiten Werkstatt', 'auto-emotion' ),
		'hrb'           => __( 'Handelsregister', 'auto-emotion' ),
		'vat_id'        => __( 'USt-IdNr.', 'auto-emotion' ),
		'management'    => __( 'Vertretungsberechtigte', 'auto-emotion' ),
		'instagram'     => __( 'Instagram-URL', 'auto-emotion' ),
		'facebook'      => __( 'Facebook-URL', 'auto-emotion' ),
	);

	foreach ( $contact_fields as $key => $label ) {
		$setting_id = 'ae_' . $key;

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $label,
				'section' => 'auto_emotion_contact',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'auto_emotion_customize_register' );
