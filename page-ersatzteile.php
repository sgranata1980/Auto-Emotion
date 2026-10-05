<?php
/**
 * Template Name: Ersatzteile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Ersatzteile', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Als Vertragswerkstatt für Seat, Cupra und Nissan beziehen wir Original-Ersatzteile direkt über die Hersteller – für Reparaturen und Wartung in unserer Werkstatt ebenso wie auf Anfrage als Einzelteil, etwa wenn Sie selbst Hand anlegen möchten.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Teilen Sie uns Fahrzeug und benötigtes Teil mit (am einfachsten mit Fahrgestellnummer), wir prüfen Verfügbarkeit und Preis.', 'auto-emotion' ); ?></p>
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Ersatzteil-Anfrage' ); ?>">
			<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</p>
</div>

<?php
get_footer();
