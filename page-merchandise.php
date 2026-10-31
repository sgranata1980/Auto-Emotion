<?php
/**
 * Template for the "merchandise" page (per WP-Slug-Template-
 * Hierarchie automatisch aktiv). Merchandise ist jetzt eine
 * Produktkategorie im WooCommerce-Shop – diese Seite leitet dorthin
 * weiter, damit der bestehende Navigationseintrag "Merchandise"
 * nicht ins Leere führt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_merch_url = home_url( '/shop/' );
$auto_emotion_merch_term = get_term_by( 'slug', 'merchandise', 'product_cat' );
if ( $auto_emotion_merch_term && ! is_wp_error( $auto_emotion_merch_term ) ) {
	$auto_emotion_merch_link = get_term_link( $auto_emotion_merch_term );
	if ( ! is_wp_error( $auto_emotion_merch_link ) ) {
		$auto_emotion_merch_url = $auto_emotion_merch_link;
	}
}

wp_safe_redirect( $auto_emotion_merch_url, 301 );
exit;
