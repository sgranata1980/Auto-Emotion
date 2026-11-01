<?php
/**
 * Template Name: Jahreswagen / Tageszulassungen
 *
 * Hintergrund zu Jahreswagen/Tageszulassungen recherchiert (allgemeines
 * Branchenwissen, u.a. wie Zulassungsziele/Margenstaffeln das Konzept
 * entstehen lassen) - bewusst ohne Auto-Emotion-spezifische Erfindungen
 * zu konkreten Modellen, Rabatten oder Stückzahlen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_jahreswagen_faq = array(
	array(
		'q' => __( 'Was ist der Unterschied zwischen Jahreswagen und Tageszulassung?', 'auto-emotion' ),
		'a' => __( 'Eine Tageszulassung ist ein fabrikneues Fahrzeug, das für einen oder wenige Tage auf das Autohaus zugelassen und danach sofort weiterverkauft wird – de jure ein Gebrauchtwagen, de facto aber ungefahren. Ein Jahreswagen ist tatsächlich rund ein Jahr genutzt worden, meist mit 10.000 bis 20.000 Kilometern Laufleistung, klassischerweise aus einem Werksangehörigen-Programm.', 'auto-emotion' ),
	),
	array(
		'q' => __( 'Bekomme ich auf Jahreswagen und Tageszulassungen noch Herstellergarantie?', 'auto-emotion' ),
		'a' => __( 'In der Regel ja, da die Herstellergarantie ab Erstzulassung läuft und bei Fahrzeugen mit wenigen Monaten oder einem Jahr Nutzung meist noch zum größten Teil erhalten ist. Den genauen Garantiestand zu einem konkreten Fahrzeug nennen wir Ihnen gerne.', 'auto-emotion' ),
	),
);

auto_emotion_register_faq_schema( $auto_emotion_jahreswagen_faq );

get_header();

/**
 * get_header() öffnet auf Nicht-Startseiten ein .container-Div
 * (max-width 1440px, zentriert) direkt um den gesamten Seiteninhalt.
 * Der Hero ist wie bei Gebrauchtwagen/Neuwagen als vollflächige
 * Section gedacht - bricht hier kurz aus dem Container aus (siehe
 * page-gebrauchtwagen.php für denselben Fix) und öffnet ihn danach
 * wieder.
 */
echo '</div>';

get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Seat · Cupra · Nissan', 'auto-emotion' ),
		'headline_pre'    => __( 'Fast neu.', 'auto-emotion' ),
		'headline_accent' => __( 'Kaum gefahren.', 'auto-emotion' ),
		'cta_text'        => __( 'Mehr erfahren', 'auto-emotion' ),
		'cta_url'         => '#konzept',
		'cta2_text'       => __( 'Anfrage senden', 'auto-emotion' ),
		'cta2_url'        => 'mailto:' . auto_emotion_contact( 'email' ) . '?subject=' . rawurlencode( 'Jahreswagen-Anfrage' ),
		'image'           => AUTO_EMOTION_URI . '/assets/images/showroom-formentor-born.jpg?ver=' . AUTO_EMOTION_VERSION,
		'video'           => AUTO_EMOTION_URI . '/assets/videos/cupra-formentor-b-roll.mp4?ver=' . AUTO_EMOTION_VERSION,
		'video_webm'      => AUTO_EMOTION_URI . '/assets/videos/cupra-formentor-b-roll.webm?ver=' . AUTO_EMOTION_VERSION,
	)
);

echo '<div class="container">';
?>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Jahreswagen / Tageszulassungen', 'auto-emotion' ); ?></h2>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Jahreswagen und Tageszulassungen verbinden den günstigeren Preis eines Gebrauchtwagens mit dem Zustand eines Neuwagens – minimale Laufleistung, aktuelle Ausstattung, meist noch volle Herstellergarantie.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Verfügbarkeit und Ausstattung wechseln laufend. Sprechen Sie uns an, wir sagen Ihnen gerne, welche Jahreswagen und Tageszulassungen von Seat, Cupra und Nissan aktuell bei uns verfügbar sind.', 'auto-emotion' ); ?></p>
</div>

