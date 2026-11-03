<?php
/**
 * Inhalte der Service-Seiten. Die Aussagen stammen aus den bisherigen
 * Seitentexten, bitte hier keine neuen Leistungen oder Zahlen ergänzen,
 * die Auto Emotion nicht bestätigt hat.
 *
 * Solange eine Seite hier eingetragen ist, zeigt sie diese Inhalte und
 * nicht den Text aus dem WordPress-Editor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon-Pfade für viewBox 0 0 24 24.
 */
function auto_emotion_service_icon( $name ) {
	$icons = array(
		'werkzeug'  => '<path d="M14.5 6.5a4 4 0 0 1 5-3l-2.6 2.6 1.9 1.9 2.6-2.6a4 4 0 0 1-5.2 5L8 18.6a2.1 2.1 0 0 1-3-3l8.2-7.7a4 4 0 0 1 1.3-1.4Z"/>',
		'reifen'    => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2"/><path d="M12 3v5.8M12 15.2V21M3 12h5.8M15.2 12H21"/>',
		'pruefung'  => '<path d="M12 3 5 6v5.5c0 4.3 3 7.7 7 9.5 4-1.8 7-5.2 7-9.5V6Z"/><path d="m9 12 2.2 2.2L15.2 10"/>',
		'haken'     => '<circle cx="12" cy="12" r="9"/><path d="m8 12.4 2.7 2.7L16 9.8"/>',
		'haus'      => '<path d="M3.5 11 12 4l8.5 7"/><path d="M6 9.5V20h12V9.5"/><path d="M10 20v-5.5h4V20"/>',
		'teil'      => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M18.4 5.6l-2.1 2.1M7.7 16.3l-2.1 2.1"/>',
		'person'    => '<circle cx="12" cy="8" r="3.6"/><path d="M4.5 20.5a7.5 7.5 0 0 1 15 0"/>',
		'kalender'  => '<rect x="3.5" y="5" width="17" height="15.5" rx="1"/><line x1="3.5" y1="10" x2="20.5" y2="10"/><line x1="8" y1="3" x2="8" y2="7"/><line x1="16" y1="3" x2="16" y2="7"/>',
		'lager'     => '<path d="M3 9.5 12 4l9 5.5V20H3Z"/><path d="M7 20v-7h10v7M7 16.5h10"/>',
		'kaelte'    => '<path d="M12 3v18M4.2 7.5l15.6 9M19.8 7.5l-15.6 9"/><path d="m9.5 5 2.5 2 2.5-2M9.5 19l2.5-2 2.5 2"/>',
		'filter'    => '<path d="M4 5h16l-6 7.5V19l-4 2v-8.5Z"/>',
		'tropfen'   => '<path d="M12 3s6.5 7 6.5 11.5a6.5 6.5 0 0 1-13 0C5.5 10 12 3 12 3Z"/>',
		'lack'      => '<path d="M5 14V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9Z"/><path d="M5 14h12v2a1.5 1.5 0 0 1-1.5 1.500H13V21h-4v-3.500H6.500A1.5 1.5 0 0 1 5 16Z"/>',
		'dokument'  => '<path d="M6 3h8.500L19 7.500V21H6Z"/><path d="M14 3v5h5M9 13h7M9 17h7"/>',
		'achse'     => '<circle cx="5" cy="12" r="2.8"/><circle cx="19" cy="12" r="2.8"/><path d="M7.8 12h8.400M5 4v5.200M19 4v5.200M5 14.800V20M19 14.800V20"/>',
		'funke'     => '<path d="M12 3l1.8 5.700L19.5 10.500l-5.7 1.800L12 18l-1.8-5.700L4.5 10.500l5.7-1.800Z"/><path d="M19 16v4M17 18h4"/>',
		'stift'     => '<path d="m4 20 1-4L16 5l3 3L8 19Z"/><path d="m14 7 3 3"/>',
		'auto'      => '<path d="M3 17h18M5 17l1.5-6.500a2 2 0 0 1 1.950-1.500h7.100a2 2 0 0 1 1.950 1.500L19 17"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/>',
		'nachricht' => '<path d="M4 5h16v11H9l-5 4Z"/>',
	);

	echo $icons[ $name ] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput -- feste, eigene SVG-Pfade.
}

/**
 * Daten aller Service-Seiten, Schlüssel ist der Seiten-Slug.
 */
