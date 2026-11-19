<?php
/**
 * Template Name: Ersatzteile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_service_seiten = auto_emotion_service_seiten();
get_template_part( 'template-parts/service-seite', null, array( 'seite' => $auto_emotion_service_seiten['ersatzteile'] ) );
?>

<?php
get_footer();
