<?php
/**
 * Template Name: Gebrauchtwagen
 *
 * Eigene On-Site-Fahrzeugsuche für Gebrauchtwagen (Two-Way-Schnittstelle
 * zu einem Bestandssystem) ist in Vorbereitung, aber noch nicht
 * angebunden - es gibt aktuell keine strukturierten, verlässlich
 * aktuellen Gebrauchtwagen-Einzeldaten (Modell, Preis, km-Stand) im
 * System, die sich hier ehrlich anzeigen ließen. Statt erfundener
 * Beispielfahrzeuge oder eines generischen "in Vorbereitung"-Platzhalters
 * verweist die Seite - wie schon bei page-podcast.php - ehrlich auf die
 * echten, bereits heute live gepflegten Bestandsseiten auf mobile.de und
 * AutoScout24, bis die eigene Anbindung steht.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php
/**
 * get_header() öffnet auf Nicht-Startseiten ein .container-Div
 * (max-width 1440px, zentriert) direkt um den gesamten Seiteninhalt.
 * Der Hero ist wie auf Startseite/Neuwagen als vollflächige Section
 * gedacht - bricht hier kurz aus dem Container aus (siehe
 * page-neuwagen.php für denselben Fix) und öffnet ihn danach wieder.
 */
echo '</div>';

get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Seat · Cupra · Nissan', 'auto-emotion' ),
		'headline_pre'    => __( 'Geprüfte', 'auto-emotion' ),
		'headline_accent' => __( 'Gebrauchtwagen.', 'auto-emotion' ),
		'cta_text'        => __( 'Fahrzeuge ansehen', 'auto-emotion' ),
		'cta_url'         => '#bestand',
		'cta2_text'       => __( 'Anfrage senden', 'auto-emotion' ),
		'cta2_url'        => 'mailto:' . auto_emotion_contact( 'email' ) . '?subject=' . rawurlencode( 'Gebrauchtwagen-Anfrage' ),
		'image'           => AUTO_EMOTION_URI . '/assets/images/showroom-verkaufsflaeche.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => '',
		'video_webm'      => '',
	)
);

echo '<div class="container">';
?>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Gebrauchtwagen', 'auto-emotion' ); ?></h2>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Neben Neuwagen führen wir laufend geprüfte Gebrauchtfahrzeuge der Marken Seat, Cupra und Nissan sowie in Zahlung genommene Fahrzeuge anderer Hersteller. Jedes Fahrzeug durchläuft vor dem Verkauf unsere Werkstatt.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading" id="bestand">
	<h2 class="section-heading__title"><?php esc_html_e( 'Aktueller Fahrzeugbestand', 'auto-emotion' ); ?></h2>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Unser Gebrauchtwagenbestand ändert sich praktisch täglich – eine eigene Live-Fahrzeugsuche direkt auf dieser Seite ist in Vorbereitung. Bis die Anbindung steht, finden Sie unseren vollständigen, tagesaktuellen Bestand bereits jetzt auf mobile.de und AutoScout24.', 'auto-emotion' ); ?></p>
</div>

<div class="quick-actions">
	<a class="quick-action" href="https://home.mobile.de/home/index.html?customerId=456599" target="_blank" rel="noopener">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><line x1="16.2" y1="16.2" x2="21" y2="21"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Bestand auf mobile.de', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Fahrzeuge ansehen', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="https://www.autoscout24.de/haendler/auto-emotion-gmbh-und-co-kg-offenbach" target="_blank" rel="noopener">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><line x1="16.2" y1="16.2" x2="21" y2="21"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Bestand auf AutoScout24', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Fahrzeuge ansehen', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( home_url( '/fahrzeugankauf/' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 20V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M4 20h10M7 20v-6h4v6M15 9l2.3 2.3a1 1 0 0 1 .3.7V17a1.3 1.3 0 0 0 2.6 0v-3.2a1 1 0 0 0-.3-.7L17.5 10.7M8 8h2"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Ihr Auto in Zahlung geben', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Fahrzeugankauf', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( home_url( '/finanzierung-leasing/' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="1"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="10.5" y2="12"/><line x1="13.5" y1="12" x2="16" y2="12"/><line x1="8" y1="16" x2="10.5" y2="16"/><line x1="13.5" y1="16" x2="16" y2="16"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Finanzierung berechnen', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Rechner öffnen', 'auto-emotion' ); ?></span>
	</a>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Auch interessant', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p>
		<?php
		printf(
			/* translators: %1$s: link to Jahreswagen/Tageszulassungen page, %2$s: link to Neuwagen page */
			esc_html__( 'Fast neu statt gebraucht: Auf unserer Seite %1$s finden Sie Fahrzeuge mit minimaler Laufleistung und meist voller Herstellergarantie. Wer lieber neu kauft, wird auf unserer %2$s-Seite fündig.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/jahreswagen-tageszulassungen/' ) ) . '">' . esc_html__( 'Jahreswagen / Tageszulassungen', 'auto-emotion' ) . '</a>',
			'<a href="' . esc_url( home_url( '/neuwagen/' ) ) . '">' . esc_html__( 'Neuwagen', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
</div>

<div class="entry-content">
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Gebrauchtwagen-Anfrage' ); ?>">
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
