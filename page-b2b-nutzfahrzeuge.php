<?php
/**
 * Template Name: B2B – Nissan Nutzfahrzeuge
 *
 * Landingpage für Gewerbekunden: Nissan-Nutzfahrzeuge für den
 * Fuhrpark, mit direktem Anfrageformular statt allgemeiner
 * Kontaktseite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status = isset( $_GET['anfrage'] ) ? sanitize_text_field( wp_unslash( $_GET['anfrage'] ) ) : '';
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Nissan Nutzfahrzeuge für Ihren Fuhrpark', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Drei Baugrößen für unterschiedliche Einsatzzwecke – vom City-Kurierdienst bis zum großen Servicefahrzeug:', 'auto-emotion' ); ?></p>
	<ul>
		<li><strong>Nissan Townstar</strong> &ndash; <?php esc_html_e( 'kompakter Transporter für den Stadtverkehr, auch vollelektrisch.', 'auto-emotion' ); ?></li>
		<li><strong>Nissan Primastar</strong> &ndash; <?php esc_html_e( 'flexibler Van im mittleren Segment, konfigurierbar je nach Einsatzbereich.', 'auto-emotion' ); ?></li>
		<li><strong>Nissan Interstar</strong> &ndash; <?php esc_html_e( 'der große Transporter, als Diesel oder vollelektrisch (Interstar-e).', 'auto-emotion' ); ?></li>
	</ul>
	<p><?php esc_html_e( 'Ob einzelnes Fahrzeug oder ganzer Fuhrpark: Sprechen Sie uns an, wir erarbeiten ein Angebot für Ihren Betrieb – individuell auf Ihren Bedarf zugeschnitten.', 'auto-emotion' ); ?></p>
	<p>
		<?php
		printf(
			/* translators: %s: link to the Beklebungsservice page */
			esc_html__( 'Für Ihren Fuhrpark übernimmt unsere eigene Grafikabteilung auch die Beschriftung und Beklebung der Fahrzeuge – vom Logo bis zur vollflächigen Fahrzeugfolierung, individuell nach Ihren Vorgaben. Mehr dazu auf unserer %s.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/beklebungsservice/' ) ) . '">' . esc_html__( 'Seite zum Beklebungsservice', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
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
	<input type="hidden" name="action" value="auto_emotion_b2b_anfrage">
	<?php wp_nonce_field( 'auto_emotion_b2b', 'auto_emotion_b2b_nonce' ); ?>

	<p class="application-form__honeypot" aria-hidden="true">
		<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
		<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
	</p>

	<div class="application-form__field">
		<label for="b2b_firma"><?php esc_html_e( 'Firma', 'auto-emotion' ); ?></label>
		<input type="text" id="b2b_firma" name="b2b_firma" required>
	</div>

	<div class="application-form__field">
		<label for="b2b_ansprechpartner"><?php esc_html_e( 'Ansprechpartner', 'auto-emotion' ); ?></label>
		<input type="text" id="b2b_ansprechpartner" name="b2b_ansprechpartner" required>
	</div>

	<div class="application-form__field">
		<label for="b2b_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
		<input type="tel" id="b2b_telefon" name="b2b_telefon" required>
	</div>

	<div class="application-form__field">
		<label for="b2b_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
		<input type="email" id="b2b_email" name="b2b_email" required>
	</div>

	<div class="application-form__field">
		<label for="b2b_fuhrpark"><?php esc_html_e( 'Fuhrpark-Interesse (optional)', 'auto-emotion' ); ?></label>
		<input type="text" id="b2b_fuhrpark" name="b2b_fuhrpark" placeholder="<?php esc_attr_e( 'z. B. 3x Townstar, 1x Interstar-e', 'auto-emotion' ); ?>">
	</div>

	<div class="application-form__field">
		<label for="b2b_nachricht"><?php esc_html_e( 'Nachricht (optional)', 'auto-emotion' ); ?></label>
		<textarea id="b2b_nachricht" name="b2b_nachricht" rows="5"></textarea>
	</div>

	<label class="application-form__consent">
		<input type="checkbox" name="b2b_dsgvo" value="1" required>
		<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bearbeitung dieser Anfrage gespeichert werden. Jederzeit widerrufbar.', 'auto-emotion' ); ?>
	</label>

	<button type="submit" class="btn btn-giallo application-form__submit">
		<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
		<span class="btn-arrow" aria-hidden="true">&rarr;</span>
	</button>
</form>

<?php
get_footer();
