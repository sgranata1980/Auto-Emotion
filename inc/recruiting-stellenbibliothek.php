<?php
/**
 * Stellenbibliothek: interne Vorlagen-Datenbank typischer Autohaus-
 * Berufe (Verkauf, Werkstatt, Service, Gutachten, Verwaltung, Lager,
 * Ausbildung) mit fertigen Aufgaben-/Anforderungsprofilen. Dient als
 * Nachschlagewerk beim Anlegen eines neuen Suchprofils – ein Klick
 * übernimmt Titel, Stichworte und Anstellungsart als Startpunkt, statt
 * jede Position von Null an zu formulieren.
 *
 * Bewusst als eigene, editierbare Bibliothek (privater Post-Type) statt
 * als starres Array: die Texte sind allgemeine, branchenübliche
 * Rollenbeschreibungen (keine erfundenen Auto-Emotion-spezifischen
 * Behauptungen) und lassen sich im Mitarbeiterbereich jederzeit
 * anpassen oder um weitere Berufe ergänzen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_stellenvorlage_cpt() {
	register_post_type(
		'stellenvorlage',
		array(
			'labels'              => array(
				'name'          => __( 'Stellenbibliothek', 'auto-emotion' ),
				'singular_name' => __( 'Stellenvorlage', 'auto-emotion' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'        => false,
			'show_ui'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => array( 'title' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_stellenvorlage_cpt' );

function auto_emotion_stellenbibliothek_kategorien() {
	return array(
		'verkauf'    => __( 'Verkauf', 'auto-emotion' ),
		'werkstatt'  => __( 'Werkstatt & Technik', 'auto-emotion' ),
		'service'    => __( 'Service & Kundenbetreuung', 'auto-emotion' ),
		'gutachten'  => __( 'Gutachten & Bewertung', 'auto-emotion' ),
		'verwaltung' => __( 'Verwaltung & Management', 'auto-emotion' ),
		'lager'      => __( 'Lager, Teile & Aufbereitung', 'auto-emotion' ),
		'ausbildung' => __( 'Ausbildung', 'auto-emotion' ),
	);
}

/**
 * Einmalige Befüllung mit branchenüblichen Autohaus-Berufen. Läuft nur
 * einmal (versioniert) – danach ist die Bibliothek frei editierbar, ein
 * erneutes Plugin-/Theme-Update überschreibt keine eigenen Änderungen.
 */
