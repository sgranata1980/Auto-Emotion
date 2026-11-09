<?php
/**
 * Template Name: Finanzierung & Leasing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_status = isset( $_GET['anfrage'] ) ? sanitize_text_field( wp_unslash( $_GET['anfrage'] ) ) : '';
$auto_emotion_art    = isset( $_GET['art'] ) ? sanitize_text_field( wp_unslash( $_GET['art'] ) ) : '';
?>

<?php
echo '</div>';
get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Seat, Cupra und Nissan bei Auto Emotion', 'auto-emotion' ),
		'headline_pre'    => "Finan\xC2\xADzierung",
		'headline_accent' => __( '& Leasing.', 'auto-emotion' ),
		'cta_text'        => __( 'Beratung vereinbaren', 'auto-emotion' ),
		'cta_url'         => '#beratung',
		'cta2_text'       => __( 'Rate berechnen', 'auto-emotion' ),
		'cta2_url'        => '#rechner',
		'image'           => AUTO_EMOTION_URI . '/assets/images/finanzierung-beratung.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => '',
		'video_webm'      => '',
	)
);
echo '<div class="container">';
?>

<div class="entry-content">
	<p><?php esc_html_e( 'Für Ihr neues Fahrzeug arbeiten wir nicht mit einer einzigen festen Hausbank, sondern mit unabhängigen Finanzierungspartnern zusammen. Das heißt: Wir vergleichen die Konditionen verschiedener Banken für Sie und finden die passende Lösung – ob Kauf, Finanzierung oder Leasing.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Sie behalten dabei die freie Bankwahl – es gibt keinen Zwang zu einem bestimmten Anbieter. Ihr individuelles Angebot mit den für Sie passenden Konditionen erstellen wir gerne persönlich.', 'auto-emotion' ); ?></p>
</div>

<div class="finanz-bloecke">
	<section class="finanz-block" aria-labelledby="finanz-block-0">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/finanzierung-block-qashqai.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Fahrerin am Steuer eines Nissan Qashqai" width="1600" height="1200" loading="lazy">
		<div class="finanz-block__text">
			<p class="finanz-block__eyebrow"><?php esc_html_e( 'Finanzierung', 'auto-emotion' ); ?></p>
			<h2 id="finanz-block-0"><?php esc_html_e( 'In Raten statt auf einmal.', 'auto-emotion' ); ?></h2>
			<p><?php esc_html_e( 'Statt den Kaufpreis auf einen Schlag zu zahlen, verteilen Sie ihn auf monatliche Raten. Wir vergleichen dafür die Konditionen verschiedener Banken, und Sie behalten die freie Bankwahl.', 'auto-emotion' ); ?></p>
			<a class="btn btn-outline" href="#rechner"><?php esc_html_e( 'Rate berechnen', 'auto-emotion' ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</section>
	<section class="finanz-block" aria-labelledby="finanz-block-1">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/leasing-block-xtrail.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Nissan X-Trail mit Fahrerin im Wald" width="1600" height="1200" loading="lazy">
		<div class="finanz-block__text">
			<p class="finanz-block__eyebrow"><?php esc_html_e( 'Leasing', 'auto-emotion' ); ?></p>
			<h2 id="finanz-block-1"><?php esc_html_e( 'Fahren, ohne zu kaufen.', 'auto-emotion' ); ?></h2>
			<p><?php esc_html_e( 'Beim Leasing zahlen Sie für die Nutzung: eine feste Monatsrate über die vereinbarte Laufzeit. Danach geben Sie das Fahrzeug in der Regel zurück und können auf ein anderes Modell wechseln.', 'auto-emotion' ); ?></p>
			<a class="btn btn-outline" href="?art=Leasing#beratung"><?php esc_html_e( 'Leasing anfragen', 'auto-emotion' ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</section>
	<section class="finanz-block" aria-labelledby="finanz-block-2">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/showroom-verkaufsflaeche.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Verkaufsfläche im Showroom von Auto Emotion" width="1920" height="1440" loading="lazy">
		<div class="finanz-block__text">
			<p class="finanz-block__eyebrow"><?php esc_html_e( 'Inzahlungnahme', 'auto-emotion' ); ?></p>
			<h2 id="finanz-block-2"><?php esc_html_e( 'Ihr Auto als Anzahlung.', 'auto-emotion' ); ?></h2>
			<p><?php esc_html_e( 'Ihren jetzigen Wagen nehmen wir in Zahlung oder kaufen ihn an. Das verringert den Betrag, den Sie für das neue Fahrzeug noch aufbringen müssen.', 'auto-emotion' ); ?></p>
			<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/fahrzeugankauf/' ) ); ?>"><?php esc_html_e( 'Zum Fahrzeugankauf', 'auto-emotion' ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</section>
	<section class="finanz-block" aria-labelledby="finanz-block-3">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/service-empfang-seat-anmeldung.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Empfang im Servicebereich von Auto Emotion" width="2000" height="1333" loading="lazy">
		<div class="finanz-block__text">
			<p class="finanz-block__eyebrow"><?php esc_html_e( 'Mietwagen', 'auto-emotion' ); ?></p>
			<h2 id="finanz-block-3"><?php esc_html_e( 'Wenn Sie kurz ein anderes Auto brauchen.', 'auto-emotion' ); ?></h2>
			<p><?php esc_html_e( 'Neben Werkstatt und Notdienst gehört auch ein Mietwagen zu unserem Service. Rufen Sie uns an, wir sagen Ihnen, was gerade verfügbar ist.', 'auto-emotion' ); ?></p>
			<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</section>
</div>

<div class="section-heading" id="rechner">
	<h2 class="section-heading__title"><?php esc_html_e( 'Unverbindlicher Vorab-Rechner', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Ein erster Richtwert, bevor Sie zu uns kommen – ersetzt aber keine individuelle Beratung und kein konkretes Angebot.', 'auto-emotion' ); ?></p>
</div>

<div class="finance-calculator" data-finanzierungsrechner>
	<div class="finance-calculator__inputs">
		<div class="application-form__field">
			<label for="fr_preis"><?php esc_html_e( 'Fahrzeugpreis (€)', 'auto-emotion' ); ?></label>
			<input type="number" id="fr_preis" min="0" step="100" value="30000" data-fr-preis>
		</div>
		<div class="application-form__field">
			<label for="fr_anzahlung"><?php esc_html_e( 'Anzahlung (€)', 'auto-emotion' ); ?></label>
			<input type="number" id="fr_anzahlung" min="0" step="100" value="3000" data-fr-anzahlung>
		</div>
		<div class="application-form__field">
			<label for="fr_laufzeit"><?php esc_html_e( 'Laufzeit', 'auto-emotion' ); ?></label>
			<select id="fr_laufzeit" data-fr-laufzeit>
				<option value="12">12 <?php esc_html_e( 'Monate', 'auto-emotion' ); ?></option>
				<option value="24">24 <?php esc_html_e( 'Monate', 'auto-emotion' ); ?></option>
				<option value="36" selected>36 <?php esc_html_e( 'Monate', 'auto-emotion' ); ?></option>
				<option value="48">48 <?php esc_html_e( 'Monate', 'auto-emotion' ); ?></option>
				<option value="60">60 <?php esc_html_e( 'Monate', 'auto-emotion' ); ?></option>
				<option value="72">72 <?php esc_html_e( 'Monate', 'auto-emotion' ); ?></option>
			</select>
		</div>
		<div class="application-form__field">
			<label for="fr_zins"><?php esc_html_e( 'Angenommener effektiver Jahreszins (%)', 'auto-emotion' ); ?></label>
			<input type="number" id="fr_zins" min="0" max="20" step="0.1" value="5.9" data-fr-zins>
		</div>
	</div>

	<div class="finance-calculator__result">
		<div class="finance-calculator__result-item">
			<span class="finance-calculator__result-label"><?php esc_html_e( 'Zu finanzierender Betrag', 'auto-emotion' ); ?></span>
			<span class="finance-calculator__result-value" data-fr-ergebnis-kredit>–</span>
		</div>
		<div class="finance-calculator__result-item finance-calculator__result-item--highlight">
			<span class="finance-calculator__result-label"><?php esc_html_e( 'Geschätzte Monatsrate', 'auto-emotion' ); ?></span>
			<span class="finance-calculator__result-value" data-fr-ergebnis-rate>–</span>
		</div>
		<div class="finance-calculator__result-item">
			<span class="finance-calculator__result-label"><?php esc_html_e( 'Geschätzter Gesamtbetrag', 'auto-emotion' ); ?></span>
			<span class="finance-calculator__result-value" data-fr-ergebnis-gesamt>–</span>
		</div>
	</div>
</div>

<div class="entry-content">
	<p class="model-card__disclaimer">
		<?php
		esc_html_e( 'Unverbindliche Beispielrechnung auf Basis des linearen Annuitätenmodells, kein Angebot und keine Finanzierungsberatung. Der voreingestellte Zinssatz von 5,9 % orientiert sich am Marktdurchschnitt für Autokredite laut Verivox-Verbraucheratlas (Stand: Anfang 2026, Bestzinsen für sehr gute Bonität lagen davon abweichend ab 3,49 %) und kann von Ihrem individuellen, bonitätsabhängigen Angebot erheblich abweichen. Maßgeblich ist stets unser schriftliches Angebot.', 'auto-emotion' );
		?>
	</p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php echo esc_html( "Unsere Finanzierungs\xC2\xADpartner" ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Je nach Marke und Fahrzeug arbeiten wir unter anderem mit den herstellereigenen Finanzdienstleistern zusammen – ergänzt um weitere, unabhängige Finanzierungspartner, deren Konditionen wir für Sie vergleichen.', 'auto-emotion' ); ?></p>
	<div class="service-teaser-grid">
		<div class="service-teaser">
			<h3 class="service-teaser__title">SEAT Leasing</h3>
			<p><?php esc_html_e( 'Zweigniederlassung der Volkswagen Leasing GmbH – für Finanzierung und Leasing von Seat- und Cupra-Modellen.', 'auto-emotion' ); ?></p>
		</div>
		<div class="service-teaser">
			<h3 class="service-teaser__title">Nissan Financial Services</h3>
			<p><?php esc_html_e( 'Geschäftsbereich der RCI Banque S.A. Niederlassung Deutschland – für Finanzierung und Leasing von Nissan-Modellen.', 'auto-emotion' ); ?></p>
		</div>
	</div>
	<p><?php esc_html_e( 'Weitere, markenunabhängige Finanzierungspartner nennen wir Ihnen gerne persönlich im Beratungsgespräch.', 'auto-emotion' ); ?></p>
</div>

<div class="finanz-beratung" id="beratung">
	<div class="finanz-beratung__text">
		<h2 class="section-heading__title"><?php esc_html_e( 'Beratung vereinbaren', 'auto-emotion' ); ?></h2>
		<p><?php esc_html_e( 'Schreiben Sie uns, was Sie vorhaben. Ihr individuelles Angebot erstellen wir persönlich.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		<p class="finanz-beratung__zeiten"><?php echo esc_html( auto_emotion_contact( 'hours_sales' ) ); ?></p>
	</div>
	<div>
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
			<option value="Leasing" <?php selected( 'Leasing', $auto_emotion_art ); ?>><?php esc_html_e( 'Leasing', 'auto-emotion' ); ?></option>
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
	</div>
</div>

<nav class="service-kacheln" aria-label="<?php esc_attr_e( 'Weiter zu', 'auto-emotion' ); ?>">
	<a class="service-kachel" href="<?php echo esc_url( home_url( '/neuwagen/' ) ); ?>">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17h18M5 17l1.5-6.5a2 2 0 0 1 1.95-1.5h7.1a2 2 0 0 1 1.95 1.5L19 17"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/></svg>
		<strong><?php esc_html_e( 'Neuwagen', 'auto-emotion' ); ?></strong>
		<span><?php esc_html_e( 'Seat, Cupra und Nissan im Überblick.', 'auto-emotion' ); ?></span>
	</a>
	<a class="service-kachel" href="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="10" cy="10" r="6.5"/><line x1="14.8" y1="14.8" x2="20" y2="20"/></svg>
		<strong><?php esc_html_e( 'Aktuelle Angebote', 'auto-emotion' ); ?></strong>
		<span><?php esc_html_e( 'Unsere Fahrzeugangebote ansehen.', 'auto-emotion' ); ?></span>
	</a>
	<a class="service-kachel" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h16v11H9l-5 4Z"/></svg>
		<strong><?php esc_html_e( 'Kontakt', 'auto-emotion' ); ?></strong>
		<span><?php esc_html_e( 'So erreichen Sie uns in Offenbach.', 'auto-emotion' ); ?></span>
	</a>
</nav>

<?php
get_footer();
