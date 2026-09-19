<?php
/**
 * Hero Stage template part.
 *
 * @param array $args {
 *     @type string $eyebrow  Small uppercase label above the headline.
 *     @type string $headline Hero headline text.
 *     @type string $cta_text Label for the Giallo CTA button.
 *     @type string $cta_url  URL for the Giallo CTA button.
 *     @type string $image    Background/poster image URL.
 *     @type string $video    Optional background video URL (mp4). Falls back
 *                            to $image as poster/still when not set.
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
		'image'    => AUTO_EMOTION_URI . '/assets/images/hero-fusion.jpg',
		'video'    => AUTO_EMOTION_URI . '/assets/videos/hero-fusion.mp4',
	)
);
?>
<section class="hero-stage" style="background-image:url('<?php echo esc_url( $auto_emotion_hero['image'] ); ?>')">
	<?php if ( $auto_emotion_hero['video'] ) : ?>
		<video
			class="hero-stage__video"
			autoplay
			muted
			loop
			playsinline
			poster="<?php echo esc_url( $auto_emotion_hero['image'] ); ?>"
		>
			<source src="<?php echo esc_url( $auto_emotion_hero['video'] ); ?>" type="video/mp4">
		</video>
	<?php endif; ?>

	<div class="hero-stage__content">
		<p class="hero-stage__eyebrow"><?php echo esc_html( $auto_emotion_hero['eyebrow'] ); ?></p>
		<h1 class="hero-stage__headline"><?php echo esc_html( $auto_emotion_hero['headline'] ); ?></h1>
		<a class="btn btn-giallo" href="<?php echo esc_url( $auto_emotion_hero['cta_url'] ); ?>">
			<?php echo esc_html( $auto_emotion_hero['cta_text'] ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>
