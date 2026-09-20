<?php
/**
 * Template Name: Finanzierung & Leasing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status = isset( $_GET['anfrage'] ) ? sanitize_text_field( wp_unslash( $_GET['anfrage'] ) ) : '';
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Finanzierung & Leasing', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Für Ihr neues Fahrzeug arbeiten wir nicht mit einer einzigen festen Hausbank, sondern mit unabhängigen Finanzierungspartnern zusammen. Das heißt: Wir vergleichen die Konditionen verschiedener Banken für Sie und finden die passende Lösung – ob Kauf, Finanzierung oder Leasing.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Sie behalten dabei die freie Bankwahl – es gibt keinen Zwang zu einem bestimmten Anbieter. Ihr individuelles Angebot mit den für Sie passenden Konditionen erstellen wir gerne persönlich.', 'auto-emotion' ); ?></p>
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
	<input type="hidden" name="action" value="auto_emotion_finanzierung_anfrage">
	<?php wp_nonce_field( 'auto_emotion_finanzierung', 'auto_emotion_finanzierung_nonce' ); ?>

	<p class="application-form__honeypot" aria-hidden="true">
		<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
		<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
	</p>

	<div class="application-form__field">
		<label for="fin_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
		<input type="text" id="fin_name" name="fin_name" required>
	</div>

	<div class="application-form__field">
		<label for="fin_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
		<input type="tel" id="fin_telefon" name="fin_telefon" required>
	</div>

	<div class="application-form__field">
		<label for="fin_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
		<input type="email" id="fin_email" name="fin_email" required>
	</div>

	<div class="application-form__field">
		<label for="fin_art"><?php esc_html_e( 'Interesse an', 'auto-emotion' ); ?></label>
		<select id="fin_art" name="fin_art">
			<option value="Finanzierung"><?php esc_html_e( 'Finanzierung', 'auto-emotion' ); ?></option>
			<option value="Leasing"><?php esc_html_e( 'Leasing', 'auto-emotion' ); ?></option>
			<option value="Barkauf"><?php esc_html_e( 'Barkauf', 'auto-emotion' ); ?></option>
			<option value="Noch offen"><?php esc_html_e( 'Noch offen / Beratung gewünscht', 'auto-emotion' ); ?></option>
		</select>
	</div>

	<div class="application-form__field">
		<label for="fin_fahrzeug"><?php esc_html_e( 'Fahrzeug von Interesse (optional)', 'auto-emotion' ); ?></label>
		<input type="text" id="fin_fahrzeug" name="fin_fahrzeug" placeholder="<?php esc_attr_e( 'z. B. Cupra Born', 'auto-emotion' ); ?>">
	</div>

	<div class="application-form__field">
		<label for="fin_nachricht"><?php esc_html_e( 'Nachricht (optional)', 'auto-emotion' ); ?></label>
		<textarea id="fin_nachricht" name="fin_nachricht" rows="5"></textarea>
	</div>

	<label class="application-form__consent">
		<input type="checkbox" name="fin_dsgvo" value="1" required>
		<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bearbeitung dieser Anfrage gespeichert werden. Jederzeit widerrufbar.', 'auto-emotion' ); ?>
	</label>

	<button type="submit" class="btn btn-giallo application-form__submit">
		<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
		<span class="btn-arrow" aria-hidden="true">&rarr;</span>
	</button>
</form>

<?php
get_footer();
