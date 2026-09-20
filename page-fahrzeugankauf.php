<?php
/**
 * Template Name: Fahrzeugankauf & Inzahlungnahme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status = isset( $_GET['anfrage'] ) ? sanitize_text_field( wp_unslash( $_GET['anfrage'] ) ) : '';
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Fahrzeugankauf & Inzahlungnahme', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Beim Kauf Ihres neuen Seat, Cupra oder Nissan nehmen wir Ihr aktuelles Fahrzeug in Zahlung – unabhängig davon, welche Marke Sie bisher gefahren haben. In unserer Gebrauchtwagenhalle stehen Fahrzeuge unterschiedlichster Hersteller, die wir auf diesem Weg übernommen haben.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Bringen Sie Ihr Fahrzeug einfach vorbei oder schicken Sie uns die Eckdaten über das Formular unten – wir erstellen Ihnen ein faires Angebot.', 'auto-emotion' ); ?></p>
</div>

<?php if ( 'ok' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--success">
		<?php esc_html_e( 'Danke für Ihre Anfrage! Wir melden uns innerhalb von 24 Stunden bei Ihnen.', 'auto-emotion' ); ?>
	</div>
<?php elseif ( 'fehler' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--error">
		<?php esc_html_e( 'Bitte alle Pflichtfelder ausfüllen und erneut senden.', 'auto-emotion' ); ?>
	</div>
<?php endif; ?>

<form class="application-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="auto_emotion_ankauf_anfrage">
	<?php wp_nonce_field( 'auto_emotion_ankauf', 'auto_emotion_ankauf_nonce' ); ?>

	<p class="application-form__honeypot" aria-hidden="true">
		<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
		<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
	</p>

	<div class="application-form__field">
		<label for="ankauf_marke"><?php esc_html_e( 'Marke Ihres Fahrzeugs', 'auto-emotion' ); ?></label>
		<input type="text" id="ankauf_marke" name="ankauf_marke" required>
	</div>

	<div class="application-form__field">
		<label for="ankauf_modell"><?php esc_html_e( 'Modell', 'auto-emotion' ); ?></label>
		<input type="text" id="ankauf_modell" name="ankauf_modell" required>
	</div>

	<div class="application-form__field">
		<label for="ankauf_baujahr"><?php esc_html_e( 'Baujahr (optional)', 'auto-emotion' ); ?></label>
		<input type="text" id="ankauf_baujahr" name="ankauf_baujahr">
	</div>

	<div class="application-form__field">
		<label for="ankauf_kilometer"><?php esc_html_e( 'Kilometerstand (optional)', 'auto-emotion' ); ?></label>
		<input type="text" id="ankauf_kilometer" name="ankauf_kilometer">
	</div>

	<div class="application-form__field">
		<label for="ankauf_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
		<input type="text" id="ankauf_name" name="ankauf_name" required>
	</div>

	<div class="application-form__field">
		<label for="ankauf_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
		<input type="tel" id="ankauf_telefon" name="ankauf_telefon" required>
	</div>

	<div class="application-form__field">
		<label for="ankauf_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
		<input type="email" id="ankauf_email" name="ankauf_email" required>
	</div>

	<div class="application-form__field">
		<label for="ankauf_nachricht"><?php esc_html_e( 'Nachricht (optional)', 'auto-emotion' ); ?></label>
		<textarea id="ankauf_nachricht" name="ankauf_nachricht" rows="5"></textarea>
	</div>

	<label class="application-form__consent">
		<input type="checkbox" name="ankauf_dsgvo" value="1" required>
		<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bearbeitung dieser Anfrage gespeichert werden. Jederzeit widerrufbar.', 'auto-emotion' ); ?>
	</label>

	<button type="submit" class="btn btn-giallo application-form__submit">
		<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
		<span class="btn-arrow" aria-hidden="true">&rarr;</span>
	</button>
</form>

<?php
get_footer();
