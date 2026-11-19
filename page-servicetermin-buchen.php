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

<?php
echo '</div>';
get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Service bei Auto Emotion in Offenbach', 'auto-emotion' ),
		'headline_pre'    => "Service\xC2\xADtermin",
		'headline_accent' => __( 'online buchen.', 'auto-emotion' ),
		'cta_text'        => __( 'Zum Formular', 'auto-emotion' ),
		'cta_url'         => '#termin',
		'cta2_text'       => auto_emotion_contact( 'phone' ),
		'cta2_url'        => 'tel:' . auto_emotion_contact( 'phone_href' ),
		'image'           => AUTO_EMOTION_URI . '/assets/images/career-mechatroniker.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => '',
		'video_webm'      => '',
	)
);
echo '<div class="container">';
?>

<p class="service-lead" id="termin"><?php esc_html_e( 'Ob Inspektion, Reifenwechsel oder HU-Vorstellung: Füllen Sie das Formular aus, und wir melden uns zeitnah bei Ihnen, um einen passenden Termin abzustimmen.', 'auto-emotion' ); ?></p>

<?php if ( 'ok' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--success">
		<?php esc_html_e( 'Danke für Ihre Anfrage! Wir melden uns, um einen Termin abzustimmen.', 'auto-emotion' ); ?>
	</div>
<?php elseif ( 'fehler' === $auto_emotion_status ) : ?>
	<div class="application-notice application-notice--error">
		<?php esc_html_e( 'Bitte alle Pflichtfelder ausfüllen und erneut senden.', 'auto-emotion' ); ?>
	</div>
<?php endif; ?>

<?php
$auto_emotion_termin_marken = array(
	array( 'SEAT', 'Seat', 'termin-marke-seat.jpg', 'seat-logo-weiss.png' ),
	array( 'CUPRA', 'Cupra', 'termin-marke-cupra.jpg', 'cupra-logo-weiss.png' ),
	array( 'NISSAN', 'Nissan', 'termin-marke-nissan.jpg', 'nissan-logo-weiss.png' ),
);
$auto_emotion_termin_leistungen = array(
	array( 'Inspektion', 'haken', __( 'Inspektion', 'auto-emotion' ) ),
	array( 'Reifenwechsel', 'reifen', __( 'Reifenwechsel', 'auto-emotion' ) ),
	array( 'HU-Vorstellung', 'pruefung', __( 'HU-Vorstellung', 'auto-emotion' ) ),
	array( 'Klimaservice', 'kaelte', __( 'Klimaservice', 'auto-emotion' ) ),
	array( 'Unfallschaden', 'lack', __( 'Unfallschaden', 'auto-emotion' ) ),
	array( 'Etwas anderes', 'nachricht', __( 'Etwas anderes', 'auto-emotion' ) ),
);
$auto_emotion_termin_svg = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"';
?>

<div class="termin-layout">
	<form class="application-form termin-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="auto_emotion_servicetermin">
		<?php wp_nonce_field( 'auto_emotion_servicetermin', 'auto_emotion_servicetermin_nonce' ); ?>

		<p class="application-form__honeypot" aria-hidden="true">
			<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
			<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
		</p>

		<fieldset class="termin-schritt">
			<legend><span>1</span><?php esc_html_e( 'Welche Marke fahren Sie?', 'auto-emotion' ); ?></legend>
			<div class="termin-marken">
				<?php foreach ( $auto_emotion_termin_marken as $auto_emotion_marke ) : ?>
					<label class="termin-marke">
						<input type="radio" name="service_hersteller" value="<?php echo esc_attr( $auto_emotion_marke[0] ); ?>" required>
						<img class="termin-marke__foto" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_marke[2] . '?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="" loading="lazy">
						<img class="termin-marke__logo" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_marke[3] . '?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="" loading="lazy">
						<span class="termin-marke__name"><?php echo esc_html( $auto_emotion_marke[1] ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</fieldset>

		<fieldset class="termin-schritt">
			<legend><span>2</span><?php esc_html_e( 'Was steht an?', 'auto-emotion' ); ?></legend>
			<div class="termin-leistungen">
				<?php foreach ( $auto_emotion_termin_leistungen as $auto_emotion_leistung ) : ?>
					<label class="termin-leistung">
						<input type="checkbox" name="service_leistungen[]" value="<?php echo esc_attr( $auto_emotion_leistung[0] ); ?>">
						<svg <?php echo $auto_emotion_termin_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_leistung[1] ); ?></svg>
						<span><?php echo esc_html( $auto_emotion_leistung[2] ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</fieldset>

		<fieldset class="termin-schritt">
			<legend><span>3</span><?php esc_html_e( 'Ihr Fahrzeug und Wunschtermin', 'auto-emotion' ); ?></legend>
			<div class="termin-felder">
				<div class="application-form__field">
					<label for="service_modell"><?php esc_html_e( 'Modell', 'auto-emotion' ); ?></label>
					<input type="text" id="service_modell" name="service_modell" required>
				</div>
				<div class="application-form__field">
					<label for="service_kennzeichen"><?php esc_html_e( 'Amtliches Kennzeichen (optional)', 'auto-emotion' ); ?></label>
					<input type="text" id="service_kennzeichen" name="service_kennzeichen">
				</div>
				<div class="application-form__field termin-felder__breit">
					<label for="service_termin"><?php esc_html_e( 'Wunschtermin (optional)', 'auto-emotion' ); ?></label>
					<input type="text" id="service_termin" name="service_termin" placeholder="<?php esc_attr_e( 'z. B. Montag in zwei Wochen, vormittags', 'auto-emotion' ); ?>">
				</div>
				<div class="application-form__field termin-felder__breit">
					<label for="service_nachricht"><?php esc_html_e( 'Anmerkungen (optional)', 'auto-emotion' ); ?></label>
					<textarea id="service_nachricht" name="service_nachricht" rows="3" placeholder="<?php esc_attr_e( 'z. B. Kilometerstand, Auffälligkeiten', 'auto-emotion' ); ?>"></textarea>
				</div>
			</div>
		</fieldset>

		<fieldset class="termin-schritt">
			<legend><span>4</span><?php esc_html_e( 'Wie erreichen wir Sie?', 'auto-emotion' ); ?></legend>
			<div class="termin-felder">
				<div class="application-form__field termin-felder__breit">
					<label for="service_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
					<input type="text" id="service_name" name="service_name" autocomplete="name" required>
				</div>
				<div class="application-form__field">
					<label for="service_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
					<input type="tel" id="service_telefon" name="service_telefon" autocomplete="tel" required>
				</div>
				<div class="application-form__field">
					<label for="service_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
					<input type="email" id="service_email" name="service_email" autocomplete="email" required>
				</div>
			</div>
		</fieldset>

		<label class="application-form__consent">
			<input type="checkbox" name="service_dsgvo" value="1" required>
			<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bearbeitung dieser Anfrage gespeichert werden. Jederzeit widerrufbar.', 'auto-emotion' ); ?>
		</label>

		<button type="submit" class="btn btn-giallo application-form__submit">
			<?php esc_html_e( 'Termin anfragen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</button>
	</form>

	<aside class="termin-info">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/werkstatt-hebebuehnen.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Nissan Qashqai und Seat Ibiza auf Hebebühnen in der Werkstatt von Auto Emotion" loading="lazy">
		<div class="termin-info__text">
			<h2><?php esc_html_e( 'So geht es weiter', 'auto-emotion' ); ?></h2>
			<ol class="termin-info__schritte">
				<li><svg <?php echo $auto_emotion_termin_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'dokument' ); ?></svg><?php esc_html_e( 'Sie senden uns das Formular.', 'auto-emotion' ); ?></li>
				<li><svg <?php echo $auto_emotion_termin_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'nachricht' ); ?></svg><?php esc_html_e( 'Wir melden uns zeitnah bei Ihnen.', 'auto-emotion' ); ?></li>
				<li><svg <?php echo $auto_emotion_termin_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'kalender' ); ?></svg><?php esc_html_e( 'Gemeinsam stimmen wir den Termin ab.', 'auto-emotion' ); ?></li>
			</ol>
			<p class="termin-info__zeiten"><?php echo esc_html( sprintf( __( 'Werkstatt geöffnet: %s', 'auto-emotion' ), auto_emotion_contact( 'hours_service' ) ) ); ?></p>
			<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</aside>
