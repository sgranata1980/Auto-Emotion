<?php
/**
 * WooCommerce-Anbindung ans Theme. Ohne diese Datei rendern die
 * WooCommerce-Templates (Shop, Warenkorb, Kasse) zwar innerhalb von
 * get_header()/get_footer(), aber ohne Theme-Unterstützung nutzt
 * WooCommerce sein eigenes, generisches Standard-Stylesheet statt
 * unserem Design-System.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'auto_emotion_woocommerce_setup' );

/**
 * Eigenes .container statt WooCommerce-Standardwrapper, damit die
 * Shop-Seiten dieselbe Breite/Innenabstände wie der Rest der Seite
 * bekommen (Header/Footer liefern bereits <main><div class="container">).
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Generisches WooCommerce-Stylesheet abschalten – wir liefern die
 * nötigen Stile selbst in assets/css/main.css, damit Shop/Warenkorb/
 * Kasse zum Lamborghini-Style-Referenzdesign der übrigen Seite passen.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
