<?php
/**
 * Strukturierte Daten (JSON-LD).
 *
 * Nutzt ausschließlich real bestätigte Geschäftsdaten aus
 * inc/contact-info.php – keine erfundenen Bewertungen, Preise
 * oder Eigenschaften werden ausgezeichnet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_autodealer_schema() {
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'AutoDealer',
		'name'        => auto_emotion_contact( 'company' ),
		'url'         => home_url( '/' ),
		'telephone'   => auto_emotion_contact( 'phone_href' ),
		'email'       => auto_emotion_contact( 'email' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => auto_emotion_contact( 'street' ),
			'postalCode'      => auto_emotion_contact( 'postal_code' ),
			'addressLocality' => auto_emotion_contact( 'city' ),
			'addressCountry' => 'DE',
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '08:00',
				'closes'    => '18:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Saturday' ),
				'opens'     => '09:00',
				'closes'    => '14:00',
			),
		),
		'brand' => array(
			array( '@type' => 'Brand', 'name' => 'Cupra' ),
			array( '@type' => 'Brand', 'name' => 'Seat' ),
			array( '@type' => 'Brand', 'name' => 'Nissan' ),
		),
	);

	$sameas = array_filter(
		array(
			auto_emotion_contact( 'instagram' ),
			auto_emotion_contact( 'facebook' ),
		)
	);

	if ( $sameas ) {
		$schema['sameAs'] = array_values( $sameas );
	}

	if ( has_site_icon() ) {
		$schema['logo'] = get_site_icon_url();
	}

	return $schema;
}

function auto_emotion_website_schema() {
	return array(
		'@context' => 'https://schema.org',
		'@type'    => 'WebSite',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	);
}

function auto_emotion_output_schema() {
	$graph = array( auto_emotion_autodealer_schema() );

	if ( is_front_page() ) {
		$graph[] = auto_emotion_website_schema();
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'auto_emotion_output_schema', 2 );
