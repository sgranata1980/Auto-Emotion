<?php
/**
 * Template Name: Markenevents & Probefahrt-Tage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Markenevents & Probefahrt-Tage', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Zu neuen Modellen von Seat, Cupra und Nissan veranstalten Hersteller und Händler gemeinsam Probefahrt-Aktionen – eine gute Gelegenheit, ein Fahrzeug vor der Kaufentscheidung ausgiebig zu testen, oft mit mehreren Modellvarianten an einem Termin.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Eine Probefahrt ist bei uns aber nicht an einen Aktionstag gebunden: Vereinbaren Sie jederzeit einen individuellen Termin für das Modell Ihrer Wahl.', 'auto-emotion' ); ?></p>
	<p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
			<?php esc_html_e( 'Probefahrt anfragen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</p>
	<p><?php esc_html_e( 'Konkrete Markenevents und Aktionstage kündigen wir an, sobald Termine feststehen – am schnellsten erfahren Sie davon über unsere Social-Media-Kanäle.', 'auto-emotion' ); ?></p>
	<p>
		<?php $auto_emotion_instagram_url = auto_emotion_contact( 'instagram' ); ?>
		<?php if ( $auto_emotion_instagram_url ) : ?>
			<a href="<?php echo esc_url( $auto_emotion_instagram_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Auto Emotion auf Instagram', 'auto-emotion' ); ?></a>
		<?php endif; ?>
	</p>
</div>

<?php
get_footer();
