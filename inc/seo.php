<?php
/**
 * SEO-Grundgerüst: Meta Description, Open Graph, Twitter Card, Canonical.
 *
 * Bewusst ohne SEO-Plugin-Abhängigkeit umgesetzt. Sollte das Projekt
 * später Yoast/Rank Math o.ä. einsetzen, sind die hier registrierten
 * wp_head-Hooks zu deaktivieren, um doppelte Tags zu vermeiden.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_get_meta_description() {
	if ( is_singular() ) {
		$excerpt = get_the_excerpt();
		if ( $excerpt ) {
			return wp_strip_all_tags( $excerpt );
		}
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();
		if ( $description ) {
			return wp_strip_all_tags( $description );
		}
	}

	$tagline = get_bloginfo( 'description' );
	if ( $tagline ) {
		return $tagline;
	}

	return sprintf(
		/* translators: %s: site name */
		__( '%s – Ihr Autohaus.', 'auto-emotion' ),
		get_bloginfo( 'name' )
	);
}

function auto_emotion_get_og_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $image ) {
			return $image[0];
		}
	}

	return AUTO_EMOTION_URI . '/assets/images/hero-cupra-01.png';
}

function auto_emotion_get_canonical_url() {
	if ( is_front_page() ) {
		return home_url( '/' );
	}

	$canonical = wp_get_canonical_url();
	if ( $canonical ) {
		return $canonical;
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			return get_term_link( $term );
		}
	}

	if ( is_post_type_archive() ) {
		return get_post_type_archive_link( get_query_var( 'post_type' ) );
	}

	global $wp;
	return home_url( $wp->request );
}

function auto_emotion_meta_tags() {
	$description = auto_emotion_get_meta_description();
	$title       = wp_get_document_title();
	$url         = auto_emotion_get_canonical_url();
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<link rel="canonical" href="<?php echo esc_url( $url ); ?>">

	<meta property="og:locale" content="de_DE">
	<meta property="og:type" content="<?php echo is_singular( 'post' ) ? 'article' : 'website'; ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:image" content="<?php echo esc_url( auto_emotion_get_og_image() ); ?>">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
	<meta name="twitter:image" content="<?php echo esc_url( auto_emotion_get_og_image() ); ?>">
	<?php
}
add_action( 'wp_head', 'auto_emotion_meta_tags', 1 );

function auto_emotion_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $hints;
}
add_filter( 'wp_resource_hints', 'auto_emotion_resource_hints', 10, 2 );
