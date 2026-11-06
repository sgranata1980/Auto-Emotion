<?php
/**
 * Template for single pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_service_seiten = auto_emotion_service_seiten();
$auto_emotion_seiten_slug    = get_post_field( 'post_name' );

if ( isset( $auto_emotion_service_seiten[ $auto_emotion_seiten_slug ] ) ) {
	get_template_part( 'template-parts/service-seite', null, array( 'seite' => $auto_emotion_service_seiten[ $auto_emotion_seiten_slug ] ) );
	get_footer();
	return;
}
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'template-parts/content' ); ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>
<?php endwhile; ?>

<?php
get_footer();
