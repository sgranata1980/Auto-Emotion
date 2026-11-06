<?php
/**
 * Archive template for the "marke" taxonomy (Cupra, Seat, Nissan).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_term = get_queried_object();

/**
 * Großer Video-/Bild-Hero statt kleinem statischen Kopfbild (Nutzer-
 * Feedback: "bei Marken ... Header ganz groß, mit einem Video").
 * Alle drei Marken nutzen echtes Herstellermaterial (Seat Arona,
 * Cupra Born VZ, Nissan Leaf).
 */
$auto_emotion_marke_heroes = array(
	'nissan' => array(
		'eyebrow'         => 'Nissan bei Auto Emotion',
		'headline_pre'    => "Innova\xC2\xADtion",
		'headline_accent' => __( 'für jeden Tag.', 'auto-emotion' ),
		'image'           => 'nissan-header-spot-poster.jpg',
		'video'           => 'nissan-header-spot.mp4',
		'video_webm'      => '',
	),
	'seat'   => array(
		'eyebrow'         => 'Seat bei Auto Emotion',
		'headline_pre'    => __( 'Typisch', 'auto-emotion' ),
		'headline_accent' => __( 'spanisch.', 'auto-emotion' ),
		'image'           => 'seat-header-spot-poster.jpg',
		'video'           => 'seat-header-spot.mp4',
		'video_webm'      => '',
	),
	'cupra'  => array(
		'eyebrow'         => 'Cupra bei Auto Emotion',
		'headline_pre'    => __( 'Mehr als', 'auto-emotion' ),
		'headline_accent' => __( 'nur schnell.', 'auto-emotion' ),
		'image'           => 'cupra-header-spot-pro-poster.jpg',
		'video'           => 'cupra-header-spot-pro.mp4',
		'video_webm'      => '',
	),
);
$auto_emotion_marke_hero  = $auto_emotion_marke_heroes[ $auto_emotion_term->slug ] ?? null;

if ( $auto_emotion_marke_hero ) {
	echo '</div>';

	get_template_part(
		'template-parts/hero',
		null,
		array(
			'eyebrow'         => $auto_emotion_marke_hero['eyebrow'],
			'headline_pre'    => $auto_emotion_marke_hero['headline_pre'],
			'headline_accent' => $auto_emotion_marke_hero['headline_accent'],
			'cta_text'        => __( 'Modelle entdecken', 'auto-emotion' ),
			'cta_url'         => '#modelle',
			'cta2_text'       => __( 'Anfrage senden', 'auto-emotion' ),
			'cta2_url'        => 'mailto:' . auto_emotion_contact( 'email' ) . '?subject=' . rawurlencode( $auto_emotion_term->name . '-Anfrage' ),
			'image'           => AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_marke_hero['image'] . '?ver=' . AUTO_EMOTION_VERSION,
			'video'           => $auto_emotion_marke_hero['video'] ? AUTO_EMOTION_URI . '/assets/videos/' . $auto_emotion_marke_hero['video'] . '?ver=' . AUTO_EMOTION_VERSION : '',
			'video_webm'      => $auto_emotion_marke_hero['video_webm'] ? AUTO_EMOTION_URI . '/assets/videos/' . $auto_emotion_marke_hero['video_webm'] . '?ver=' . AUTO_EMOTION_VERSION : '',
		)
	);

	echo '<div class="container">';
}

/**
 * Markenlogo neben dem H1. Das Seat-Symbol ist aus dem offiziellen
 * Logo-Motiv freigestellt, nicht nachgezeichnet. alt bleibt leer, weil
 * der H1 daneben die Marke bereits benennt.
 */
$auto_emotion_marke_logos = array(
	'seat' => array(
		'file'   => 'seat-logo.png',
		'width'  => 141,
		'height' => 126,
	),
	'cupra' => array(
		'file'   => 'cupra-logo.png',
		'width'  => 856,
		'height' => 659,
	),
	'nissan' => array(
		'file'   => 'nissan-logo.png',
		'width'  => 729,
		'height' => 610,
	),
);
$auto_emotion_marke_logo  = $auto_emotion_marke_logos[ $auto_emotion_term->slug ] ?? null;
?>

<div class="section-heading<?php echo $auto_emotion_marke_logo ? ' section-heading--marke' : ''; ?>">
	<?php if ( $auto_emotion_marke_logo ) : ?>
		<img
			class="section-heading__logo"
			src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_marke_logo['file'] . '?ver=' . AUTO_EMOTION_VERSION ); ?>"
			alt=""
			width="<?php echo (int) $auto_emotion_marke_logo['width']; ?>"
			height="<?php echo (int) $auto_emotion_marke_logo['height']; ?>"
		>
	<?php endif; ?>
	<h1 class="section-heading__title"><?php echo esc_html( $auto_emotion_term->name ); ?></h1>
</div>

<?php if ( $auto_emotion_term->description ) : ?>
	<div class="archive-description"><?php echo wp_kses_post( wpautop( $auto_emotion_term->description ) ); ?></div>
<?php endif; ?>

