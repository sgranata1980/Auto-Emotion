<?php
/**
 * Post content template part.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( is_singular() ? '' : 'date-card' ); ?>>
	<?php if ( ! is_singular() ) : ?>
		<span class="date-card__date"><?php echo esc_html( get_the_date() ); ?></span>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="date-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();
		} else {
			the_excerpt();
		}
		?>
	</div>
</article>
