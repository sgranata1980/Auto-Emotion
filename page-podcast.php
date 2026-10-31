<?php
/**
 * Template Name: Podcast
 *
 * Bewusst ohne erfundenen Podcast: Es gibt bei Auto Emotion aktuell
 * keinen. Statt den generischen "in Vorbereitung"-Text stehen zu
 * lassen, verweist die Seite ehrlich auf die echten Kanäle
 * (Instagram/Facebook), über die Auto Emotion bereits erreichbar ist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Podcast', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Einen eigenen Podcast gibt es bei Auto Emotion aktuell nicht. Wenn sich das ändert, erfahren Sie es zuerst über unsere Social-Media-Kanäle.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Bis dahin finden Sie uns dort bereits mit Einblicken aus Showroom und Werkstatt:', 'auto-emotion' ); ?></p>
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
