<?php
/**
 * Template Name: Datenschutz
 *
 * Verantwortlicher (Name/Adresse/Kontakt) ist real und stammt aus
 * inc/contact-info.php (Quelle: auto-emotion.de, Stand 2026-09-17).
 * Die eigentlichen DSGVO-Rechtstexte (Verarbeitungszwecke, Cookies,
 * Drittanbieter, Rechtsgrundlagen) sind bewusst NICHT vorformuliert,
 * da sie von der tatsächlichen technischen Umsetzung (Plugins, Tracking,
 * Formulare) abhängen und ohne diese Angaben erfunden wären. Vor
 * Livegang durch eine Datenschutz-Fachperson vervollständigen lassen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Datenschutzerklärung', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content legal-content">
	<h2><?php esc_html_e( 'Verantwortlicher', 'auto-emotion' ); ?></h2>
	<p>
		<?php echo esc_html( auto_emotion_contact( 'company' ) ); ?><br>
		<?php echo esc_html( auto_emotion_contact( 'street' ) ); ?><br>
		<?php echo esc_html( auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?><br>
		<?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?>: <?php echo esc_html( auto_emotion_contact( 'email' ) ); ?><br>
		<?php esc_html_e( 'Telefon', 'auto-emotion' ); ?>: <?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
	</p>

	<h2><?php esc_html_e( 'Vertreten durch', 'auto-emotion' ); ?></h2>
	<p><?php echo esc_html( auto_emotion_contact( 'management' ) ); ?></p>

	<h2><?php esc_html_e( 'Verarbeitung personenbezogener Daten', 'auto-emotion' ); ?></h2>
	<p><em>
		<?php esc_html_e( '[Platzhalter: Hier fehlen noch die konkreten Angaben zu Hosting, Kontaktformular, Cookies/Tracking, eingesetzten Diensten (z. B. Google Maps, Social-Media-Plugins) und den jeweiligen Rechtsgrundlagen. Diese Inhalte hängen von der tatsächlichen technischen Umsetzung ab und wurden hier bewusst nicht erfunden – bitte gemeinsam mit einer datenschutzkundigen Person auf Basis der final eingesetzten Tools ausformulieren.]', 'auto-emotion' ); ?>
	</em></p>
</div>

<?php
get_footer();
