<?php
/**
 * Template Name: Impressum
 *
 * Pflichtangaben gemäß § 5 TMG. Werte stammen aus inc/contact-info.php
 * (Quelle: auto-emotion.de, Stand 2026-09-17) bzw. dem WP-Customizer.
 * Rechtstexte in Abschnitt "Haftungsausschluss" sind Boilerplate und
 * ersetzen keine juristische Prüfung.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Impressum', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content legal-content">
	<h2><?php esc_html_e( 'Angaben gemäß § 5 TMG', 'auto-emotion' ); ?></h2>
	<p>
		<?php echo esc_html( auto_emotion_contact( 'company' ) ); ?><br>
		<?php echo esc_html( auto_emotion_contact( 'street' ) ); ?><br>
		<?php echo esc_html( auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?><br>
		<?php echo esc_html( auto_emotion_contact( 'country' ) ); ?>
	</p>

	<h2><?php esc_html_e( 'Vertreten durch', 'auto-emotion' ); ?></h2>
	<p><?php echo esc_html( auto_emotion_contact( 'management' ) ); ?></p>

	<h2><?php esc_html_e( 'Kontakt', 'auto-emotion' ); ?></h2>
	<p>
		<?php esc_html_e( 'Telefon', 'auto-emotion' ); ?>: <?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?><br>
		<?php esc_html_e( 'Fax', 'auto-emotion' ); ?>: <?php echo esc_html( auto_emotion_contact( 'fax' ) ); ?><br>
		<?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?>: <?php echo esc_html( auto_emotion_contact( 'email' ) ); ?>
	</p>

	<h2><?php esc_html_e( 'Registereintrag', 'auto-emotion' ); ?></h2>
	<p><?php echo esc_html( auto_emotion_contact( 'hrb' ) ); ?></p>

	<h2><?php esc_html_e( 'Umsatzsteuer-ID', 'auto-emotion' ); ?></h2>
	<p><?php esc_html_e( 'Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:', 'auto-emotion' ); ?> <?php echo esc_html( auto_emotion_contact( 'vat_id' ) ); ?></p>

	<h2><?php esc_html_e( 'Haftungsausschluss', 'auto-emotion' ); ?></h2>
	<p><em>
		<?php esc_html_e( '[Platzhalter: Haftungs- und Urheberrechtshinweise durch eine rechtliche Prüfung ergänzen/bestätigen lassen, bevor die Seite live geht.]', 'auto-emotion' ); ?>
	</em></p>
</div>

<?php
get_footer();
