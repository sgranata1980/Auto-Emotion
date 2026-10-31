<?php
/**
 * Newsletter-Anmeldung (Footer) - siehe inc/newsletter.php für den
 * Double-Opt-in-Ablauf dahinter.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_newsletter_status = isset( $_GET['newsletter'] ) ? sanitize_text_field( wp_unslash( $_GET['newsletter'] ) ) : '';
?>
<div class="newsletter-signup">
	<h2 class="footer-column__title"><?php esc_html_e( 'Newsletter', 'auto-emotion' ); ?></h2>
	<p class="newsletter-signup__text">
		<?php esc_html_e( 'Neue Angebote und Aktionen von Seat, Cupra und Nissan – unverbindlich, jederzeit abbestellbar.', 'auto-emotion' ); ?>
	</p>

	<?php if ( 'bestaetigung-gesendet' === $auto_emotion_newsletter_status ) : ?>
		<p class="newsletter-signup__notice"><?php esc_html_e( 'Fast geschafft! Bitte bestätigen Sie die Anmeldung über den Link in der E-Mail, die wir Ihnen gerade geschickt haben.', 'auto-emotion' ); ?></p>
	<?php elseif ( 'bestaetigt' === $auto_emotion_newsletter_status ) : ?>
		<p class="newsletter-signup__notice"><?php esc_html_e( 'Danke! Ihre Newsletter-Anmeldung ist jetzt bestätigt.', 'auto-emotion' ); ?></p>
	<?php elseif ( 'bereits-abonniert' === $auto_emotion_newsletter_status ) : ?>
		<p class="newsletter-signup__notice"><?php esc_html_e( 'Diese E-Mail-Adresse ist bereits angemeldet.', 'auto-emotion' ); ?></p>
	<?php elseif ( 'fehler' === $auto_emotion_newsletter_status ) : ?>
		<p class="newsletter-signup__notice newsletter-signup__notice--error"><?php esc_html_e( 'Bitte eine gültige E-Mail-Adresse angeben und der Speicherung zustimmen.', 'auto-emotion' ); ?></p>
	<?php else : ?>
		<form class="newsletter-signup__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="auto_emotion_newsletter_signup">
			<?php wp_nonce_field( 'auto_emotion_newsletter', 'auto_emotion_newsletter_nonce' ); ?>

			<p class="newsletter-signup__honeypot" aria-hidden="true">
				<label for="newsletter_website"><?php esc_html_e( 'Bitte freilassen', 'auto-emotion' ); ?></label>
				<input type="text" id="newsletter_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
			</p>

			<div class="newsletter-signup__row">
				<label class="screen-reader-text" for="newsletter_email"><?php esc_html_e( 'E-Mail-Adresse', 'auto-emotion' ); ?></label>
				<input type="email" id="newsletter_email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Ihre E-Mail-Adresse', 'auto-emotion' ); ?>" required>
				<button type="submit" class="btn btn-giallo">
					<?php esc_html_e( 'Anmelden', 'auto-emotion' ); ?>
					<span class="btn-arrow" aria-hidden="true">&rarr;</span>
				</button>
			</div>

			<label class="newsletter-signup__consent">
				<input type="checkbox" name="newsletter_dsgvo" value="1" required>
				<?php
				echo wp_kses(
					sprintf(
						/* translators: %s: link to privacy page */
						__( 'Ich möchte den Newsletter erhalten und bin mit der Speicherung meiner E-Mail-Adresse zu diesem Zweck einverstanden. Jederzeit widerrufbar. <a href="%s">Datenschutzerklärung</a>.', 'auto-emotion' ),
						esc_url( home_url( '/datenschutz/' ) )
					),
					array( 'a' => array( 'href' => array() ) )
				);
				?>
			</label>
		</form>
	<?php endif; ?>
</div>
