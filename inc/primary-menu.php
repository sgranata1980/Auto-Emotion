<?php
/**
 * Hauptmenü: statisch im Theme definiert statt über wp_nav_menu()/die
 * WP-Menüverwaltung, auf Wunsch des Kunden von 10 auf 5 Hauptpunkte
 * (plus "AI-Assistent"-Button) verdichtet - nach dem Vorbild von
 * bmw.de. Alle Ziel-URLs sind die echten, bereits bestehenden Seiten
 * des vorherigen Menüs, nur neu gruppiert (nichts erfunden, keine neue
 * Seite). "Fahrzeuge", "Marken" und "Service" haben weiterhin eine
 * echte eigene Übersichtsseite und bekommen daher den
 * "Alle X ansehen"-Link; für die neu gebildeten Gruppen "Kaufen" und
 * "Unternehmen" gibt es keine einzelne reale Übersichtsseite für die
 * GESAMTE Gruppe, deshalb bewusst ohne diesen Link.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_primary_menu_items() {
	$home = home_url( '/' );

	return array(
		array(
			'title'    => __( 'Fahrzeuge', 'auto-emotion' ),
			'url'      => $home . 'angebote/',
			'overview' => true,
			'children' => array(
				array( 'title' => __( 'Neuwagen', 'auto-emotion' ), 'url' => $home . 'neuwagen/' ),
				array( 'title' => __( 'Gebrauchtwagen', 'auto-emotion' ), 'url' => $home . 'gebrauchtwagen/' ),
				array( 'title' => __( 'Jahreswagen / Tageszulassungen', 'auto-emotion' ), 'url' => $home . 'jahreswagen-tageszulassungen/' ),
				array( 'title' => __( 'Elektro & Hybrid', 'auto-emotion' ), 'url' => $home . 'elektro-hybrid/' ),
				array( 'title' => __( 'Nissan Nutzfahrzeuge (B2B)', 'auto-emotion' ), 'url' => $home . 'b2b-nutzfahrzeuge/' ),
			),
		),
		array(
			'title'    => __( 'Kaufen', 'auto-emotion' ),
			'url'      => $home . 'finanzierung-leasing/',
			'overview' => false,
			'children' => array(
				array( 'title' => __( 'Finanzierung & Leasing', 'auto-emotion' ), 'url' => $home . 'finanzierung-leasing/' ),
				array( 'title' => __( 'Fahrzeugankauf (Ihr Auto verkaufen)', 'auto-emotion' ), 'url' => $home . 'fahrzeugankauf/' ),
			),
		),
		array(
			'title'    => __( 'Marken', 'auto-emotion' ),
			'url'      => $home . '#marken',
			'overview' => true,
			'children' => array(
				array( 'title' => __( 'Seat', 'auto-emotion' ), 'url' => $home . 'marke/seat/' ),
				array( 'title' => __( 'Cupra', 'auto-emotion' ), 'url' => $home . 'marke/cupra/' ),
				array( 'title' => __( 'Nissan', 'auto-emotion' ), 'url' => $home . 'marke/nissan/' ),
			),
		),
		array(
			'title'    => __( 'Service', 'auto-emotion' ),
			'url'      => $home . 'service/',
			'overview' => true,
			'children' => array(
				array( 'title' => __( 'Freie Werkstatt', 'auto-emotion' ), 'url' => $home . 'freie-werkstatt/' ),
				array( 'title' => __( 'HU / AU', 'auto-emotion' ), 'url' => $home . 'hu-au/' ),
				array( 'title' => __( 'Inspektion & Wartung', 'auto-emotion' ), 'url' => $home . 'inspektion-wartung/' ),
				array( 'title' => __( 'Reifenservice & Reifeneinlagerung', 'auto-emotion' ), 'url' => $home . 'reifenservice-reifeneinlagerung/' ),
				array( 'title' => __( 'Klimaservice', 'auto-emotion' ), 'url' => $home . 'klimaservice/' ),
				array( 'title' => __( 'Unfallinstandsetzung & Lackierung', 'auto-emotion' ), 'url' => $home . 'unfallinstandsetzung-lackierung/' ),
				array( 'title' => __( 'Achsvermessung', 'auto-emotion' ), 'url' => $home . 'achsvermessung/' ),
				array( 'title' => __( 'Fahrzeugaufbereitung', 'auto-emotion' ), 'url' => $home . 'fahrzeugaufbereitung/' ),
				array( 'title' => __( 'Servicetermin online buchen', 'auto-emotion' ), 'url' => $home . 'servicetermin-buchen/' ),
				array( 'title' => __( 'Beklebungsservice', 'auto-emotion' ), 'url' => $home . 'beklebungsservice/' ),
				array( 'title' => __( 'Zubehör & Tuning', 'auto-emotion' ), 'url' => $home . 'zubehoer-tuning/' ),
				array( 'title' => __( 'Ersatzteile', 'auto-emotion' ), 'url' => $home . 'ersatzteile/' ),
				array( 'title' => __( 'Reifen & Felgen', 'auto-emotion' ), 'url' => $home . 'reifen-felgen/' ),
				array( 'title' => __( 'Merchandise', 'auto-emotion' ), 'url' => $home . 'merchandise/' ),
			),
		),
		array(
			'title'    => __( 'Unternehmen', 'auto-emotion' ),
			'url'      => $home . 'ueber-uns/',
			'overview' => false,
			'children' => array(
				array( 'title' => __( 'Über uns', 'auto-emotion' ), 'url' => $home . 'ueber-uns/' ),
				array( 'title' => __( 'Firmengeschichte', 'auto-emotion' ), 'url' => $home . 'firmengeschichte/' ),
				array( 'title' => __( 'Team / Ansprechpartner', 'auto-emotion' ), 'url' => $home . 'team-ansprechpartner/' ),
				array( 'title' => __( 'Unsere Kunden', 'auto-emotion' ), 'url' => $home . 'unsere-kunden/' ),
				array( 'title' => __( 'Auszeichnungen', 'auto-emotion' ), 'url' => $home . 'auszeichnungen/' ),
				array( 'title' => __( 'Standorte', 'auto-emotion' ), 'url' => $home . 'standorte/' ),
				array( 'title' => __( 'Karriere', 'auto-emotion' ), 'url' => $home . 'karriere/' ),
				array( 'title' => __( 'Offene Stellen', 'auto-emotion' ), 'url' => $home . 'offene-stellen/' ),
				array( 'title' => __( 'Initiativbewerbung', 'auto-emotion' ), 'url' => $home . 'initiativbewerbung/' ),
				array( 'title' => __( 'Ausbildung', 'auto-emotion' ), 'url' => $home . 'ausbildung/' ),
				array( 'title' => __( 'Warum Auto Emotion?', 'auto-emotion' ), 'url' => $home . 'warum-auto-emotion/' ),
				array( 'title' => __( 'Events & Schulungen', 'auto-emotion' ), 'url' => $home . 'events-schulungen/' ),
				array( 'title' => __( 'Markenevents & Probefahrt-Tage', 'auto-emotion' ), 'url' => $home . 'markenevents-probefahrt-tage/' ),
				array( 'title' => __( 'Tag der offenen Tür', 'auto-emotion' ), 'url' => $home . 'tag-der-offenen-tuer/' ),
				array( 'title' => __( 'Werkstatt-Schulungen', 'auto-emotion' ), 'url' => $home . 'werkstatt-schulungen/' ),
				array( 'title' => __( 'Kundenveranstaltungen', 'auto-emotion' ), 'url' => $home . 'kundenveranstaltungen/' ),
				array( 'title' => __( 'Magazin', 'auto-emotion' ), 'url' => $home . 'magazin/' ),
				array( 'title' => __( 'Blog', 'auto-emotion' ), 'url' => $home . 'blog/' ),
				array( 'title' => __( 'Vlog', 'auto-emotion' ), 'url' => $home . 'vlog/' ),
				array( 'title' => __( 'Podcast', 'auto-emotion' ), 'url' => $home . 'podcast/' ),
				array( 'title' => __( 'FAQ', 'auto-emotion' ), 'url' => $home . 'faq/' ),
				array( 'title' => __( 'Kontakt', 'auto-emotion' ), 'url' => $home . 'kontakt/' ),
			),
		),
	);
}

/**
 * Rendert dieselbe Markup-Struktur, die vorher Auto_Emotion_Nav_Walker
 * über wp_nav_menu() erzeugt hat (gleiche Klassennamen), damit das
 * bestehende CSS/JS unverändert weiterfunktioniert.
 */
