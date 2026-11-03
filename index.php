<?php
/**
 * Main template file (fallback).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_home() && ! is_front_page() ) {
	echo '</div>';
	get_template_part(
		'template-parts/hero',
		null,
		array(
			'eyebrow'         => __( 'Blog', 'auto-emotion' ),
			'headline_pre'    => __( 'Neues aus', 'auto-emotion' ),
			'headline_accent' => __( 'dem Autohaus.', 'auto-emotion' ),
			'cta_text'        => __( 'Beiträge lesen', 'auto-emotion' ),
			'cta_url'         => '#beitraege',
			'cta2_text'       => auto_emotion_contact( 'phone' ),
			'cta2_url'        => 'tel:' . auto_emotion_contact( 'phone_href' ),
			'image'           => AUTO_EMOTION_URI . '/assets/images/cupra-bild-full-raval.jpg?ver=' . AUTO_EMOTION_VERSION,
			'video'           => '',
			'video_webm'      => '',
		)
	);
	echo '<div class="container">';
	echo '<p class="service-lead" id="beitraege">' . esc_html__( 'Beiträge zu Modellen und Angeboten von Seat, Cupra und Nissan.', 'auto-emotion' ) . '</p>';
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