function auto_emotion_service_seiten() {
	return array(
		'freie-werkstatt' => array(
			'pre'     => __( 'Freie', 'auto-emotion' ),
			'accent'  => __( 'Werkstatt.', 'auto-emotion' ),
			'hero'    => 'service-eingang.jpg',
			'lead'    => __( 'Kein Seat, Cupra oder Nissan in der Einfahrt? Kommen Sie trotzdem. Auf diese drei Marken sind wir als Vertragswerkstatt spezialisiert, unsere Werkstattleistungen stehen aber grundsätzlich allen Fahrzeughaltern offen.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'werkzeug', __( 'Inspektion', 'auto-emotion' ), __( 'Auch für Fahrzeuge anderer Marken.', 'auto-emotion' ) ),
				array( 'reifen', __( 'Reifenservice', 'auto-emotion' ), __( 'Vom Radwechsel bis zur Montage neuer Reifen.', 'auto-emotion' ) ),
				array( 'pruefung', __( 'HU-Vorbereitung', 'auto-emotion' ), __( 'Damit Ihr Fahrzeug vorbereitet zur Prüfung geht.', 'auto-emotion' ) ),
			),
			'block'   => array( 'werkstatt-hebebuehnen.jpg', __( 'Nissan Qashqai und Seat Ibiza auf Hebebühnen in der Werkstatt von Auto Emotion', 'auto-emotion' ), __( 'Fragen kostet nichts', 'auto-emotion' ), __( 'Ein Anruf klärt das meiste.', 'auto-emotion' ), __( 'Nennen Sie uns Ihr Fahrzeug und was anliegt, auch wenn es um eine Unfallinstandsetzung geht. Wir sagen Ihnen, ob und wie wir weiterhelfen können.', 'auto-emotion' ) ),
			'weitere' => array( 'inspektion-wartung', 'hu-au', 'unfallinstandsetzung-lackierung' ),
		),
		'hu-au' => array(
			'pre'     => __( 'HU', 'auto-emotion' ),
			'accent'  => __( '/ AU.', 'auto-emotion' ),
			'hero'    => 'career-werkstattleiter.jpg',
			'lead'    => __( 'Für die Hauptuntersuchung müssen Sie nicht quer durch die Stadt fahren: Eine staatlich anerkannte, unabhängige Prüforganisation prüft Ihr Fahrzeug direkt bei uns im Haus.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'haus', __( 'Direkt vor Ort', 'auto-emotion' ), __( 'Die Prüfung findet bei uns im Haus statt.', 'auto-emotion' ) ),
				array( 'pruefung', __( 'Vorab-Check', 'auto-emotion' ), __( 'Auf Wunsch suchen wir vorher nach möglichen Mängeln.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Nachbesserung', 'auto-emotion' ), __( 'Was nötig ist, erledigen wir bei Bedarf gleich mit.', 'auto-emotion' ) ),
			),
			'block'   => array( 'service-eingang-aussen.jpg', __( 'Außenansicht des Servicegebäudes von Auto Emotion in Offenbach', 'auto-emotion' ), __( 'Ohne böse Überraschungen', 'auto-emotion' ), __( 'Erst der Check, dann die Plakette.', 'auto-emotion' ), __( 'Wenn wir Ihr Fahrzeug vorab ansehen, wissen Sie schon vor der Prüfung, wo es hakt. Das ist besser, als es erst bei der Hauptuntersuchung zu erfahren.', 'auto-emotion' ) ),
			'weitere' => array( 'inspektion-wartung', 'freie-werkstatt', 'achsvermessung' ),
		),
		'inspektion-wartung' => array(
			'pre'     => __( 'Inspektion', 'auto-emotion' ),
			'accent'  => __( '& Wartung.', 'auto-emotion' ),
			'hero'    => 'career-mechatroniker.jpg',
			'lead'    => __( 'Wer die Service-Intervalle einhält, erhält Wert, Sicherheit und Garantieanspruch seines Autos. Für Cupra, Seat und Nissan führen wir die vorgeschriebenen Intervalle durch.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'dokument', __( 'Nach Herstellervorgaben', 'auto-emotion' ), __( 'Die vorgeschriebenen Intervalle Ihrer Marke.', 'auto-emotion' ) ),
				array( 'teil', __( 'Original-Ersatzteile', 'auto-emotion' ), __( 'Verbaut werden Original-Teile.', 'auto-emotion' ) ),
				array( 'person', __( 'Geschultes Fachpersonal', 'auto-emotion' ), __( 'Auf Cupra, Seat und Nissan spezialisiert.', 'auto-emotion' ) ),
			),
			'block'   => array( 'service-empfang-cupra.jpg', __( 'Servicehalle von Auto Emotion mit Cupra-Logo', 'auto-emotion' ), __( 'Seat und Cupra', 'auto-emotion' ), __( 'Wartungskosten, die sich planen lassen.', 'auto-emotion' ), __( 'Für Seat und Cupra sorgt „Wartung & Inspektion“ der SEAT Leasing für planbare, niedrige Wartungskosten. Sprechen Sie uns darauf an.', 'auto-emotion' ) ),
			'weitere' => array( 'hu-au', 'klimaservice', 'reifenservice-reifeneinlagerung' ),
		),
		'reifenservice-reifeneinlagerung' => array(
			'pre'     => "Reifen\xC2\xADservice",
			'accent'  => __( '& Einlagerung.', 'auto-emotion' ),
			'hero'    => 'reifen-felgen-showroom-weitwinkel.jpg',
			'lead'    => __( 'Zweimal im Jahr Räder wechseln, und dazwischen liegt der zweite Satz im Keller im Weg? Beides können Sie bei uns lassen: den Wechsel und die Lagerung.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'reifen', __( 'Saisonaler Radwechsel', 'auto-emotion' ), __( 'Sommer auf Winter und wieder zurück.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Montage und Prüfung', 'auto-emotion' ), __( 'Neue Reifen fachgerecht montiert, alle auf Beschädigungen geprüft.', 'auto-emotion' ) ),
				array( 'lager', __( 'Einlagerung', 'auto-emotion' ), __( 'Ihr zweiter Satz lagert in unserer Werkstatt.', 'auto-emotion' ) ),
			),
			'block'   => array( 'reifen-felgen-wand-violett.jpg', __( 'Präsentation von Kompletträdern im Showroom von Auto Emotion', 'auto-emotion' ), __( 'Zwischen den Saisons', 'auto-emotion' ), __( 'Ein Reifensatz weniger, um den Sie sich kümmern.', 'auto-emotion' ), __( 'Wir lagern Ihre Räder oder Reifen fachgerecht und platzsparend ein. Sie müssen sich bis zum nächsten Wechsel um nichts kümmern.', 'auto-emotion' ) ),
			'weitere' => array( 'reifen-felgen', 'achsvermessung', 'inspektion-wartung' ),
		),
		'klimaservice' => array(
			'pre'     => __( 'Klimaservice', 'auto-emotion' ),
			'accent'  => __( 'für saubere Luft.', 'auto-emotion' ),
			'hero'    => 'service-klima-innenraum.jpg',
			'lead'    => __( 'Eine Klimaanlage kühlt nicht nur, sie filtert auch die Luft im Innenraum. Mit der Zeit verliert sie aber Kältemittel, und Bakterien oder Pollen können sich im System festsetzen.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'kaelte', __( 'Dichtheit und Kältemittel', 'auto-emotion' ), __( 'Wir prüfen beides.', 'auto-emotion' ) ),
				array( 'filter', __( 'Innenraumfilter', 'auto-emotion' ), __( 'Bei Bedarf tauschen wir ihn aus.', 'auto-emotion' ) ),
				array( 'tropfen', __( 'Reinigung', 'auto-emotion' ), __( 'Wir reinigen das System.', 'auto-emotion' ) ),
			),
			'block'   => array( 'service-klima-duese.jpg', __( 'Lüftungsdüse im Armaturenbrett eines Seat Ibiza', 'auto-emotion' ), __( 'Je nach Marke', 'auto-emotion' ), __( 'Passend zu Ihrem Fahrzeug.', 'auto-emotion' ), __( 'Für Cupra und Seat arbeiten wir mit Original-Teilen. Bei Nissan empfehlen wir die regelmäßige Klimaanlagenwartung im Rahmen des NISSAN Rundum-Service.', 'auto-emotion' ) ),
			'weitere' => array( 'inspektion-wartung', 'fahrzeugaufbereitung', 'hu-au' ),
		),
		'unfallinstandsetzung-lackierung' => array(
			'pre'     => "Unfall\xC2\xADinstand\xC2\xADsetzung",
			'accent'  => __( '& Lackierung.', 'auto-emotion' ),
			'hero'    => 'notdienst-abschleppen.jpg',
			'lead'    => __( 'Ob kleiner Parkrempler oder größerer Unfallschaden: Unsere Werkstatt repariert Karosserie und Lack nach Herstellervorgaben, damit Ihr Auto wieder aussieht und fährt wie zuvor.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'lack', __( 'Karosserie und Lack', 'auto-emotion' ), __( 'Fachgerecht und nach Herstellervorgaben.', 'auto-emotion' ) ),
				array( 'dokument', __( 'Kostenvoranschlag', 'auto-emotion' ), __( 'Unverbindlich, bevor die Reparatur beginnt.', 'auto-emotion' ) ),
				array( 'haken', __( 'Versicherung', 'auto-emotion' ), __( 'Die Abwicklung übernehmen wir für Sie.', 'auto-emotion' ) ),
			),
			'block'   => array( 'service-empfang-nissan.jpg', __( 'Serviceannahme von Auto Emotion mit Nissan-Schriftzug', 'auto-emotion' ), __( 'Nach dem Schaden', 'auto-emotion' ), __( 'Der Papierkram bleibt nicht an Ihnen hängen.', 'auto-emotion' ), __( 'Sie wissen vorab, was die Reparatur kostet, und wir kümmern uns um die Abwicklung mit Ihrer Versicherung.', 'auto-emotion' ) ),
			'weitere' => array( 'achsvermessung', 'fahrzeugaufbereitung', 'freie-werkstatt' ),
		),
		'achsvermessung' => array(
			'pre'     => "Achs\xC2\xADvermessung",
			'accent'  => __( 'Spur und Sturz.', 'auto-emotion' ),
			'hero'    => 'werkstatt-hebebuehnen.jpg',
			'lead'    => __( 'Eine falsch eingestellte Achse merken Sie oft erst am Reifen: einseitiger Verschleiß, höherer Kraftstoffverbrauch, ein schlechteres Fahrverhalten. Wir prüfen und justieren Spur und Sturz mit modernem Messequipment.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'reifen', __( 'Nach neuen Reifen', 'auto-emotion' ), __( 'Ein guter Zeitpunkt für die Messung.', 'auto-emotion' ) ),
				array( 'pruefung', __( 'Nach einem Unfall', 'auto-emotion' ), __( 'Wir prüfen, ob die Achse noch stimmt.', 'auto-emotion' ) ),
				array( 'achse', __( 'Wenn es einseitig zieht', 'auto-emotion' ), __( 'Dann sollte die Achse vermessen werden.', 'auto-emotion' ) ),
			),
			'block'   => array( 'service-achse-rad.jpg', __( 'Rad eines Cupra Born VZ in der Nahaufnahme', 'auto-emotion' ), __( 'Spur und Sturz', 'auto-emotion' ), __( 'Damit Ihre Reifen gleichmäßig abfahren.', 'auto-emotion' ), __( 'Die Messung zeigt, ob Spur und Sturz stimmen. Wenn nicht, justieren wir sie direkt für Sie nach.', 'auto-emotion' ) ),
			'weitere' => array( 'reifenservice-reifeneinlagerung', 'reifen-felgen', 'unfallinstandsetzung-lackierung' ),
		),
		'fahrzeugaufbereitung' => array(
			'pre'     => "Fahrzeug\xC2\xADaufbereitung",
			'accent'  => __( 'innen und außen.', 'auto-emotion' ),
			'hero'    => 'service-aufbereitung-lack.jpg',
			'lead'    => __( 'Vor dem Verkauf, nach dem Gebrauchtwagenkauf oder einfach zwischendurch: Wir bringen Ihr Auto innen und außen wieder auf Vordermann.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'tropfen', __( 'Innenraumreinigung', 'auto-emotion' ), __( 'Damit es innen wieder gepflegt aussieht.', 'auto-emotion' ) ),
				array( 'lack', __( 'Lackaufbereitung', 'auto-emotion' ), __( 'Für den Lack Ihres Fahrzeugs.', 'auto-emotion' ) ),
				array( 'funke', __( 'Politur', 'auto-emotion' ), __( 'Der letzte Schritt für mehr Glanz.', 'auto-emotion' ) ),
			),
			'block'   => array( 'service-aufbereitung-innen.jpg', __( 'Innenraum eines Seat mit Sitzen und Mittelkonsole', 'auto-emotion' ), __( 'Ihr Umfang', 'auto-emotion' ), __( 'Sie entscheiden, wie viel gemacht wird.', 'auto-emotion' ), __( 'Sprechen Sie uns an. Den Umfang der Aufbereitung stimmen wir individuell mit Ihnen ab.', 'auto-emotion' ) ),
			'weitere' => array( 'unfallinstandsetzung-lackierung', 'beklebungsservice', 'klimaservice' ),
		),
		'beklebungsservice' => array(
			'pre'     => "Beklebungs\xC2\xADservice",
			'accent'  => __( 'aus einer Hand.', 'auto-emotion' ),
			'hero'    => 'wrap-nissan.jpg',
			'lead'    => __( 'Ihr Fahrzeug fährt jeden Tag durch die Stadt, warum nicht mit Ihrem Namen darauf? Unsere hauseigene Grafikabteilung entwirft und produziert Beklebungen nach Ihren Wünschen.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'stift', __( 'Eigenes Design', 'auto-emotion' ), __( 'Wir gestalten die Grafik für Ihr Fahrzeug.', 'auto-emotion' ) ),
				array( 'auto', __( 'Beschriftung bis Vollfolierung', 'auto-emotion' ), __( 'Vom einzelnen Schriftzug bis zum ganzen Auto.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Anbringung', 'auto-emotion' ), __( 'Die Beklebung übernehmen wir ebenfalls.', 'auto-emotion' ) ),
			),
			'block'   => array( 'nissan-nutzfahrzeuge.jpg', __( 'Nissan Primastar auf einer Landstraße', 'auto-emotion' ), __( 'Einzelfahrzeug oder Fuhrpark', 'auto-emotion' ), __( 'Das Angebot richtet sich nach Ihrem Fahrzeug.', 'auto-emotion' ), __( 'Angebote schneiden wir individuell auf Fahrzeug und Anforderung zu, auch für einen ganzen Fuhrpark.', 'auto-emotion' ) ),
			'mail'    => 'Anfrage Beklebungsservice',
			'weitere' => array( 'fahrzeugaufbereitung', 'zubehoer-tuning', 'unfallinstandsetzung-lackierung' ),
		),
		'zubehoer-tuning' => array(
			'pre'     => __( 'Zubehör', 'auto-emotion' ),
			'accent'  => __( '& Tuning.', 'auto-emotion' ),
			'hero'    => 'zubehoer-reifenwand.jpg',
			'lead'    => __( 'Dachträger für den Urlaub, Anhängerkupplung fürs Hobby oder ein paar eigene Akzente im Innenraum: Original-Zubehör von Seat, Cupra und Nissan rüsten wir bei Bedarf bei der Übergabe oder bei einem Werkstatttermin nach.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'auto', __( 'Dachträger', 'auto-emotion' ), __( 'Original-Zubehör Ihrer Marke.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Anhängerkupplungen', 'auto-emotion' ), __( 'Nachgerüstet bei einem Werkstatttermin.', 'auto-emotion' ) ),
				array( 'stift', __( 'Innenraum und Design', 'auto-emotion' ), __( 'Individuelle Elemente für Ihr Fahrzeug.', 'auto-emotion' ) ),
			),
			'block'   => array( 'cupra-formentor-abt-angebot.jpg', __( 'CUPRA Formentor VZ Custom by ABT', 'auto-emotion' ), __( 'Mehr als Original-Zubehör', 'auto-emotion' ), __( 'Zum Beispiel: Formentor by ABT.', 'auto-emotion' ), __( 'Wie weit das gehen kann, zeigt unser Angebot des CUPRA Formentor VZ Custom by ABT, veredelt mit dem ABT Custom-Tuningpaket. Wir sagen Ihnen, was für Ihr Fahrzeug verfügbar und sinnvoll ist.', 'auto-emotion' ), home_url( '/angebote/cupra-formentor-vz-custom-by-abt-leasing-ab-333-e-im-monat/' ), __( 'Angebot ansehen', 'auto-emotion' ) ),
			'mail'    => 'Anfrage Zubehör & Tuning',
			'weitere' => array( 'reifen-felgen', 'beklebungsservice', 'ersatzteile' ),
		),
		'ersatzteile' => array(
			'pre'     => "Ersatz\xC2\xADteile",
			'accent'  => __( 'im Original.', 'auto-emotion' ),
			'hero'    => 'service-empfang-seat-anmeldung.jpg',
			'lead'    => __( 'Als Vertragswerkstatt für Seat, Cupra und Nissan beziehen wir Original-Ersatzteile direkt über die Hersteller. Nicht nur für unsere Werkstatt: Wenn Sie selbst Hand anlegen möchten, bekommen Sie sie auf Anfrage auch als Einzelteil.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'teil', __( 'Direkt vom Hersteller', 'auto-emotion' ), __( 'Original-Teile für Seat, Cupra und Nissan.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Auch als Einzelteil', 'auto-emotion' ), __( 'Für alle, die selbst schrauben möchten.', 'auto-emotion' ) ),
				array( 'dokument', __( 'Mit Fahrgestellnummer', 'auto-emotion' ), __( 'So finden wir am einfachsten das richtige Teil.', 'auto-emotion' ) ),
			),
			'block'   => array( 'career-kfz-serviceberater.jpg', __( 'Servicehalle von Auto Emotion', 'auto-emotion' ), __( 'So geht es', 'auto-emotion' ), __( 'Fahrzeug und Teil nennen, fertig.', 'auto-emotion' ), __( 'Teilen Sie uns Ihr Fahrzeug und das benötigte Teil mit, am einfachsten mit der Fahrgestellnummer. Wir prüfen Verfügbarkeit und Preis.', 'auto-emotion' ) ),
			'mail'    => 'Ersatzteil-Anfrage',
			'weitere' => array( 'zubehoer-tuning', 'inspektion-wartung', 'reifen-felgen' ),
		),
		'reifen-felgen' => array(
			'pre'     => __( 'Reifen', 'auto-emotion' ),
			'accent'  => __( '& Felgen.', 'auto-emotion' ),
			'hero'    => 'service-felge-xtrail.jpg',
			'lead'    => __( 'Sommer, Winter oder Ganzjahr, Stahl oder Leichtmetall: Wir beraten Sie, welche Reifen und Felgen zu Ihrem Auto passen, und besorgen sie in der gewünschten Dimension und Ausführung.', 'auto-emotion' ),
			'punkte'  => array(
				array( 'reifen', __( 'Reifen für jede Saison', 'auto-emotion' ), __( 'Sommer-, Winter- oder Ganzjahresreifen.', 'auto-emotion' ) ),
				array( 'teil', __( 'Stahl oder Leichtmetall', 'auto-emotion' ), __( 'In Ihrer Dimension und Ausführung.', 'auto-emotion' ) ),
				array( 'werkzeug', __( 'Montage im Haus', 'auto-emotion' ), __( 'Fachgerecht montiert, direkt bei uns.', 'auto-emotion' ) ),
			),
			'block'   => array( 'reifen-felgen-rad-detail.jpg', __( 'Komplettrad auf einem Reifenstapel im Showroom von Auto Emotion', 'auto-emotion' ), __( 'Ihr Angebot', 'auto-emotion' ), __( 'Passend zu Fahrzeug und Budget.', 'auto-emotion' ), __( 'Sprechen Sie uns an. Wir erstellen Ihnen ein individuelles Angebot für Ihr Fahrzeug.', 'auto-emotion' ) ),
			'weitere' => array( 'reifenservice-reifeneinlagerung', 'achsvermessung', 'zubehoer-tuning' ),
		),
	);
}

