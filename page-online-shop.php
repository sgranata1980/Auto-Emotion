<?php
/**
 * Template for the "online-shop" page (per WP-Slug-Template-
 * Hierarchie automatisch aktiv). Der echte Shop läuft jetzt über
 * WooCommerce unter /shop/ – diese Seite leitet dorthin weiter,
 * damit der bestehende Navigationseintrag "Online-Shop" nicht ins
 * Leere führt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_shop_url = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
wp_safe_redirect( $auto_emotion_shop_url, 301 );
exit;