<?php
/**
 * Ein vollflächiges Imagebild je Marke zwischen Einleitung und
 * Modellraster (Nutzer-Feedback: "ab und an mal vollflächig ein
 * paar Imagebilder") - echte, bislang auf dieser Seite ungenutzte
 * Pressefotos statt generischer Deko. Mit 'hoch' läuft das Bild im
 * Seitenverhältnis statt in fester Höhe (width/height halten den
 * Platz frei); ein zweites Foto steht weiter unten nach den Angeboten.
 */
$auto_emotion_marke_bild_full = array(
	'nissan' => array(
		'image'  => 'nissan-bild-full-primastar.jpg',
		'alt'    => 'Nissan Primastar Kombi auf einer Landstraße bei tief stehender Sonne, offizielles Pressefoto',
		'width'  => 2560,
		'height' => 2003,
		'hoch'   => true,
	),
	'seat'   => array(
		'image'  => 'seat-bild-full-1.jpg',
		'alt'    => 'Seat Arona und Seat Ibiza an der Küste vor einer Altstadt auf dem Hügel, offizielles Pressefoto',
		'width'  => 2560,
		'height' => 1707,
		'hoch'   => true,
	),
	'cupra'  => array(
		'image'  => 'cupra-bild-full-raval.jpg',
		'alt'    => 'Cupra Raval in einer Hofeinfahrt unter einem großen weißen Cupra-Logo, offizielles Pressefoto',
		'width'  => 2560,
		'height' => 1707,
		'hoch'   => true,
	),
);
$auto_emotion_bild_full       = $auto_emotion_marke_bild_full[ $auto_emotion_term->slug ] ?? null;
$auto_emotion_bild_full_hoch  = ! empty( $auto_emotion_bild_full['hoch'] );

$auto_emotion_marke_bild_full_2 = array(
	'seat' => array(
		'image'  => 'seat-bild-full-2.jpg',
		'alt'    => 'Roter Seat Ibiza FR an der Küste bei Sonnenuntergang, offizielles Pressefoto',
		'width'  => 2560,
		'height' => 1706,
	),
);
$auto_emotion_bild_full_2       = $auto_emotion_marke_bild_full_2[ $auto_emotion_term->slug ] ?? null;
?>

<?php if ( $auto_emotion_bild_full ) : ?>
	<?php echo '</div>'; ?>
	<img
		class="content-header-image<?php echo $auto_emotion_bild_full_hoch ? ' content-header-image--hoch' : ''; ?>"
		src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_bild_full['image'] . '?ver=' . AUTO_EMOTION_VERSION ); ?>"
		alt="<?php echo esc_attr( $auto_emotion_bild_full['alt'] ); ?>"
		<?php if ( $auto_emotion_bild_full_hoch ) : ?>
			width="<?php echo (int) $auto_emotion_bild_full['width']; ?>"
			height="<?php echo (int) $auto_emotion_bild_full['height']; ?>"
		<?php endif; ?>
		loading="lazy"
	>
	<?php echo '<div class="container">'; ?>
<?php endif; ?>

<?php
/**
 * Markentypische Lackfarben – echte, für die Marke bekannte
 * Farbnamen (u. a. erhältlich, nicht als exakte Verfügbarkeit für
 * jede einzelne Ausstattungslinie zu verstehen). Ein Fotowechsel je
 * Farbe findet bewusst nicht statt, um keine zusätzlichen Bilder
 * erzeugen zu müssen.
 */
$auto_emotion_marke_farben = array(
	'nissan' => array(
		array(
			'name' => __( 'Pearl White', 'auto-emotion' ),
			'hex'  => '#f1f1f0',
		),
		array(
			'name' => __( 'Gun Metallic', 'auto-emotion' ),
			'hex'  => '#55575a',
		),
		array(
			'name' => __( 'Vivid Blue', 'auto-emotion' ),
			'hex'  => '#1e5fa8',
		),
	),
	'seat'   => array(
		array(
			'name' => __( 'Desire Red', 'auto-emotion' ),
			'hex'  => '#c8102e',
		),
		array(
			'name' => __( 'Nevada White', 'auto-emotion' ),
			'hex'  => '#f2f1ec',
		),
		array(
			'name' => __( 'Graphene Grey', 'auto-emotion' ),
			'hex'  => '#4a4c4e',
		),
	),
	'cupra'  => array(
		array(
			'name' => __( 'Century Bronze', 'auto-emotion' ),
			'hex'  => '#7a6a55',
		),
		array(
			'name' => __( 'Enceladus Grey', 'auto-emotion' ),
			'hex'  => '#6e7276',
		),
		array(
			'name' => __( 'Petrol Blue', 'auto-emotion' ),
			'hex'  => '#1f3b45',
		),
	),
);
$auto_emotion_farben       = $auto_emotion_marke_farben[ $auto_emotion_term->slug ] ?? array();

/**
 * Felgen- und Interieur-Stufen: bewusst allgemein gehalten (keine
 * erfundenen Modellbezeichnungen), da echte, modellspezifische
 * Felgen-/Polsternamen nicht für jedes Modell zuverlässig vorliegen.
 */
