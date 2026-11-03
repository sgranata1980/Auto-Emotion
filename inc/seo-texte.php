<?php
/**
 * Suchmaschinentexte der Service- und Unternehmensseiten: Seitentitel,
 * Meta Description, längere Abschnitte und sichtbare Fragen.
 *
 * Aussagen über Auto Emotion stammen aus den bisherigen Seitentexten.
 * Allgemeines Fachwissen (etwa HU-Fristen) ist als solches formuliert.
 * Keine Preise, Dauer oder Leistungen ergänzen, die nicht bestätigt sind.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Alle Einträge nach Slug: title, desc, abschnitte, fragen.
 */
function auto_emotion_seo_seiten() {
	return array(
		'freie-werkstatt' => array(
			'title'      => 'Freie Werkstatt in Offenbach für alle Marken | Auto Emotion',
			'desc'       => 'Freie Werkstatt in Offenbach: Inspektion, Reifenservice und HU-Vorbereitung auch für andere Marken. Spezialisiert auf Seat, Cupra und Nissan.',
			'abschnitte' => array(
				array(
					'Werkstatt in Offenbach, auch für andere Marken',
					array(
						'Als Vertragswerkstatt kennen wir Seat, Cupra und Nissan besonders gut. Die Werkstatt an der Sprendlinger Landstraße 166 steht aber auch Fahrern anderer Marken offen, aus Offenbach, Frankfurt und der Umgebung.',
						'Typische Anlässe sind die <a href="/inspektion-wartung/">Inspektion</a>, der <a href="/reifenservice-reifeneinlagerung/">Reifenservice</a> und die Vorbereitung auf die <a href="/hu-au/">Hauptuntersuchung</a>. Auch bei einer <a href="/unfallinstandsetzung-lackierung/">Unfallinstandsetzung</a> lohnt sich der Anruf.',
					),
				),
				array(
					'So kommen Sie zu Ihrem Termin',
					array(
						'Nennen Sie uns Marke, Modell und das, was anliegt. Wir sagen Ihnen, ob und wie wir weiterhelfen können. Den Termin fragen Sie am einfachsten <a href="/servicetermin-buchen/">online an</a> oder telefonisch.',
					),
				),
			),
			'fragen'     => array(
				array( 'Repariert Auto Emotion auch andere Marken als Seat, Cupra und Nissan?', 'Ja. Unsere Werkstattleistungen stehen grundsätzlich allen Fahrzeughaltern offen. Rufen Sie uns an und nennen Sie uns Ihr Fahrzeug, dann klären wir, was möglich ist.' ),
				array( 'Welche Arbeiten übernimmt die Werkstatt bei Fremdmarken?', 'Dazu gehören unter anderem Inspektion, Reifenservice und die Vorbereitung auf die Hauptuntersuchung.' ),
				array( 'Wo finde ich die Werkstatt?', 'Sie finden uns an der Sprendlinger Landstraße 166 in 63069 Offenbach.' ),
			),
		),
		'hu-au' => array(
			'title'      => 'HU und AU in Offenbach: Prüfung im Haus | Auto Emotion',
			'desc'       => 'HU und AU direkt bei Auto Emotion in Offenbach: Prüfung durch eine anerkannte Prüforganisation im Haus, auf Wunsch mit Vorab-Check und Nachbesserung.',
			'abschnitte' => array(
				array(
					'Hauptuntersuchung direkt bei uns im Haus',
					array(
						'Die Hauptuntersuchung führt bei uns eine staatlich anerkannte, unabhängige Prüforganisation durch. Sie stellen Ihr Fahrzeug also an einem Ort vor und müssen für die Prüfung nicht extra zu einer Prüfstelle fahren.',
						'Auf Wunsch sehen wir uns Ihr Auto vorher an. So wissen Sie schon vor dem Termin, ob etwas zu tun ist. Stellt der Prüfer einen Mangel fest, können wir die Nachbesserung bei Bedarf in unserer Werkstatt übernehmen.',
					),
				),
				array(
					'Wann ist die HU fällig?',
					array(
						'Pkw müssen in Deutschland in der Regel alle 24 Monate zur Hauptuntersuchung, Neuwagen erstmals nach 36 Monaten. Die Abgasuntersuchung (AU) ist heute Teil der HU. Den genauen Termin zeigt die Plakette auf dem hinteren Kennzeichen, außerdem steht er im Fahrzeugschein.',
					),
				),
			),
			'fragen'     => array(
				array( 'Führt Auto Emotion die HU selbst durch?', 'Die Prüfung übernimmt eine staatlich anerkannte, unabhängige Prüforganisation. Sie findet direkt bei uns im Haus statt.' ),
				array( 'Was bedeutet Vorab-Check?', 'Auf Wunsch prüfen wir Ihr Fahrzeug vor der Hauptuntersuchung auf mögliche Mängel. So erfahren Sie rechtzeitig, ob etwas zu tun ist.' ),
				array( 'Was passiert, wenn mein Auto die HU nicht besteht?', 'Festgestellte Mängel müssen behoben und nachgeprüft werden. Die nötigen Arbeiten können wir bei Bedarf in unserer Werkstatt erledigen.' ),
			),
		),
		'inspektion-wartung' => array(
			'title'      => 'Inspektion und Wartung in Offenbach | Auto Emotion',
			'desc'       => 'Inspektion und Wartung für Seat, Cupra und Nissan in Offenbach: nach Herstellervorgaben, mit Original-Ersatzteilen und geschultem Fachpersonal.',
			'abschnitte' => array(
				array(
					'Inspektion nach Herstellervorgaben',
					array(
						'Die Service-Intervalle legt der Hersteller fest. Wer sie einhält, erhält Wert, Sicherheit und Garantieanspruch seines Fahrzeugs. Für Seat, Cupra und Nissan führen wir die vorgeschriebenen Intervalle mit Original-Ersatzteilen durch.',
						'Unser Fachpersonal ist auf diese drei Marken spezialisiert und bildet sich regelmäßig bei den Herstellern weiter. Mehr dazu lesen Sie bei den <a href="/werkstatt-schulungen/">Werkstatt-Schulungen</a>.',
					),
				),
				array(
					'Woran Sie den richtigen Zeitpunkt erkennen',
					array(
						'Wann die nächste Inspektion ansteht, zeigt in vielen Fahrzeugen die Serviceanzeige im Cockpit. Auch das Serviceheft gibt Auskunft. Sind Sie unsicher, nennen Sie uns Modell und Kilometerstand im <a href="/servicetermin-buchen/">Terminformular</a>.',
						'Für Seat und Cupra sorgt „Wartung & Inspektion“ der SEAT Leasing für planbare Wartungskosten. Sprechen Sie uns darauf an.',
					),
				),
			),
			'fragen'     => array(
				array( 'Für welche Marken bietet Auto Emotion Inspektionen an?', 'Spezialisiert sind wir auf Seat, Cupra und Nissan. Als freie Werkstatt betreuen wir auch Fahrzeuge anderer Marken.' ),
				array( 'Welche Ersatzteile werden verbaut?', 'Bei Seat, Cupra und Nissan verwenden wir Original-Ersatzteile.' ),
				array( 'Wie frage ich einen Inspektionstermin an?', 'Über das Formular „Servicetermin online buchen“ oder telefonisch. Wir melden uns und stimmen den Termin mit Ihnen ab.' ),
			),
		),
		'reifenservice-reifeneinlagerung' => array(
			'title'      => 'Reifenservice und Einlagerung in Offenbach | Auto Emotion',
			'desc'       => 'Räder wechseln und einlagern in Offenbach: saisonaler Radwechsel, Reifenmontage, Prüfung auf Beschädigungen und Einlagerung bei Auto Emotion.',
			'abschnitte' => array(
				array(
					'Radwechsel und Reifenhotel aus einer Hand',
					array(
						'Zweimal im Jahr steht der Wechsel an, und dazwischen muss der zweite Satz irgendwo bleiben. Bei uns bekommen Sie beides: den Wechsel in der Werkstatt und die fachgerechte Einlagerung Ihrer Räder oder Reifen.',
						'Neue Reifen montieren wir fachgerecht und prüfen alle Reifen auf Beschädigungen. Wenn Sie neue brauchen, beraten wir Sie unter <a href="/reifen-felgen/">Reifen & Felgen</a>.',
					),
				),
				array(
					'Wann sollten Sie wechseln?',
					array(
						'Eine feste Wechselpflicht zu einem Datum gibt es in Deutschland nicht. Bei Glatteis, Schnee und Schneematsch sind aber wintertaugliche Reifen vorgeschrieben. Gesetzlich gilt eine Mindestprofiltiefe von 1,6 Millimetern. Zieht das Auto einseitig oder fahren sich die Reifen ungleich ab, kann eine <a href="/achsvermessung/">Achsvermessung</a> sinnvoll sein.',
					),
				),
			),
			'fragen'     => array(
				array( 'Lagert Auto Emotion meine Räder ein?', 'Ja. Wir lagern Räder oder Reifen fachgerecht und platzsparend ein, bis der nächste Wechsel ansteht.' ),
				array( 'Montieren Sie auch neue Reifen?', 'Ja. Neue Reifen montieren wir fachgerecht direkt bei uns im Haus.' ),
				array( 'Wie tief muss das Reifenprofil sein?', 'Gesetzlich vorgeschrieben sind in Deutschland mindestens 1,6 Millimeter.' ),
			),
		),
		'klimaservice' => array(
			'title'      => 'Klimaservice und Klimaanlage in Offenbach | Auto Emotion',
			'desc'       => 'Klimaservice in Offenbach: Dichtheit und Kältemittel prüfen, Innenraumfilter tauschen und das System reinigen. Für Seat, Cupra und Nissan.',
			'abschnitte' => array(
				array(
					'Was beim Klimaservice passiert',
					array(
						'Wir prüfen die Dichtheit der Anlage und das Kältemittel, tauschen bei Bedarf den Innenraumfilter und reinigen das System. Denn eine Klimaanlage verliert mit der Zeit Kältemittel, und im System können sich Bakterien oder Pollen festsetzen.',
						'Für Cupra und Seat arbeiten wir mit Original-Teilen. Bei Nissan empfehlen wir die regelmäßige Klimaanlagenwartung im Rahmen des NISSAN Rundum-Service.',
					),
				),
				array(
					'Woran Sie merken, dass es Zeit wird',
					array(
						'Typische Anzeichen sind eine schwächere Kühlleistung, ein muffiger Geruch beim Einschalten oder Scheiben, die länger beschlagen bleiben. Tritt so etwas auf, nennen Sie es einfach bei Ihrer <a href="/servicetermin-buchen/">Terminanfrage</a>. Oft lässt sich der Klimaservice mit der <a href="/inspektion-wartung/">Inspektion</a> verbinden.',
					),
				),
			),
			'fragen'     => array(
				array( 'Was umfasst der Klimaservice?', 'Wir prüfen Dichtheit und Kältemittel, tauschen bei Bedarf den Innenraumfilter und reinigen das System.' ),
				array( 'Warum riecht meine Klimaanlage muffig?', 'Häufig haben sich im System Bakterien oder andere Ablagerungen festgesetzt. Eine Reinigung und gegebenenfalls ein neuer Innenraumfilter können helfen.' ),
			),
		),
		'unfallinstandsetzung-lackierung' => array(
			'title'      => 'Unfallreparatur und Lackierung in Offenbach | Auto Emotion',
			'desc'       => 'Unfallinstandsetzung und Lackierung in Offenbach: Karosserie und Lack nach Herstellervorgaben, Kostenvoranschlag und Abwicklung mit der Versicherung.',
			'abschnitte' => array(
				array(
					'Karosserie und Lack nach Herstellervorgaben',
					array(
						'Ob Parkrempler oder größerer Unfallschaden: Unsere Werkstatt repariert Karosserie und Lack fachgerecht nach Herstellervorgaben. Bevor die Reparatur beginnt, erhalten Sie einen unverbindlichen Kostenvoranschlag.',
						'Die Abwicklung mit Ihrer Versicherung übernehmen wir für Sie. Nach einem Unfall prüfen wir außerdem, ob eine <a href="/achsvermessung/">Achsvermessung</a> nötig ist.',
					),
				),
				array(
					'Was Sie nach einem Unfall tun sollten',
					array(
						'Sichern Sie zuerst die Unfallstelle, rufen Sie bei Verletzten den Notruf 112 und halten Sie die Daten der Beteiligten fest. Fotos vom Schaden helfen später bei der Abwicklung. Danach melden Sie den Schaden Ihrer Versicherung und rufen uns an, wir besprechen dann die nächsten Schritte.',
					),
				),
			),
			'fragen'     => array(
				array( 'Bekomme ich vorab einen Kostenvoranschlag?', 'Ja. Sie erhalten einen unverbindlichen Kostenvoranschlag, bevor die Reparatur beginnt.' ),
				array( 'Übernimmt Auto Emotion die Abwicklung mit der Versicherung?', 'Ja. Um die Abwicklung mit Ihrer Versicherung kümmern wir uns für Sie.' ),
				array( 'Repariert die Werkstatt auch andere Marken nach einem Unfall?', 'Rufen Sie uns an und nennen Sie uns Ihr Fahrzeug. Unsere Werkstattleistungen stehen grundsätzlich allen Fahrzeughaltern offen.' ),
			),
		),
		'achsvermessung' => array(
			'title'      => 'Achsvermessung in Offenbach: Spur und Sturz | Auto Emotion',
			'desc'       => 'Achsvermessung in Offenbach: Wir prüfen und justieren Spur und Sturz mit modernem Messequipment, zum Beispiel nach neuen Reifen oder nach einem Unfall.',
			'abschnitte' => array(
				array(
					'Warum die Achse stimmen sollte',
					array(
						'Eine falsch eingestellte Achse zeigt sich oft erst am Reifen: Er fährt sich einseitig ab. Dazu können ein höherer Kraftstoffverbrauch und ein schlechteres Fahrverhalten kommen. Mit modernem Messequipment prüfen wir Spur und Sturz und justieren sie bei Bedarf.',
						'Die Spur beschreibt, wie die Räder von oben gesehen zueinander stehen. Der Sturz beschreibt ihre Neigung von vorn gesehen. Weichen die Werte von den Vorgaben ab, lassen sie sich oft einstellen.',
					),
				),
				array(
					'Wann eine Vermessung sinnvoll ist',
					array(
						'Gute Zeitpunkte sind neue <a href="/reifen-felgen/">Reifen</a> oder der Saisonwechsel beim <a href="/reifenservice-reifeneinlagerung/">Reifenservice</a>. Auch nach einem Unfall, einem harten Bordsteinkontakt oder wenn das Auto einseitig zieht, sollten Sie die Achse prüfen lassen.',
					),
				),
			),
			'fragen'     => array(
				array( 'Wann sollte ich eine Achsvermessung machen lassen?', 'Zum Beispiel nach neuen Reifen, nach einem Unfall oder wenn das Auto einseitig zieht oder die Reifen ungleichmäßig abfahren.' ),
				array( 'Was wird bei der Achsvermessung geprüft?', 'Wir messen Spur und Sturz. Stimmen die Werte nicht, justieren wir sie direkt nach.' ),
			),
		),
		'fahrzeugaufbereitung' => array(
			'title'      => 'Fahrzeugaufbereitung in Offenbach | Auto Emotion',
			'desc'       => 'Fahrzeugaufbereitung in Offenbach: Innenraumreinigung, Lackaufbereitung und Politur bei Auto Emotion. Den Umfang stimmen wir individuell mit Ihnen ab.',
			'abschnitte' => array(
				array(
					'Innen und außen wieder gepflegt',
					array(
						'Vor dem Verkauf, nach dem Gebrauchtwagenkauf oder einfach zwischendurch: Wir reinigen den Innenraum, bereiten den Lack auf und polieren ihn. Was davon nötig ist, stimmen wir individuell mit Ihnen ab.',
						'Ein gepflegtes Auto macht auch beim Verkauf einen besseren Eindruck. Wenn Sie Ihr Fahrzeug abgeben möchten, sehen Sie sich auch unseren <a href="/fahrzeugankauf/">Fahrzeugankauf</a> an.',
					),
				),
				array(
					'Was zur Aufbereitung passt',
					array(
						'Hat der Lack tiefere Schäden, reicht eine Politur nicht immer aus. Dann hilft unsere <a href="/unfallinstandsetzung-lackierung/">Lackierung</a> weiter. Wenn es im Innenraum muffig riecht, lohnt zusätzlich ein Blick auf den <a href="/klimaservice/">Klimaservice</a>.',
					),
				),
			),
			'fragen'     => array(
				array( 'Was gehört zur Fahrzeugaufbereitung?', 'Innenraumreinigung, Lackaufbereitung und Politur. Den genauen Umfang legen wir gemeinsam mit Ihnen fest.' ),
				array( 'Wann lohnt sich eine Aufbereitung?', 'Zum Beispiel vor dem Verkauf, nach dem Gebrauchtwagenkauf oder einfach, wenn Ihr Auto wieder gepflegter aussehen soll.' ),
			),
		),
		'servicetermin-buchen' => array(
			'title'      => 'Servicetermin online anfragen in Offenbach | Auto Emotion',
			'desc'       => 'Servicetermin für Seat, Cupra und Nissan online anfragen: Inspektion, Reifenwechsel, HU oder Klimaservice. Wir melden uns und stimmen den Termin ab.',
			'abschnitte' => array(
				array(
					'Werkstatttermin in Offenbach anfragen',
					array(
						'Mit dem Formular fragen Sie Ihren Termin bei Auto Emotion an der Sprendlinger Landstraße 166 an. Wählen Sie Ihre Marke und die gewünschten Leistungen, zum Beispiel <a href="/inspektion-wartung/">Inspektion</a>, <a href="/reifenservice-reifeneinlagerung/">Reifenwechsel</a>, <a href="/hu-au/">HU</a> oder <a href="/klimaservice/">Klimaservice</a>.',
						'Das Formular ist eine Anfrage und noch keine feste Buchung. Wir melden uns zeitnah und stimmen den Termin persönlich mit Ihnen ab.',
					),
				),
			),
			'fragen'     => array(
				array( 'Ist mein Termin nach dem Absenden fest gebucht?', 'Noch nicht. Sie senden eine Anfrage, wir melden uns zeitnah und stimmen den Termin mit Ihnen ab.' ),
				array( 'Welche Angaben brauchen Sie von mir?', 'Name, Telefon, E-Mail, Marke und Modell. Kennzeichen, Wunschtermin und Anmerkungen sind freiwillig.' ),
			),
		),
		'beklebungsservice' => array(
			'title'      => 'Fahrzeugbeschriftung, Folierung Offenbach | Auto Emotion',
			'desc'       => 'Fahrzeugbeschriftung und Vollfolierung aus Offenbach: Unsere hauseigene Grafikabteilung entwirft und produziert Beklebungen, auch für den ganzen Fuhrpark.',
			'abschnitte' => array(
				array(
					'Vom Entwurf bis zur Anbringung',
					array(
						'Unsere hauseigene Grafikabteilung entwirft und produziert Beklebungen nach Ihren Wünschen und bringt sie auch an. Das reicht vom einzelnen Schriftzug bis zur Vollfolierung.',
						'Für Firmen ist die Beschriftung eine einfache Möglichkeit, im Alltag sichtbar zu sein. Angebote schneiden wir individuell auf Fahrzeug und Anforderung zu, auch für einen ganzen Fuhrpark. Passende Transporter finden Sie bei den <a href="/b2b-nutzfahrzeuge/">Nissan Nutzfahrzeugen</a>.',
					),
				),
				array(
					'Was wir für Ihr Angebot brauchen',
					array(
						'Nennen Sie uns Fahrzeug und Modell, Ihre Vorstellung und falls vorhanden Ihr Logo. Wie viele Fahrzeuge beklebt werden sollen, ist ebenfalls hilfreich. Daraus erstellen wir Ihr individuelles Angebot.',
					),
				),
			),
			'fragen'     => array(
				array( 'Gestaltet Auto Emotion die Beklebung selbst?', 'Ja. Unsere hauseigene Grafikabteilung entwirft und produziert die Beklebung nach Ihren Wünschen.' ),
				array( 'Ist auch eine Beklebung für mehrere Fahrzeuge möglich?', 'Ja. Wir erstellen Angebote auch für einen ganzen Fuhrpark.' ),
			),
		),
		'zubehoer-tuning' => array(
			'title'      => 'Zubehör und Tuning für Seat, Cupra, Nissan | Auto Emotion',
			'desc'       => 'Original-Zubehör und Tuning in Offenbach: Dachträger, Anhängerkupplung und Innenraum-Akzente für Seat, Cupra und Nissan, nachgerüstet bei Auto Emotion.',
			'abschnitte' => array(
				array(
					'Original-Zubehör für Ihr Fahrzeug',
					array(
						'Dachträger, Anhängerkupplung oder individuelle Elemente im Innenraum: Original-Zubehör von Seat, Cupra und Nissan rüsten wir bei Bedarf bei der Übergabe oder bei einem Werkstatttermin nach.',
						'Wir sagen Ihnen, was für Ihr Modell verfügbar und sinnvoll ist. Felgen und Kompletträder finden Sie unter <a href="/reifen-felgen/">Reifen & Felgen</a>, Beschriftungen und Folierungen beim <a href="/beklebungsservice/">Beklebungsservice</a>.',
					),
				),
			),
			'fragen'     => array(
				array( 'Kann ich Zubehör nachrüsten lassen?', 'Ja. Das geht bei der Fahrzeugübergabe oder bei einem Werkstatttermin.' ),
				array( 'Bieten Sie auch Tuning an?', 'Ein Beispiel ist unser Angebot des CUPRA Formentor VZ Custom by ABT. Was für Ihr Fahrzeug möglich ist, klären wir gemeinsam.' ),
			),
		),
		'ersatzteile' => array(
			'title'      => 'Original-Ersatzteile in Offenbach | Auto Emotion',
			'desc'       => 'Original-Ersatzteile für Seat, Cupra und Nissan in Offenbach, auf Anfrage auch als Einzelteil. Mit der Fahrgestellnummer finden wir das passende Teil.',
			'abschnitte' => array(
				array(
					'Das richtige Teil für Ihr Fahrzeug',
					array(
						'Als Vertragswerkstatt beziehen wir Original-Ersatzteile für Seat, Cupra und Nissan direkt über die Hersteller. Wer selbst schrauben möchte, bekommt sie auf Anfrage auch als Einzelteil.',
						'Am einfachsten geht es mit der Fahrgestellnummer, die im Fahrzeugschein steht. Damit lässt sich das Teil Ihrem Fahrzeug eindeutig zuordnen. Wir prüfen Verfügbarkeit und Preis und melden uns bei Ihnen. Soll das Teil gleich eingebaut werden, fragen Sie einen <a href="/servicetermin-buchen/">Servicetermin</a> an.',
					),
				),
			),
			'fragen'     => array(
				array( 'Kann ich Ersatzteile auch ohne Werkstatttermin kaufen?', 'Ja. Auf Anfrage erhalten Sie Original-Ersatzteile auch als Einzelteil.' ),
				array( 'Was brauchen Sie für eine Ersatzteil-Anfrage?', 'Ihr Fahrzeug und das benötigte Teil, am einfachsten zusammen mit der Fahrgestellnummer.' ),
			),
		),
		'reifen-felgen' => array(
			'title'      => 'Reifen und Felgen kaufen in Offenbach | Auto Emotion',
			'desc'       => 'Sommer-, Winter- und Ganzjahresreifen sowie Stahl- und Leichtmetallfelgen in Offenbach: Beratung, individuelles Angebot und Montage bei Auto Emotion.',
			'abschnitte' => array(
				array(
					'Welche Reifen passen zu Ihnen?',
					array(
						'Sommerreifen sind auf warme Temperaturen ausgelegt, Winterreifen auf Kälte, Schnee und Eis. Ganzjahresreifen sparen den Wechsel, sind aber ein Kompromiss. Welche Wahl sinnvoll ist, hängt davon ab, wie und wo Sie fahren.',
						'Bei Felgen stehen Stahl und Leichtmetall zur Wahl. Wir besorgen Reifen und Felgen in der passenden Dimension und Ausführung, erstellen Ihnen ein individuelles Angebot und montieren alles fachgerecht bei uns im Haus.',
					),
				),
				array(
					'Nach dem Kauf',
					array(
						'Den zweiten Satz können Sie bei uns lassen: Mehr dazu unter <a href="/reifenservice-reifeneinlagerung/">Reifenservice & Einlagerung</a>. Nach dem Reifenwechsel ist auch ein guter Zeitpunkt für eine <a href="/achsvermessung/">Achsvermessung</a>.',
					),
				),
			),
			'fragen'     => array(
				array( 'Welche Reifenarten bietet Auto Emotion an?', 'Sommer-, Winter- und Ganzjahresreifen in der passenden Dimension.' ),
				array( 'Montieren Sie die neuen Reifen und Felgen auch?', 'Ja. Die Montage übernehmen wir fachgerecht bei uns im Haus.' ),
			),
		),
		'merchandise' => array(
			'title' => 'Merchandise | Auto Emotion Offenbach',
			'desc'  => 'Merchandise von Auto Emotion in Offenbach: Hier erfahren Sie, sobald das Angebot verfügbar ist.',
		),
		'ueber-uns' => array(
			'title'      => 'Über uns: Autohaus in Offenbach | Auto Emotion',
			'desc'       => 'Auto Emotion ist Vertragshändler für Seat, Cupra und Nissan in Offenbach, seit 2001 inhabergeführt. Verkauf, Werkstatt und Reifenlager an einem Standort.',
			'abschnitte' => array(
				array(
					'Ihr Autohaus für Seat, Cupra und Nissan',
					array(
						'Auto Emotion gibt es seit Mai 2001 in Offenbach. Geführt wird das Familienunternehmen von Donato und Agostino Cisternino. An der Sprendlinger Landstraße 166 finden Sie <a href="/neuwagen/">Neuwagen</a>, <a href="/gebrauchtwagen/">Gebrauchtwagen</a> und eine eigene Werkstatt auf einem Gelände.',
						'Wir sind für Kunden aus Offenbach, Frankfurt und Umgebung da. Viele Stammkunden betreuen wir seit dem ersten Tag. Wie alles angefangen hat, lesen Sie in der <a href="/firmengeschichte/">Firmengeschichte</a>.',
					),
				),
			),
		),
		'firmengeschichte' => array(
			'title'      => 'Firmengeschichte: Auto Emotion seit 2001 in Offenbach',
			'desc'       => 'Von der Eröffnung im Mai 2001 über das 19.400 Quadratmeter große Gelände bis zu den Auszeichnungen von Nissan und Cupra: die Geschichte von Auto Emotion.',
			'abschnitte' => array(
				array(
					'Vom kleinen Autohaus zum großen Gelände',
					array(
						'Auto Emotion entstand im Mai 2001 mit viel Eigeninitiative an der Sprendlinger Landstraße in Offenbach. Von Beginn an stand die Marke Seat im Mittelpunkt. Nach 15 Jahren wurde es am damaligen Standort zu eng.',
						'2016 kam ein 19.400 Quadratmeter großes Gewerbeareal nur wenige Hausnummern entfernt dazu. Seitdem ist Platz für Neufahrzeuge, Vorführwagen, Transport- und Nutzfahrzeuge sowie Elektrofahrzeuge. Seit 2018 tragen wir außerdem <a href="/auszeichnungen/">zwei Auszeichnungen</a> von Nissan und Cupra.',
					),
				),
			),
		),
		'team-ansprechpartner' => array(
			'title' => 'Team und Ansprechpartner in Offenbach | Auto Emotion',
			'desc'  => 'Ihre Ansprechpartner bei Auto Emotion in Offenbach: Geschäftsführung, Verkauf, Service und Teiledienst, direkt per Telefon oder E-Mail erreichbar.',
			'abschnitte' => array(
				array(
					'Der schnellste Weg zur richtigen Person',
					array(
						'Für Fragen zu Neu- und Gebrauchtwagen wenden Sie sich an den Verkauf, für Termine und Reparaturen an den Service, für Teile an den Teiledienst. Wenn Sie nicht sicher sind, wer zuständig ist, erreichen Sie uns unter der zentralen Nummer 069 8740334-0.',
						'Einen Werkstatttermin können Sie auch <a href="/servicetermin-buchen/">online anfragen</a>. Anfahrt und Öffnungszeiten finden Sie beim <a href="/standorte/">Standort</a>.',
					),
				),
			),
		),
		'unsere-kunden' => array(
			'title'      => 'Unsere Kunden: seit 2001 in Offenbach | Auto Emotion',
			'desc'       => 'Viele Kunden sind seit dem ersten Tag dabei: feste Ansprechpartner, Geschäftsführung im Haus und eine Werkstatt, die auch Fahrzeuge anderer Marken betreut.',
			'abschnitte' => array(
				array(
					'Warum Kunden wiederkommen',
					array(
						'Was Kunden immer wieder zu uns führt, ist der direkte Draht: feste <a href="/team-ansprechpartner/">Ansprechpartner</a>, eine Geschäftsführung, die im Haus erreichbar ist, und eine <a href="/freie-werkstatt/">Werkstatt</a>, die auch Fahrzeuge anderer Marken betreut.',
						'Am einfachsten überzeugen Sie sich selbst: Kommen Sie vorbei oder vereinbaren Sie eine Probefahrt.',
					),
				),
			),
		),
		'auszeichnungen' => array(
			'title'      => 'Auszeichnungen: GT-R Center, CUPRA Specialist | Auto Emotion',
			'desc'       => 'Auto Emotion in Offenbach ist seit 2018 Nissan GT-R High Performance Center und CUPRA Specialist. Das bedeuten die beiden Auszeichnungen der Hersteller.',
			'abschnitte' => array(
				array(
					'Vertragshändler für drei Marken',
					array(
						'Hinter den Auszeichnungen stehen langjährige Partnerschaften. Auto Emotion ist seit 2001 Seat-Vertragshändler und heute auch Vertragshändler von Nissan und Cupra. Die aktuellen Modelle sehen Sie bei unseren <a href="/neuwagen/">Neuwagen</a>.',
					),
				),
			),
		),
		'standorte' => array(
			'title'      => 'Standort und Anfahrt in Offenbach | Auto Emotion',
			'desc'       => 'Auto Emotion finden Sie an der Sprendlinger Landstraße 166 in 63069 Offenbach. Anfahrt, Öffnungszeiten von Verkauf und Werkstatt, Telefon und E-Mail.',
			'abschnitte' => array(
				array(
					'So finden Sie Auto Emotion',
					array(
						'Unser Standort liegt an der Sprendlinger Landstraße 166 in 63069 Offenbach am Main, also auch für Kunden aus Frankfurt und dem Rhein-Main-Gebiet in der Nähe. Die Route plant Google Maps direkt von Ihrem Startpunkt aus.',
						'Verkauf und Werkstatt haben unterschiedliche Öffnungszeiten. Wenn Sie zum Service kommen möchten, fragen Sie am besten vorab einen <a href="/servicetermin-buchen/">Termin</a> an.',
					),
				),
			),
		),
		'karriere' => array(
			'title' => 'Karriere und Jobs im Autohaus Offenbach | Auto Emotion',
			'desc'  => 'Jobs bei Auto Emotion in Offenbach: Kfz-Mechatroniker, Hochvolttechniker, Serviceberater und mehr. 30 Tage Urlaub, Rückmeldung in der Regel in 24 Stunden.',
		),
		'offene-stellen' => array(
			'title'      => 'Offene Stellen im Autohaus Offenbach | Auto Emotion',
			'desc'       => 'Aktuelle Stellen bei Auto Emotion in Offenbach: Kfz-Mechatroniker, Hochvolttechniker, Serviceberater, Serviceassistenz und Werkstattleitung in Vollzeit.',
			'abschnitte' => array(
				array(
					'Kfz-Jobs in Offenbach und im Rhein-Main-Gebiet',
					array(
						'Wir suchen derzeit für Werkstatt und Service. Du arbeitest an Seat, Cupra und Nissan in einer Werkstatt mit 12 Hebebühnen. Was wir sonst noch bieten, steht unter <a href="/warum-auto-emotion/">Warum Auto Emotion?</a>.',
					),
				),
			),
		),
		'initiativbewerbung' => array(
			'title' => 'Initiativbewerbung im Autohaus Offenbach | Auto Emotion',
			'desc'  => 'Keine passende Stelle dabei? Bewirb dich initiativ bei Auto Emotion in Offenbach, formlos und mit oder ohne Lebenslauf. Rückmeldung in der Regel in 24 Stunden.',
		),
		'ausbildung' => array(
			'title'      => 'Ausbildung im Autohaus in Offenbach | Auto Emotion',
			'desc'       => 'Ausbildung bei Auto Emotion in Offenbach: aktueller Stand, Kfz-Mechatroniker und Automobilkaufleute im Überblick und wie du dich jetzt vormerken lässt.',
			'abschnitte' => array(
				array(
					'Ehrlicher Zwischenstand',
					array(
						'Feste Ausbildungsplätze mit Jahrgang haben wir aktuell noch nicht ausgeschrieben, sie sind in Vorbereitung. Wenn du Interesse hast, melde dich trotzdem schon: Wir merken deine Bewerbung für den nächsten Ausbildungsjahrgang vor.',
						'Was wir als Arbeitgeber grundsätzlich bieten, von gestelltem Werkzeug bis zu bezahlter Weiterbildung, liest du unter <a href="/warum-auto-emotion/">Warum Auto Emotion?</a>.',
					),
				),
			),
			'fragen'     => array(
				array( 'Wie lange dauert die Ausbildung zum Kfz-Mechatroniker?', 'Rund dreieinhalb Jahre, im Wechsel zwischen Betrieb und Berufsschule.' ),
				array( 'Wie lange dauert die Ausbildung zum Automobilkaufmann?', 'Rund drei Jahre, von der Kundenberatung über die Werkstattdisposition bis zur Auftragsabwicklung.' ),
			),
		),
		'warum-auto-emotion' => array(
			'title' => 'Warum Auto Emotion? Arbeiten in Offenbach | Auto Emotion',
			'desc'  => 'Moderne Werkstatt mit 12 Hebebühnen, gestelltes Werkzeug, bezahlte Schulungen und ein eingespieltes Team: Das bietet Auto Emotion in Offenbach.',
			'abschnitte' => array(
				array(
					'Arbeiten in einer Werkstatt in Offenbach',
					array(
						'Die Werkstatt an der Sprendlinger Landstraße ist beheizt und klimatisiert, gearbeitet wird an Seat, Cupra und Nissan. Du arbeitest selbstständig, Herstellerzeiten dienen dir zur Orientierung. Dein Werkzeug wird gestellt, Hochvolt- und Diagnoseschulungen werden bezahlt.',
						'Eine Bewerbung ist unkompliziert: Eine Rückmeldung bekommst du in der Regel innerhalb von 24 Stunden, das erste Gespräch führst du persönlich mit Agostino Cisternino. Die aktuellen Ausschreibungen findest du unter <a href="/offene-stellen/">Offene Stellen</a>. Ist nichts Passendes dabei, geht auch eine <a href="/initiativbewerbung/">Initiativbewerbung</a>.',
					),
				),
			),
		),
		'events-schulungen' => array(
			'title' => 'Events und Schulungen in Offenbach | Auto Emotion',
			'desc'  => 'Tag der offenen Tür, Probefahrt-Tage, Kundenveranstaltungen und Werkstatt-Schulungen: die Anlässe rund um Auto Emotion in Offenbach im Überblick.',
			'abschnitte' => array(
				array(
					'Veranstaltungen rund um Seat, Cupra und Nissan',
					array(
						'Sobald Termine feststehen, kündigen wir sie auf unseren Social-Media-Kanälen an. Eine Probefahrt müssen Sie aber nicht an einen Aktionstag koppeln: Einen individuellen Termin können Sie jederzeit vereinbaren.',
						'Die Weiterbildung unseres Teams läuft unabhängig von Veranstaltungen. Unsere Mitarbeiter schulen sich regelmäßig bei den Herstellern, damit Ihr Fahrzeug nach deren Vorgaben gewartet wird.',
					),
				),
			),
		),
		'markenevents-probefahrt-tage' => array(
			'title' => 'Probefahrt und Markenevents in Offenbach | Auto Emotion',
			'desc'  => 'Neue Modelle von Seat, Cupra und Nissan testen: Probefahrt-Aktionen und individuelle Termine bei Auto Emotion in Offenbach, auch ohne Aktionstag.',
			'abschnitte' => array(
				array(
					'Probefahrt in Offenbach vereinbaren',
					array(
						'Wählen Sie unter unseren <a href="/angebote/">Angeboten</a> das Modell, das Sie interessiert, oder rufen Sie uns an. Ob <a href="/marke/seat/">Seat</a>, <a href="/marke/cupra/">Cupra</a> oder <a href="/marke/nissan/">Nissan</a>: Wir stimmen einen Termin für Ihr Wunschmodell ab.',
						'Bringen Sie zur Probefahrt Ihren gültigen Führerschein mit. Nutzen Sie die Fahrt, um das Auto auf Ihren üblichen Strecken zu erleben, und fragen Sie gern nach dem, was Ihnen im Alltag wichtig ist.',
					),
				),
			),
			'fragen'     => array(
				array( 'Brauche ich für eine Probefahrt einen Aktionstag?', 'Nein. Einen individuellen Termin für das Modell Ihrer Wahl können Sie jederzeit vereinbaren.' ),
				array( 'Wo erfahre ich von neuen Aktionstagen?', 'Am schnellsten über unsere Social-Media-Kanäle, sobald Termine feststehen.' ),
			),
		),
		'tag-der-offenen-tuer' => array(
			'title' => 'Tag der offenen Tür in Offenbach | Auto Emotion',
			'desc'  => 'Tag der offenen Tür bei Auto Emotion in Offenbach: Showroom, Werkstatt und Modelle ohne Terminzwang. Aktuell ist kein Termin geplant, wir kündigen ihn an.',
			'abschnitte' => array(
				array(
					'Was Sie an diesem Tag erwartet',
					array(
						'Sie können sich in Ruhe im Showroom an der Sprendlinger Landstraße umsehen, das aktuelle Modellprogramm von Seat, Cupra und Nissan anschauen und einen Blick in die Werkstatt werfen. Eine Anmeldung ist dafür nicht nötig.',
						'Sie möchten nicht warten? Unser Showroom ist auch sonst geöffnet. Die Zeiten finden Sie beim <a href="/standorte/">Standort</a>, unsere weiteren Formate unter <a href="/events-schulungen/">Events & Schulungen</a>.',
					),
				),
			),
		),
		'werkstatt-schulungen' => array(
			'title' => 'Werkstatt-Schulungen in Offenbach | Auto Emotion',
			'desc'  => 'Unser Werkstattteam bildet sich regelmäßig bei Cupra, Seat und Nissan weiter, von neuen Modellreihen über Assistenzsysteme bis zu Elektro und Hybrid.',
			'abschnitte' => array(
				array(
					'Warum Schulungen für Ihr Auto wichtig sind',
					array(
						'Neue Modellreihen, Assistenzsysteme sowie Elektro- und Hybridantriebe verändern die Arbeit in der Werkstatt ständig. Darum bilden sich unsere Mitarbeiter regelmäßig bei Cupra, Seat und Nissan weiter.',
						'Davon profitieren Sie bei jedem Werkstattbesuch, von der <a href="/inspektion-wartung/">Inspektion</a> bis zur Reparatur: Ihr Fahrzeug wird fachgerecht nach Herstellervorgaben gewartet und repariert. Auch Hochvolt- und Diagnoseschulungen gehören dazu.',
					),
				),
			),
		),
		'kundenveranstaltungen' => array(
			'title' => 'Kundenveranstaltungen in Offenbach | Auto Emotion',
			'desc'  => 'Zu Modellpremieren oder Jubiläen lädt Auto Emotion auch gezielt Kunden nach Offenbach ein. Termine kündigen wir unter anderem auf Social Media an.',
			'abschnitte' => array(
				array(
					'Persönlicher Kontakt nach dem Autokauf',
					array(
						'Als inhabergeführtem Familienunternehmen ist uns der Kontakt über den Fahrzeugkauf hinaus wichtig. Einige Kunden begleiten uns seit der Gründung 2001. Darum laden wir zu Anlässen wie Modellpremieren oder Jubiläen auch gezielt Kunden ein.',
						'Wie es zu dieser engen Bindung kam, lesen Sie bei <a href="/unsere-kunden/">Unsere Kunden</a>. Offen für alle ist dagegen der <a href="/tag-der-offenen-tuer/">Tag der offenen Tür</a>.',
					),
				),
			),
		),
		'magazin' => array(
			'title' => 'Magazin: Neues rund ums Auto | Auto Emotion Offenbach',
			'desc'  => 'Ratgeber, Einblicke und Themen rund um Seat, Cupra und Nissan im Blog und auf Social Media. Ein gedrucktes Auto-Emotion-Magazin ist in Planung.',
			'abschnitte' => array(
				array(
					'Themen rund um Seat, Cupra und Nissan',
					array(
						'Im <a href="/blog/">Blog</a> erscheinen Beiträge zu aktuellen Modellen und Angeboten. Einblicke aus Showroom und Werkstatt zeigen wir auf Instagram und Facebook. Antworten auf häufige Fragen haben wir in den <a href="/faq/">FAQ</a> zusammengestellt.',
					),
				),
			),
		),
		'blog' => array(
			'title' => 'Blog: Seat, Cupra und Nissan | Auto Emotion Offenbach',
			'desc'  => 'Beiträge zu aktuellen Modellen und Angeboten von Seat, Cupra und Nissan aus dem Autohaus Auto Emotion in Offenbach.',
		),
		'vlog' => array(
			'title' => 'Vlog: Videos auf Social Media | Auto Emotion Offenbach',
			'desc'  => 'Ein eigener Vlog ist aktuell nicht geplant. Videos aus Showroom und Werkstatt von Auto Emotion finden Sie auf Instagram und Facebook.',
		),
		'podcast' => array(
			'title' => 'Podcast | Auto Emotion Offenbach',
			'desc'  => 'Einen Podcast gibt es bei Auto Emotion aktuell nicht. Einblicke aus Showroom und Werkstatt finden Sie auf Instagram und Facebook.',
		),
		'faq' => array(
			'title' => 'FAQ: Häufige Fragen an das Autohaus | Auto Emotion Offenbach',
			'desc'  => 'Antworten zu Marken, Standort, Öffnungszeiten, Werkstatt, HU, Reifeneinlagerung, Probefahrt und Bewerbung bei Auto Emotion in Offenbach.',
		),
		'kontakt' => array(
			'title' => 'Kontakt und Öffnungszeiten | Auto Emotion Offenbach',
			'desc'  => 'So erreichen Sie Auto Emotion in Offenbach: Adresse, Telefon, E-Mail und Öffnungszeiten von Verkauf und Werkstatt, dazu die Route per Google Maps.',
			'abschnitte' => array(
				array(
					'Der richtige Weg für Ihr Anliegen',
					array(
						'Für einen Werkstatttermin nutzen Sie am einfachsten das Formular <a href="/servicetermin-buchen/">Servicetermin online buchen</a>. Für eine Probefahrt wählen Sie Ihr Modell unter den <a href="/angebote/">Angeboten</a>. Wenn Sie eine bestimmte Person sprechen möchten, finden Sie die Durchwahlen bei <a href="/team-ansprechpartner/">Team und Ansprechpartner</a>.',
						'Bewerbungen bearbeiten wir ausschließlich über die Formulare unter <a href="/karriere/">Karriere</a>.',
					),
				),
			),
		),
	);
}

