<?php
/**
 * Main template file (fallback).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_home() && ! is_front_page() ) {
	get_template_part( 'template-parts/blog-uebersicht' );
	get_footer();
	return;
}
?>

<?php if ( have_posts() ) : ?>
	<div class="story-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
	</div>

	<?php the_posts_pagination(); ?>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>

<?php
get_footer();
