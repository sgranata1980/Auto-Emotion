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

	<?php
	// Einzelne Beiträge können ein Video (z.B. offizielles Hersteller-
	// Pressematerial) statt des Beitragsbilds zeigen – über das Custom
	// Field "auto_emotion_video" gepflegt. In Archiv-/Listenansichten
	// bleibt es beim Standbild, damit Teaser-Kacheln konsistent bleiben.
	$auto_emotion_post_video = is_singular() ? get_post_meta( get_the_ID(), 'auto_emotion_video', true ) : '';
	?>
	<?php if ( $auto_emotion_post_video ) : ?>
		<video
			class="post-thumbnail post-thumbnail--video"
			src="<?php echo esc_url( $auto_emotion_post_video ); ?>"
			width="1280" height="720"
			autoplay muted loop playsinline webkit-playsinline preload="auto"
		></video>
	<?php elseif ( has_post_thumbnail() ) : ?>
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