</div>

<?php get_template_part( 'template-parts/seo-text' ); ?>

<nav class="termin-bilder" aria-label="<?php esc_attr_e( 'Mehr aus unserem Service', 'auto-emotion' ); ?>">
	<?php
	$auto_emotion_termin_bilder = array(
		array( 'klimaservice', 'service-klima-innenraum.jpg', 'kaelte', __( 'Klimaservice', 'auto-emotion' ) ),
		array( 'reifen-felgen', 'service-felge-xtrail.jpg', 'reifen', __( 'Reifen & Felgen', 'auto-emotion' ) ),
		array( 'fahrzeugaufbereitung', 'service-aufbereitung-lack.jpg', 'funke', __( 'Fahrzeugaufbereitung', 'auto-emotion' ) ),
	);
	?>
	<?php foreach ( $auto_emotion_termin_bilder as $auto_emotion_bild ) : ?>
		<a class="termin-bild" href="<?php echo esc_url( home_url( '/' . $auto_emotion_bild[0] . '/' ) ); ?>">
			<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_bild[1] . '?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="" loading="lazy">
			<span><svg <?php echo $auto_emotion_termin_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_bild[2] ); ?></svg><?php echo esc_html( $auto_emotion_bild[3] ); ?> <span aria-hidden="true">&rarr;</span></span>
		</a>
	<?php endforeach; ?>
</nav>

<?php
get_footer();