/**
 * Slug der aktuellen Seite, die Beitragsübersicht zählt als „blog“.
 */
function auto_emotion_seo_slug() {
	if ( is_home() && ! is_front_page() ) {
		return 'blog';
	}

	return is_page() ? get_post_field( 'post_name', get_queried_object_id() ) : '';
}

/**
 * Eintrag der aktuellen Seite oder leeres Array.
 */
function auto_emotion_seo_eintrag() {
	return auto_emotion_seo_seiten()[ auto_emotion_seo_slug() ] ?? array();
}

/**
 * Eigener Seitentitel.
 */
function auto_emotion_seo_titel( $titel ) {
	$eintrag = auto_emotion_seo_eintrag();

	return $eintrag['title'] ?? $titel;
}
add_filter( 'pre_get_document_title', 'auto_emotion_seo_titel' );

/**
 * Sichtbare Fragen der Seite als FAQ-Schema anmelden.
 */
function auto_emotion_seo_fragen_schema() {
	$eintrag = auto_emotion_seo_eintrag();

	if ( empty( $eintrag['fragen'] ) ) {
		return;
	}

	$items = array();
	foreach ( $eintrag['fragen'] as $frage ) {
		$items[] = array(
			'q' => $frage[0],
			'a' => $frage[1],
		);
	}
	auto_emotion_register_faq_schema( $items );
}
add_action( 'template_redirect', 'auto_emotion_seo_fragen_schema' );

// Das Theme gibt den Canonical-Link selbst aus (inc/seo.php).
remove_action( 'wp_head', 'rel_canonical' );