function auto_emotion_seed_stellenbibliothek() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_stellenbibliothek_seed_version' ) === $needed_version ) {
		return;
	}

	$vorlagen = array(
		array(
			'titel'        => 'Verkaufsleiter/in',
			'kategorie'    => 'verkauf',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Vertrieb, Führung, Autohaus, Verkauf, Kennzahlen',
			'aufgaben'     => "Führung und Entwicklung des Verkaufsteams (Neu- und Gebrauchtwagen)\nVerantwortung für Absatz-, Umsatz- und Ertragsziele des Autohauses\nSteuerung von Einkauf und Fahrzeugbestand\nPreisgestaltung und Verhandlung bei Großkunden- und Flottengeschäften\nZusammenarbeit mit den Herstellern bei Verkaufsprogrammen\nAuswertung von Kennzahlen und Reporting an die Geschäftsführung",
			'anforderungen' => "Mehrjährige Erfahrung im Automobilverkauf, idealerweise in leitender Funktion\nFührungserfahrung und ausgeprägte Vertriebsstärke\nKaufmännisches Verständnis und Zahlenaffinität\nVerhandlungsgeschick und sicheres Auftreten\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Automobilverkäufer/in (Neuwagen)',
			'kategorie'    => 'verkauf',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Verkauf, Neuwagen, Kundenberatung',
			'aufgaben'     => "Beratung und Verkauf von Neufahrzeugen\nDurchführung von Probefahrten und Fahrzeugpräsentationen\nErstellung von Finanzierungs- und Leasingangeboten\nPflege und Ausbau des Kundenstamms\nTeilnahme an Verkaufsförderungsaktionen und Messen",
			'anforderungen' => "Abgeschlossene kaufmännische oder technische Ausbildung\nErfahrung im Automobilverkauf von Vorteil\nKommunikationsstärke und Freude am Kundenkontakt\nVerhandlungsgeschick und Abschlusssicherheit\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Gebrauchtwagenverkäufer/in',
			'kategorie'    => 'verkauf',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Gebrauchtwagen, Verkauf, Fahrzeugbewertung',
			'aufgaben'     => "Beratung und Verkauf von Gebrauchtfahrzeugen\nFahrzeugbewertung bei Inzahlungnahmen\nErstellung aussagekräftiger Online-Inserate\nAbwicklung von Finanzierung, Zulassung und Übergabe\nPflege des Gebrauchtwagenbestands und der Ausstellungsfläche",
			'anforderungen' => "Erfahrung im Fahrzeugverkauf, idealerweise Gebrauchtwagen\nGutes technisches Verständnis für Fahrzeugzustand und -bewertung\nVerhandlungsgeschick und verbindliches Auftreten\nSicherer Umgang mit Verkaufs- und Inseratsplattformen\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Verkaufsberater/in Flotten- & Gewerbekunden',
			'kategorie'    => 'verkauf',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Flottenverkauf, B2B, Geschäftskunden, Leasing',
			'aufgaben'     => "Betreuung und Ausbau von Geschäfts- und Flottenkunden\nErstellung individueller Flotten- und Leasingkonzepte\nKoordination von Großaufträgen mit Werkstatt und Zulassungsstelle\nPflege langfristiger Kundenbeziehungen im B2B-Bereich\nMarktbeobachtung und Akquise neuer Geschäftskunden",
			'anforderungen' => "Erfahrung im B2B-Vertrieb, idealerweise im Automobilbereich\nVerständnis für Leasing-, Finanzierungs- und Flottenmodelle\nVerhandlungssicherheit und unternehmerisches Denken\nReisebereitschaft im regionalen Einzugsgebiet\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Werkstattleiter/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Werkstattleitung, Kfz-Meister, Führung, Technik',
			'aufgaben'     => "Fachliche und organisatorische Leitung der Werkstatt\nPersonaleinsatzplanung und Terminsteuerung\nSicherstellung von Qualität, Arbeitssicherheit und Herstellervorgaben\nAnsprechpartner für technische Rückfragen von Kunden und Team\nVerantwortung für Werkstattauslastung und Wirtschaftlichkeit",
			'anforderungen' => "Meister- oder Technikerausbildung im Kfz-Handwerk\nMehrjährige Berufserfahrung, idealerweise mit Führungsverantwortung\nOrganisationsstärke und technisches Fachwissen\nSicherer Umgang mit Werkstattsteuerungssystemen\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Kfz-Mechatroniker/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Kfz-Mechatroniker, Diagnose, Service, Werkstatt',
			'aufgaben'     => "Wartung, Inspektion und Reparatur von Fahrzeugen\nFehlerdiagnose an mechanischen, elektrischen und elektronischen Systemen\nDurchführung von Service- und Garantiearbeiten nach Herstellervorgaben\nEin- und Umbau von Zubehör und Sonderausstattung\nDokumentation der durchgeführten Arbeiten im Werkstattsystem",
			'anforderungen' => "Abgeschlossene Ausbildung als Kfz-Mechatroniker/in\nSicherer Umgang mit Diagnosegeräten und Werkstattsoftware\nSorgfältige, selbstständige Arbeitsweise\nTeamfähigkeit und Bereitschaft zur Weiterbildung\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Kfz-Mechaniker/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Kfz-Mechaniker, Wartung, Reparatur',
			'aufgaben'     => "Durchführung mechanischer Reparatur- und Wartungsarbeiten\nAustausch von Verschleißteilen (Bremsen, Reifen, Öl, Filter)\nUnterstützung bei der Fehlersuche an Fahrzeugsystemen\nVorbereitung von Fahrzeugen für die Hauptuntersuchung\nEinhaltung von Sauberkeit und Ordnung am Arbeitsplatz",
			'anforderungen' => "Abgeschlossene Ausbildung als Kfz-Mechaniker/in oder vergleichbar\nHandwerkliches Geschick und technisches Verständnis\nZuverlässigkeit und körperliche Belastbarkeit\nTeamfähigkeit\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Kfz-Elektriker/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Kfz-Elektrik, Elektronik, Diagnose',
			'aufgaben'     => "Diagnose und Reparatur elektrischer und elektronischer Fahrzeugsysteme\nEinbau von Nachrüst- und Zubehörteilen (Navigation, Alarmanlagen, Anhängerkupplungen)\nFehlerauslese und -behebung mit Diagnosesystemen\nPrüfung von Bordnetz, Sensorik und Steuergeräten\nDokumentation der Arbeiten im Werkstattsystem",
			'anforderungen' => "Abgeschlossene Ausbildung als Kfz-Elektriker/in oder Mechatroniker/in mit Schwerpunkt Elektrik\nGutes Verständnis von Fahrzeugelektronik und Bordnetzen\nSorgfalt und analytisches Denken\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Hochvolttechniker/in (E-Mobilität)',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Hochvolt, E-Mobilität, Hybrid, Elektrofahrzeuge',
			'aufgaben'     => "Wartung und Reparatur von Hybrid- und Elektrofahrzeugen\nArbeiten an Hochvolt-Systemen nach Sicherheitsvorgaben\nDiagnose von Batterie-, Lade- und Antriebssystemen\nDurchführung von Hochvolt-Freischaltungen und Sicherheitsprüfungen\nBeratung des Teams zu Fragen der E-Mobilität",
			'anforderungen' => "Abgeschlossene Kfz-Ausbildung mit Zusatzqualifikation Hochvolt\nFundiertes Wissen im Bereich Elektro- und Hybridantriebe\nSicherheitsbewusstsein und strukturierte Arbeitsweise\nBereitschaft zu regelmäßigen Schulungen\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Lackierer/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Lackierer, Lackierung, Karosserie',
			'aufgaben'     => "Vorbereitung, Lackierung und Nachbearbeitung von Fahrzeugteilen\nFarbtonbestimmung und Mischung nach Herstellervorgaben\nAusbesserung von Lackschäden und Unfallreparaturen\nQualitätskontrolle der lackierten Oberflächen\nPflege und Wartung der Lackierkabine und Geräte",
			'anforderungen' => "Abgeschlossene Ausbildung als Fahrzeuglackierer/in\nGutes Farbempfinden und handwerkliches Geschick\nSorgfältige, präzise Arbeitsweise\nKenntnisse im Umgang mit Lackiersystemen und Mischanlagen",
		),
		array(
			'titel'        => 'Karosserie- und Fahrzeugbaumechaniker/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Karosseriebau, Unfallinstandsetzung, Schweißen',
			'aufgaben'     => "Instandsetzung von Karosserie- und Unfallschäden\nAusbeulen, Richten und Schweißen von Karosserieteilen\nAus- und Einbau von Anbauteilen\nZusammenarbeit mit Lackierer/innen bei Unfallreparaturen\nPrüfung der Karosseriegeometrie nach der Reparatur",
			'anforderungen' => "Abgeschlossene Ausbildung im Karosserie- und Fahrzeugbau\nErfahrung in der Unfallinstandsetzung von Vorteil\nHandwerkliches Geschick und technisches Verständnis\nTeamfähigkeit und Sorgfalt",
		),
		array(
			'titel'        => 'Diagnosetechniker/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Diagnose, Fehlersuche, Kfz-Technik',
			'aufgaben'     => "Systematische Fehlerdiagnose an komplexen Fahrzeugsystemen\nEinsatz herstellerspezifischer Diagnosesoftware\nUnterstützung des Werkstattteams bei schwierigen Störungsfällen\nDokumentation und Auswertung von Diagnoseergebnissen\nRückmeldung an den Hersteller bei wiederkehrenden Fehlerbildern",
			'anforderungen' => "Abgeschlossene Kfz-Ausbildung mit Weiterbildung im Diagnosebereich\nAusgeprägtes analytisches Denkvermögen\nSicherer Umgang mit Diagnosesystemen und Stromlaufplänen\nErfahrung und Ruhe auch bei schwierigen Fehlersuchen",
		),
		array(
			'titel'        => 'Reifenmonteur/in',
			'kategorie'    => 'werkstatt',
			'anstellungsart' => 'teilzeit',
			'stichworte'   => 'Reifen, Räder, Saisonwechsel',
			'aufgaben'     => "Montage, Demontage und Auswuchten von Reifen und Rädern\nDurchführung des saisonalen Reifenwechsels\nEinlagerung und Verwaltung von Kundenreifen\nSichtprüfung von Reifen, Felgen und Bremsanlage\nUnterstützung der Werkstatt bei allgemeinen Serviceaufgaben",
			'anforderungen' => "Erste Erfahrung in der Reifenmontage wünschenswert, Quereinstieg möglich\nHandwerkliches Geschick und körperliche Belastbarkeit\nZuverlässigkeit, besonders in der Saison\nFührerschein Klasse B von Vorteil",
		),
		array(
			'titel'        => 'Serviceberater/in',
			'kategorie'    => 'service',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Serviceberatung, Kundenannahme, Werkstatt',
			'aufgaben'     => "Fahrzeugannahme und Beratung der Kunden zu Reparatur- und Serviceumfang\nErstellung von Kostenvoranschlägen und Auftragsfreigaben\nKoordination zwischen Kunde, Werkstatt und Ersatzteillager\nKommunikation von Zusatzarbeiten und Terminänderungen\nFahrzeugübergabe inklusive Rechnungserklärung",
			'anforderungen' => "Abgeschlossene Kfz-technische oder kaufmännische Ausbildung\nTechnisches Verständnis und sicheres, freundliches Auftreten\nOrganisationstalent und Kommunikationsstärke\nErfahrung im Werkstatt- oder Serviceumfeld von Vorteil\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Serviceassistent/in',
			'kategorie'    => 'service',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Serviceassistenz, Terminplanung, Kundenempfang',
			'aufgaben'     => "Terminvereinbarung und -koordination für den Werkstattbereich\nEmpfang und Betreuung von Kunden am Serviceschalter\nUnterstützung der Serviceberater bei administrativen Aufgaben\nPflege von Kundendaten und Werkstattsystemen\nOrganisation von Ersatzmobilität (Leihwagen, Shuttle)",
			'anforderungen' => "Abgeschlossene kaufmännische Ausbildung oder vergleichbare Erfahrung\nFreundliches, organisiertes Auftreten\nSicherer Umgang mit MS Office und Dealer-Management-Systemen\nTeamfähigkeit und Belastbarkeit im Tagesgeschäft",
		),
		array(
			'titel'        => 'Kundendienstberater/in (Annahmemeister/in)',
			'kategorie'    => 'service',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Annahmemeister, Kundendienst, Qualitätskontrolle',
			'aufgaben'     => "Technische Erstdiagnose bei der Fahrzeugannahme\nBeratung zu Reparaturumfang, Kosten und Dauer\nQualitätskontrolle vor der Fahrzeugübergabe\nReklamationsbearbeitung und Kundenbetreuung bei Rückfragen\nEnge Abstimmung mit Werkstattleitung und Technikern",
			'anforderungen' => "Meister- oder Technikerausbildung im Kfz-Handwerk\nMehrjährige Werkstatterfahrung\nAusgeprägte Kunden- und Serviceorientierung\nDurchsetzungsvermögen in der Teamkoordination",
		),
		array(
			'titel'        => 'Kfz-Sachverständiger / Gutachter/in',
			'kategorie'    => 'gutachten',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Gutachten, Sachverständiger, Schadensbewertung',
			'aufgaben'     => "Erstellung von Schadensgutachten nach Unfällen\nBewertung von Fahrzeugzustand, Zeitwert und Reparaturkosten\nAbstimmung mit Versicherungen, Werkstatt und Kunden\nDokumentation von Schäden inklusive Fotoprotokoll\nPlausibilitätsprüfung von Kostenvoranschlägen",
			'anforderungen' => "Ausbildung oder Studium mit kfz-technischem Schwerpunkt, idealerweise Sachverständigen-Qualifikation\nFundierte Kenntnisse in Schadens- und Wertgutachten\nSorgfältige, objektive Arbeitsweise\nGute kommunikative Fähigkeiten im Umgang mit Versicherungen und Kunden",
		),
		array(
			'titel'        => 'Geschäftsführer/in (Autohausleiter/in)',
			'kategorie'    => 'verwaltung',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Geschäftsführung, Autohausleitung, Management',
			'aufgaben'     => "Gesamtverantwortung für Strategie, Wirtschaftlichkeit und Entwicklung des Autohauses\nFührung der Abteilungsleiter in Verkauf, Werkstatt und Verwaltung\nVerhandlungen mit Herstellern, Lieferanten und Großkunden\nBudgetplanung, Controlling und Erfolgskennzahlen\nRepräsentation des Unternehmens nach außen",
			'anforderungen' => "Mehrjährige Führungserfahrung im Automobilhandel\nBetriebswirtschaftliches Verständnis und unternehmerisches Denken\nEntscheidungsstärke und Kommunikationsgeschick\nKenntnisse der Hersteller- und Markenanforderungen",
		),
		array(
			'titel'        => 'Marketingleiter/in',
			'kategorie'    => 'verwaltung',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Marketing, Social Media, Kampagnen, Markenauftritt',
			'aufgaben'     => "Entwicklung und Umsetzung der Marketingstrategie des Autohauses\nPlanung und Steuerung von Kampagnen (Online, Social Media, Print)\nPflege von Website und Social-Media-Kanälen\nOrganisation von Events, Aktionen und Markenauftritten\nErfolgsmessung und Budgetverantwortung für Marketingmaßnahmen",
			'anforderungen' => "Ausbildung oder Studium im Bereich Marketing/Kommunikation\nErfahrung im Automobil- oder Handelsumfeld von Vorteil\nKreativität gepaart mit analytischem Denken\nSicherer Umgang mit gängigen Marketing- und Social-Media-Tools",
		),
		array(
			'titel'        => 'Buchhalter/in (Finanzbuchhaltung)',
			'kategorie'    => 'verwaltung',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Buchhaltung, Finanzen, Rechnungswesen',
			'aufgaben'     => "Führung der laufenden Finanzbuchhaltung\nKontenabstimmung, Zahlungsverkehr und Mahnwesen\nVorbereitung von Monats- und Jahresabschlüssen\nZusammenarbeit mit Steuerberatung und Wirtschaftsprüfung\nErstellung betriebswirtschaftlicher Auswertungen",
			'anforderungen' => "Abgeschlossene kaufmännische Ausbildung, idealerweise mit Weiterbildung zum/zur Finanzbuchhalter/in\nBerufserfahrung in der Buchhaltung, idealerweise im Autohaus\nSicherer Umgang mit Buchhaltungssoftware und DMS-Systemen\nGenauigkeit und Zahlenaffinität",
		),
		array(
			'titel'        => 'Personalreferent/in',
			'kategorie'    => 'verwaltung',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Personalwesen, Recruiting, HR',
			'aufgaben'     => "Betreuung des gesamten Bewerbungs- und Einstellungsprozesses\nAnsprechpartner/in für Mitarbeitende in personalrelevanten Fragen\nPflege von Personalakten und -daten\nVorbereitung der Lohn- und Gehaltsabrechnung in Zusammenarbeit mit der Buchhaltung\nMitwirkung an Employer-Branding- und Recruiting-Maßnahmen",
			'anforderungen' => "Abgeschlossene kaufmännische Ausbildung, idealerweise mit personalwirtschaftlicher Weiterbildung\nErfahrung im Personalwesen\nDiskretion, Organisationstalent und Kommunikationsstärke\nSicherer Umgang mit MS Office",
		),
		array(
			'titel'        => 'Teileverkäufer/in (Ersatzteile)',
			'kategorie'    => 'lager',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Ersatzteile, Teilelager, Disposition',
			'aufgaben'     => "Beratung und Verkauf von Ersatz- und Zubehörteilen\nBestellung, Disposition und Verwaltung des Teilelagers\nZusammenarbeit mit der Werkstatt bei der Teileversorgung für Reparaturaufträge\nWareneingangskontrolle und Inventur\nRechnungsstellung und Reklamationsbearbeitung",
			'anforderungen' => "Abgeschlossene Ausbildung im Groß- und Außenhandel, Kfz-Bereich oder vergleichbar\nGutes technisches Verständnis für Fahrzeugteile\nOrganisationsgeschick und sorgfältige Arbeitsweise\nSicherer Umgang mit Teile- und Lagerverwaltungssystemen",
		),
		array(
			'titel'        => 'Lagerist/in (Ersatzteillager)',
			'kategorie'    => 'lager',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Lager, Logistik, Ersatzteile',
			'aufgaben'     => "Warenannahme, Einlagerung und Kommissionierung von Ersatzteilen\nInnerbetrieblicher Transport von Teilen zur Werkstatt\nDurchführung von Bestandskontrollen und Inventuren\nVerpackung und Versandvorbereitung von Teilen\nOrdnung und Sauberkeit im Lagerbereich",
			'anforderungen' => "Erste Erfahrung in Lager oder Logistik von Vorteil, Quereinstieg möglich\nSorgfalt und körperliche Belastbarkeit\nStaplerschein wünschenswert\nZuverlässigkeit und Teamfähigkeit",
		),
		array(
			'titel'        => 'Fahrzeugaufbereiter/in',
			'kategorie'    => 'lager',
			'anstellungsart' => 'vollzeit',
			'stichworte'   => 'Fahrzeugaufbereitung, Reinigung, Politur',
			'aufgaben'     => "Innen- und Außenreinigung von Neu-, Gebraucht- und Werkstattfahrzeugen\nAufbereitung von Fahrzeugen für Verkauf und Übergabe\nDurchführung von Lackversiegelung, Politur und Kleinstschadenbeseitigung\nVorbereitung von Fahrzeugen für Fotos und Online-Inserate\nPflege der Außen- und Ausstellungsflächen",
			'anforderungen' => "Erfahrung in der Fahrzeugaufbereitung wünschenswert, Quereinstieg möglich\nSorgfältige, gründliche Arbeitsweise\nFreude an sauberem, gepflegtem Arbeiten\nFührerschein Klasse B",
		),
		array(
			'titel'        => 'Auszubildende/r Kfz-Mechatroniker/in',
			'kategorie'    => 'ausbildung',
			'anstellungsart' => 'ausbildung',
			'stichworte'   => 'Ausbildung, Kfz-Mechatroniker, Nachwuchs',
			'aufgaben'     => "Erlernen von Wartung, Diagnose und Reparatur moderner Fahrzeuge\nBegleitung erfahrener Mechatroniker/innen im Werkstattalltag\nSchrittweise Übernahme eigener Arbeitsaufträge unter Anleitung\nBesuch der Berufsschule und interner Schulungen\nVorbereitung auf die Zwischen- und Abschlussprüfung",
			'anforderungen' => "Guter Haupt- oder Realschulabschluss\nTechnisches Interesse und handwerkliches Geschick\nZuverlässigkeit und Lernbereitschaft\nTeamfähigkeit",
		),
	);

	foreach ( $vorlagen as $vorlage ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'stellenvorlage',
				'post_title'  => $vorlage['titel'],
				'post_status' => 'publish',
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		update_post_meta( $post_id, '_vorlage_kategorie', $vorlage['kategorie'] );
		update_post_meta( $post_id, '_vorlage_anstellungsart', $vorlage['anstellungsart'] );
		update_post_meta( $post_id, '_vorlage_stichworte', $vorlage['stichworte'] );
		update_post_meta( $post_id, '_vorlage_aufgaben', $vorlage['aufgaben'] );
		update_post_meta( $post_id, '_vorlage_anforderungen', $vorlage['anforderungen'] );
	}

	update_option( 'auto_emotion_stellenbibliothek_seed_version', $needed_version );
}
add_action( 'init', 'auto_emotion_seed_stellenbibliothek', 15 );

