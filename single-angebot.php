<?php
/**
 * Single template for the "Angebot" post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class(); ?>>
		<header class="entry-header">
			<?php
			$auto_emotion_marken = get_the_terms( get_the_ID(), 'marke' );
			if ( $auto_emotion_marken && ! is_wp_error( $auto_emotion_marken ) ) :
				?>
				<span class="story-grid__date"><?php echo esc_html( $auto_emotion_marken[0]->name ); ?></span>
			<?php endif; ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>

		<a class="btn btn-giallo" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php esc_html_e( 'Jetzt anfragen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</article>
<?php endwhile; ?>

<?php
get_footer();