$auto_emotion_felgen_optionen    = array(
	__( '16–17" Serienfelgen', 'auto-emotion' ),
	__( '18–19" Leichtmetallfelgen (optional)', 'auto-emotion' ),
);
$auto_emotion_interieur_optionen = array(
	__( 'Stoffausstattung (Serie)', 'auto-emotion' ),
	__( 'Teilleder/Leder (ausstattungsabhängig optional)', 'auto-emotion' ),
);

/**
 * Modellübersicht je Marke, ohne Preise. "engines" sind die im
 * Konfigurator wählbaren Motorisierungen. Details
 * klappen pro Kachel per <details> auf, der Konfigurator selbst
 * braucht nur eine kleine, unaufdringliche JS-Datei zur Anzeige der
 * Auswahl (keine Preisberechnung, keine Datenübertragung ohne Klick
 * auf den Anfrage-Button).
 */
$auto_emotion_marke_modelle = array(
	'nissan' => array(
		array(
			'image'       => 'nissan-modell-juke.jpg',
			'name'        => 'Nissan Juke',
			'description' => __( 'Coupé-SUV mit auffälligem Design und wendigem Fahrverhalten im Stadtverkehr.', 'auto-emotion' ),
			'engines'     => array( '1.0 DIG-T 114 PS', 'e-Power Vollhybrid 143 PS' ),
		),
		array(
			'image'       => 'nissan-modell-qashqai.jpg',
			'name'        => 'Nissan Qashqai',
			'description' => __( 'Nissans meistverkauftes Modell in Europa – geräumiges Kompakt-SUV mit moderner Hybridtechnik.', 'auto-emotion' ),
			'engines'     => array( '1.3 DIG-T Mild-Hybrid 140 PS', '1.3 DIG-T Mild-Hybrid 158 PS', 'e-Power Vollhybrid 190 PS' ),
		),
		array(
			'image'       => 'nissan-modell-xtrail.jpg',
			'name'        => 'Nissan X-Trail',
			'description' => __( 'Das große SUV der Marke, serienmäßig mit Hybridantrieb – auch mit Allrad und dritter Sitzreihe.', 'auto-emotion' ),
			'engines'     => array( 'e-Power Vollhybrid 204 PS', 'e-4ORCE Allrad-Hybrid 213 PS' ),
		),
		array(
			'image'       => 'nissan-modell-ariya.jpg',
			'name'        => 'Nissan Ariya',
			'description' => __( 'Elektrisches Coupé-SUV mit großzügigem Innenraum und leisem Fahrgefühl.', 'auto-emotion' ),
			'engines'     => array( '63 kWh, 218 PS', '87 kWh, 242 PS', 'e-4ORCE Allrad bis 306 PS' ),
		),
		array(
			'image'       => 'nissan-modell-micra.jpg',
			'name'        => 'Nissan Micra',
			'description' => __( 'Kompakter Stadtwagen, jetzt vollelektrisch – wendig und alltagstauglich für die Stadt.', 'auto-emotion' ),
			'engines'     => array( '40 kWh, 122 PS' ),
		),
		array(
			'image'       => 'nissan-modell-leaf.jpg',
			'name'        => 'Nissan Leaf',
			'description' => __( 'Der Elektro-Pionier von Nissan, komplett neu aufgelegt – geräumiger Kompaktwagen mit langer Serientradition.', 'auto-emotion' ),
			'engines'     => array( '52 kWh, 176 PS', '75 kWh, 217 PS' ),
		),
	),
	'seat'   => array(
		array(
			'image'       => 'seat-modell-arona.jpg',
			'name'        => 'Seat Arona',
			'description' => __( 'Kompaktes SUV für die Stadt – sparsam, wendig und mit viel Platz für seine Klasse.', 'auto-emotion' ),
			'engines'     => array( '1.0 TSI 81 PS', '1.0 TSI 95 PS', '1.0 TSI 110 PS' ),
		),
		array(
			'image'       => 'seat-modell-ateca.jpg',
			'name'        => 'Seat Ateca',
			'description' => __( 'Familientaugliches SUV mit großzügigem Kofferraum und optionalem Allradantrieb.', 'auto-emotion' ),
			'engines'     => array( '1.0 TSI 110 PS', '1.5 TSI 150 PS', '1.5 TSI 150 PS mit Allrad' ),
		),
		array(
			'image'       => 'seat-modell-ibiza.jpg',
			'name'        => 'Seat Ibiza',
			'description' => __( 'Der Kleinwagen-Klassiker von Seat – sparsam im Verbrauch und ideal für den Alltag.', 'auto-emotion' ),
			'engines'     => array( '1.0 MPI 80 PS', '1.0 TSI 95 PS', '1.0 TSI 115 PS' ),
		),
		array(
			'image'       => 'seat-modell-leon.jpg',
			'name'        => 'Seat Leon',
			'description' => __( 'Die Kompaktklasse von Seat – sportlich abgestimmt, wahlweise auch als Plug-in-Hybrid.', 'auto-emotion' ),
			'engines'     => array( '1.0 TSI 110 PS', '1.5 TSI 150 PS', 'e-HYBRID 204 PS (Plug-in)' ),
		),
		array(
			'image'       => 'seat-modell-leon-sportstourer.jpg',
			'name'        => 'Seat Leon Sportstourer',
			'description' => __( 'Der Kombi zum Leon – gleiche Motoren, mehr Platz für Gepäck und Familie.', 'auto-emotion' ),
			'engines'     => array( '1.0 TSI 110 PS', '1.5 TSI 150 PS', 'e-HYBRID 204 PS (Plug-in)' ),
		),
	),
	'cupra'  => array(
		array(
			'image'       => 'cupra-modell-born.jpg',
			'name'        => 'Cupra Born',
			'description' => __( 'Cupras erstes vollelektrisches Modell – sportlich abgestimmtes Fahrwerk in kompakter Karosserie.', 'auto-emotion' ),
			'engines'     => array( '58 kWh, 190 PS', '79 kWh, 231 PS', 'VZ 79 kWh, 326 PS' ),
		),
		array(
			'image'       => 'cupra-modell-tavascan.jpg',
			'name'        => 'Cupra Tavascan',
			'description' => __( 'Elektrisches Coupé-SUV mit markantem Design und sportlicher Auslegung.', 'auto-emotion' ),
			'engines'     => array( '58 kWh, 190 PS', '77 kWh, 286 PS', 'VZ 77 kWh, 340 PS Allrad' ),
		),
		array(
			'image'       => 'cupra-modell-terramar.jpg',
			'name'        => 'Cupra Terramar',
			'description' => __( 'Kompaktes SUV von Cupra, auch als Plug-in-Hybrid mit alltagstauglicher elektrischer Reichweite.', 'auto-emotion' ),
			'engines'     => array( '1.5 TSI 150 PS', 'e-HYBRID 204 PS (Plug-in)', 'e-HYBRID 272 PS (Plug-in)' ),
		),
		array(
			'image'       => 'cupra-modell-formentor.jpg',
			'name'        => 'Cupra Formentor',
			'description' => __( 'Das erste eigenständige Cupra-Modell – Coupé-SUV mit sportlichem Anspruch bis zur VZ-Topversion.', 'auto-emotion' ),
			'engines'     => array( '1.5 TSI 150 PS', '2.0 TSI 190 PS', 'e-HYBRID 204/272 PS', 'VZ über 300 PS' ),
		),
		array(
			'image'       => 'cupra-modell-leon.jpg',
			'name'        => 'Cupra Leon',
			'description' => __( 'Die sportliche Cupra-Version des Leon, mit eigenständigem Fahrwerks-Tuning.', 'auto-emotion' ),
			'engines'     => array( '1.5 eTSI 150 PS', 'e-HYBRID 204 PS (Plug-in)', 'VZ e-HYBRID 272 PS (Plug-in)' ),
		),
		array(
			'image'       => 'cupra-modell-leon-sportstourer.jpg',
			'name'        => 'Cupra Leon Sportstourer',
			'description' => __( 'Der Cupra Leon als Kombi – gleiche Sportlichkeit, mehr Platz für den Alltag.', 'auto-emotion' ),
			'engines'     => array( '1.5 eTSI 150 PS', 'e-HYBRID 204 PS (Plug-in)', 'VZ e-HYBRID 272 PS (Plug-in)' ),
		),
	),
);
$auto_emotion_modelle       = $auto_emotion_marke_modelle[ $auto_emotion_term->slug ] ?? array();