function auto_emotion_stellenbibliothek_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/stellenbibliothek/?$', 'index.php?ae_staff_route=stellenbibliothek', 'top' );
	add_rewrite_rule( '^mitarbeiter/stellenbibliothek/neu/?$', 'index.php?ae_staff_route=stellenvorlage_neu', 'top' );
	add_rewrite_rule( '^mitarbeiter/stellenbibliothek/([0-9]+)/?$', 'index.php?ae_staff_route=stellenvorlage_bearbeiten&ae_staff_id=$matches[1]', 'top' );
}
add_action( 'init', 'auto_emotion_stellenbibliothek_rewrite_rules' );

function auto_emotion_maybe_flush_stellenbibliothek_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_stellenbibliothek_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_stellenbibliothek_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_stellenbibliothek_rewrite_rules', 20 );

function auto_emotion_stellenbibliothek_template_redirect() {
	$route = get_query_var( 'ae_staff_route' );

	if ( ! in_array( $route, array( 'stellenbibliothek', 'stellenvorlage_neu', 'stellenvorlage_bearbeiten' ), true ) ) {
		return;
	}

	auto_emotion_staff_require_login();

	if ( 'stellenbibliothek' === $route ) {
		$filter_kategorie = isset( $_GET['kategorie'] ) ? sanitize_key( wp_unslash( $_GET['kategorie'] ) ) : '';
		$query_args       = array(
			'post_type'      => 'stellenvorlage',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		if ( $filter_kategorie && array_key_exists( $filter_kategorie, auto_emotion_stellenbibliothek_kategorien() ) ) {
			$query_args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- kleine, interne Ergebnismenge (eigene Stellenbibliothek).
				array(
					'key'   => '_vorlage_kategorie',
					'value' => $filter_kategorie,
				),
			);
		}

		auto_emotion_render_template_part(
			'stellenbibliothek.php',
			array(
				'auto_emotion_vorlagen'          => get_posts( $query_args ),
				'auto_emotion_filter_kategorie'  => $filter_kategorie,
			)
		);
		exit;
	}

	if ( 'stellenvorlage_neu' === $route ) {
		auto_emotion_render_template_part( 'stellenvorlage-form.php', array( 'auto_emotion_vorlage_post' => null ) );
		exit;
	}

	if ( 'stellenvorlage_bearbeiten' === $route ) {
		$id   = absint( get_query_var( 'ae_staff_id' ) );
		$post = get_post( $id );
		if ( ! $post || 'stellenvorlage' !== $post->post_type ) {
			wp_safe_redirect( home_url( '/mitarbeiter/stellenbibliothek/' ) );
			exit;
		}
		auto_emotion_render_template_part( 'stellenvorlage-form.php', array( 'auto_emotion_vorlage_post' => $post ) );
		exit;
	}
}
add_action( 'template_redirect', 'auto_emotion_stellenbibliothek_template_redirect' );