function auto_emotion_render_primary_menu() {
	$items = auto_emotion_primary_menu_items();

	echo '<ul id="primary-menu" class="menu">';

	foreach ( $items as $item ) {
		$has_children = ! empty( $item['children'] );
		$classes      = $has_children ? ' menu-item-has-children' : '';

		echo '<li class="menu-item' . esc_attr( $classes ) . '">';

		if ( $has_children ) {
			/**
			 * Hauptpunkte mit Untermenü sind - wie bei bmw.de beobachtet -
			 * ein einziger Aufklapp-Button, der NIE selbst navigiert,
			 * auch wenn der Punkt (wie "Fahrzeuge") eine echte eigene
			 * Übersichtsseite hat. Wer die Übersichtsseite will, erreicht
			 * sie über den "Alle X ansehen"-Link im geöffneten Panel.
			 * Vorher klickte der Text direkt weg (z.B. "Kaufen" landete
			 * auf /finanzierung-leasing/ statt das Menü zu öffnen) - das
			 * wurde vom Nutzer live als Abweichung vom bmw.de-Vorbild
			 * gemeldet.
			 */
			echo '<button type="button" class="menu-item__link submenu-toggle" aria-expanded="false" aria-label="' . esc_attr(
				/* translators: %s: Menu item title. */
				sprintf( __( 'Untermenü %s', 'auto-emotion' ), $item['title'] )
			) . '">' . esc_html( $item['title'] ) . '<span class="submenu-toggle-icon" aria-hidden="true"></span></button>';

			echo '<ul class="sub-menu" data-state="closed">';

			if ( ! empty( $item['overview'] ) ) {
				echo '<li class="menu-item sub-menu__overview">';
				echo '<a href="' . esc_url( $item['url'] ) . '" class="menu-item__link sub-menu__overview-link">';
				echo esc_html(
					sprintf(
						/* translators: %s: Titel des übergeordneten Menüpunkts. */
						__( 'Alle %s ansehen', 'auto-emotion' ),
						$item['title']
					)
				);
				echo ' <span aria-hidden="true">&rarr;</span>';
				echo '</a></li>';
			}

			foreach ( $item['children'] as $child ) {
				echo '<li class="menu-item">';
				echo '<a href="' . esc_url( $child['url'] ) . '" class="menu-item__link">' . esc_html( $child['title'] ) . '</a>';
				echo '</li>';
			}

			echo '</ul>';
		} else {
			echo '<a href="' . esc_url( $item['url'] ) . '" class="menu-item__link">' . esc_html( $item['title'] ) . '</a>';
		}

		echo '</li>';
	}

	echo '</ul>';
}
