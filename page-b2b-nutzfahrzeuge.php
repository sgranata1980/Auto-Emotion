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

/**
 * get_header() öffnet auf Nicht-Startseiten ein .container-Div
 * (max-width 1440px, zentriert) direkt um den gesamten Seiteninhalt.
 * Hero, Einsatzzweck-Kacheln sind bewusst außerhalb des Fließtexts
 * aufgebaut (Nutzer-Feedback: "mehr mit Kästen und Grafiken
 * arbeiten") statt der bisherigen reinen Text-/Listen-Darstellung.
 */
$auto_emotion_b2b_use_cases = array(
	array(
		'icon'  => '<path d="M12 3 7 19h10L12 3Z"/><path d="M4.5 19h15"/><path d="M9.3 11h5.4"/><path d="M8 15h8"/>',
		'title' => __( 'Baustelle & Handwerk', 'auto-emotion' ),
		'text'  => __( 'Nissan Primastar und Interstar als Kastenwagen mit viel Laderaum und hoher Nutzlast für Werkzeug, Material und Geräte.', 'auto-emotion' ),
	),
	array(
		'icon'  => '<path d="M3 8l9-5 9 5-9 5-9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
		'title' => "Liefer\xC2\xADservice & Gastro\xC2\xADnomie",
		'text'  => __( 'Der kompakte Nissan Townstar für den City-Kurierdienst – wendig und sparsam, auch vollelektrisch für emissionsfreie Innenstadtlieferungen.', 'auto-emotion' ),
	),
	array(
		'icon'  => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L4 17l3 3 5.3-5.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2-2 2.6-2.6Z"/>',
		'title' => "Haus\xC2\xADmeister- & Reinigungs\xC2\xADdienste",
		'text'  => __( 'Flexibel ausgestattete Kastenwagen für Werkzeug, Maschinen und Reinigungsequipment – passend zur Größe Ihres Fuhrparks.', 'auto-emotion' ),
	),
	array(
		'icon'  => '<rect x="3" y="6" width="18" height="11" rx="2"/><path d="M3 11.5h18"/><path d="M6.5 8.5h3M10.8 8.5h3M15 8.5h2.5"/><circle cx="7.5" cy="19" r="1.6"/><circle cx="16.5" cy="19" r="1.6"/>',
		'title' => "Personen\xC2\xADtransport",
		'text'  => __( 'Nissan Primastar und Interstar als Kombi-Variante mit mehreren Sitzreihen – für Fahrdienste, Shuttles oder Teamtransporte.', 'auto-emotion' ),
	),
	array(
		'icon'  => '<path d="M12 3v18"/><path d="M4.6 7.5l14.8 9"/><path d="M19.4 7.5 4.6 16.5"/><path d="M12 7.2 9.9 8.9M12 7.2l2.1 1.7M12 16.8l-2.1-1.7M12 16.8l2.1-1.7"/>',
		'title' => "Feinkost & K\xC3\xBChl\xC2\xADtransport",
		'text'  => __( 'Unsere Nutzfahrzeuge lassen sich mit Kühl- oder Isolieraufbauten ausstatten – für die Auslieferung temperaturempfindlicher Ware.', 'auto-emotion' ),
	),
	array(
		'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>',
		'title' => "Fahr- & Rettungs\xC2\xADdienste",
		'text'  => __( 'Die Kombi-Ausführung des Interstar bietet Platz für Personentransport – inklusive individueller Beschriftung durch unsere Grafikabteilung.', 'auto-emotion' ),
	),
);
/**
 * Weiche Trennzeichen (U+00AD) in den Kacheltiteln statt __(): die
 * langen deutschen Komposita brechen sonst in der schmalen,
 * großgeschriebenen Spalte des model-card__title mitten im Wort um
 * (gleicher Bug wie bei "Fahrzeugsuche", siehe
 * template-parts/vehicle-search.php) - hyphens:manual + die
 * unsichtbaren Trennzeichen garantieren den richtigen Umbruchpunkt.
 */

get_header();

$auto_emotion_status = isset( $_GET['anfrage'] ) ? sanitize_text_field( wp_unslash( $_GET['anfrage'] ) ) : '';

echo '</div>';

get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Nissan Nutzfahrzeuge · B2B', 'auto-emotion' ),
		'headline_pre'    => __( 'Wachsen Sie', 'auto-emotion' ),
		'headline_accent' => __( 'mit Ihrem Business.', 'auto-emotion' ),
		'cta_text'        => __( 'Einsatzzwecke ansehen', 'auto-emotion' ),
		'cta_url'         => '#einsatzzwecke',
		'cta2_text'       => __( 'Anfrage senden', 'auto-emotion' ),
		'cta2_url'        => '#anfrage',
		'image'           => AUTO_EMOTION_URI . '/assets/images/nissan-nutzfahrzeuge.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => '',
		'video_webm'      => '',
	)
);

echo '<div class="container">';
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
</div>

