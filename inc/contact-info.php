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

/**
 * Strukturierte Verkaufs-Öffnungszeiten je Wochentag (0 = Sonntag),
 * als echte Berechnungsgrundlage für den "Geöffnet/Geschlossen"-
 * Hinweis im Header - deckt sich 1:1 mit dem Text in
 * auto_emotion_contact('hours_sales') ("Mo–Fr 08:00–18:00 Uhr, Sa
 * 09:00–14:00 Uhr"). Bei einer Änderung der Öffnungszeiten im
 * Customizer muss diese Struktur manuell mitgepflegt werden, da der
 * Customizer-Wert ein freier Text ist.
 */
function auto_emotion_opening_hours() {
	return array(
		0 => null,
		1 => array( '08:00', '18:00' ),
		2 => array( '08:00', '18:00' ),
		3 => array( '08:00', '18:00' ),
		4 => array( '08:00', '18:00' ),
		5 => array( '08:00', '18:00' ),
		6 => array( '09:00', '14:00' ),
	);
}

/**
 * Ob der Autohaus-Verkauf laut den echten, hinterlegten
 * Öffnungszeiten gerade geöffnet hat - serverseitig in der
 * WordPress-Zeitzone berechnet, keine geschätzte/erfundene Angabe.
 */
function auto_emotion_is_open_now() {
	$hours = auto_emotion_opening_hours();
	$day   = (int) current_time( 'w' );

	if ( empty( $hours[ $day ] ) ) {
		return false;
	}

	$now = current_time( 'H:i' );

	return $now >= $hours[ $day ][0] && $now < $hours[ $day ][1];
}
