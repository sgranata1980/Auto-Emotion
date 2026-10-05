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

/**
 * Meta-Description-Überschreibungen je Seiten-Slug.
 *
 * Für Seiten, die per page-{slug}.php-Template gerendert werden (die
 * eigentliche Darstellung kommt also aus dem Theme, nicht aus dem in
 * der WP-Datenbank gespeicherten post_content): get_the_excerpt()
 * liest weiterhin den gespeicherten post_content, unabhängig vom
 * Template. Ohne diese Liste würde die Meta-Description z.B. weiter
 * einen längst ersetzten "... in Vorbereitung"-Platzhaltertext zeigen,
 * obwohl die Seite selbst schon echten Inhalt hat.
 */
function auto_emotion_meta_description_overrides() {
	return array(
		'unsere-kunden'                 => __( 'Familienunternehmen seit 2001 in Offenbach, ausgezeichnet als Nissan GT-R High Performance Center und CUPRA Specialist. Echte Kundenbewertungen bei Google.', 'auto-emotion' ),
		'ausbildung'                    => __( 'Ausbildung bei Auto Emotion in Offenbach: aktueller Stand, echte Ausbildungsberufe im Autohaus und wie Sie sich jetzt schon vormerken lassen.', 'auto-emotion' ),
		'tag-der-offenen-tuer'          => __( 'Tag der offenen Tür bei Auto Emotion in Offenbach: Showroom und Werkstatt ohne Terminzwang entdecken, Seat, Cupra und Nissan live erleben.', 'auto-emotion' ),
		'markenevents-probefahrt-tage'  => __( 'Markenevents und Probefahrt-Tage bei Auto Emotion: neue Seat-, Cupra- und Nissan-Modelle testen – Probefahrten auch unabhängig von Aktionstagen möglich.', 'auto-emotion' ),
		'kundenveranstaltungen'         => __( 'Kundenveranstaltungen bei Auto Emotion in Offenbach: persönliche Anlässe für unsere langjährigen Seat-, Cupra- und Nissan-Kunden.', 'auto-emotion' ),
		'events-schulungen'             => __( 'Events & Schulungen bei Auto Emotion: Tag der offenen Tür, Markenevents, Kundenveranstaltungen und Werkstatt-Schulungen im Überblick.', 'auto-emotion' ),
		'zubehoer-tuning'               => __( 'Original-Zubehör für Seat, Cupra und Nissan sowie individuelles Tuning – inklusive unseres CUPRA Formentor VZ Custom by ABT.', 'auto-emotion' ),
		'ersatzteile'                   => __( 'Original-Ersatzteile für Seat, Cupra und Nissan bei Auto Emotion in Offenbach – für die eigene Werkstatt und auf Anfrage als Einzelteil.', 'auto-emotion' ),
		'podcast'                       => __( 'Podcast bei Auto Emotion: aktuell nicht vorhanden. Einblicke aus Showroom und Werkstatt gibt es bereits auf Instagram und Facebook.', 'auto-emotion' ),
		'vlog'                          => __( 'Vlog bei Auto Emotion: aktuell nicht geplant. Videoinhalte aus Showroom und Werkstatt gibt es bereits auf Instagram und Facebook.', 'auto-emotion' ),
		'elektro-hybrid'                => __( 'Elektro- und Hybridmodelle von Seat, Cupra und Nissan bei Auto Emotion: aktuelle Förderung, Geschichte der E-Mobilität und häufige Fragen.', 'auto-emotion' ),
	);
}

function auto_emotion_get_meta_description() {
	// Zuerst prüfen: front-page.php rendert die Startseite unabhängig
	// vom Inhalt der als "Startseite" hinterlegten WP-Seite – die
	// Excerpt-Logik unten darf hier also nicht greifen, sonst können
	// fremde (ggf. vertrauliche) Seiteninhalte in die Meta-Description
	// der öffentlichen Startseite durchsickern.
	if ( is_front_page() ) {
		return __( 'Auto Emotion – Ihr Vertragshändler für Seat, Cupra und Nissan in Offenbach, für Frankfurt, Offenbach und Umgebung.', 'auto-emotion' );
	}

	if ( is_singular() ) {
		$overrides = auto_emotion_meta_description_overrides();
		$slug      = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $overrides[ $slug ] ) ) {
			return $overrides[ $slug ];
		}

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
	if ( ! is_front_page() && is_singular() && has_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $image ) {
			return $image[0];
		}
	}

	return AUTO_EMOTION_URI . '/assets/images/cupra-header-poster.jpg';
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