<div class="quick-actions">
	<a class="quick-action quick-action--featured" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Jahreswagen-Anfrage' ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M4 7l8 6 8-6"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Aktuelle Verfügbarkeit anfragen', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( home_url( '/neuwagen/' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 20V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M4 20h10M7 20v-6h4v6M15 9l2.3 2.3a1 1 0 0 1 .3.7V17a1.3 1.3 0 0 0 2.6 0v-3.2a1 1 0 0 0-.3-.7L17.5 10.7M8 8h2"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Lieber frei konfigurieren', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Zu Neuwagen', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( home_url( '/gebrauchtwagen/' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><line x1="16.2" y1="16.2" x2="21" y2="21"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Gesamten Bestand durchsuchen', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Zu Gebrauchtwagen', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( home_url( '/finanzierung-leasing/' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="1"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="10.5" y2="12"/><line x1="13.5" y1="12" x2="16" y2="12"/><line x1="8" y1="16" x2="10.5" y2="16"/><line x1="13.5" y1="16" x2="16" y2="16"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Finanzierung berechnen', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Rechner öffnen', 'auto-emotion' ); ?></span>
	</a>
</div>

<?php
/**
 * Konzept-Erklärung als Career-Banner-Layout (Bild links, Text rechts)
 * statt reinem Fließtext - gleiches Komponenten-Paar wie auf der
 * Startseite (career-banner/event-banner), bricht dafür wie der Hero
 * kurz aus dem .container aus.
 */
echo '</div>';
?>
<section class="career-banner" aria-labelledby="konzept-heading" id="konzept">
	<div class="career-banner__media">
		<img
			class="career-banner__image"
			src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/showroom-nissan-xtrail.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>"
			alt="Fahrzeuge auf der Verkaufsfläche von Auto Emotion, darunter ein Nissan X-Trail"
			loading="lazy"
		>
	</div>
	<div class="career-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Hintergrund', 'auto-emotion' ); ?></p>
		<h2 id="konzept-heading" class="career-banner__headline"><?php esc_html_e( 'Wie ist das Konzept entstanden?', 'auto-emotion' ); ?></h2>
		<p><?php esc_html_e( 'Hersteller geben Autohäusern Zulassungsziele und Stückzahl-Boni vor: Je mehr Fahrzeuge ein Händler in einem bestimmten Zeitraum zulässt, desto höher fällt sein Bonus vom Hersteller aus. Eine Tageszulassung – das Autohaus meldet ein fabrikneues Fahrzeug kurz auf sich selbst an und direkt wieder ab – zählt dabei bereits als Verkauf. So entstehen Fahrzeuge, die rechtlich als gebraucht gelten, in Wirklichkeit aber nie bewegt wurden. Einen Teil des dadurch ausgelösten Bonus geben Händler als Preisvorteil an Kundinnen und Kunden weiter.', 'auto-emotion' ); ?></p>
		<p><?php esc_html_e( 'Jahreswagen haben einen anderen Ursprung: Viele Hersteller lassen Mitarbeitende Neuwagen vergünstigt least oder kaufen, verbunden mit einer Mindesthaltezeit von meist rund einem Jahr. Danach kommen diese Fahrzeuge zurück in den Handel – echt genutzt, aber mit überschaubarer Laufleistung und meist sehr gepflegt.', 'auto-emotion' ); ?></p>
	</div>
</section>

<section class="event-banner" aria-labelledby="vorteile-heading">
	<img
		class="event-banner__image"
		src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/showroom-cupra-ecke.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>"
		alt=""
		loading="lazy"
	>
	<div class="event-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Vorteil', 'auto-emotion' ); ?></p>
		<h2 id="vorteile-heading" class="event-banner__headline"><?php esc_html_e( 'Was bringt mir das als Käufer?', 'auto-emotion' ); ?></h2>
		<p><?php esc_html_e( 'Der Preisvorteil gegenüber einem echten Neuwagen kann je nach Marke und Modell spürbar ausfallen, gerade bei Tageszulassungen mit praktisch null Kilometern. Dafür verzichten Sie auf die freie Konfiguration eines Neuwagens – Ausstattung, Farbe und Motorisierung stehen bereits fest. Wer sich mit dem verfügbaren Fahrzeug anfreunden kann, bekommt ein de facto neues Auto zu einem günstigeren Preis.', 'auto-emotion' ); ?></p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Jahreswagen-Anfrage' ); ?>">
			<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>
<?php
echo '<div class="container">';
?>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Bei uns im Haus', 'auto-emotion' ); ?></h2>
</div>
<div class="photo-gallery">
	<figure>
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/showroom-nissan-juke-lounge.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Nissan Juke im Showroom von Auto Emotion" loading="lazy">
	</figure>
	<figure>
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/showroom-lounge.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Seat-Fahrzeug und Lounge-Bereich im Auto Emotion Showroom" loading="lazy">
	</figure>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Häufige Fragen', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<?php foreach ( $auto_emotion_jahreswagen_faq as $auto_emotion_faq_item ) : ?>
		<h3><?php echo esc_html( $auto_emotion_faq_item['q'] ); ?></h3>
		<p><?php echo esc_html( $auto_emotion_faq_item['a'] ); ?></p>
	<?php endforeach; ?>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Auch interessant', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p>
		<?php
		printf(
			/* translators: %1$s: link to Gebrauchtwagen page, %2$s: link to Neuwagen page */
			esc_html__( 'Den vollständigen Bestand an geprüften %1$s finden Sie auf unserer Gebrauchtwagen-Seite. Wer lieber frei konfiguriert, wird auf unserer %2$s-Seite fündig.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/gebrauchtwagen/' ) ) . '">' . esc_html__( 'Fahrzeugen', 'auto-emotion' ) . '</a>',
			'<a href="' . esc_url( home_url( '/neuwagen/' ) ) . '">' . esc_html__( 'Neuwagen', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
</div>

<div class="entry-content">
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Jahreswagen-Anfrage' ); ?>">
			<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</p>
</div>

<?php
get_footer();