function auto_emotion_handle_stellenvorlage_speichern() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_stellenvorlage_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_stellenvorlage_nonce'] ) ), 'auto_emotion_stellenvorlage_speichern' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post_id   = isset( $_POST['ae_vorlage_id'] ) ? absint( $_POST['ae_vorlage_id'] ) : 0;
	$titel     = isset( $_POST['ae_vorlage_titel'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_vorlage_titel'] ) ) : '';
	$kategorie = isset( $_POST['ae_vorlage_kategorie'] ) ? sanitize_key( wp_unslash( $_POST['ae_vorlage_kategorie'] ) ) : '';

	if ( ! $titel || ! array_key_exists( $kategorie, auto_emotion_stellenbibliothek_kategorien() ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/stellenbibliothek/' ) );
		exit;
	}

	$post_data = array(
		'post_title'  => $titel,
		'post_type'   => 'stellenvorlage',
		'post_status' => 'publish',
	);

	if ( $post_id ) {
		$existing = get_post( $post_id );
		if ( ! $existing || 'stellenvorlage' !== $existing->post_type ) {
			wp_safe_redirect( home_url( '/mitarbeiter/stellenbibliothek/' ) );
			exit;
		}
		$post_data['ID'] = $post_id;
		wp_update_post( $post_data );
	} else {
		$post_id = wp_insert_post( $post_data );
	}

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_vorlage_kategorie', $kategorie );

		$anstellungsart = isset( $_POST['ae_vorlage_anstellungsart'] ) ? sanitize_key( wp_unslash( $_POST['ae_vorlage_anstellungsart'] ) ) : '';
		update_post_meta( $post_id, '_vorlage_anstellungsart', $anstellungsart );

		$stichworte = isset( $_POST['ae_vorlage_stichworte'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_vorlage_stichworte'] ) ) : '';
		update_post_meta( $post_id, '_vorlage_stichworte', $stichworte );

		$aufgaben = isset( $_POST['ae_vorlage_aufgaben'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_vorlage_aufgaben'] ) ) : '';
		update_post_meta( $post_id, '_vorlage_aufgaben', $aufgaben );

		$anforderungen = isset( $_POST['ae_vorlage_anforderungen'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_vorlage_anforderungen'] ) ) : '';
		update_post_meta( $post_id, '_vorlage_anforderungen', $anforderungen );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/stellenbibliothek/' . ( $post_id ? $post_id . '/' : '' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_stellenvorlage_speichern', 'auto_emotion_handle_stellenvorlage_speichern' );

function auto_emotion_handle_stellenvorlage_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_vorlage_id'] ) ? absint( $_GET['ae_vorlage_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_stellenvorlage_delete_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'stellenvorlage' === $post->post_type ) {
		wp_trash_post( $post_id );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/stellenbibliothek/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_stellenvorlage_delete', 'auto_emotion_handle_stellenvorlage_delete' );
