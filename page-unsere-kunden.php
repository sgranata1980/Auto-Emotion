<?php
/**
 * Template Name: Unsere Kunden
 *
 * Bewusst ohne Testimonials/Zitate, solange keine echten Kunden-
 * stimmen freigegeben sind (Projektregel: nichts erfinden). Verweist
 * stattdessen auf echte, öffentlich nachprüfbare Fakten (Firmen-
 * geschichte, Auszeichnungen) und auf echte Google-Bewertungen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Unsere Kunden', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Auto Emotion ist seit Mai 2001 als inhabergeführtes Familienunternehmen in Offenbach ansässig. Viele unserer Kunden sind uns seit dem ersten Tag treu – vom ersten Seat bis zum aktuellen Cupra oder Nissan.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Was uns Kunden immer wieder zurückkehren lässt, sind keine großen Versprechen, sondern der direkte Draht: feste Ansprechpartner, eine Geschäftsführung, die im Haus erreichbar ist, und eine Werkstatt, die sich nicht nur auf Seat, Cupra und Nissan beschränkt, sondern als freie Werkstatt auch Fahrzeuge anderer Marken betreut.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Auszeichnungen als Qualitätsnachweis', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p>
		<?php
		printf(
			/* translators: %s: link to Auszeichnungen page */
			esc_html__( 'Statt eigener Werbeaussagen lassen wir lieber unsere Hersteller sprechen: Seit 2018 sind wir als Nissan GT-R High Performance Center und CUPRA Specialist ausgezeichnet – beides Anerkennungen, die Nissan bzw. CUPRA nur an Händler mit besonderer Kompetenz vergeben. Mehr dazu auf unserer %s.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/auszeichnungen/' ) ) . '">' . esc_html__( 'Seite zu unseren Auszeichnungen', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
	<p>
		<?php
		$auto_emotion_kunden_address = sprintf(
			'%s, %s %s',
			auto_emotion_contact( 'street' ),
			auto_emotion_contact( 'postal_code' ),
			auto_emotion_contact( 'city' )
		);
		printf(
			/* translators: %s: link to Google Maps listing */
			esc_html__( 'Echte Erfahrungsberichte unserer Kunden finden Sie direkt bei Google: %s.', 'auto-emotion' ),
			'<a href="https://www.google.com/maps/search/?api=1&query=' . rawurlencode( auto_emotion_contact( 'company' ) . ', ' . $auto_emotion_kunden_address ) . '" target="_blank" rel="noopener">' . esc_html__( 'Auto Emotion bei Google Maps', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Sie überlegen, Kunde zu werden?', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Am einfachsten überzeugen Sie sich selbst: Kommen Sie vorbei, sprechen Sie uns an, oder vereinbaren Sie eine Probefahrt.', 'auto-emotion' ); ?></p>
	<p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
			<?php esc_html_e( 'Kontakt aufnehmen', 'auto-emotion' ); ?>
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
