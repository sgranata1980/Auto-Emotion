<?php
/**
 * Zentrale Geschäfts-/Kontaktdaten.
 *
 * Standardwerte entsprechen den öffentlich auf auto-emotion.de
 * veröffentlichten Angaben (Impressum/Datenschutz, Stand: 2026-09-17).
 * Über Design > Customizer > Kontaktdaten im WP-Admin überschreibbar,
 * ohne dass Theme-Code angefasst werden muss.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_contact_defaults() {
	return array(
		'company'       => 'Auto Emotion GmbH & Co. KG',
		'street'        => 'Sprendlinger Landstr. 166',
		'postal_code'   => '63069',
		'city'          => 'Offenbach',
		'country'       => 'Deutschland',
		'phone'         => '069 8740334-0',
		'phone_href'    => '+496987403340',
		'fax'           => '069 8740334-39',
		'email'         => 'info@auto-emotion.de',
		'hours_sales'   => 'Mo–Fr 08:00–18:00 Uhr, Sa 09:00–14:00 Uhr',
		'hours_service' => 'Mo–Fr 07:30–18:00 Uhr, Sa 09:00–13:00 Uhr',
		'hrb'           => 'Amtsgericht Offenbach, HRB 40543',
		'vat_id'        => 'DE244324242',
		'management'    => 'Donato Cisternino, Agostino Cisternino',
		'instagram'     => 'https://www.instagram.com/autoemotion_offenbach/',
		'facebook'      => 'https://www.facebook.com/AutoEmotionOF',
	);
}

/**
 * Liest einen Kontaktdaten-Wert, mit Customizer-Override.
 */
function auto_emotion_contact( $key ) {
	$defaults = auto_emotion_contact_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	return get_theme_mod( 'ae_' . $key, $default );
}
