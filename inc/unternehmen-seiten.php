<?php
/**
 * Inhalte der Unternehmensseiten. Die Aussagen stammen aus den bisherigen
 * Seitentexten. Bitte hier keine neuen Zahlen, Personen oder Leistungen
 * ergänzen, die Auto Emotion nicht bestätigt hat.
 *
 * Eine hier eingetragene Seite zeigt diese Inhalte und nicht den Text aus
 * dem WordPress-Editor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Offene Stellen, Bild, Umfang, Titel, Text und Stellenseite.
 */
function auto_emotion_stellen() {
	return array(
		array( 'career-mechatroniker.jpg', __( '2–3 Stellen · Vollzeit', 'auto-emotion' ), __( 'Kfz-Mechatroniker (m/w/d)', 'auto-emotion' ), __( 'Wartung, Reparatur und Diagnose an Seat, Cupra und Nissan. Bruttogehalt 2.900–3.900 €.', 'auto-emotion' ), 'karriere-mechatroniker' ),
		array( 'career-hochvolttechniker.jpg', __( 'Vollzeit', 'auto-emotion' ), __( 'Hochvolttechniker / Hochvoltexperte (m/w/d)', 'auto-emotion' ), __( 'Arbeit an Hybrid- und Elektrofahrzeugen, inklusive Hochvoltbatterien. Bruttogehalt 4.000–4.500 €.', 'auto-emotion' ), 'karriere-hochvolttechniker' ),
		array( 'career-kfz-serviceberater.jpg', __( 'Vollzeit', 'auto-emotion' ), __( 'Kfz-Serviceberater (m/w/d)', 'auto-emotion' ), __( 'Kundenberatung, Serviceaufträge und Kostenvoranschläge für Seat, Cupra und Nissan.', 'auto-emotion' ), 'karriere-kfz-serviceberater' ),
		array( 'career-serviceassistentin.jpg', __( 'Vollzeit', 'auto-emotion' ), __( 'Serviceassistent/in / Automobilkauffrau/-mann (m/w/d)', 'auto-emotion' ), __( 'Kundenbetreuung, Termindisposition und Ersatzwagenplanung. Bruttogehalt 2.800–3.500 €.', 'auto-emotion' ), 'karriere-serviceassistentin' ),
		array( 'career-werkstattleiter.jpg', __( 'Vollzeit', 'auto-emotion' ), __( 'Werkstattleiter (m/w/d)', 'auto-emotion' ), __( 'Führung und Organisation des Werkstattteams. Bruttogehalt 4.300–5.000 €, Kfz-Meister vorausgesetzt.', 'auto-emotion' ), 'karriere-werkstattleiter' ),
	);
}

/**
 * Ablauf einer Bewerbung.
 */
function auto_emotion_bewerbung_schritte() {
	return array(
		array( 'dokument', __( 'Bewerben', 'auto-emotion' ), __( 'Formlos, mit oder ohne Lebenslauf, direkt online über das Formular deiner Wunschstelle.', 'auto-emotion' ) ),
		array( 'person', __( 'Gespräch', 'auto-emotion' ), __( 'Das erste Gespräch führt Agostino Cisternino persönlich.', 'auto-emotion' ) ),
		array( 'nachricht', __( 'Rückmeldung', 'auto-emotion' ), __( 'In der Regel innerhalb von 24 Stunden. Ein Start ist ab sofort denkbar.', 'auto-emotion' ) ),
	);
}

/**
 * Bildkachel für eine Unternehmensseite: Bild, Icon, Titel.
 */
function auto_emotion_unternehmen_kachel( $slug ) {
	$kacheln = array(
		'ueber-uns'                    => array( 'showroom-nissan-floor.jpg', 'haus', __( 'Über uns', 'auto-emotion' ) ),
		'firmengeschichte'             => array( 'showroom-fahrzeugausstellung.jpg', 'kalender', __( 'Firmengeschichte', 'auto-emotion' ) ),
		'team-ansprechpartner'         => array( 'showroom-lounge-auftanken.jpg', 'person', __( 'Team', 'auto-emotion' ) ),
		'unsere-kunden'                => array( 'showroom-lounge-seat.jpg', 'nachricht', __( 'Unsere Kunden', 'auto-emotion' ) ),
		'auszeichnungen'               => array( 'showroom-nissan-designlab.jpg', 'pokal', __( 'Auszeichnungen', 'auto-emotion' ) ),
		'standorte'                    => array( 'standort-fassade.jpg', 'ort', __( 'Standort', 'auto-emotion' ) ),
		'karriere'                     => array( 'career-karriere-hub.jpg', 'werkzeug', __( 'Karriere', 'auto-emotion' ) ),
		'offene-stellen'               => array( 'career-kfz-serviceberater.jpg', 'dokument', __( 'Offene Stellen', 'auto-emotion' ) ),
		'initiativbewerbung'           => array( 'career-serviceassistentin.jpg', 'stift', __( 'Initiativbewerbung', 'auto-emotion' ) ),
		'ausbildung'                   => array( 'career-mechatroniker.jpg', 'person', __( 'Ausbildung', 'auto-emotion' ) ),
		'warum-auto-emotion'           => array( 'werkstatt-hebebuehnen.jpg', 'haken', __( 'Warum Auto Emotion?', 'auto-emotion' ) ),
		'events-schulungen'            => array( 'showroom-tiefgarage.jpg', 'kalender', __( 'Events & Schulungen', 'auto-emotion' ) ),
		'markenevents-probefahrt-tage' => array( 'seat-bild-full-1.jpg', 'auto', __( 'Markenevents & Probefahrt-Tage', 'auto-emotion' ) ),
		'tag-der-offenen-tuer'         => array( 'showroom-verkaufsflaeche.jpg', 'haus', __( 'Tag der offenen Tür', 'auto-emotion' ) ),
		'werkstatt-schulungen'         => array( 'career-hochvolttechniker.jpg', 'werkzeug', __( 'Werkstatt-Schulungen', 'auto-emotion' ) ),
		'kundenveranstaltungen'        => array( 'showroom-cupra-ecke.jpg', 'person', __( 'Kundenveranstaltungen', 'auto-emotion' ) ),
		'magazin'                      => array( 'cupra-tindaya-showcar.jpg', 'dokument', __( 'Magazin', 'auto-emotion' ) ),
		'blog'                         => array( 'cupra-bild-full-raval.jpg', 'stift', __( 'Blog', 'auto-emotion' ) ),
		'faq'                          => array( 'showroom-nissan-lounge.jpg', 'nachricht', __( 'FAQ', 'auto-emotion' ) ),
		'kontakt'                      => array( 'service-eingang-aussen.jpg', 'telefon', __( 'Kontakt', 'auto-emotion' ) ),
	);

	return $kacheln[ $slug ] ?? null;
}

