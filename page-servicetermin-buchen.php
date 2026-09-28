<?php
/**
 * Template for the "servicetermin-buchen" page (per WP-Slug-Template-
 * Hierarchie automatisch aktiv) – Werkstatttermin-Anfrage mit
 * Fahrzeugdaten, analog zum echten Buchungsformular auf der
 * bestehenden Auto-Emotion-Seite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status = isset( $_GET['anfrage'] ) ? sanitize_text_field( wp_unslash( $_GET['anfrage'] ) ) : '';
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Servicetermin online buchen', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Ob Inspektion, Reifenwechsel oder HU-Vorstellung: Füllen Sie das Formular aus, und wir melden uns zeitnah bei Ihnen, um einen passenden Termin abzustimmen.', 'auto-emotion' ); ?></p>
</div>

<?php if ( 'ok' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--success">
		<?php esc_html_e( 'Danke für Ihre Anfrage! Wir melden uns, um einen Termin abzustimmen.', 'auto-emotion' ); ?>
	</div>
<?php elseif ( 'fehler' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--error">
		<?php esc_html_e( 'Bitte alle Pflichtfelder ausfüllen und erneut senden.', 'auto-emotion' ); ?>
	</div>
<?php endif; ?>

<form class="application-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="auto_emotion_servicetermin">
	<?php wp_nonce_field( 'auto_emotion_servicetermin', 'auto_emotion_servicetermin_nonce' ); ?>

	<p class="application-form__honeypot" aria-hidden="true">
		<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
		<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
	</p>

	<div class="application-form__field">
		<label for="service_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
		<input type="text" id="service_name" name="service_name" required>
	</div>

	<div class="application-form__field">
		<label for="service_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
		<input type="tel" id="service_telefon" name="service_telefon" required>
	</div>

	<div class="application-form__field">
		<label for="service_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
		<input type="email" id="service_email" name="service_email" required>
	</div>

	<div class="application-form__field">
		<label for="service_hersteller"><?php esc_html_e( 'Hersteller', 'auto-emotion' ); ?></label>
		<select id="service_hersteller" name="service_hersteller" required>
			<option value=""><?php esc_html_e( 'Bitte wählen', 'auto-emotion' ); ?></option>
			<option value="CUPRA">CUPRA</option>
			<option value="NISSAN">NISSAN</option>
			<option value="SEAT">SEAT</option>
		</select>
	</div>

	<div class="application-form__field">
		<label for="service_modell"><?php esc_html_e( 'Modell', 'auto-emotion' ); ?></label>
		<input type="text" id="service_modell" name="service_modell" required>
	</div>

	<div class="application-form__field">
		<label for="service_kennzeichen"><?php esc_html_e( 'Amtliches Kennzeichen (optional)', 'auto-emotion' ); ?></label>
		<input type="text" id="service_kennzeichen" name="service_kennzeichen">
	</div>

	<div class="application-form__field">
		<label for="service_termin"><?php esc_html_e( 'Wunschtermin (optional)', 'auto-emotion' ); ?></label>
		<input type="text" id="service_termin" name="service_termin" placeholder="<?php esc_attr_e( 'z. B. Montag in zwei Wochen, vormittags', 'auto-emotion' ); ?>">
	</div>

	<div class="application-form__field">
		<label for="service_nachricht"><?php esc_html_e( 'Anmerkungen (optional)', 'auto-emotion' ); ?></label>
		<textarea id="service_nachricht" name="service_nachricht" rows="4" placeholder="<?php esc_attr_e( 'z. B. gewünschte Leistung, Kilometerstand, Auffälligkeiten', 'auto-emotion' ); ?>"></textarea>
	</div>

	<label class="application-form__consent">
		<input type="checkbox" name="service_dsgvo" value="1" required>
		<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bearbeitung dieser Anfrage gespeichert werden. Jederzeit widerrufbar.', 'auto-emotion' ); ?>
	</label>

	<button type="submit" class="btn btn-giallo application-form__submit">
		<?php esc_html_e( 'Termin anfragen', 'auto-emotion' ); ?>
		<span class="btn-arrow" aria-hidden="true">&rarr;</span>
	</button>
</form>

<?php
get_footer();
