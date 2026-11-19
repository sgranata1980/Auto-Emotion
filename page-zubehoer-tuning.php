<?php
/**
 * Template Name: Zubehör & Tuning
 *
 * Tuning-Kompetenz nicht behauptet, sondern mit echtem Beleg
 * verlinkt: dem live auf der Angebote-Seite stehenden CUPRA
 * Formentor VZ Custom by ABT.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_service_seiten = auto_emotion_service_seiten();
get_template_part( 'template-parts/service-seite', null, array( 'seite' => $auto_emotion_service_seiten['zubehoer-tuning'] ) );
?>

<?php
get_footer();
