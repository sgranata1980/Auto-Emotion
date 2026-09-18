<?php
/**
 * Template Name: Karriere – Kfz-Mechatroniker
 *
 * Job-Landingpage nach dem Prinzip aus dem hausinternen Recruiting-
 * Handbuch: ein Job, ein Formular, fünf Felder, mobil zuerst.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status = isset( $_GET['bewerbung'] ) ? sanitize_text_field( wp_unslash( $_GET['bewerbung'] ) ) : '';
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Kfz-Mechatroniker (m/w/d) gesucht', 'auto-emotion' ); ?></h1>
</div>

<?php while ( have_posts() ) : the_post(); ?>
	<div class="entry-content"><?php the_content(); ?></div>
<?php endwhile; ?>

<?php if ( 'ok' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--success">
		<?php esc_html_e( 'Danke! Wir melden uns innerhalb von 24 Stunden bei dir.', 'auto-emotion' ); ?>
	</div>
<?php elseif ( 'fehler' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--error">
		<?php esc_html_e( 'Bitte alle Pflichtfelder ausfüllen und erneut senden.', 'auto-emotion' ); ?>
	</div>
<?php endif; ?>

<form class="application-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="auto_emotion_bewerbung">
	<input type="hidden" name="bewerbung_stelle" value="Kfz-Mechatroniker (m/w/d)">
	<?php wp_nonce_field( 'auto_emotion_bewerbung', 'auto_emotion_bewerbung_nonce' ); ?>

	<p class="application-form__honeypot" aria-hidden="true">
		<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
		<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
	</p>

	<div class="application-form__field">
		<label for="bewerbung_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
		<input type="text" id="bewerbung_name" name="bewerbung_name" required>
	</div>

	<div class="application-form__field">
		<label for="bewerbung_telefon"><?php esc_html_e( 'Telefon / WhatsApp', 'auto-emotion' ); ?></label>
		<input type="tel" id="bewerbung_telefon" name="bewerbung_telefon" required>
	</div>

	<fieldset class="application-form__field">
		<legend><?php esc_html_e( 'Bevorzugter Kontakt', 'auto-emotion' ); ?></legend>
		<label class="application-form__radio"><input type="radio" name="bewerbung_kontakt" value="Anruf" required> <?php esc_html_e( 'Anruf', 'auto-emotion' ); ?></label>
		<label class="application-form__radio"><input type="radio" name="bewerbung_kontakt" value="WhatsApp"> <?php esc_html_e( 'WhatsApp', 'auto-emotion' ); ?></label>
		<label class="application-form__radio"><input type="radio" name="bewerbung_kontakt" value="E-Mail"> <?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
	</fieldset>

	<label class="application-form__consent">
		<input type="checkbox" name="bewerbung_dsgvo" value="1" required>
		<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bewerbung gespeichert werden. Löschung spätestens 6 Monate nach Absage, jederzeit widerrufbar.', 'auto-emotion' ); ?>
	</label>

	<button type="submit" class="btn btn-giallo application-form__submit">
		<?php esc_html_e( 'Bewerbung senden', 'auto-emotion' ); ?>
		<span class="btn-arrow" aria-hidden="true">&rarr;</span>
	</button>
</form>

<?php
get_footer();
