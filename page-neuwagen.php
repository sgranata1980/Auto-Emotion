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
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Neuwagen', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Als Vertragshändler für Seat, Cupra und Nissan bieten wir Ihnen das komplette aktuelle Modellprogramm aller drei Marken – vom kompakten Stadtauto bis zum vollelektrischen SUV. Ein Überblick über die Modelle, ihre Einordnung und ihren Antrieb – für aktuelle Preise, Ausstattungslinien und Lieferzeiten sprechen Sie uns am besten direkt an, dazu ändert sich zu viel, als dass wir es hier verlässlich pflegen könnten.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title">SEAT</h2>
</div>
<img class="content-header-image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/neuwagen-seat-lineup.png?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Seat Ibiza, Arona und Leon im Showroom von Auto Emotion" loading="lazy">
<div class="entry-content">
	<p><?php esc_html_e( 'Die spanische Volumenmarke des VW-Konzerns, bei Auto Emotion Gründungsmarke seit 2001 – zugängliche Preise, jugendliches Design, Verbrenner mit zunehmender Mild-Hybrid-Technik.', 'auto-emotion' ); ?></p>
	<h3>Seat Ibiza</h3>
	<p><?php esc_html_e( 'Der Kleinwagen der Marke, seit Jahrzehnten das meistverkaufte Modell von Seat – kompakt, wendig, mit vergleichsweise günstigem Einstiegspreis.', 'auto-emotion' ); ?></p>
	<h3>Seat Arona</h3>
	<p><?php esc_html_e( 'Der kompakte SUV auf Ibiza-Basis: höhere Sitzposition, mehr Kofferraum, gleiches zugängliches Preissegment.', 'auto-emotion' ); ?></p>
	<h3>Seat Ateca</h3>
	<p><?php esc_html_e( 'Der größere Kompakt-SUV von Seat, eine Klasse über dem Arona – mehr Platz für Familien, wahlweise mit Allradantrieb.', 'auto-emotion' ); ?></p>
	<h3>Seat Leon</h3>
	<p><?php esc_html_e( 'Das Kompaktklasse-Modell von Seat, als Fünftürer und als Kombi (Sportstourer) erhältlich – das technische Rückgrat, auf dem auch der Cupra Leon aufbaut.', 'auto-emotion' ); ?></p>
	<p><a href="<?php echo esc_url( home_url( '/marke/seat/' ) ); ?>"><?php esc_html_e( 'Alle Seat-Modelle und aktuelle Angebote bei Auto Emotion', 'auto-emotion' ); ?></a></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title">CUPRA</h2>
</div>
<img class="content-header-image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/neuwagen-cupra-lineup.png?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Cupra Formentor, Leon und Born im Showroom von Auto Emotion" loading="lazy">
<div class="entry-content">
	<p><?php esc_html_e( 'Die 2018 aus Seat ausgegründete Performance-Marke – eigenständiges Design, sportliche Abstimmung, konsequent elektrifiziert. Auto Emotion ist seit 2018 als CUPRA Specialist ausgezeichnet.', 'auto-emotion' ); ?></p>
	<h3>Cupra Formentor</h3>
	<p><?php esc_html_e( 'Das erste Modell, das von Grund auf als Cupra entwickelt wurde, ohne direktes Seat-Pendant – ein coupéhaft gezeichneter Kompakt-SUV, das Topmodell der Baureihe ist seit jeher stark motorisiert und wahlweise mit Allradantrieb erhältlich.', 'auto-emotion' ); ?></p>
	<h3>Cupra Leon / Leon Sportstourer</h3>
	<p><?php esc_html_e( 'Die sportliche Version des Seat Leon, als Fünftürer und als Kombi – straffere Abstimmung, mehr Leistung, eigenständige Optik.', 'auto-emotion' ); ?></p>
	<h3>Cupra Born</h3>
	<p><?php esc_html_e( 'Cupras erstes vollelektrisches Modell, auf der MEB-Plattform des VW-Konzerns – kompakte Außenmaße, sportlich abgestimmtes Fahrwerk, sofortiger Drehmomentaufbau typisch für den Elektroantrieb.', 'auto-emotion' ); ?></p>
	<h3>Cupra Tavascan</h3>
	<p><?php esc_html_e( 'Ein vollelektrisches Coupé-SUV, ebenfalls auf der MEB-Plattform – größer und praktischer als der Born, mit markant abfallender Dachlinie.', 'auto-emotion' ); ?></p>
	<h3>Cupra Terramar</h3>
	<p><?php esc_html_e( 'Der neueste Zugang im Cupra-Programm: ein Kompakt-SUV mit Verbrenner- und Plug-in-Hybrid-Antrieben, positioniert zwischen Formentor und den größeren Konzern-SUVs.', 'auto-emotion' ); ?></p>
	<p><a href="<?php echo esc_url( home_url( '/marke/cupra/' ) ); ?>"><?php esc_html_e( 'Alle Cupra-Modelle und aktuelle Angebote bei Auto Emotion', 'auto-emotion' ); ?></a></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title">NISSAN</h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Der japanische Hersteller, bei Auto Emotion seit 2015 im Programm, seit 2018 zusätzlich als Nissan GT-R High Performance Center ausgezeichnet – bekannt für SUVs und frühe, konsequente Elektrifizierung.', 'auto-emotion' ); ?></p>
	<h3>Nissan Micra</h3>
	<p><?php esc_html_e( 'Der Kleinwagen der Marke, in aktueller Generation vollelektrisch – Nissans Antwort auf die Elektrifizierung des Kleinwagensegments.', 'auto-emotion' ); ?></p>
	<h3>Nissan Juke</h3>
	<p><?php esc_html_e( 'Der kompakte Crossover mit markantem, polarisierendem Design – seit seiner Einführung eines der prägenden Modelle im B-SUV-Segment.', 'auto-emotion' ); ?></p>
	<h3>Nissan Qashqai</h3>
	<p><?php esc_html_e( 'Nissans Erfolgsmodell und Namensgeber des Kompakt-SUV-Segments in Europa – unter anderem mit e-POWER erhältlich: ein Elektromotor treibt die Räder an, ein kleiner Verbrennungsmotor lädt lediglich die Batterie nach, ganz ohne externes Laden.', 'auto-emotion' ); ?></p>
	<h3>Nissan X-Trail</h3>
	<p><?php esc_html_e( 'Der größere SUV im Programm, wahlweise mit bis zu sieben Sitzen und e-4ORCE-Allradantrieb (zwei Elektromotoren, einer pro Achse) in Kombination mit e-POWER.', 'auto-emotion' ); ?></p>
	<h3>Nissan Ariya</h3>
	<p><?php esc_html_e( 'Nissans vollelektrisches Coupé-SUV, aufgebaut auf der konzerneigenen CMF-EV-Plattform – das bislang modernste Elektromodell der Marke.', 'auto-emotion' ); ?></p>
	<h3>Nissan Leaf</h3>
	<p><?php esc_html_e( 'Einer der ersten in Großserie gebauten Elektro-Pkw der Welt, seit 2010 im Markt – über die Jahre mehrfach überarbeitet und weiterentwickelt.', 'auto-emotion' ); ?></p>
	<p><a href="<?php echo esc_url( home_url( '/marke/nissan/' ) ); ?>"><?php esc_html_e( 'Alle Nissan-Modelle und aktuelle Angebote bei Auto Emotion', 'auto-emotion' ); ?></a></p>
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
