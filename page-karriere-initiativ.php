<?php
/**
 * Template Name: Karriere – Initiativbewerbung
 *
 * Allgemeines Bewerbungsformular ohne konkrete Stelle, für alle, die
 * sich unabhängig von einer aktuellen Ausschreibung bei Auto Emotion
 * bewerben möchten. Nutzt denselben admin-post.php-Handler wie die
 * stellenspezifischen Landingpages (inc/recruiting.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status   = isset( $_GET['bewerbung'] ) ? sanitize_text_field( wp_unslash( $_GET['bewerbung'] ) ) : '';
$auto_emotion_prefill  = isset( $_GET['stelle'] ) ? sanitize_text_field( wp_unslash( $_GET['stelle'] ) ) : '';
$auto_emotion_herkunft_referrer = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';
?>

<?php
echo '</div>';
get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Initiativbewerbung', 'auto-emotion' ),
		'headline_pre'    => __( 'Keine passende Stelle?', 'auto-emotion' ),
		'headline_accent' => __( 'Schreib uns trotzdem.', 'auto-emotion' ),
		'cta_text'        => __( 'Zum Formular', 'auto-emotion' ),
		'cta_url'         => '#bewerbung',
		'cta2_text'       => __( 'Offene Stellen', 'auto-emotion' ),
		'cta2_url'        => home_url( '/offene-stellen/' ),
		'image'           => AUTO_EMOTION_URI . '/assets/images/career-serviceassistentin.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => '',
		'video_webm'      => '',
	)
);
echo '<div class="container">';
$auto_emotion_svg = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"';
?>

<p class="service-lead" id="bewerbung"><?php esc_html_e( 'Du hast Interesse an Auto Emotion, aber keine passende Ausschreibung gefunden? Schreib uns kurz, welche Position dich interessiert.', 'auto-emotion' ); ?></p>

<?php if ( 'ok' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--success">
		<?php esc_html_e( 'Danke! Wir melden uns innerhalb von 24 Stunden bei dir.', 'auto-emotion' ); ?>
	</div>
<?php elseif ( 'fehler' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--error">
		<?php esc_html_e( 'Bitte alle Pflichtfelder ausfüllen und erneut senden.', 'auto-emotion' ); ?>
	</div>
<?php endif; ?>

<div class="termin-layout">
<form class="application-form termin-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="auto_emotion_bewerbung">
	<input type="hidden" name="bewerbung_herkunft_referrer" value="<?php echo esc_attr( $auto_emotion_herkunft_referrer ); ?>">
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

	<div class="application-form__field">
		<label for="bewerbung_email"><?php esc_html_e( 'E-Mail (optional, für Rückmeldungen per Mail)', 'auto-emotion' ); ?></label>
		<input type="email" id="bewerbung_email" name="bewerbung_email">
	</div>

	<div class="application-form__field">
		<label for="bewerbung_stelle"><?php esc_html_e( 'Wunschposition', 'auto-emotion' ); ?></label>
		<input type="text" id="bewerbung_stelle" name="bewerbung_stelle" value="<?php echo esc_attr( $auto_emotion_prefill ); ?>" placeholder="<?php esc_attr_e( 'z. B. Kfz-Mechatroniker, Serviceberatung, Verkauf …', 'auto-emotion' ); ?>" required>
	</div>

	<fieldset class="application-form__field">
		<legend><?php esc_html_e( 'Bevorzugter Kontakt', 'auto-emotion' ); ?></legend>
		<label class="application-form__radio"><input type="radio" name="bewerbung_kontakt" value="Anruf" required> <?php esc_html_e( 'Anruf', 'auto-emotion' ); ?></label>
		<label class="application-form__radio"><input type="radio" name="bewerbung_kontakt" value="WhatsApp"> <?php esc_html_e( 'WhatsApp', 'auto-emotion' ); ?></label>
		<label class="application-form__radio"><input type="radio" name="bewerbung_kontakt" value="E-Mail"> <?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
	</fieldset>

	<div class="application-form__field">
		<label for="bewerbung_nachricht"><?php esc_html_e( 'Nachricht (optional)', 'auto-emotion' ); ?></label>
		<textarea id="bewerbung_nachricht" name="bewerbung_nachricht" rows="5"></textarea>
	</div>

	<div class="application-form__field">
		<label for="bewerbung_lebenslauf"><?php esc_html_e( 'Lebenslauf (optional)', 'auto-emotion' ); ?></label>
		<input type="file" id="bewerbung_lebenslauf" name="bewerbung_lebenslauf" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
	</div>

	<div class="application-form__field">
		<label for="bewerbung_zeugnisse"><?php esc_html_e( 'Zeugnisse / weitere Unterlagen (optional)', 'auto-emotion' ); ?></label>
		<input type="file" id="bewerbung_zeugnisse" name="bewerbung_zeugnisse[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple>
		<span class="application-form__hint"><?php esc_html_e( 'PDF, Word oder Bild, je Datei max. 8 MB.', 'auto-emotion' ); ?></span>
	</div>

	<label class="application-form__consent">
		<input type="checkbox" name="bewerbung_dsgvo" value="1" required>
		<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bewerbung gespeichert werden. Löschung spätestens 6 Monate nach Absage, jederzeit widerrufbar.', 'auto-emotion' ); ?>
	</label>

	<p class="application-form__hint">
		<?php esc_html_e( 'Aus datenschutzrechtlichen Gründen bearbeiten wir Bewerbungen ausschließlich über dieses Formular. Wir halten uns dabei an die gesetzlichen Vorgaben der DSGVO und des § 26 BDSG.', 'auto-emotion' ); ?>
	</p>

	<button type="submit" class="btn btn-giallo application-form__submit">
		<?php esc_html_e( 'Bewerbung senden', 'auto-emotion' ); ?>
		<span class="btn-arrow" aria-hidden="true">&rarr;</span>
	</button>
</form>

	<aside class="termin-info">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/werkstatt-hebebuehnen.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Nissan Qashqai und Seat Ibiza auf Hebebühnen in der Werkstatt von Auto Emotion" loading="lazy">
		<div class="termin-info__text">
			<h2><?php esc_html_e( 'So läuft deine Bewerbung ab', 'auto-emotion' ); ?></h2>
			<ol class="termin-info__schritte">
				<?php foreach ( auto_emotion_bewerbung_schritte() as $auto_emotion_schritt ) : ?>
					<li><svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_schritt[0] ); ?></svg><?php echo esc_html( $auto_emotion_schritt[2] ); ?></li>
				<?php endforeach; ?>
			</ol>
			<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</aside>
</div>

<?php
get_footer();
