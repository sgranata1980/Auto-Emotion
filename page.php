<?php
/**
 * Template for single pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'template-parts/content' ); ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>
<?php endwhile; ?>

<?php
get_footer();
