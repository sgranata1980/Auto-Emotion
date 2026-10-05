<?php
/**
 * Template Name: Zubehör & Tuning
 *
 * Tuning-Kompetenz nicht behauptet, sondern mit echtem Beleg
 * verlinkt: dem live auf der Angebote-Seite stehenden CUPRA
 * Formentor VZ Custom by ABT.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Zubehör & Tuning', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Original-Zubehör von Seat, Cupra und Nissan rüsten wir bei Bedarf direkt bei der Fahrzeugübergabe oder im Rahmen eines Werkstatttermins nach – von Dachträgern über Anhängerkupplungen bis zu individuellen Innenraum- und Design-Elementen.', 'auto-emotion' ); ?></p>
	<p>
		<?php
		printf(
			/* translators: %s: link to the ABT-tuned CUPRA Formentor offer */
			esc_html__( 'Dass wir auch über reines Original-Zubehör hinausgehen, zeigt unser aktuelles Angebot: %s, veredelt mit dem ABT Custom-Tuningpaket.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/angebote/cupra-formentor-vz-custom-by-abt-leasing-ab-333-e-im-monat/' ) ) . '">' . esc_html__( 'der CUPRA Formentor VZ Custom by ABT', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
	<p><?php esc_html_e( 'Sprechen Sie uns zu Ihren Zubehör- und Tuning-Wünschen einfach an, wir sagen Ihnen, was für Ihr Fahrzeug verfügbar und sinnvoll ist.', 'auto-emotion' ); ?></p>
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Anfrage Zubehör & Tuning' ); ?>">
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
