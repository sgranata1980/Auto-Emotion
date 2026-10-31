<?php
/**
 * Template Name: Vlog
 *
 * Analog zu page-podcast.php: ehrlich, kein erfundenes Videoformat.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Vlog', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Ein eigener Vlog ist bei Auto Emotion aktuell nicht geplant. Videoinhalte aus Showroom und Werkstatt veröffentlichen wir bereits auf unseren Social-Media-Kanälen.', 'auto-emotion' ); ?></p>
	<p>
		<?php $auto_emotion_instagram_url = auto_emotion_contact( 'instagram' ); ?>
		<?php $auto_emotion_facebook_url = auto_emotion_contact( 'facebook' ); ?>
		<?php if ( $auto_emotion_instagram_url ) : ?>
			<a class="btn btn-giallo" href="<?php echo esc_url( $auto_emotion_instagram_url ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'Auf Instagram folgen', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		<?php endif; ?>
		<?php if ( $auto_emotion_facebook_url ) : ?>
			<a class="btn btn-outline" href="<?php echo esc_url( $auto_emotion_facebook_url ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'Auf Facebook folgen', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		<?php endif; ?>
	</p>
</div>

<?php
get_footer();
