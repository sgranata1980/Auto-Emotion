<?php
/**
 * Template Name: Neuwagen
 *
 * Modellbeschreibungen auf Basis von Segment/Positionierung und
 * bekannten, stabilen Fakten (Antriebsart, Plattform, Historie) -
 * bewusst ohne volatile Einzelangaben (genaue PS-Zahlen, 0-100-Zeiten,
 * Preise), die sich häufig ändern und projektweit ohnehin nicht
 * einzeln gepflegt werden. Aktuelle Preise/Ausstattungen verweisen auf
 * die Marken- und Angebotsseiten bzw. die persönliche Beratung.
 *
 * Kartenraster je Marke statt reiner H3+Absatz-Textwand (Nutzer-
 * Feedback: "sieht billig aus") - Icon je Modell ist eine rein
 * visuelle Einordnung der bereits vorhandenen, echten Beschreibung in
 * unsere bestehende Karosserieform-Icon-Taxonomie
 * (auto_emotion_vehicle_filter_icon(), siehe inc/cpt.php), keine neue
 * erfundene Angabe.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * @param string $slug  Icon-Slug aus auto_emotion_vehicle_filter_icon() (suv/kombi/kompakt/kleinwagen).
 * @param string $title Modellname.
 * @param string $text  Beschreibungstext.
 */
function auto_emotion_neuwagen_model_card( $slug, $title, $text ) {
	?>
	<article class="model-card">
		<svg class="model-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<?php auto_emotion_vehicle_filter_icon( $slug ); ?>
		</svg>
		<h3 class="model-card__title"><?php echo esc_html( $title ); ?></h3>
		<p class="model-card__text"><?php echo esc_html( $text ); ?></p>
	</article>
	<?php
}
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Neuwagen', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Als Vertragshändler für Seat, Cupra und Nissan bieten wir Ihnen das komplette aktuelle Modellprogramm aller drei Marken – vom kompakten Stadtauto bis zum vollelektrischen SUV. Für aktuelle Preise, Ausstattungslinien und Lieferzeiten sprechen Sie uns am besten direkt an, dazu ändert sich zu viel, als dass wir es hier verlässlich pflegen könnten.', 'auto-emotion' ); ?></p>
</div>