$auto_emotion_karosserie_labels = array(
	'suv'        => __( 'SUV', 'auto-emotion' ),
	'kleinwagen' => __( 'Kleinwagen', 'auto-emotion' ),
	'kompakt'    => __( 'Kompakt', 'auto-emotion' ),
	'kombi'      => __( 'Kombi', 'auto-emotion' ),
);

/**
 * Eckdaten auf der Kachel: Werte von den deutschen Herstellerseiten
 * (Stand 11/2026). "wltp" nennt genau eine Beispiel-Motorisierung,
 * "klasse" deren CO2-Klasse, zuletzt das Getriebe dieser Variante. Ausnahmen, vor Freigabe prüfen: Micra stammt aus dem
 * bisherigen Theme, Ateca aus der älteren Seat-Preisliste.
 */
$auto_emotion_eckdaten = array(
	'Cupra Born'              => array( 'kompakt', 'elektro', 'Elektrisch', '190–326 PS', 'A', 'CUPRA Born 140 kW (190 PS), 58 kWh: Stromverbrauch kombiniert: 14,3 kWh/100 km; CO₂-Emissionen kombiniert: 0 g/km; CO₂-Klasse: A', 'Automatik' ),
	'Cupra Tavascan'          => array( 'suv', 'elektro', 'Elektrisch', '190–340 PS', 'A', 'CUPRA Tavascan 140 kW (190 PS), 58 kWh: Stromverbrauch kombiniert: 15,4–17,2 kWh/100 km; CO₂-Emissionen kombiniert: 0 g/km; CO₂-Klasse: A', 'Automatik' ),
	'Cupra Terramar'          => array( 'suv', 'benzin', 'Benzin, Plug-in-Hybrid', '150–272 PS', 'E', 'CUPRA Terramar 1.5 eTSI 110 kW (150 PS), 7-Gang-DSG: Kraftstoffverbrauch kombiniert: 6,1 l/100 km; CO₂-Emissionen kombiniert: 136 g/km; CO₂-Klasse: E', '7-Gang-DSG' ),
	'Cupra Formentor'         => array( 'suv', 'benzin', 'Benzin, Diesel, Plug-in-Hybrid', '150–390 PS', 'E', 'CUPRA Formentor 1.5 TSI 110 kW (150 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 6,0 l/100 km; CO₂-Emissionen kombiniert: 136 g/km; CO₂-Klasse: E', '6-Gang-Schaltgetriebe' ),
	'Cupra Leon'              => array( 'kompakt', 'benzin', 'Benzin, Diesel, Plug-in-Hybrid', '150–325 PS', 'D', 'CUPRA Leon 1.5 TSI 110 kW (150 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 5,8 l/100 km; CO₂-Emissionen kombiniert: 131 g/km; CO₂-Klasse: D', '6-Gang-Schaltgetriebe' ),
	'Cupra Leon Sportstourer' => array( 'kombi', 'benzin', 'Benzin, Diesel, Plug-in-Hybrid', '150–333 PS', 'D–E', 'CUPRA Leon Sportstourer 1.5 TSI 110 kW (150 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 5,8–6,2 l/100 km; CO₂-Emissionen kombiniert: 132–142 g/km; CO₂-Klasse: D–E', '6-Gang-Schaltgetriebe' ),
	'Seat Arona'              => array( 'suv', 'benzin', 'Benzin', 'FR 116–150 PS', 'D', 'Seat Arona FR 1.0 TSI 85 kW (116 PS): Kraftstoffverbrauch kombiniert: 5,3–5,6 l/100 km; CO₂-Emissionen kombiniert: 120–128 g/km; CO₂-Klasse: D', '6-Gang oder 7-Gang-DSG' ),
	'Seat Ateca'              => array( 'suv', 'benzin', 'Benzin', '150 PS', 'E–F', 'Seat Ateca 1.5 TSI 110 kW (150 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 6,2–6,9 l/100 km; CO₂-Emissionen kombiniert: 141–156 g/km; CO₂-Klasse: E–F', '6-Gang-Schaltgetriebe' ),
	'Seat Ibiza'              => array( 'kleinwagen', 'benzin', 'Benzin', 'FR 95–150 PS', 'D', 'Seat Ibiza FR 1.0 TSI 85 kW (116 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 5,2–5,6 l/100 km; CO₂-Emissionen kombiniert: 117–128 g/km; CO₂-Klasse: D', '6-Gang-Schaltgetriebe' ),
	'Seat Leon'               => array( 'kompakt', 'benzin', 'Benzin, Diesel, Plug-in-Hybrid', 'FR ab 116 PS', 'D', 'Seat Leon FR 1.5 TSI 85 kW (116 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 5,5–5,9 l/100 km; CO₂-Emissionen kombiniert: 126–134 g/km; CO₂-Klasse: D', '6-Gang-Schaltgetriebe' ),
	'Seat Leon Sportstourer'  => array( 'kombi', 'benzin', 'Benzin, Diesel, Plug-in-Hybrid', 'FR 116–204 PS', 'D–E', 'Seat Leon Sportstourer FR 1.5 TSI 85 kW (116 PS), 6-Gang: Kraftstoffverbrauch kombiniert: 5,6–6,0 l/100 km; CO₂-Emissionen kombiniert: 128–136 g/km; CO₂-Klasse: D–E', '6-Gang-Schaltgetriebe' ),
	'Nissan Juke'             => array( 'suv', 'hybrid', 'Hybrid', '143 PS', 'C', 'Nissan Juke N-Connecta 1,6 l Hybrid 105 kW (143 PS), Automatik: Energieverbrauch kombiniert: 4,7 l/100 km; CO₂-Emissionen kombiniert: 107–108 g/km; CO₂-Klasse: C', 'Automatik' ),
	'Nissan Qashqai'          => array( 'suv', 'hybrid', 'Mild-Hybrid, e-POWER', '158–205 PS', 'C', 'Nissan Qashqai Acenta 1,5 l e-POWER 151 kW (205 PS), Automatik: Energieverbrauch kombiniert: 4,3 l/100 km; CO₂-Emissionen kombiniert: 98 g/km; CO₂-Klasse: C', 'Automatik' ),
	'Nissan X-Trail'          => array( 'suv', 'hybrid', 'e-POWER', '204–213 PS', 'D', 'Nissan X-Trail Acenta 1,5 l e-POWER 150 kW (204 PS): Energieverbrauch kombiniert: 5,6 l/100 km; CO₂-Emissionen kombiniert: 128 g/km; CO₂-Klasse: D', 'Automatik' ),
	'Nissan Ariya'            => array( 'suv', 'elektro', 'Elektrisch', '306 PS', 'A', 'Nissan ARIYA 87 kWh, 225 kW (306 PS), e-4ORCE: Energieverbrauch kombiniert: 20,4 kWh/100 km; CO₂-Emissionen kombiniert: 0 g/km; CO₂-Klasse: A', 'Automatik' ),
	'Nissan Micra'            => array( 'kleinwagen', 'elektro', 'Elektrisch', '122 PS', 'A', 'Nissan Micra 40 kWh (122 PS): Energieverbrauch kombiniert: 14,2 kWh/100 km; CO₂-Klasse: A', 'Automatik' ),
	'Nissan Leaf'             => array( 'kompakt', 'elektro', 'Elektrisch', '176–217 PS', 'A', 'Nissan Leaf 52 kWh, 130 kW (176 PS): Energieverbrauch kombiniert: 13,5 kWh/100 km; CO₂-Emissionen kombiniert: 0 g/km; CO₂-Klasse: A', 'Automatik' ),
);
?>

