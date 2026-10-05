<?php
/**
 * Template Name: Events & Schulungen
 *
 * Funktioniert als Übersichtsseite/Hub, die auf die thematisch
 * überschneidenden Einzelseiten verweist (Tag der offenen Tür,
 * Markenevents & Probefahrt-Tage, Kundenveranstaltungen,
 * Werkstatt-Schulungen) statt deren Inhalt zu duplizieren.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Events & Schulungen', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Rund um Auto Emotion gibt es mehrere Anlässe, bei denen Sie uns persönlich treffen oder mehr erfahren können – von offenen Besuchstagen über Probefahrt-Termine bis zur technischen Weiterbildung unseres Werkstattteams.', 'auto-emotion' ); ?></p>
</div>

<div class="service-teaser-grid">
	<div class="service-teaser">
		<h3 class="service-teaser__title"><?php esc_html_e( 'Tag der offenen Tür', 'auto-emotion' ); ?></h3>
		<p><?php esc_html_e( 'Showroom und Werkstatt ohne Terminzwang entdecken.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/tag-der-offenen-tuer/' ) ); ?>"><?php esc_html_e( 'Mehr erfahren', 'auto-emotion' ); ?><span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
	<div class="service-teaser">
		<h3 class="service-teaser__title"><?php esc_html_e( 'Markenevents & Probefahrt-Tage', 'auto-emotion' ); ?></h3>
		<p><?php esc_html_e( 'Neue Modelle von Seat, Cupra und Nissan live erleben und testen.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/markenevents-probefahrt-tage/' ) ); ?>"><?php esc_html_e( 'Mehr erfahren', 'auto-emotion' ); ?><span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
	<div class="service-teaser">
		<h3 class="service-teaser__title"><?php esc_html_e( 'Kundenveranstaltungen', 'auto-emotion' ); ?></h3>
		<p><?php esc_html_e( 'Persönliche Anlässe für unsere langjährigen Kunden.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/kundenveranstaltungen/' ) ); ?>"><?php esc_html_e( 'Mehr erfahren', 'auto-emotion' ); ?><span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
	<div class="service-teaser">
		<h3 class="service-teaser__title"><?php esc_html_e( 'Werkstatt-Schulungen', 'auto-emotion' ); ?></h3>
		<p><?php esc_html_e( 'Wie unser Werkstattteam bei Seat, Cupra und Nissan auf dem aktuellen Stand bleibt.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/werkstatt-schulungen/' ) ); ?>"><?php esc_html_e( 'Mehr erfahren', 'auto-emotion' ); ?><span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
</div>

<?php
get_footer();