/**
 * Titel und Icon für die Kacheln „Weitere Leistungen“.
 */
function auto_emotion_service_kachel( $slug ) {
	$kacheln = array(
		'freie-werkstatt'                 => array( 'werkzeug', __( 'Freie Werkstatt', 'auto-emotion' ) ),
		'hu-au'                           => array( 'pruefung', __( 'HU / AU', 'auto-emotion' ) ),
		'inspektion-wartung'              => array( 'haken', __( 'Inspektion & Wartung', 'auto-emotion' ) ),
		'reifenservice-reifeneinlagerung' => array( 'lager', __( 'Reifenservice & Einlagerung', 'auto-emotion' ) ),
		'klimaservice'                    => array( 'kaelte', __( 'Klimaservice', 'auto-emotion' ) ),
		'unfallinstandsetzung-lackierung' => array( 'lack', __( 'Unfall & Lackierung', 'auto-emotion' ) ),
		'achsvermessung'                  => array( 'achse', __( 'Achsvermessung', 'auto-emotion' ) ),
		'fahrzeugaufbereitung'            => array( 'funke', __( 'Fahrzeugaufbereitung', 'auto-emotion' ) ),
		'beklebungsservice'               => array( 'stift', __( 'Beklebungsservice', 'auto-emotion' ) ),
		'zubehoer-tuning'                 => array( 'auto', __( 'Zubehör & Tuning', 'auto-emotion' ) ),
		'ersatzteile'                     => array( 'teil', __( 'Ersatzteile', 'auto-emotion' ) ),
		'reifen-felgen'                   => array( 'reifen', __( 'Reifen & Felgen', 'auto-emotion' ) ),
	);

	return $kacheln[ $slug ] ?? null;
}
