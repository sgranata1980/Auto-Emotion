<?php
/**
 * Hero Stage template part.
 *
 * @param array $args {
 *     @type string $eyebrow  Small uppercase label above the headline.
 *     @type string $headline Hero headline text.
 *     @type string $cta_text Label for the Giallo CTA button.
 *     @type string $cta_url  URL for the Giallo CTA button.
 *     @type string $image    Background image URL.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_hero = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'  => __( 'Cupra · Seat · Nissan – Offenbach', 'auto-emotion' ),
		'headline' => __( 'Mehr als Autos.', 'auto-emotion' ),
		'cta_text' => __( 'Marken entdecken', 'auto-emotion' ),
		'cta_url'  => '#marken',
		'image'    => AUTO_EMOTION_URI . '/assets/images/hero-cupra-01.jpg',
	)
);
?>
<section class="hero-stage" style="background-image:url('<?php echo esc_url( $auto_emotion_hero['image'] ); ?>')">
	<div class="hero-stage__content">
		<p class="hero-stage__eyebrow"><?php echo esc_html( $auto_emotion_hero['eyebrow'] ); ?></p>
		<h1 class="hero-stage__headline"><?php echo esc_html( $auto_emotion_hero['headline'] ); ?></h1>
		<a class="btn btn-giallo" href="<?php echo esc_url( $auto_emotion_hero['cta_url'] ); ?>">
			<?php echo esc_html( $auto_emotion_hero['cta_text'] ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>