<div class="quick-actions">
	<a class="quick-action" href="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="10" cy="10" r="6.5"/><line x1="14.8" y1="14.8" x2="20" y2="20"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Aktuelle Angebote', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Angebote ansehen', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( home_url( '/finanzierung-leasing/' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="1"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="10.5" y2="12"/><line x1="13.5" y1="12" x2="16" y2="12"/><line x1="8" y1="16" x2="10.5" y2="16"/><line x1="13.5" y1="16" x2="16" y2="16"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Finanzierung berechnen', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Rechner öffnen', 'auto-emotion' ); ?></span>
	</a>
	<a class="quick-action" href="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
		<svg class="quick-action__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="15" r="3"/><path d="M11 13l8-8 2 2-2 2 1.5 1.5L19 12l-5.5 5.5"/><path d="M15.5 9.5l2 2"/></svg>
		<span class="quick-action__title"><?php esc_html_e( 'Probefahrt vereinbaren', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Jetzt anfragen', 'auto-emotion' ); ?></span>
	</a>
	<button type="button" class="quick-action js-open-chat">
		<?php auto_emotion_ai_badge_icon( 24 ); ?>
		<span class="quick-action__title"><?php esc_html_e( 'Welches Modell passt zu mir?', 'auto-emotion' ); ?></span>
		<span class="btn btn-outline quick-action__btn"><?php esc_html_e( 'Emo fragen', 'auto-emotion' ); ?></span>
	</button>
</div>

<section class="career-banner" aria-labelledby="neuwagen-seat-heading">
	<div class="career-banner__media">
		<img class="career-banner__image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/neuwagen-seat-lineup.png?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Seat Ibiza, Arona und Leon im Showroom von Auto Emotion" loading="lazy">
	</div>
	<div class="career-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Seit 2001 bei Auto Emotion', 'auto-emotion' ); ?></p>
		<h2 id="neuwagen-seat-heading" class="career-banner__headline">SEAT</h2>
		<p><?php esc_html_e( 'Die spanische Volumenmarke des VW-Konzerns – zugängliche Preise, jugendliches Design, Verbrenner mit zunehmender Mild-Hybrid-Technik.', 'auto-emotion' ); ?></p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/marke/seat/' ) ); ?>">
			<?php esc_html_e( 'Alle Seat-Angebote ansehen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>

<div class="model-grid">
	<?php
	auto_emotion_neuwagen_model_card( 'kleinwagen', 'Seat Ibiza', __( 'Der Kleinwagen der Marke, seit Jahrzehnten das meistverkaufte Modell von Seat – kompakt, wendig, mit vergleichsweise günstigem Einstiegspreis.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Seat Arona', __( 'Der kompakte SUV auf Ibiza-Basis: höhere Sitzposition, mehr Kofferraum, gleiches zugängliches Preissegment.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Seat Ateca', __( 'Der größere Kompakt-SUV von Seat, eine Klasse über dem Arona – mehr Platz für Familien, wahlweise mit Allradantrieb.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'kompakt', 'Seat Leon', __( 'Das Kompaktklasse-Modell von Seat, als Fünftürer und als Kombi (Sportstourer) erhältlich – das technische Rückgrat, auf dem auch der Cupra Leon aufbaut.', 'auto-emotion' ) );
	?>
</div>

<section class="career-banner" aria-labelledby="neuwagen-cupra-heading">
	<div class="career-banner__media">
		<img class="career-banner__image career-banner__image--formentor" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/neuwagen-cupra-formentor.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="CUPRA Formentor, offizielles Herstellerfoto" loading="lazy">
	</div>
	<div class="career-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'CUPRA Specialist seit 2018', 'auto-emotion' ); ?></p>
		<h2 id="neuwagen-cupra-heading" class="career-banner__headline">CUPRA</h2>
		<p><?php esc_html_e( 'Die 2018 aus Seat ausgegründete Performance-Marke – eigenständiges Design, sportliche Abstimmung, konsequent elektrifiziert.', 'auto-emotion' ); ?></p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/marke/cupra/' ) ); ?>">
			<?php esc_html_e( 'Alle Cupra-Angebote ansehen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<p class="career-banner__wltp">
			<?php esc_html_e( 'Abgebildet: CUPRA Formentor. Kraftstoffverbrauch kombiniert: 1,4–10,2 l/100 km; CO₂-Emissionen kombiniert: 32–231 g/km; CO₂-Klasse: B–G (Werte je nach Motorisierung, gemäß WLTP).', 'auto-emotion' ); ?>
		</p>
	</div>
</section>

<div class="model-grid">
	<?php
	auto_emotion_neuwagen_model_card( 'suv', 'Cupra Formentor', __( 'Das erste Modell, das von Grund auf als Cupra entwickelt wurde – ein coupéhaft gezeichneter Kompakt-SUV, das Topmodell stark motorisiert und wahlweise mit Allradantrieb.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'kompakt', 'Cupra Leon / Sportstourer', __( 'Die sportliche Version des Seat Leon, als Fünftürer und als Kombi – straffere Abstimmung, mehr Leistung, eigenständige Optik.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'kompakt', 'Cupra Born', __( 'Cupras erstes vollelektrisches Modell, auf der MEB-Plattform des VW-Konzerns – kompakte Außenmaße, sportlich abgestimmtes Fahrwerk.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'kleinwagen', 'Cupra Raval', __( 'Der neue, vollelektrische Kleinwagen von Cupra – gebaut auf der MEB-Plattform, das bislang kompakteste und zugänglichste Modell der Marke.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Cupra Tavascan', __( 'Ein vollelektrisches Coupé-SUV, ebenfalls auf der MEB-Plattform – größer und praktischer als der Born, mit markant abfallender Dachlinie.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Cupra Terramar', __( 'Der neueste Zugang im Cupra-Programm: ein Kompakt-SUV mit Verbrenner- und Plug-in-Hybrid-Antrieben.', 'auto-emotion' ) );
	?>
</div>

<section class="career-banner" aria-labelledby="neuwagen-nissan-heading">
	<img class="career-banner__image career-banner__image--nissan-garage" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/neuwagen-nissan-lineup.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Nissan Juke, Qashqai und X-Trail im Showroom von Auto Emotion" loading="lazy">
	<div class="career-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Nissan GT-R High Performance Center seit 2018', 'auto-emotion' ); ?></p>
		<h2 id="neuwagen-nissan-heading" class="career-banner__headline">NISSAN</h2>
		<p><?php esc_html_e( 'Der japanische Hersteller, bei Auto Emotion seit 2015 im Programm – bekannt für SUVs und frühe, konsequente Elektrifizierung.', 'auto-emotion' ); ?></p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/marke/nissan/' ) ); ?>">
			<?php esc_html_e( 'Alle Nissan-Angebote ansehen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>

<div class="model-grid">
	<?php
	auto_emotion_neuwagen_model_card( 'kleinwagen', 'Nissan Micra', __( 'Der Kleinwagen der Marke, in aktueller Generation vollelektrisch – Nissans Antwort auf die Elektrifizierung des Kleinwagensegments.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Nissan Juke', __( 'Der kompakte Crossover mit markantem, polarisierendem Design – eines der prägenden Modelle im B-SUV-Segment.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Nissan Qashqai', __( 'Nissans Erfolgsmodell und Namensgeber des Kompakt-SUV-Segments – unter anderem mit e-POWER: ein Elektromotor treibt an, ein kleiner Verbrenner lädt nur die Batterie nach.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Nissan X-Trail', __( 'Der größere SUV im Programm, wahlweise mit bis zu sieben Sitzen und e-4ORCE-Allradantrieb in Kombination mit e-POWER.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'suv', 'Nissan Ariya', __( 'Nissans vollelektrisches Coupé-SUV, aufgebaut auf der konzerneigenen CMF-EV-Plattform – das modernste Elektromodell der Marke.', 'auto-emotion' ) );
	auto_emotion_neuwagen_model_card( 'kompakt', 'Nissan Leaf', __( 'Einer der ersten in Großserie gebauten Elektro-Pkw der Welt, seit 2010 im Markt – über die Jahre mehrfach überarbeitet.', 'auto-emotion' ) );
	?>
</div>

<div class="entry-content">
	<p>
		<?php
		printf(
			/* translators: 1: link to Elektro & Hybrid page, 2: link to Finanzierung & Leasing page */
			esc_html__( 'Mehr zu Förderung und Technik der Elektro- und Hybridmodelle auf unserer Seite %1$s, mehr zu Kauf, Finanzierung und Leasing auf unserer Seite %2$s.', 'auto-emotion' ),
			'<a href="' . esc_url( home_url( '/elektro-hybrid/' ) ) . '">' . esc_html__( 'Elektro & Hybrid', 'auto-emotion' ) . '</a>',
			'<a href="' . esc_url( home_url( '/finanzierung-leasing/' ) ) . '">' . esc_html__( 'Finanzierung & Leasing', 'auto-emotion' ) . '</a>'
		);
		?>
	</p>
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Neuwagen-Anfrage' ); ?>">
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
