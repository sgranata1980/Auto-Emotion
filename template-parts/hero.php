<?php
/**
 * Hero Stage template part.
 *
 * Rendert eine horizontal swipebare Hero-Galerie (Touch-Swipe per
 * CSS scroll-snap, zusätzlich per Klick auf die Dots bedienbar).
 *
 * @param array $args {
 *     @type string $eyebrow  Small uppercase label above the headline (nur Slide 1).
 *     @type string $headline Hero headline text (nur Slide 1).
 *     @type string $cta_text Label for the Giallo CTA button (nur Slide 1).
 *     @type string $cta_url  URL for the Giallo CTA button (nur Slide 1).
 *     @type string $image    Background/poster image URL (Slide 1).
 *     @type string $video    Optional background video URL (mp4, Slide 1).
 *     @type array  $slides   Weitere Slides, je array( 'image' => ..., 'video' => ... ).
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
		'image'    => AUTO_EMOTION_URI . '/assets/images/hero-glow-01.jpg',
		'video'    => AUTO_EMOTION_URI . '/assets/videos/hero-glow.mp4',
		'slides'   => array(
			array(
				'image' => AUTO_EMOTION_URI . '/assets/images/hero-glow-02.jpg',
				'video' => AUTO_EMOTION_URI . '/assets/videos/hero-glow-02.mp4',
			),
		),
	)
);

$auto_emotion_hero_slides   = array();
$auto_emotion_hero_slides[] = array(
	'image'    => $auto_emotion_hero['image'],
	'video'    => $auto_emotion_hero['video'],
	'eyebrow'  => $auto_emotion_hero['eyebrow'],
	'headline' => $auto_emotion_hero['headline'],
	'cta_text' => $auto_emotion_hero['cta_text'],
	'cta_url'  => $auto_emotion_hero['cta_url'],
);

foreach ( (array) $auto_emotion_hero['slides'] as $auto_emotion_extra_slide ) {
	$auto_emotion_hero_slides[] = wp_parse_args(
		$auto_emotion_extra_slide,
		array(
			'image'    => '',
			'video'    => '',
			'eyebrow'  => '',
			'headline' => '',
			'cta_text' => '',
			'cta_url'  => '',
		)
	);
}
?>
<section class="hero-stage">
	<div class="hero-stage__track">
		<?php foreach ( $auto_emotion_hero_slides as $auto_emotion_slide_index => $auto_emotion_slide ) : ?>
			<div class="hero-stage__slide" style="background-image:url('<?php echo esc_url( $auto_emotion_slide['image'] ); ?>')">
				<?php if ( $auto_emotion_slide['video'] ) : ?>
					<video
						class="hero-stage__video"
						autoplay
						muted
						loop
						playsinline
						poster="<?php echo esc_url( $auto_emotion_slide['image'] ); ?>"
					>
						<source src="<?php echo esc_url( $auto_emotion_slide['video'] ); ?>" type="video/mp4">
					</video>
				<?php endif; ?>

				<?php if ( $auto_emotion_slide['headline'] ) : ?>
					<div class="hero-stage__content">
						<?php if ( $auto_emotion_slide['eyebrow'] ) : ?>
							<p class="hero-stage__eyebrow"><?php echo esc_html( $auto_emotion_slide['eyebrow'] ); ?></p>
						<?php endif; ?>
						<h1 class="hero-stage__headline"><?php echo esc_html( $auto_emotion_slide['headline'] ); ?></h1>
						<?php if ( $auto_emotion_slide['cta_text'] && $auto_emotion_slide['cta_url'] ) : ?>
							<a class="btn btn-giallo" href="<?php echo esc_url( $auto_emotion_slide['cta_url'] ); ?>">
								<?php echo esc_html( $auto_emotion_slide['cta_text'] ); ?>
								<span class="btn-arrow" aria-hidden="true">&rarr;</span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

	<?php if ( count( $auto_emotion_hero_slides ) > 1 ) : ?>
		<div class="hero-stage__dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero-Galerie', 'auto-emotion' ); ?>">
			<?php foreach ( $auto_emotion_hero_slides as $auto_emotion_slide_index => $auto_emotion_slide ) : ?>
				<button
					type="button"
					class="hero-stage__dot<?php echo 0 === $auto_emotion_slide_index ? ' is-active' : ''; ?>"
					data-slide-target="<?php echo esc_attr( $auto_emotion_slide_index ); ?>"
					aria-current="<?php echo 0 === $auto_emotion_slide_index ? 'true' : 'false'; ?>"
					<?php
					/* translators: %d: slide number */
					?>
					aria-label="<?php echo esc_attr( sprintf( __( 'Folie %d anzeigen', 'auto-emotion' ), $auto_emotion_slide_index + 1 ) ); ?>"
				></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