<?php
echo '</div>';
?>
<section class="career-banner" aria-labelledby="townstar-heading">
	<div class="career-banner__media">
		<img
			class="career-banner__image"
			src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/nissan-townstar-familie-strand.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>"
			alt="Nissan Townstar"
			loading="lazy"
		>
	</div>
	<div class="career-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Nissan Townstar', 'auto-emotion' ); ?></p>
		<h2 id="townstar-heading" class="career-banner__headline"><?php esc_html_e( 'Flexibel für jeden Alltag.', 'auto-emotion' ); ?></h2>
		<p><?php esc_html_e( 'Ob als Kombi für die Familie oder als Kastenwagen für den Betrieb: Der Townstar ist vielseitig einsetzbar und auch vollelektrisch erhältlich.', 'auto-emotion' ); ?></p>
	</div>
</section>
<?php
echo '<div class="container">';
?>

<div class="section-heading" id="einsatzzwecke">
	<h2 class="section-heading__title"><?php esc_html_e( 'Für jeden Einsatzzweck das passende Fahrzeug', 'auto-emotion' ); ?></h2>
</div>
<div class="model-grid">
	<?php foreach ( $auto_emotion_b2b_use_cases as $auto_emotion_use_case ) : ?>
		<article class="model-card">
			<svg class="model-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $auto_emotion_use_case['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- feste, eigene SVG-Pfade, kein Nutzereingang. ?></svg>
			<h3 class="model-card__title"><?php echo esc_html( $auto_emotion_use_case['title'] ); ?></h3>
			<p class="model-card__text"><?php echo esc_html( $auto_emotion_use_case['text'] ); ?></p>
		</article>
	<?php endforeach; ?>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Nicht nur Nutzfahrzeuge: Dienstwagen für Vertrieb & Geschäftsführung', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Neben Nissan-Nutzfahrzeugen führen wir auch Seat und Cupra – passend für den gesamten Fuhrpark, vom internen Pool-Fahrzeug bis zum Dienstwagen für die Geschäftsführung.', 'auto-emotion' ); ?></p>
</div>
<div class="model-grid">
	<article class="fleet-card">
		<img class="fleet-card__image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/seat-modell-ibiza.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Seat Ibiza" loading="lazy">
		<div class="fleet-card__body">
			<h3 class="fleet-card__title"><?php esc_html_e( 'Kompakt für den Innendienst', 'auto-emotion' ); ?></h3>
			<p class="fleet-card__text"><?php esc_html_e( 'Der Seat Ibiza als wendiges Pool-Fahrzeug für kurze Dienstfahrten – sparsam im Unterhalt, einfach in der Verwaltung.', 'auto-emotion' ); ?></p>
		</div>
	</article>
	<article class="fleet-card">
		<img class="fleet-card__image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/seat-modell-leon-sportstourer.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Seat Leon Sportstourer" loading="lazy">
		<div class="fleet-card__body">
			<h3 class="fleet-card__title"><?php esc_html_e( 'Kombi für den Außendienst', 'auto-emotion' ); ?></h3>
			<p class="fleet-card__text"><?php esc_html_e( 'Der Seat Leon Sportstourer mit viel Platz für Gepäck und lange Strecken – für Vertriebsmitarbeitende, die viel unterwegs sind.', 'auto-emotion' ); ?></p>
		</div>
	</article>
	<article class="fleet-card">
		<img class="fleet-card__image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/cupra-modell-tavascan.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Cupra Tavascan" loading="lazy">
		<div class="fleet-card__body">
			<h3 class="fleet-card__title"><?php esc_html_e( 'Repräsentativ für die Geschäftsführung', 'auto-emotion' ); ?></h3>
			<p class="fleet-card__text"><?php esc_html_e( 'Der elektrische Cupra Tavascan als hochwertiges Business-Flaggschiff – für Führungskräfte, die Eindruck hinterlassen möchten.', 'auto-emotion' ); ?></p>
		</div>
	</article>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'So kommen Sie zu Ihrem Fuhrpark', 'auto-emotion' ); ?></h2>
</div>
<div class="process-diagram">
	<div class="process-step">
		<div class="process-step__number">1</div>
		<h3 class="process-step__title"><?php esc_html_e( 'Anfrage', 'auto-emotion' ); ?></h3>
		<p class="process-step__text"><?php esc_html_e( 'Formular ausfüllen oder anrufen – mit oder ohne konkrete Fahrzeugvorstellung.', 'auto-emotion' ); ?></p>
	</div>
	<div class="process-step">
		<div class="process-step__number">2</div>
		<h3 class="process-step__title"><?php esc_html_e( 'Angebot', 'auto-emotion' ); ?></h3>
		<p class="process-step__text"><?php esc_html_e( 'Individuelles Angebot für Einzelfahrzeug oder gesamte Flotte, inklusive Finanzierung oder Leasing.', 'auto-emotion' ); ?></p>
	</div>
	<div class="process-step">
		<div class="process-step__number">3</div>
		<h3 class="process-step__title"><?php esc_html_e( 'Beklebung & Ausstattung', 'auto-emotion' ); ?></h3>
		<p class="process-step__text"><?php esc_html_e( 'Unsere Grafikabteilung beschriftet Ihre Fahrzeuge nach Ihren Vorgaben.', 'auto-emotion' ); ?></p>
	</div>
	<div class="process-step">
		<div class="process-step__number">4</div>
		<h3 class="process-step__title"><?php esc_html_e( 'Lieferung & Service', 'auto-emotion' ); ?></h3>
		<p class="process-step__text"><?php esc_html_e( 'Übergabe und anschließend Wartung, Inspektion und Reparatur in unserer Werkstatt.', 'auto-emotion' ); ?></p>
	</div>
