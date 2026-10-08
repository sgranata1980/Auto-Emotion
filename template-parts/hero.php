<?php
/**
 * Hero Stage template part.
 *
 * @param array $args {
 *     @type string $eyebrow         Small uppercase label shown in the badge pill.
 *     @type string $headline_pre    Headline text before the accent word.
 *     @type string $headline_accent Serif-italic accent word (keep short - one word).
 *     @type string $cta_text        Label for the Giallo CTA button.
 *     @type string $cta_url         URL for the Giallo CTA button.
 *     @type string $cta2_text       Label for the secondary (ghost) CTA button.
 *     @type string $cta2_url        URL for the secondary CTA button.
 *     @type string $image      Background/poster image URL.
 *     @type string $video      Optional background video URL (mp4, H.264).
 *                              Falls back to $image as poster/still when
 *                              not set.
 *     @type string $video_webm Optional WebM/VP9 variant, offered first so
 *                              browsers that support it get a smaller file;
 *                              $video (mp4) stays as the compatibility
 *                              fallback for every mainstream browser.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_hero = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'         => __( 'Cupra · Seat · Nissan – Frankfurt Rhein-Main', 'auto-emotion' ),
		'headline_pre'    => __( 'Mehr als', 'auto-emotion' ),
		'headline_accent' => __( 'Autos.', 'auto-emotion' ),
		'cta_text'        => __( 'Marken entdecken', 'auto-emotion' ),
		'cta_url'         => '#marken',
		'cta2_text'       => __( 'Fahrzeug finden', 'auto-emotion' ),
		'cta2_url'        => '#fahrzeugsuche',
		'image'           => AUTO_EMOTION_URI . '/assets/images/cupra-header-poster.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => AUTO_EMOTION_URI . '/assets/videos/cupra-header-spot.mp4?ver=' . AUTO_EMOTION_VERSION,
		'video_webm'      => AUTO_EMOTION_URI . '/assets/videos/cupra-header-spot.webm?ver=' . AUTO_EMOTION_VERSION,
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
			<?php if ( $auto_emotion_hero['video_webm'] ) : ?>
				<source src="<?php echo esc_url( $auto_emotion_hero['video_webm'] ); ?>" type="video/webm">
			<?php endif; ?>
			<source src="<?php echo esc_url( $auto_emotion_hero['video'] ); ?>" type="video/mp4">
		</video>
	<?php endif; ?>

	<div class="hero-stage__content">
		<p class="hero-stage__badge appear appear--pop"><?php echo esc_html( $auto_emotion_hero['eyebrow'] ); ?></p>
		<h1 class="hero-stage__headline">
			<span class="appear appear--mask"><?php echo esc_html( $auto_emotion_hero['headline_pre'] ); ?> <em class="hero-stage__accent"><?php echo esc_html( $auto_emotion_hero['headline_accent'] ); ?></em></span>
		</h1>
		<div class="hero-stage__ctas">
			<a class="btn btn-giallo appear appear--btn" href="<?php echo esc_url( $auto_emotion_hero['cta_url'] ); ?>">
				<?php echo esc_html( $auto_emotion_hero['cta_text'] ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
			<a class="btn hero-stage__cta-ghost appear appear--btn-delay" href="<?php echo esc_url( $auto_emotion_hero['cta2_url'] ); ?>">
				<?php echo esc_html( $auto_emotion_hero['cta2_text'] ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>
