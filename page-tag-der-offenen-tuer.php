<?php
/**
 * Template Name: Tag der offenen Tür
 *
 * Ohne konkret terminiertes Event ehrlich beschrieben: was ein Tag
 * der offenen Tür bei einem Autohaus wie Auto Emotion typischerweise
 * bedeutet, plus echter Hinweis, wo Termine angekündigt werden
 * (Instagram/Facebook), statt eines erfundenen Datums.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Tag der offenen Tür', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'An einem Tag der offenen Tür öffnen wir unseren Standort in der Sprendlinger Landstraße ohne Terminzwang für alle, die sich in Ruhe umsehen möchten: Showroom, Werkstatt und das aktuelle Modellprogramm von Seat, Cupra und Nissan zum Anfassen.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Einen konkreten Termin gibt es aktuell nicht fest eingeplant. Sobald einer feststeht, kündigen wir ihn auf unseren Social-Media-Kanälen an.', 'auto-emotion' ); ?></p>
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
	<p>
		<?php
		printf(
			/* translators: %s: link to Events & Schulungen hub page */
			esc_html__( 'Einen Überblick über alle Veranstaltungsformate bei Auto Emotion finden Sie auf unserer Seite %s.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/events-schulungen/' ) ) . '">' . esc_html__( 'Events & Schulungen', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
</div>

<?php
get_footer();