</div>

<div class="service-teaser-grid">
	<div class="service-teaser">
		<h3 class="service-teaser__title"><?php esc_html_e( 'Beklebung & Beschriftung', 'auto-emotion' ); ?></h3>
		<p><?php esc_html_e( 'Unsere eigene Grafikabteilung übernimmt die Beschriftung und Beklebung Ihrer Fahrzeuge – vom Logo bis zur vollflächigen Fahrzeugfolierung, individuell nach Ihren Vorgaben.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/beklebungsservice/' ) ); ?>"><?php esc_html_e( 'Zum Beklebungsservice', 'auto-emotion' ); ?><span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
	<div class="service-teaser">
		<h3 class="service-teaser__title"><?php esc_html_e( 'Service & Werkstatt für Ihren Fuhrpark', 'auto-emotion' ); ?></h3>
		<p><?php esc_html_e( 'Wartung, Inspektion und Reparatur Ihrer Nutzfahrzeuge nach Herstellervorgaben – damit Ihr Fuhrpark einsatzbereit bleibt.', 'auto-emotion' ); ?></p>
		<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/service/' ) ); ?>"><?php esc_html_e( 'Zu Service & Werkstatt', 'auto-emotion' ); ?><span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
</div>

<?php
echo '</div>';
?>
<section class="event-banner" aria-labelledby="finanzierung-b2b-heading">
	<img
		class="event-banner__image event-banner__image--finanzierung-beratung"
		src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/finanzierung-beratung.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>"
		alt=""
		loading="lazy"
	>
	<div class="event-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Finanzierung', 'auto-emotion' ); ?></p>
		<h2 id="finanzierung-b2b-heading" class="event-banner__headline"><?php echo esc_html( "Wachsen Sie mit gesch\xC3\xA4fts\xC2\xADfreundlichen Konditionen." ); ?></h2>
		<p><?php esc_html_e( 'Leasing statt Kapitalbindung: planbare monatliche Raten für Ihren Fuhrpark, abgestimmt auf Ihr Unternehmen. Ob Einzelfahrzeug oder komplette Flotte – wir erarbeiten gemeinsam mit Ihnen die passende Finanzierungs- oder Leasinglösung. Steuerliche Details klären Sie am besten zusätzlich mit Ihrem Steuerberater.', 'auto-emotion' ); ?></p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/finanzierung-leasing/' ) ); ?>">
			<?php esc_html_e( 'Zur Finanzierung & Leasing', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>
<?php
echo '<div class="container">';
?>

<?php
$auto_emotion_nutzfahrzeuge_angebote = new WP_Query(
	array(
		'post_type'      => 'angebot',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
		'post__in'       => array( 328, 329, 330 ),
		'orderby'        => 'post__in',
	)
);
?>

<?php if ( $auto_emotion_nutzfahrzeuge_angebote->have_posts() ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title"><?php esc_html_e( 'Aktuelle Geschäftskundenangebote', 'auto-emotion' ); ?></h2>
	</div>
	<div class="story-grid">
		<?php while ( $auto_emotion_nutzfahrzeuge_angebote->have_posts() ) : $auto_emotion_nutzfahrzeuge_angebote->the_post(); ?>
			<article class="product-tile">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
				<?php endif; ?>
				<h2 class="product-tile__caption"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</article>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?></h2>
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

<div class="form-panel">
<form id="anfrage" class="application-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
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

	<aside class="form-panel__aside">
		<img class="form-panel__aside-image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/service-empfang-nissan.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Nissan Service-Empfang bei Auto Emotion" loading="lazy">
		<h3><?php esc_html_e( 'Lieber direkt sprechen?', 'auto-emotion' ); ?></h3>
		<p>
			<?php esc_html_e( 'Telefon', 'auto-emotion' ); ?>:
			<a href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?></a><br>
			<?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?>:
			<a href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'email' ) ); ?></a>
		</p>
		<p>
			<?php esc_html_e( 'Öffnungszeiten Verkauf', 'auto-emotion' ); ?>:<br>
			<?php echo esc_html( auto_emotion_contact( 'hours_sales' ) ); ?>
		</p>
	</aside>
</div>

<?php
get_footer();