<?php if ( $auto_emotion_modelle ) : ?>
	<div class="section-heading" id="modelle">
		<h2 class="section-heading__title">
			<?php
			/* translators: %s: brand name, e.g. "Seat" */
			printf( esc_html__( 'Unsere %s-Modelle', 'auto-emotion' ), esc_html( $auto_emotion_term->name ) );
			?>
		</h2>
		<p class="section-heading__hint"><?php esc_html_e( 'Kachel anklicken und Fahrzeug konfigurieren.', 'auto-emotion' ); ?></p>
	</div>
	<div class="photo-gallery photo-gallery--products">
		<?php foreach ( $auto_emotion_modelle as $auto_emotion_index => $auto_emotion_modell ) : ?>
			<?php $auto_emotion_field_id = $auto_emotion_term->slug . '-' . $auto_emotion_index; ?>
			<?php $auto_emotion_eckdaten_modell = $auto_emotion_eckdaten[ $auto_emotion_modell['name'] ] ?? null; ?>
			<details class="model-card" id="<?php echo esc_attr( 'modell-' . sanitize_title( $auto_emotion_modell['name'] ) ); ?>">
				<summary class="model-card__summary">
					<button
						type="button"
						class="model-card__teilen"
						data-titel="<?php echo esc_attr( $auto_emotion_modell['name'] . ' bei Auto Emotion' ); ?>"
						aria-label="<?php echo esc_attr( sprintf( /* translators: %s: model name */ __( '%s teilen', 'auto-emotion' ), $auto_emotion_modell['name'] ) ); ?>"
					><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="2.6"/><circle cx="6" cy="12" r="2.6"/><circle cx="18" cy="19" r="2.6"/><path d="m8.3 10.7 7.4-4.4M8.3 13.3l7.4 4.4"/></svg></button>
					<figure>
						<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_modell['image'] . '?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="<?php echo esc_attr( $auto_emotion_modell['name'] . ', offizielles Herstellerfoto' ); ?>" loading="lazy">
						<figcaption>
							<span class="model-card__name"><?php echo esc_html( $auto_emotion_modell['name'] ); ?></span>
							<?php if ( $auto_emotion_eckdaten_modell ) : ?>
								<span class="model-card__fakten">
									<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php auto_emotion_vehicle_filter_icon( $auto_emotion_eckdaten_modell[0] ); ?></svg><?php echo esc_html( $auto_emotion_karosserie_labels[ $auto_emotion_eckdaten_modell[0] ] ); ?></span>
									<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php auto_emotion_vehicle_filter_icon( $auto_emotion_eckdaten_modell[1] ); ?></svg><?php echo esc_html( $auto_emotion_eckdaten_modell[2] ); ?></span>
									<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 16a8 8 0 1 1 16 0"/><path d="m12 16 3.5-5"/></svg><?php echo esc_html( $auto_emotion_eckdaten_modell[3] ); ?></span>
									<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="6" cy="5" r="1.8"/><circle cx="12" cy="5" r="1.8"/><circle cx="18" cy="5" r="1.8"/><circle cx="6" cy="19" r="1.8"/><circle cx="12" cy="19" r="1.8"/><path d="M6 7v10M12 7v10M18 7v5H6"/></svg><?php echo esc_html( $auto_emotion_eckdaten_modell[6] ); ?></span>
								</span>
								<span class="model-card__wltp">
									<span class="co2-badge co2-badge--<?php echo esc_attr( strtolower( substr( $auto_emotion_eckdaten_modell[4], 0, 1 ) ) ); ?>" aria-hidden="true"><?php echo esc_html( $auto_emotion_eckdaten_modell[4] ); ?></span>
									<span><?php echo esc_html( $auto_emotion_eckdaten_modell[5] ); ?></span>
								</span>
							<?php endif; ?>
							<span class="model-card__mehr">
								<?php esc_html_e( 'Konfigurieren', 'auto-emotion' ); ?>
								<span class="model-card__toggle" aria-hidden="true"></span>
							</span>
						</figcaption>
					</figure>
				</summary>
				<div class="model-card__details">
					<?php if ( ! empty( $auto_emotion_modell['description'] ) ) : ?>
						<p><?php echo esc_html( $auto_emotion_modell['description'] ); ?></p>
					<?php endif; ?>

					<div class="configurator" data-model="<?php echo esc_attr( $auto_emotion_modell['name'] ); ?>">
						<?php if ( ! empty( $auto_emotion_farben ) ) : ?>
							<fieldset class="configurator__group">
								<legend><?php esc_html_e( 'Lackfarbe', 'auto-emotion' ); ?></legend>
								<div class="configurator__colors">
									<?php foreach ( $auto_emotion_farben as $auto_emotion_farbe_index => $auto_emotion_farbe ) : ?>
										<label class="color-chip">
											<input
												type="radio"
												name="farbe-<?php echo esc_attr( $auto_emotion_field_id ); ?>"
												value="<?php echo esc_attr( $auto_emotion_farbe['name'] ); ?>"
												<?php checked( 0 === $auto_emotion_farbe_index ); ?>
											>
											<span class="color-chip__swatch" style="background-color:<?php echo esc_attr( $auto_emotion_farbe['hex'] ); ?>"></span>
											<span class="color-chip__label"><?php echo esc_html( $auto_emotion_farbe['name'] ); ?></span>
										</label>
									<?php endforeach; ?>
								</div>
							</fieldset>
						<?php endif; ?>

						<?php if ( ! empty( $auto_emotion_modell['engines'] ) ) : ?>
							<div class="configurator__group">
								<label for="motor-<?php echo esc_attr( $auto_emotion_field_id ); ?>"><?php esc_html_e( 'Motorisierung', 'auto-emotion' ); ?></label>
								<select id="motor-<?php echo esc_attr( $auto_emotion_field_id ); ?>" class="configurator__select">
									<?php foreach ( $auto_emotion_modell['engines'] as $auto_emotion_engine ) : ?>
										<option value="<?php echo esc_attr( $auto_emotion_engine ); ?>"><?php echo esc_html( $auto_emotion_engine ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						<?php endif; ?>

						<div class="configurator__group">
							<label for="felgen-<?php echo esc_attr( $auto_emotion_field_id ); ?>"><?php esc_html_e( 'Felgen', 'auto-emotion' ); ?></label>
							<select id="felgen-<?php echo esc_attr( $auto_emotion_field_id ); ?>" class="configurator__select">
								<?php foreach ( $auto_emotion_felgen_optionen as $auto_emotion_felge ) : ?>
									<option value="<?php echo esc_attr( $auto_emotion_felge ); ?>"><?php echo esc_html( $auto_emotion_felge ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="configurator__group">
							<label for="interieur-<?php echo esc_attr( $auto_emotion_field_id ); ?>"><?php esc_html_e( 'Interieur', 'auto-emotion' ); ?></label>
							<select id="interieur-<?php echo esc_attr( $auto_emotion_field_id ); ?>" class="configurator__select">
								<?php foreach ( $auto_emotion_interieur_optionen as $auto_emotion_interieur ) : ?>
									<option value="<?php echo esc_attr( $auto_emotion_interieur ); ?>"><?php echo esc_html( $auto_emotion_interieur ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<p class="configurator__summary">
							<?php esc_html_e( 'Ihre Konfiguration:', 'auto-emotion' ); ?>
							<span class="configurator__summary-text" aria-live="polite"></span>
						</p>

						<a
							class="btn btn-giallo configurator__cta"
							href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Konfiguration Anfrage: ' . $auto_emotion_modell['name'] ); ?>"
							data-href-base="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Konfiguration Anfrage: ' . $auto_emotion_modell['name'] ); ?>"
						>
							<?php esc_html_e( 'Konfiguration anfragen', 'auto-emotion' ); ?>
							<span class="btn-arrow" aria-hidden="true">&rarr;</span>
						</a>
					</div>
				</div>
			</details>
		<?php endforeach; ?>
	</div>
	<p class="model-card__disclaimer">
		<?php esc_html_e( 'Motorisierungen, Verbrauchs-/Reichweitenangaben und Farben sind allgemeine Herstellerangaben ohne Anspruch auf aktuelle Verfügbarkeit für jede Ausstattungslinie. Verbindliche Auskunft und Preise erhalten Sie auf Anfrage.', 'auto-emotion' ); ?>
	</p>


	<nav class="service-kacheln" aria-label="<?php esc_attr_e( 'Rund um Ihr Fahrzeug', 'auto-emotion' ); ?>">
		<a class="service-kachel" href="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="10" cy="10" r="6.5"/><line x1="14.8" y1="14.8" x2="20" y2="20"/></svg>
			<strong><?php esc_html_e( 'Aktuelle Angebote', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Unsere Fahrzeugangebote ansehen.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/gebrauchtwagen/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17h18M5 17l1.5-6.5a2 2 0 0 1 1.95-1.5h7.1a2 2 0 0 1 1.95 1.5L19 17"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/></svg>
			<strong><?php esc_html_e( 'Gebrauchtwagen', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Gebrauchte Fahrzeuge in unserem Bestand.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/finanzierung-leasing/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="1"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="10.5" y2="12"/><line x1="13.5" y1="12" x2="16" y2="12"/><line x1="8" y1="16" x2="10.5" y2="16"/><line x1="13.5" y1="16" x2="16" y2="16"/></svg>
			<strong><?php esc_html_e( 'Finanzierung & Leasing', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Die passende Rate für Ihr Fahrzeug finden.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/servicetermin-buchen/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="1"/><line x1="3.5" y1="10" x2="20.5" y2="10"/><line x1="8" y1="3" x2="8" y2="7"/><line x1="16" y1="3" x2="16" y2="7"/></svg>
			<strong><?php esc_html_e( 'Servicetermin', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Ihren Termin in der Werkstatt buchen.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/fahrzeugankauf/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 8h13l-3-3"/><path d="M20 16H7l3 3"/></svg>
			<strong><?php esc_html_e( 'Fahrzeugankauf', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Ihr Auto verkaufen oder in Zahlung geben.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h16v11H9l-5 4Z"/></svg>
			<strong><?php esc_html_e( 'Kontakt', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'So erreichen Sie uns in Offenbach.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="#modelle">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18h13M4.5 18l1.2-5a2 2 0 0 1 2-1.5h5.6a2 2 0 0 1 2 1.5l1.2 5"/><circle cx="7" cy="18.5" r="1.4"/><circle cx="14" cy="18.5" r="1.4"/><circle cx="18.5" cy="6.5" r="2.2"/><path d="M18.5 2.5v1.8M18.5 8.7v1.8M14.5 6.5h1.8M20.7 6.5h1.8"/></svg>
			<strong><?php esc_html_e( 'Konfigurator', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Ihr Fahrzeug zusammenstellen und anfragen.', 'auto-emotion' ); ?></span>
		</a>
		<a class="service-kachel" href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo rawurlencode( auto_emotion_contact( 'street' ) . ', ' . auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?>" target="_blank" rel="noopener">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.5"/></svg>
			<strong><?php esc_html_e( 'Standort', 'auto-emotion' ); ?></strong>
			<span><?php echo esc_html( auto_emotion_contact( 'street' ) . ', ' . auto_emotion_contact( 'city' ) ); ?></span>
		</a>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/online-shop/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 4h2.2l2.2 11h10.4l2-8H6"/><circle cx="9" cy="19" r="1.5"/><circle cx="17" cy="19" r="1.5"/></svg>
			<strong><?php esc_html_e( 'Online-Shop', 'auto-emotion' ); ?></strong>
			<span><?php esc_html_e( 'Unseren Shop ansehen.', 'auto-emotion' ); ?></span>
		</a>
	</nav>
<?php endif; ?>

<?php
$auto_emotion_marke_showroom_fotos = array(
	'nissan' => array(
		array(
			'image' => 'showroom-nissan-designlab.jpg',
			'name'  => 'Nissan Design Lab im Showroom',
		),
		array(
			'image' => 'showroom-nissan-evs.jpg',
			'name'  => 'Nissan Elektrofahrzeuge im Showroom',
		),
		array(
			'image' => 'showroom-nissan-logo.jpg',
			'name'  => 'Nissan Markenzeichen im Showroom',
		),
	),
	'cupra'  => array(
		array(
			'image' => 'showroom-cupra-detail.jpg',
			'name'  => 'Cupra Corner im Showroom',
		),
	),
);
$auto_emotion_showroom_fotos       = $auto_emotion_marke_showroom_fotos[ $auto_emotion_term->slug ] ?? array();
?>

<?php if ( $auto_emotion_showroom_fotos ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title"><?php esc_html_e( 'Bei uns vor Ort', 'auto-emotion' ); ?></h2>
	</div>
	<div class="photo-gallery">
		<?php foreach ( $auto_emotion_showroom_fotos as $auto_emotion_showroom_foto ) : ?>
			<figure>
				<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_showroom_foto['image'] ); ?>" alt="<?php echo esc_attr( $auto_emotion_showroom_foto['name'] ); ?>" loading="lazy">
			</figure>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php
$auto_emotion_angebote = new WP_Query(
	array(
		'post_type'      => 'angebot',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'marke',
				'field'    => 'term_id',
				'terms'    => $auto_emotion_term->term_id,
			),
		),
	)
);
?>

<?php if ( $auto_emotion_angebote->have_posts() ) : ?>
	<div class="story-grid">
		<?php while ( $auto_emotion_angebote->have_posts() ) : $auto_emotion_angebote->the_post(); ?>
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

<?php if ( $auto_emotion_bild_full_2 ) : ?>
	<?php echo '</div>'; ?>
	<img
		class="content-header-image content-header-image--hoch"
		src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_bild_full_2['image'] . '?ver=' . AUTO_EMOTION_VERSION ); ?>"
		alt="<?php echo esc_attr( $auto_emotion_bild_full_2['alt'] ); ?>"
		width="<?php echo (int) $auto_emotion_bild_full_2['width']; ?>"
		height="<?php echo (int) $auto_emotion_bild_full_2['height']; ?>"
		loading="lazy"
	>
	<?php echo '<div class="container">'; ?>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title"><?php esc_html_e( 'News', 'auto-emotion' ); ?></h2>
	</div>

	<div class="story-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
	</div>

	<?php the_posts_pagination(); ?>
<?php endif; ?>

<?php
get_footer();