/**
 * Alle Unternehmensseiten nach Slug.
 */
function auto_emotion_unternehmen_seiten() {
	$url       = static function ( $pfad ) {
		return home_url( '/' . $pfad . '/' );
	};
	$telefon   = array( auto_emotion_contact( 'phone' ), 'tel:' . auto_emotion_contact( 'phone_href' ) );
	$kontakt   = array( __( 'Kontakt aufnehmen', 'auto-emotion' ), $url( 'kontakt' ) );
	$instagram = array( __( 'Auf Instagram folgen', 'auto-emotion' ), auto_emotion_contact( 'instagram' ) );
	$facebook  = array( __( 'Auf Facebook folgen', 'auto-emotion' ), auto_emotion_contact( 'facebook' ) );
	$anschrift = auto_emotion_contact( 'street' ) . ', ' . auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' );
	$route     = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $anschrift );
	$bewerben  = array( __( 'Initiativbewerbung senden', 'auto-emotion' ), $url( 'initiativbewerbung' ) );
	$probe     = array( __( 'Probefahrt anfragen', 'auto-emotion' ), $url( 'angebote' ) );

	return array(
		'ueber-uns' => array(
			'eyebrow' => __( 'Über uns', 'auto-emotion' ),
			'pre'     => __( 'Autohaus in', 'auto-emotion' ),
			'accent'  => __( 'Offenbach.', 'auto-emotion' ),
			'hero'    => 'showroom-nissan-floor.jpg',
			'cta1'    => array( __( 'Showroom ansehen', 'auto-emotion' ), '#galerie' ),
			'cta2'    => $telefon,
			'lead'    => __( 'Auto Emotion ist Vertragshändler für Seat, Cupra und Nissan an der Sprendlinger Landstraße 166 in Offenbach. Das Haus führen Donato und Agostino Cisternino.', 'auto-emotion' ),
			'fakten'  => array(
				array( '2001', __( 'in Offenbach', 'auto-emotion' ) ),
				array( '3', __( 'Marken', 'auto-emotion' ) ),
				array( '19.400 m²', __( 'Gewerbeareal', 'auto-emotion' ) ),
				array( '12', __( 'Hebebühnen', 'auto-emotion' ) ),
			),
			'bloecke' => array(
				array( 'standort-luftbild.jpg', __( 'Luftbild des Auto Emotion Standorts in der Sprendlinger Landstraße, Offenbach', 'auto-emotion' ), __( 'Unser Standort', 'auto-emotion' ), __( 'Alles auf einem Grundstück.', 'auto-emotion' ), __( 'Ausstellung, Werkstatt und Reifenlager liegen bei uns auf demselben Gelände. Im Luftbild sehen Sie, wie viel Fläche dafür zur Verfügung steht.', 'auto-emotion' ), $url( 'standorte' ), __( 'Anfahrt und Öffnungszeiten', 'auto-emotion' ) ),
			),
			'galerie' => array(
				'titel'  => __( 'Unser Showroom', 'auto-emotion' ),
				'bilder' => array(
					array( 'showroom-cupra-vwall.jpg', __( 'Cupra-Fläche mit V-Wand', 'auto-emotion' ) ),
					array( 'showroom-formentor-born.jpg', __( 'Cupra Formentor und Born auf der Fläche', 'auto-emotion' ) ),
					array( 'showroom-verkaufsflaeche.jpg', __( 'Seat Arona und Leon im Showroom', 'auto-emotion' ) ),
					array( 'showroom-lounge-seat.jpg', __( 'Seat-Lounge', 'auto-emotion' ) ),
					array( 'showroom-nissan-logo.jpg', __( 'Nissan bei Auto Emotion', 'auto-emotion' ) ),
					array( 'showroom-nissan-evs.jpg', __( 'Nissan Elektromodelle im Eingangsbereich', 'auto-emotion' ) ),
					array( 'showroom-nissan-juke-lounge.jpg', __( 'Nissan Juke und Lounge', 'auto-emotion' ) ),
					array( 'showroom-lounge-auftanken.jpg', __( 'Lounge mit Kinderecke', 'auto-emotion' ) ),
					array( 'showroom-tiefgarage.jpg', __( 'Untere Verkaufsfläche', 'auto-emotion' ) ),
				),
			),
			'notiz'   => __( 'Auto Emotion GmbH & Co. KG, Amtsgericht Offenbach, HRB 40543. Geschäftsführung: Donato Cisternino, Agostino Cisternino.', 'auto-emotion' ),
			'weitere' => array( 'firmengeschichte', 'team-ansprechpartner', 'auszeichnungen' ),
		),
		'firmengeschichte' => array(
			'eyebrow'    => __( 'Firmengeschichte', 'auto-emotion' ),
			'pre'        => __( 'Firmengeschichte:', 'auto-emotion' ),
			'accent'     => __( 'seit 2001 in Offenbach.', 'auto-emotion' ),
			'hero'       => 'showroom-fahrzeugausstellung.jpg',
			'cta1'       => array( __( 'Zur Zeitleiste', 'auto-emotion' ), '#zeitleiste' ),
			'cta2'       => $telefon,
			'lead'       => __( 'Angefangen hat Auto Emotion im Mai 2001 als kleines Seat-Autohaus an der Sprendlinger Landstraße. Nach 15 Jahren wurde es dort zu eng, der Umzug führte nur wenige Hausnummern weiter.', 'auto-emotion' ),
			'zeitleiste' => array(
				array( __( 'Mai 2001', 'auto-emotion' ), __( 'Der Anfang mit Seat', 'auto-emotion' ), __( 'Eröffnung in Offenbach, von Beginn an mit der Marke Seat.', 'auto-emotion' ) ),
				array( __( 'Januar 2015', 'auto-emotion' ), __( 'Nissan kommt dazu', 'auto-emotion' ), __( 'Start der Partnerschaft mit Nissan.', 'auto-emotion' ) ),
				array( '2016', __( 'Neues Gelände', 'auto-emotion' ), __( 'Kauf eines 19.400 Quadratmeter großen Gewerbeareals. Dort ist Platz für Neufahrzeuge, Vorführwagen, Transport- und Nutzfahrzeuge sowie Elektrofahrzeuge.', 'auto-emotion' ) ),
				array( '2018', __( 'Zwei Auszeichnungen', 'auto-emotion' ), __( 'Auto Emotion wird Nissan GT-R High Performance Center und CUPRA Specialist.', 'auto-emotion' ) ),
				array( __( 'Oktober 2018', 'auto-emotion' ), __( 'Umbau der Filiale', 'auto-emotion' ), '' ),
			),
			'bloecke'    => array(
				array( 'service-eingang-aussen.jpg', __( 'Eingang des Auto Emotion Standorts in Offenbach', 'auto-emotion' ), __( 'Bis heute', 'auto-emotion' ), __( 'Inhabergeführt, mit vielen Stammkunden.', 'auto-emotion' ), __( 'Auto Emotion ist ein Familienunternehmen geblieben. Viele Stammkunden betreuen wir seit dem ersten Tag.', 'auto-emotion' ), $url( 'unsere-kunden' ), __( 'Unsere Kunden', 'auto-emotion' ) ),
			),
			'weitere'    => array( 'ueber-uns', 'auszeichnungen', 'team-ansprechpartner' ),
		),
		'team-ansprechpartner' => array(
			'eyebrow' => __( 'Team / Ansprechpartner', 'auto-emotion' ),
			'pre'     => __( 'Team und', 'auto-emotion' ),
			'accent'  => __( 'Ansprechpartner.', 'auto-emotion' ),
			'hero'    => 'showroom-lounge-auftanken.jpg',
			'cta1'    => array( __( 'Ansprechpartner finden', 'auto-emotion' ), '#team' ),
			'cta2'    => $telefon,
			'lead'    => __( 'Ihre Ansprechpartner bei Auto Emotion in Offenbach, persönlich erreichbar per Telefon oder E-Mail.', 'auto-emotion' ),
			'team'    => array(
				__( 'Geschäftsführung', 'auto-emotion' ) => array(
					array( 'Agostino Cisternino', __( 'Geschäftsführer', 'auto-emotion' ), '069 8740334-0', '+496987403340', 'a.cisternino@auto-emotion.de' ),
					array( 'Donato Cisternino', __( 'Geschäftsführer', 'auto-emotion' ), '069 8740334-0', '+496987403340', 'd.cisternino@auto-emotion.de' ),
					array( 'Andrea Mierzwa', __( 'Assistentin der Geschäftsleitung', 'auto-emotion' ), '069 8740334-31', '+4969874033431', 'a.mierzwa@auto-emotion.de' ),
				),
				__( 'Verkauf', 'auto-emotion' )          => array(
					array( 'Christopher Placzek', __( 'Verkaufsleiter', 'auto-emotion' ), '069 8740334-0', '+496987403340', 'c.placzek@auto-emotion.de' ),
					array( 'Maximilian Herbert', __( 'Verkauf Neu- & Gebrauchtwagen', 'auto-emotion' ), '069 8740334-52', '+4969874033452', 'm.herbert@auto-emotion.de' ),
					array( 'Istvan Farkas', __( 'Verkauf Neu- & Gebrauchtwagen', 'auto-emotion' ), '069 8740334-51', '+4969874033451', 'i.farkas@auto-emotion.de' ),
					array( 'Mushtaq Ahmad', __( 'Verkauf Neuwagen', 'auto-emotion' ), '069 8740334-26', '+4969874033426', 'm.amahd@auto-emotion.de' ),
					array( 'Giovanni Savasta', __( 'Verkauf Gebrauchtfahrzeuge', 'auto-emotion' ), '069 8740334-21', '+4969874033421', 'g.savasta@auto-emotion.de' ),
				),
				__( 'Service', 'auto-emotion' )          => array(
					array( 'Christian Simon', __( 'Serviceleiter', 'auto-emotion' ), '069 8740334-12', '+4969874033412', 'c.simon@auto-emotion.de' ),
					array( 'Laurel Di Caro', __( 'Serviceassistentin', 'auto-emotion' ), '069 8740334-0', '+496987403340', 'l.dicaro@auto-emotion.de' ),
					array( 'Lavinia de las Heras', __( 'Serviceassistentin', 'auto-emotion' ), '069 8740334-0', '+496987403340', 'l.delasheras@auto-emotion.de' ),
				),
				__( 'Teiledienst', 'auto-emotion' )      => array(
					array( 'Harald Seidler', __( 'Lagerist', 'auto-emotion' ), '069 8740334-16', '+4969874033416', 'teiledienst@auto-emotion.de' ),
					array( 'Maurice Wiemer', __( 'Lagerist', 'auto-emotion' ), '069 8740334-17', '+4969874033417', 'teiledienst@auto-emotion.de' ),
				),
			),
			'weitere' => array( 'kontakt', 'karriere', 'ueber-uns' ),
		),
		'unsere-kunden' => array(
			'eyebrow' => __( 'Unsere Kunden', 'auto-emotion' ),
			'pre'     => __( 'Unsere Kunden,', 'auto-emotion' ),
			'accent'  => __( 'viele seit dem ersten Tag.', 'auto-emotion' ),
			'hero'    => 'showroom-lounge-seat.jpg',
			'cta1'    => $kontakt,
			'cta2'    => $telefon,
			'lead'    => __( 'Auto Emotion ist seit Mai 2001 als inhabergeführtes Familienunternehmen in Offenbach ansässig. Viele Kunden sind seit dem ersten Tag dabei, vom ersten Seat bis zum aktuellen Cupra oder Nissan.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'person', __( 'Feste Ansprechpartner', 'auto-emotion' ), __( 'Sie wissen, wen Sie anrufen.', 'auto-emotion' ) ),
				array( 'haus', __( 'Geschäftsführung im Haus', 'auto-emotion' ), __( 'Die Inhaber sind vor Ort erreichbar.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Werkstatt für alle Marken', 'auto-emotion' ), __( 'Als freie Werkstatt betreuen wir auch Fahrzeuge anderer Marken.', 'auto-emotion' ) ),
			),
			'bloecke' => array(
				array( 'showroom-nissan-designlab.jpg', __( 'Nissan Design Lab im Showroom von Auto Emotion', 'auto-emotion' ), __( 'Von Herstellern bestätigt', 'auto-emotion' ), __( 'Auszeichnungen als Nachweis.', 'auto-emotion' ), __( 'Seit 2018 sind wir Nissan GT-R High Performance Center und CUPRA Specialist.', 'auto-emotion' ), $url( 'auszeichnungen' ), __( 'Zu den Auszeichnungen', 'auto-emotion' ) ),
				array( 'showroom-lounge.jpg', __( 'Lounge-Bereich für Kunden im Showroom von Auto Emotion', 'auto-emotion' ), __( 'Erfahrungsberichte', 'auto-emotion' ), __( 'Lesen Sie, was Kunden schreiben.', 'auto-emotion' ), __( 'Echte Erfahrungsberichte unserer Kunden finden Sie direkt bei Google.', 'auto-emotion' ), 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( auto_emotion_contact( 'company' ) . ', ' . $anschrift ), __( 'Auto Emotion bei Google Maps', 'auto-emotion' ) ),
			),
			'cta'     => array( __( 'Sie überlegen, Kunde zu werden?', 'auto-emotion' ), __( 'Am einfachsten überzeugen Sie sich selbst: Kommen Sie vorbei oder vereinbaren Sie eine Probefahrt.', 'auto-emotion' ), $kontakt, $telefon ),
			'weitere' => array( 'kundenveranstaltungen', 'auszeichnungen', 'team-ansprechpartner' ),
		),
		'auszeichnungen' => array(
			'eyebrow' => __( 'Auszeichnungen', 'auto-emotion' ),
			'pre'     => __( 'Unsere', 'auto-emotion' ),
			'accent'  => __( 'Auszeichnungen.', 'auto-emotion' ),
			'hero'    => 'showroom-nissan-designlab.jpg',
			'cta1'    => $kontakt,
			'cta2'    => $telefon,
			'lead'    => __( 'Seit 2018 trägt Auto Emotion zwei Auszeichnungen von Nissan und Cupra. Sie stehen für unsere langjährige Partnerschaft mit den Marken.', 'auto-emotion' ),
			'bloecke' => array(
				array( 'showroom-nissan-juke-lounge.jpg', __( 'Nissan Juke mit Lounge-Bereich und NISMO-Ecke im Showroom', 'auto-emotion' ), __( 'Nissan', 'auto-emotion' ), __( 'Nissan GT-R High Performance Center', 'auto-emotion' ), __( 'Eine von Nissan Deutschland vergebene Auszeichnung für Autohäuser mit besonderer Kompetenz rund um das Topmodell Nissan GT-R.', 'auto-emotion' ), $url( 'marke/nissan' ), __( 'Nissan bei Auto Emotion', 'auto-emotion' ) ),
				array( 'showroom-cupra-vwall.jpg', __( 'Cupra-Ausstellungsfläche mit Formentor und Born vor der beleuchteten V-Wand', 'auto-emotion' ), __( 'Cupra', 'auto-emotion' ), __( 'CUPRA Specialist', 'auto-emotion' ), __( 'Die Auszeichnung von Cupra für Händler, die sich besonders auf die eigenständige Performance-Marke spezialisiert haben.', 'auto-emotion' ), $url( 'marke/cupra' ), __( 'Cupra bei Auto Emotion', 'auto-emotion' ) ),
			),
			'weitere' => array( 'firmengeschichte', 'unsere-kunden', 'ueber-uns' ),
		),
		'standorte' => array(
			'eyebrow' => __( 'Standort', 'auto-emotion' ),
			'pre'     => __( 'Standort', 'auto-emotion' ),
			'accent'  => __( 'Offenbach.', 'auto-emotion' ),
			'hero'    => 'standort-fassade.jpg',
			'cta1'    => array( __( 'Route planen', 'auto-emotion' ), $route ),
			'cta2'    => $telefon,
			'lead'    => __( 'Auto Emotion finden Sie an der Sprendlinger Landstraße 166 in Offenbach. Verkauf, Werkstatt und Reifenlager liegen auf demselben Gelände.', 'auto-emotion' ),
			'kontakt' => true,
			'bloecke' => array(
				array( 'standort-luftbild.jpg', __( 'Luftbild des Auto Emotion Standorts in der Sprendlinger Landstraße, Offenbach', 'auto-emotion' ), __( 'Von oben', 'auto-emotion' ), __( 'Das Gelände im Luftbild.', 'auto-emotion' ), __( 'Die Luftaufnahme zeigt unseren Standort an der Sprendlinger Landstraße 166.', 'auto-emotion' ), $route, __( 'In Google Maps öffnen', 'auto-emotion' ) ),
			),
			'weitere' => array( 'kontakt', 'team-ansprechpartner', 'ueber-uns' ),
		),
		'karriere' => array(
			'eyebrow'  => __( 'Karriere', 'auto-emotion' ),
			'pre'      => __( 'Karriere bei', 'auto-emotion' ),
			'accent'   => __( 'Auto Emotion.', 'auto-emotion' ),
			'hero'     => 'career-karriere-hub.jpg',
			'cta1'     => array( __( 'Offene Stellen', 'auto-emotion' ), '#stellen' ),
			'cta2'     => $bewerben,
			'lead'     => __( 'Offene Stellen, Initiativbewerbung und was Auto Emotion als Arbeitgeber tatsächlich bietet.', 'auto-emotion' ),
			'fakten'   => array(
				array( __( '24 Std.', 'auto-emotion' ), __( 'Rückmeldung auf Bewerbungen', 'auto-emotion' ) ),
				array( __( '30 Tage', 'auto-emotion' ), __( 'Urlaub', 'auto-emotion' ) ),
				array( '12', __( 'Hebebühnen in der Werkstatt', 'auto-emotion' ) ),
				array( __( 'Start', 'auto-emotion' ), __( 'ab sofort möglich', 'auto-emotion' ) ),
			),
			'stellen'  => true,
			'schritte' => array( __( 'So läuft deine Bewerbung ab', 'auto-emotion' ), auto_emotion_bewerbung_schritte() ),
			'text'     => array(
				__( 'Jobs im Autohaus in Offenbach am Main', 'auto-emotion' ),
				__( 'Auto Emotion ist Vertragspartner für Seat, Cupra und Nissan in Offenbach am Main. Wir suchen laufend Kfz-Mechatroniker, Hochvolttechniker für Elektro- und Hybridfahrzeuge, Kfz-Serviceberater, Serviceassistenten sowie eine Werkstattleitung für unsere Werkstatt mit 12 Hebebühnen.', 'auto-emotion' ),
				__( 'Wer in Offenbach, Frankfurt am Main oder im Rhein-Main-Gebiet eine Stelle als Kfz-Mechaniker oder Kfz-Meister oder einen Quereinstieg in die Automobilbranche sucht, findet bei uns kurze Entscheidungswege und ein Team, das seit vielen Jahren zusammenarbeitet.', 'auto-emotion' ),
			),
			'weitere'  => array( 'warum-auto-emotion', 'ausbildung', 'initiativbewerbung' ),
		),
		'offene-stellen' => array(
			'eyebrow' => __( 'Offene Stellen', 'auto-emotion' ),
			'pre'     => __( 'Offene Stellen', 'auto-emotion' ),
			'accent'  => __( 'in Offenbach.', 'auto-emotion' ),
			'hero'    => 'career-kfz-serviceberater.jpg',
			'cta1'    => array( __( 'Stellen ansehen', 'auto-emotion' ), '#stellen' ),
			'cta2'    => $bewerben,
			'lead'    => __( 'Details und Bewerbung findest du jeweils direkt auf der Stellenseite.', 'auto-emotion' ),
			'stellen' => true,
			'cta'     => array( __( 'Nichts Passendes dabei?', 'auto-emotion' ), __( 'Schreib uns trotzdem, welche Position dich interessiert.', 'auto-emotion' ), $bewerben, $telefon ),
			'weitere' => array( 'warum-auto-emotion', 'ausbildung', 'karriere' ),
		),
		'ausbildung' => array(
			'eyebrow' => __( 'Ausbildung', 'auto-emotion' ),
			'pre'     => __( 'Ausbildung', 'auto-emotion' ),
			'accent'  => __( 'im Autohaus.', 'auto-emotion' ),
			'hero'    => 'career-mechatroniker.jpg',
			'cta1'    => $bewerben,
			'cta2'    => $telefon,
			'lead'    => __( 'Unser Ausbildungsangebot bauen wir gerade aus. Feste Ausbildungsplätze mit Ausbildungsjahrgang sind in Vorbereitung. Aktuell schreiben wir Kfz-Berufe vor allem für erfahrene Fachkräfte und den direkten Berufseinstieg aus.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'werkzeug', __( 'Kfz-Mechatroniker (m/w/d)', 'auto-emotion' ), __( 'Duale Ausbildung, rund dreieinhalb Jahre, Betrieb und Berufsschule im Wechsel.', 'auto-emotion' ) ),
				array( 'person', __( 'Automobilkaufmann/-frau (m/w/d)', 'auto-emotion' ), __( 'Rund drei Jahre, von der Kundenberatung über die Werkstattdisposition bis zur Auftragsabwicklung.', 'auto-emotion' ) ),
				array( 'kalender', __( 'Jetzt vormerken lassen', 'auto-emotion' ), __( 'Melde dich direkt, wir merken deine Bewerbung für den nächsten Ausbildungsjahrgang vor.', 'auto-emotion' ) ),
			),
			'cta'     => array( __( 'Interesse an einem Ausbildungsplatz?', 'auto-emotion' ), __( 'Eine kurze Nachricht reicht.', 'auto-emotion' ), $bewerben, $telefon ),
			'weitere' => array( 'warum-auto-emotion', 'offene-stellen', 'karriere' ),
		),
		'warum-auto-emotion' => array(
			'eyebrow' => __( 'Warum Auto Emotion?', 'auto-emotion' ),
			'pre'     => __( 'Warum', 'auto-emotion' ),
			'accent'  => __( 'Auto Emotion?', 'auto-emotion' ),
			'hero'    => 'werkstatt-hebebuehnen.jpg',
			'cta1'    => array( __( 'Offene Stellen', 'auto-emotion' ), $url( 'offene-stellen' ) ),
			'cta2'    => $bewerben,
			'lead'    => __( 'In der Werkstatt arbeiten 9 bis 10 Kollegen, viele davon seit 8 bis 14 Jahren im Betrieb. Richtzeiten vom Hersteller dienen als Orientierung, nicht als Druckmittel.', 'auto-emotion' ),
			'fakten'  => array(
				array( '12', __( 'Hebebühnen', 'auto-emotion' ) ),
				array( '9–10', __( 'Kollegen in der Werkstatt', 'auto-emotion' ) ),
				array( '8–14', __( 'Jahre im Betrieb, bei vielen', 'auto-emotion' ) ),
				array( __( '24 Std.', 'auto-emotion' ), __( 'Rückmeldung auf Bewerbungen', 'auto-emotion' ) ),
			),
			'punkte'  => array(
				array( 'haus', __( 'Moderne Werkstatt', 'auto-emotion' ), __( 'Beheizt und klimatisiert, an Seat, Cupra und Nissan.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Werkzeug wird gestellt', 'auto-emotion' ), __( 'Hochvolt- und Diagnoseschulungen werden bezahlt.', 'auto-emotion' ) ),
				array( 'haken', __( 'Selbstständiges Arbeiten', 'auto-emotion' ), __( 'Du organisierst deine Arbeit eigenständig.', 'auto-emotion' ) ),
				array( 'kalender', __( 'Überstunden', 'auto-emotion' ), __( 'Werden abgefeiert, nicht ausgezahlt.', 'auto-emotion' ) ),
				array( 'funke', __( 'Nach der Probezeit', 'auto-emotion' ), __( 'Wahl zwischen 50 € Tankgutschein pro Monat oder Kranken-Zusatzversicherung.', 'auto-emotion' ) ),
				array( 'person', __( 'Erstes Gespräch', 'auto-emotion' ), __( 'Persönlich und direkt mit Agostino Cisternino.', 'auto-emotion' ) ),
			),
			'weitere' => array( 'offene-stellen', 'ausbildung', 'initiativbewerbung' ),
		),
		'events-schulungen' => array(
			'eyebrow' => __( 'Events & Schulungen', 'auto-emotion' ),
			'pre'     => __( 'Events &', 'auto-emotion' ),
			'accent'  => __( 'Schulungen.', 'auto-emotion' ),
			'hero'    => 'showroom-tiefgarage.jpg',
			'cta1'    => $probe,
			'cta2'    => $telefon,
			'lead'    => __( 'Von offenen Besuchstagen über Probefahrt-Termine bis zur Weiterbildung unseres Werkstattteams: Das sind die Anlässe rund um Auto Emotion.', 'auto-emotion' ),
			'bloecke' => array(
				array( 'showroom-verkaufsflaeche.jpg', __( 'Verkaufsfläche mit Seat Arona und Seat Leon', 'auto-emotion' ), __( 'Für alle', 'auto-emotion' ), __( 'Tag der offenen Tür', 'auto-emotion' ), __( 'Showroom und Werkstatt ohne Terminzwang entdecken.', 'auto-emotion' ), $url( 'tag-der-offenen-tuer' ), __( 'Mehr erfahren', 'auto-emotion' ) ),
				array( 'seat-bild-full-1.jpg', __( 'Seat Modelle an der Küste, Pressefoto', 'auto-emotion' ), __( 'Probe fahren', 'auto-emotion' ), __( 'Markenevents & Probefahrt-Tage', 'auto-emotion' ), __( 'Neue Modelle von Seat, Cupra und Nissan live erleben und testen.', 'auto-emotion' ), $url( 'markenevents-probefahrt-tage' ), __( 'Mehr erfahren', 'auto-emotion' ) ),
				array( 'showroom-cupra-ecke.jpg', __( 'Cupra-Markenwelt im Showroom von Auto Emotion mit Sitzbereich', 'auto-emotion' ), __( 'Für Kunden', 'auto-emotion' ), __( 'Kundenveranstaltungen', 'auto-emotion' ), __( 'Persönliche Anlässe für unsere langjährigen Kunden.', 'auto-emotion' ), $url( 'kundenveranstaltungen' ), __( 'Mehr erfahren', 'auto-emotion' ) ),
				array( 'career-hochvolttechniker.jpg', __( 'Techniker mit Hochvolt-Schutzhandschuhen an einem Elektrofahrzeug', 'auto-emotion' ), __( 'Für die Werkstatt', 'auto-emotion' ), __( 'Werkstatt-Schulungen', 'auto-emotion' ), __( 'Wie unser Werkstattteam bei Seat, Cupra und Nissan auf dem aktuellen Stand bleibt.', 'auto-emotion' ), $url( 'werkstatt-schulungen' ), __( 'Mehr erfahren', 'auto-emotion' ) ),
			),
		),
		'markenevents-probefahrt-tage' => array(
			'eyebrow' => __( 'Markenevents & Probefahrt-Tage', 'auto-emotion' ),
			'pre'     => __( 'Probefahrt-Tage', 'auto-emotion' ),
			'accent'  => __( 'und Markenevents.', 'auto-emotion' ),
			'hero'    => 'seat-bild-full-1.jpg',
			'cta1'    => $probe,
			'cta2'    => $telefon,
			'lead'    => __( 'Zu neuen Modellen von Seat, Cupra und Nissan veranstalten Hersteller und Händler gemeinsam Probefahrt-Aktionen. So testen Sie ein Fahrzeug vor der Kaufentscheidung ausgiebig, oft mit mehreren Modellvarianten an einem Termin.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'auto', __( 'Mehrere Varianten', 'auto-emotion' ), __( 'Bei Aktionen oft mehrere Modellvarianten an einem Termin.', 'auto-emotion' ) ),
				array( 'kalender', __( 'Ihr eigener Termin', 'auto-emotion' ), __( 'Für das Modell Ihrer Wahl jederzeit individuell vereinbar.', 'auto-emotion' ) ),
				array( 'nachricht', __( 'Termine auf Social Media', 'auto-emotion' ), __( 'Aktionstage kündigen wir an, sobald sie feststehen.', 'auto-emotion' ) ),
			),
			'cta'     => array( __( 'Aktuell steht kein Aktionstag fest.', 'auto-emotion' ), __( 'Am schnellsten erfahren Sie von neuen Terminen über Instagram.', 'auto-emotion' ), $instagram, $telefon ),
			'weitere' => array( 'tag-der-offenen-tuer', 'kundenveranstaltungen', 'events-schulungen' ),
		),
		'tag-der-offenen-tuer' => array(
			'eyebrow' => __( 'Tag der offenen Tür', 'auto-emotion' ),
			'pre'     => __( 'Tag der', 'auto-emotion' ),
			'accent'  => __( 'offenen Tür.', 'auto-emotion' ),
			'hero'    => 'showroom-verkaufsflaeche.jpg',
			'cta1'    => $instagram,
			'cta2'    => $facebook,
			'lead'    => __( 'An einem Tag der offenen Tür öffnen wir unseren Standort ohne Terminzwang für alle, die sich in Ruhe umsehen möchten.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'haus', __( 'Showroom', 'auto-emotion' ), __( 'Das aktuelle Modellprogramm von Seat, Cupra und Nissan zum Anfassen.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Werkstatt', 'auto-emotion' ), __( 'Auch die Werkstatt ist an diesem Tag zu sehen.', 'auto-emotion' ) ),
				array( 'kalender', __( 'Kein Terminzwang', 'auto-emotion' ), __( 'Kommen Sie einfach vorbei, sobald der Tag feststeht.', 'auto-emotion' ) ),
			),
			'cta'     => array( __( 'Aktuell ist kein Termin fest eingeplant.', 'auto-emotion' ), __( 'Sobald einer feststeht, kündigen wir ihn auf unseren Social-Media-Kanälen an.', 'auto-emotion' ), $instagram, $facebook ),
			'weitere' => array( 'markenevents-probefahrt-tage', 'kundenveranstaltungen', 'events-schulungen' ),
		),
		'werkstatt-schulungen' => array(
			'eyebrow' => __( 'Werkstatt-Schulungen', 'auto-emotion' ),
			'pre'     => __( 'Werkstatt-', 'auto-emotion' ),
			'accent'  => __( 'Schulungen.', 'auto-emotion' ),
			'hero'    => 'career-hochvolttechniker.jpg',
			'cta1'    => array( __( 'Termin anfragen', 'auto-emotion' ), $url( 'servicetermin-buchen' ) ),
			'cta2'    => $telefon,
			'lead'    => __( 'Unsere Werkstattmitarbeiter bilden sich regelmäßig bei Cupra, Seat und Nissan weiter. So wird Ihr Fahrzeug fachgerecht nach Herstellervorgaben gewartet und repariert.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'auto', __( 'Neue Modellreihen', 'auto-emotion' ), __( 'Schulungen direkt bei den Herstellern.', 'auto-emotion' ) ),
				array( 'pruefung', __( 'Assistenzsysteme', 'auto-emotion' ), __( 'Auch die Technik im Fahrzeug ist Thema.', 'auto-emotion' ) ),
				array( 'funke', __( 'Elektro und Hybrid', 'auto-emotion' ), __( 'Weiterbildung zu Elektro- und Hybridantrieben.', 'auto-emotion' ) ),
			),
			'weitere' => array( 'warum-auto-emotion', 'events-schulungen', 'karriere' ),
		),
		'kundenveranstaltungen' => array(
			'eyebrow' => __( 'Kundenveranstaltungen', 'auto-emotion' ),
			'pre'     => "Kunden\xC2\xADveranstaltungen",
			'accent'  => __( 'in Offenbach.', 'auto-emotion' ),
			'hero'    => 'showroom-cupra-ecke.jpg',
			'cta1'    => $kontakt,
			'cta2'    => $instagram,
			'lead'    => __( 'Viele Kunden begleiten uns seit Jahren, einige seit der Gründung 2001. Zu Anlässen wie Modellpremieren oder Jubiläen laden wir deshalb auch gezielt Kunden zu uns ein.', 'auto-emotion' ),
			'cta'     => array( __( 'Nichts verpassen', 'auto-emotion' ), __( 'Konkrete Termine kündigen wir rechtzeitig an, unter anderem über Social Media. Oder Sie hinterlassen uns Ihre Kontaktdaten.', 'auto-emotion' ), $kontakt, $instagram ),
			'weitere' => array( 'unsere-kunden', 'tag-der-offenen-tuer', 'events-schulungen' ),
		),
		'magazin' => array(
			'eyebrow' => __( 'Magazin', 'auto-emotion' ),
			'pre'     => __( 'Magazin', 'auto-emotion' ),
			'accent'  => __( 'von Auto Emotion.', 'auto-emotion' ),
			'hero'    => 'cupra-tindaya-showcar.jpg',
			'cta1'    => array( __( 'Zum Blog', 'auto-emotion' ), $url( 'blog' ) ),
			'cta2'    => $instagram,
			'lead'    => __( 'Ratgeber, Einblicke und Themen rund um Seat, Cupra und Nissan finden Sie im Blog und auf unseren Social-Media-Kanälen.', 'auto-emotion' ),
			'bloecke' => array(
				array( 'cupra-bild-full-raval.jpg', __( 'Cupra Raval vor einer Backsteinfassade, Pressefoto', 'auto-emotion' ), __( 'Online', 'auto-emotion' ), __( 'Der Blog', 'auto-emotion' ), __( 'Aktuelle Beiträge zu Modellen und Angeboten.', 'auto-emotion' ), $url( 'blog' ), __( 'Beiträge lesen', 'auto-emotion' ) ),
				array( 'showroom-cupra-detail.jpg', __( 'Detailansicht der Cupra-Markenwelt im Showroom', 'auto-emotion' ), __( 'In Planung', 'auto-emotion' ), __( 'Das gedruckte Magazin', 'auto-emotion' ), __( 'Einmal im Jahr soll zusätzlich ein gedrucktes Auto-Emotion-Magazin erscheinen, zunächst in kleiner Auflage. Details folgen hier, sobald das Konzept steht.', 'auto-emotion' ) ),
			),
			'weitere' => array( 'blog', 'events-schulungen', 'faq' ),
		),
		'vlog' => array(
			'eyebrow' => __( 'Vlog', 'auto-emotion' ),
			'pre'     => __( 'Vlog:', 'auto-emotion' ),
			'accent'  => __( 'Videos auf Social Media.', 'auto-emotion' ),
			'hero'    => 'seat-bild-full-2.jpg',
			'cta1'    => $instagram,
			'cta2'    => $facebook,
			'lead'    => __( 'Ein eigener Vlog ist bei Auto Emotion aktuell nicht geplant. Videos aus Showroom und Werkstatt veröffentlichen wir auf unseren Social-Media-Kanälen.', 'auto-emotion' ),
			'weitere' => array( 'blog', 'magazin', 'events-schulungen' ),
		),
		'podcast' => array(
			'eyebrow' => __( 'Podcast', 'auto-emotion' ),
			'pre'     => __( 'Podcast?', 'auto-emotion' ),
			'accent'  => __( 'Noch nicht.', 'auto-emotion' ),
			'hero'    => 'nissan-bild-full-primastar.jpg',
			'cta1'    => $instagram,
			'cta2'    => $facebook,
			'lead'    => __( 'Einen eigenen Podcast gibt es bei Auto Emotion aktuell nicht. Wenn sich das ändert, erfahren Sie es zuerst auf Social Media. Dort finden Sie schon jetzt Einblicke aus Showroom und Werkstatt.', 'auto-emotion' ),
			'weitere' => array( 'blog', 'magazin', 'events-schulungen' ),
		),
		'faq' => array(
			'eyebrow' => __( 'FAQ', 'auto-emotion' ),
			'pre'     => __( 'FAQ:', 'auto-emotion' ),
			'accent'  => __( 'häufige Fragen.', 'auto-emotion' ),
			'hero'    => 'showroom-nissan-lounge.jpg',
			'cta1'    => $kontakt,
			'cta2'    => $telefon,
			'lead'    => __( 'Die wichtigsten Antworten zu Marken, Standort, Öffnungszeiten und Werkstatt.', 'auto-emotion' ),
			'faq'     => array(
				array( __( 'Welche Marken bietet Auto Emotion an?', 'auto-emotion' ), __( 'Seat, Cupra und Nissan.', 'auto-emotion' ) ),
				array( __( 'Wo befindet sich Auto Emotion?', 'auto-emotion' ), $anschrift ),
				array( __( 'Wie sind die Öffnungszeiten?', 'auto-emotion' ), __( 'Verkauf:', 'auto-emotion' ) . ' ' . auto_emotion_contact( 'hours_sales' ) . '. ' . __( 'Werkstatt:', 'auto-emotion' ) . ' ' . auto_emotion_contact( 'hours_service' ) . '.' ),
				array( __( 'Gibt es eine freie Werkstatt?', 'auto-emotion' ), __( 'Ja. Unsere Werkstatt repariert Fahrzeuge aller Marken, nicht nur Seat, Cupra und Nissan.', 'auto-emotion' ) ),
				array( __( 'Wie erreiche ich Auto Emotion?', 'auto-emotion' ), auto_emotion_contact( 'phone' ) . ', ' . auto_emotion_contact( 'email' ) ),
				array( __( 'Kann ich die HU bei Ihnen machen lassen?', 'auto-emotion' ), __( 'Ja. Eine staatlich anerkannte, unabhängige Prüforganisation prüft Ihr Fahrzeug direkt bei uns im Haus.', 'auto-emotion' ) ),
				array( __( 'Lagern Sie auch Reifen ein?', 'auto-emotion' ), __( 'Ja. Wir wechseln Ihre Räder und lagern den zweiten Satz fachgerecht bei uns ein.', 'auto-emotion' ) ),
				array( __( 'Wie frage ich einen Servicetermin an?', 'auto-emotion' ), __( 'Über das Formular „Servicetermin online buchen“ oder telefonisch. Wir melden uns und stimmen den Termin mit Ihnen ab.', 'auto-emotion' ) ),
				array( __( 'Kann ich eine Probefahrt machen?', 'auto-emotion' ), __( 'Ja. Einen individuellen Termin für das Modell Ihrer Wahl können Sie jederzeit vereinbaren, auch ohne Aktionstag.', 'auto-emotion' ) ),
				array( __( 'Welche Auszeichnungen hat Auto Emotion?', 'auto-emotion' ), __( 'Seit 2018 sind wir Nissan GT-R High Performance Center und CUPRA Specialist.', 'auto-emotion' ) ),
				array( __( 'Wie kann ich mich bei Auto Emotion bewerben?', 'auto-emotion' ), __( 'Formlos und online über das Formular der jeweiligen Stelle oder als Initiativbewerbung. Eine Rückmeldung gibt es in der Regel innerhalb von 24 Stunden.', 'auto-emotion' ) ),
			),
			'weitere' => array( 'kontakt', 'team-ansprechpartner', 'standorte' ),
		),
		'kontakt' => array(
			'eyebrow' => __( 'Kontakt', 'auto-emotion' ),
			'pre'     => __( 'Kontakt', 'auto-emotion' ),
			'accent'  => __( 'in Offenbach.', 'auto-emotion' ),
			'hero'    => 'service-eingang-aussen.jpg',
			'cta1'    => array( __( 'Route planen', 'auto-emotion' ), $route ),
			'cta2'    => $telefon,
			'lead'    => __( 'Sie erreichen uns telefonisch, per E-Mail oder direkt vor Ort in Offenbach.', 'auto-emotion' ),
			'kontakt' => true,
			'galerie' => array(
				'titel'  => __( 'Bei uns vor Ort', 'auto-emotion' ),
				'bilder' => array(
					array( 'showroom-lounge-auftanken.jpg', __( 'Kundenlounge', 'auto-emotion' ) ),
					array( 'showroom-tiefgarage.jpg', __( 'Fahrzeugausstellung', 'auto-emotion' ) ),
					array( 'service-eingang.jpg', __( 'Serviceannahme', 'auto-emotion' ) ),
				),
			),
			'weitere' => array( 'team-ansprechpartner', 'faq', 'standorte' ),
		),
	);
}

/**
 * Eingetragene Unternehmensseiten laufen über den gemeinsamen Aufbau,
 * unabhängig davon, welches Template im WordPress-Backend gewählt ist.
 */
function auto_emotion_unternehmen_template( $template ) {
	if ( is_page() && isset( auto_emotion_unternehmen_seiten()[ get_post_field( 'post_name' ) ] ) ) {
		return get_template_directory() . '/template-parts/unternehmen-seite.php';
	}

	return $template;
}
add_filter( 'template_include', 'auto_emotion_unternehmen_template' );
