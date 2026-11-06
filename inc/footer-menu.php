<?php
/**
 * Fußzeile: mehrspaltige Linkstruktur im bmw.de-Stil ("Kontakt",
 * "BMW erleben", "Service- & Dienstleistungen", "Modelle", ...).
 * Alle Ziel-URLs sind echte, bereits bestehende Seiten (siehe
 * inc/primary-menu.php) - hier nur nach Themen neu gruppiert, keine
 * neue Seite erfunden.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_footer_menu_columns() {
	$home = home_url( '/' );

	return array(
		array(
			'title' => __( 'Kontakt', 'auto-emotion' ),
			'links' => array(
				array( 'title' => __( 'Kontakt', 'auto-emotion' ), 'url' => $home . 'kontakt/' ),
				array( 'title' => __( 'Häufige Fragen (FAQ)', 'auto-emotion' ), 'url' => $home . 'faq/' ),
				array( 'title' => __( 'Team / Ansprechpartner', 'auto-emotion' ), 'url' => $home . 'team-ansprechpartner/' ),
				array( 'title' => __( 'Standorte', 'auto-emotion' ), 'url' => $home . 'standorte/' ),
			),
		),
		array(
			'title' => __( 'Auto Emotion erleben', 'auto-emotion' ),
			'links' => array(
				array( 'title' => __( 'Karriere', 'auto-emotion' ), 'url' => $home . 'karriere/' ),
				array( 'title' => __( 'Events & Schulungen', 'auto-emotion' ), 'url' => $home . 'events-schulungen/' ),
				array( 'title' => __( 'Magazin', 'auto-emotion' ), 'url' => $home . 'magazin/' ),
				array( 'title' => __( 'Über uns', 'auto-emotion' ), 'url' => $home . 'ueber-uns/' ),
			),
		),
		array(
			'title' => __( 'Auswählen & Kaufen', 'auto-emotion' ),
			'links' => array(
				array( 'title' => __( 'Finanzierung & Leasing', 'auto-emotion' ), 'url' => $home . 'finanzierung-leasing/' ),
				array( 'title' => __( 'Fahrzeugankauf', 'auto-emotion' ), 'url' => $home . 'fahrzeugankauf/' ),
				array( 'title' => __( 'Neuwagen', 'auto-emotion' ), 'url' => $home . 'neuwagen/' ),
				array( 'title' => __( 'Gebrauchtwagen', 'auto-emotion' ), 'url' => $home . 'gebrauchtwagen/' ),
				array( 'title' => __( 'Jahreswagen / Tageszulassungen', 'auto-emotion' ), 'url' => $home . 'jahreswagen-tageszulassungen/' ),
				array( 'title' => __( 'Elektro & Hybrid', 'auto-emotion' ), 'url' => $home . 'elektro-hybrid/' ),
				array( 'title' => __( 'Probefahrt buchen', 'auto-emotion' ), 'url' => $home . 'angebote/' ),
			),
		),
		array(
			'title' => __( 'Service- & Dienstleistungen', 'auto-emotion' ),
			'links' => array(
				array( 'title' => __( 'Servicetermin online buchen', 'auto-emotion' ), 'url' => $home . 'servicetermin-buchen/' ),
				array( 'title' => __( 'Inspektion & Wartung', 'auto-emotion' ), 'url' => $home . 'inspektion-wartung/' ),
				array( 'title' => __( 'HU / AU', 'auto-emotion' ), 'url' => $home . 'hu-au/' ),
				array( 'title' => __( 'Reifenservice & Reifeneinlagerung', 'auto-emotion' ), 'url' => $home . 'reifenservice-reifeneinlagerung/' ),
				array( 'title' => __( 'Unfallinstandsetzung & Lackierung', 'auto-emotion' ), 'url' => $home . 'unfallinstandsetzung-lackierung/' ),
				array( 'title' => __( 'Klimaservice', 'auto-emotion' ), 'url' => $home . 'klimaservice/' ),
				array( 'title' => __( 'Achsvermessung', 'auto-emotion' ), 'url' => $home . 'achsvermessung/' ),
				array( 'title' => __( 'Fahrzeugaufbereitung', 'auto-emotion' ), 'url' => $home . 'fahrzeugaufbereitung/' ),
				array( 'title' => __( 'Beklebungsservice', 'auto-emotion' ), 'url' => $home . 'beklebungsservice/' ),
				array( 'title' => __( 'Zubehör & Tuning', 'auto-emotion' ), 'url' => $home . 'zubehoer-tuning/' ),
				array( 'title' => __( 'Ersatzteile', 'auto-emotion' ), 'url' => $home . 'ersatzteile/' ),
				array( 'title' => __( 'Reifen & Felgen', 'auto-emotion' ), 'url' => $home . 'reifen-felgen/' ),
				array( 'title' => __( 'Merchandise', 'auto-emotion' ), 'url' => $home . 'merchandise/' ),
			),
		),
		array(
			'title' => __( 'Modelle', 'auto-emotion' ),
			'links' => array(
				array( 'title' => __( 'Seat', 'auto-emotion' ), 'url' => $home . 'marke/seat/' ),
				array( 'title' => __( 'Cupra', 'auto-emotion' ), 'url' => $home . 'marke/cupra/' ),
				array( 'title' => __( 'Nissan', 'auto-emotion' ), 'url' => $home . 'marke/nissan/' ),
				array( 'title' => __( 'Nissan Nutzfahrzeuge (B2B)', 'auto-emotion' ), 'url' => $home . 'b2b-nutzfahrzeuge/' ),
			),
		),
	);
}

function auto_emotion_render_footer_menu() {
	$columns = auto_emotion_footer_menu_columns();

	echo '<div class="footer-columns">';
	foreach ( $columns as $column ) {
		echo '<div class="footer-column">';
		echo '<h2 class="footer-column__title">' . esc_html( $column['title'] ) . '</h2>';
		echo '<ul class="footer-column__list">';
		foreach ( $column['links'] as $link ) {
			echo '<li><a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['title'] ) . '</a></li>';
		}
		echo '</ul>';
		echo '</div>';
	}
	echo '</div>';
}

/**
 * Kleines "Ai"-Badge-Icon (abgerundetes Quadrat mit "Ai"-Schriftzug
 * und Funken-Sparkle) - eigene, einfache Formensprache, kein
 * Fremd-Icon kopiert. Kennzeichnet überall dort echte KI-generierte/
 * KI-gestützte Inhalte, wo tatsächlich eine KI im Hintergrund arbeitet
 * (Traumauto-Finder, Emo-Chatbot) - bewusst NICHT bei der normalen
 * Textsuche im Header, die rein eine WordPress-Stichwortsuche ist und
 * keine KI einsetzt.
 */
function auto_emotion_ai_badge_icon( $size = 20 ) {
	printf(
		'<svg class="ai-badge-icon" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="2" y="3" width="16" height="16" rx="4" stroke="currentColor" stroke-width="1.4"/><text x="10" y="15" text-anchor="middle" font-size="8.5" font-weight="700" fill="currentColor" font-family="sans-serif">Ai</text><path d="M19.5 2.5 20.3 4.7 22.5 5.5 20.3 6.3 19.5 8.5 18.7 6.3 16.5 5.5 18.7 4.7 19.5 2.5Z" fill="currentColor"/></svg>',
		(int) $size
	);
}
