<?php
/**
 * Template Name: Ausbildung
 *
 * Ehrlicher Zwischenstand statt erfundenem Ausbildungsprogramm: Die
 * Karriere-Hub-Seite sagt bereits offen "Unser Ausbildungsangebot
 * bauen wir gerade aus." Diese Seite erklärt, was das in der Praxis
 * bedeutet, und bietet einen konkreten, echten nächsten Schritt
 * (Initiativbewerbung) statt eines fiktiven Ausbildungsplatzkatalogs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Ausbildung bei Auto Emotion', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Unser Ausbildungsangebot bauen wir gerade aus. Aktuell schreiben wir Kfz-Berufe vor allem für erfahrene Fachkräfte und den direkten Berufseinstieg aus – feste Ausbildungsplätze mit Ausbildungsjahrgang sind in Vorbereitung.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Die klassischen Ausbildungsberufe im Autohaus sind die duale Ausbildung zum Kfz-Mechatroniker (m/w/d) – rund dreieinhalb Jahre, Betrieb und Berufsschule im Wechsel – sowie zum Automobilkaufmann bzw. zur Automobilkauffrau (m/w/d) mit rund drei Jahren Dauer, von der Kundenberatung über die Werkstattdisposition bis zur Auftragsabwicklung. In diese Richtung wollen wir unser Angebot ausbauen.', 'auto-emotion' ); ?></p>
	<p>
		<?php
		printf(
			/* translators: %s: link to Warum Auto Emotion page */
			esc_html__( 'Was Auto Emotion als Arbeitgeber grundsätzlich bietet – von gestelltem Werkzeug bis zu bezahlter Weiterbildung – steht auf unserer Seite %s.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/warum-auto-emotion/' ) ) . '">' . esc_html__( '„Warum Auto Emotion?"', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
	<p><?php esc_html_e( 'Haben Sie jetzt schon Interesse an einem Ausbildungsplatz bei uns? Melden Sie sich direkt – wir merken uns Ihre Bewerbung für den nächsten Ausbildungsjahrgang vor.', 'auto-emotion' ); ?></p>
	<p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/initiativbewerbung/' ) ); ?>">
			<?php esc_html_e( 'Initiativbewerbung senden', 'auto-emotion' ); ?>
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
