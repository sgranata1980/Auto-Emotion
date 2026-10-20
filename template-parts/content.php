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
	// Beiträge können ein Video (z.B. offizielles Hersteller-
	// Pressematerial) statt des Beitragsbilds zeigen – über die Custom
	// Fields "auto_emotion_video" (mp4, erforderlich) und
	// "auto_emotion_video_webm" (optional, kleinere Datei für Browser
	// mit VP9-Unterstützung) gepflegt. Gilt für Einzelansicht und
	// Archiv-/Listen-Kacheln (News-Grids) gleichermaßen - ein Standbild
	// bleibt der Fallback, wenn kein Video hinterlegt ist.
	$auto_emotion_post_video      = get_post_meta( get_the_ID(), 'auto_emotion_video', true );
	$auto_emotion_post_video_webm = get_post_meta( get_the_ID(), 'auto_emotion_video_webm', true );
	?>
	<?php if ( $auto_emotion_post_video ) : ?>
		<video
			class="post-thumbnail post-thumbnail--video"
			<?php if ( has_post_thumbnail() ) : ?>poster="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>"<?php endif; ?>
			width="1280" height="720"
			autoplay muted loop playsinline webkit-playsinline preload="auto"
		>
			<?php if ( $auto_emotion_post_video_webm ) : ?>
				<source src="<?php echo esc_url( $auto_emotion_post_video_webm ); ?>" type="video/webm">
			<?php endif; ?>
			<source src="<?php echo esc_url( $auto_emotion_post_video ); ?>" type="video/mp4">
		</video>
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
