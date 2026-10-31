<?php
/**
 * Custom Post Type "Angebot" (Leasing-/Verkaufsangebote) und
 * Taxonomie "Marke" (Cupra, Seat, Nissan).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_cpt() {
	register_post_type(
		'angebot',
		array(
			'labels'        => array(
				'name'          => __( 'Angebote', 'auto-emotion' ),
				'singular_name' => __( 'Angebot', 'auto-emotion' ),
				'add_new_item'  => __( 'Neues Angebot', 'auto-emotion' ),
				'edit_item'     => __( 'Angebot bearbeiten', 'auto-emotion' ),
				'all_items'     => __( 'Alle Angebote', 'auto-emotion' ),
			),
			'public'        => true,
			'menu_icon'     => 'dashicons-tag',
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'angebote' ),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'show_in_rest'  => true,
			'menu_position' => 5,
		)
	);

	register_taxonomy(
		'marke',
		array( 'post', 'angebot' ),
		array(
			'labels'       => array(
				'name'          => __( 'Marken', 'auto-emotion' ),
				'singular_name' => __( 'Marke', 'auto-emotion' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'marke' ),
			'show_in_rest' => true,
		)
	);

	register_taxonomy(
		'karosserie',
		array( 'angebot' ),
		array(
			'labels'       => array(
				'name'          => __( 'Karosserieformen', 'auto-emotion' ),
				'singular_name' => __( 'Karosserieform', 'auto-emotion' ),
			),
			'public'       => true,
			'hierarchical'  => false,
			'rewrite'      => array( 'slug' => 'karosserie' ),
			'show_in_rest' => true,
		)
	);

	register_taxonomy(
		'antrieb',
		array( 'angebot' ),
		array(
			'labels'       => array(
				'name'          => __( 'Antriebsarten', 'auto-emotion' ),
				'singular_name' => __( 'Antriebsart', 'auto-emotion' ),
			),
			'public'       => true,
			'hierarchical'  => false,
			'rewrite'      => array( 'slug' => 'antrieb' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'auto_emotion_register_cpt' );

/**
 * Schlichte Umriss-Icons je Karosserieform/Antriebsart - eigene,
 * einfache Formensprache (kein Fremd-Icon-Set kopiert), passend zum
 * Rest des Themes mit stroke="currentColor". Zentral hier statt im
 * Filter-Template, da sowohl der Fahrzeug-Filter (Angebote-Archiv)
 * als auch die Karosserie-Schnellauswahl auf der Startseite dieselben
 * Icons brauchen.
 */
function auto_emotion_vehicle_filter_icon( $slug ) {
	$icons = array(
		'suv'          => '<path d="M3 17h18M5 17l1.5-6.5a2 2 0 0 1 1.95-1.5h7.1a2 2 0 0 1 1.95 1.5L19 17M8 10V6h8v4" /><circle cx="7.5" cy="17.5" r="1.5" /><circle cx="16.5" cy="17.5" r="1.5" />',
		'kombi'        => '<path d="M2 16h20M3 16l1-5a2 2 0 0 1 2-1.6h3L10 5h7l3 4.4h0a2 2 0 0 1 2 1.6l1 5" /><circle cx="7" cy="16.5" r="1.5" /><circle cx="17" cy="16.5" r="1.5" />',
		'kompakt'      => '<path d="M2.5 16h19M3.5 16l1-4.5a2 2 0 0 1 2-1.6h2L11 6h4l3 3.9h0.5a2 2 0 0 1 2 1.6l1 4.5" /><circle cx="7.5" cy="16.5" r="1.5" /><circle cx="16.5" cy="16.5" r="1.5" />',
		'kleinwagen'   => '<path d="M3 16h18M4 16l0.8-3.6a2 2 0 0 1 2-1.6h10.4a2 2 0 0 1 2 1.6L20 16M7.5 10.8 9 6.5h6l1.5 4.3" /><circle cx="7.5" cy="16.5" r="1.5" /><circle cx="16.5" cy="16.5" r="1.5" />',
		'nutzfahrzeug' => '<path d="M2 16h2M4 16V7a1 1 0 0 1 1-1h8.5a1 1 0 0 1 .8.4L19 11h1a1 1 0 0 1 1 1v4h-2M4 16h10.5M18 16h-3.5V9h0l3 3.3V16Z" /><circle cx="7" cy="17" r="1.6" /><circle cx="17" cy="17" r="1.6" />',
		'benzin'       => '<path d="M5 20V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M4 20h10M7 20v-6h4v6M15 9l2.3 2.3a1 1 0 0 1 .3.7V17a1.3 1.3 0 0 0 2.6 0v-3.2a1 1 0 0 0-.3-.7L17.5 10.7M8 8h2" />',
		'diesel'       => '<path d="M5 20V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M4 20h10M7 20v-6h4v6M15 9l2.3 2.3a1 1 0 0 1 .3.7V17a1.3 1.3 0 0 0 2.6 0v-3.2a1 1 0 0 0-.3-.7L17.5 10.7M8 8h2M11.5 4.5c0 1-1 1.3-1 2.3a1 1 0 0 0 2 0c0-1-1-1.3-1-2.3Z" />',
		'hybrid'       => '<path d="M13 3 6.5 13h4.5L9 21l8-11h-4.5L15 3Z" />',
		'elektro'      => '<path d="M8 3h7l-1.5 7H17l-9 11 2-9H6.5L8 3Z" />',
	);

	echo $icons[ $slug ] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput -- feste, eigene SVG-Pfade, kein Nutzereingang.
}

/**
 * Legt die drei geführten Marken als Standard-Begriffe an –
 * einmalig bei Theme-Aktivierung, nicht bei jedem Request.
 */
function auto_emotion_seed_marke_terms() {
	auto_emotion_register_cpt();

	foreach ( array( 'Cupra', 'Seat', 'Nissan' ) as $marke ) {
		if ( ! term_exists( $marke, 'marke' ) ) {
			wp_insert_term( $marke, 'marke' );
		}
	}

	foreach ( array( 'SUV', 'Kombi', 'Kompakt', 'Kleinwagen', 'Nutzfahrzeug' ) as $karosserie ) {
		if ( ! term_exists( $karosserie, 'karosserie' ) ) {
			wp_insert_term( $karosserie, 'karosserie' );
		}
	}

	foreach ( array( 'Benzin', 'Diesel', 'Hybrid', 'Elektro' ) as $antrieb ) {
		if ( ! term_exists( $antrieb, 'antrieb' ) ) {
			wp_insert_term( $antrieb, 'antrieb' );
		}
	}

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'auto_emotion_seed_marke_terms' );

/**
 * Einmalige Zuordnung von Karosserieform/Antriebsart zu den beim
 * Theme-Umbau bereits bestehenden echten Angeboten, per Post-ID (kein
 * Titel-Matching - robust gegen spätere Titeländerungen). Nur dort
 * zugeordnet, wo die Angabe aus dem echten, öffentlich bekannten
 * Modell/Titel eindeutig ist (z.B. "Nissan Leaf" ist zweifelsfrei ein
 * reines Elektrofahrzeug) - bei echter Unsicherheit (z.B. Townstar
 * Kasten gibt es als Diesel UND als Elektro-Variante "Townstar EV",
 * ohne weitere Angabe im Titel nicht unterscheidbar) bleibt das Feld
 * bewusst leer statt zu raten. Läuft nur einmal (Options-Flag), neue
 * Angebote bekommen ihre Einordnung künftig im Editor.
 */
function auto_emotion_seed_angebot_filter_terms() {
	if ( get_option( 'auto_emotion_angebot_filter_terms_seeded' ) ) {
		return;
	}

	auto_emotion_register_cpt();

	// post_id => array( karosserie, antrieb[] ) - antrieb leer = nicht sicher zuordenbar.
	$zuordnung = array(
		333 => array( 'Kleinwagen', array( 'Benzin' ) ),        // Seat Ibiza FR - Beschreibung: "1,0 TSI"
		332 => array( 'SUV', array( 'Benzin' ) ),               // CUPRA Formentor VZ Custom by ABT - "2,0 TSI"
		330 => array( 'Nutzfahrzeug', array( 'Diesel' ) ),      // Nissan Interstar Kasten
		329 => array( 'Nutzfahrzeug', array( 'Diesel' ) ),      // Nissan Primastar Kasten
		328 => array( 'Nutzfahrzeug', array() ),                // Nissan Townstar Kasten - gibt es als Benzin UND als Elektro-Variante, Beschreibung nennt keine davon
		324 => array( 'Kompakt', array( 'Elektro' ) ),          // Nissan Leaf Engage - Beschreibung: "Elektrisch"
		323 => array( 'SUV', array( 'Hybrid', 'Benzin' ) ),     // Nissan X-Trail e-POWER - Beschreibung: "e-POWER ... Benziner"
		322 => array( 'SUV', array( 'Hybrid', 'Benzin' ) ),     // Nissan Qashqai Acenta - Beschreibung: "Mild-Hybrid ... Benziner"
		321 => array( 'SUV', array( 'Benzin' ) ),               // Nissan Juke N-Tec - Beschreibung: "Benziner", keine Hybrid-Angabe
		316 => array( 'Kompakt', array( 'Elektro' ) ),          // Nissan Micra Engage - Beschreibung: "vollelektrisches Stadtauto ... Elektrisch"
		315 => array( 'Kombi', array( 'Benzin' ) ),             // Seat Leon Sportstourer FR Black Edition
		314 => array( 'Kompakt', array( 'Benzin' ) ),           // Seat Leon FR Black Edition
		313 => array( 'SUV', array( 'Benzin' ) ),               // Seat Arona FR Black Edition
		312 => array( 'Kleinwagen', array( 'Benzin' ) ),        // Seat Ibiza FR Black Edition
		311 => array( 'SUV', array( 'Elektro' ) ),              // Cupra Tavascan - Beschreibung: "140 kW/58 kWh"
		310 => array( 'SUV', array( 'Benzin', 'Hybrid' ) ),     // Cupra Terramar - Beschreibung: "1.5 eTSI" UND "e-HYBRID"
		309 => array( 'SUV', array( 'Benzin', 'Hybrid' ) ),     // Cupra Formentor - Beschreibung: "TSI" UND "e-HYBRID"
		308 => array( 'Kombi', array( 'Benzin', 'Hybrid' ) ),   // Cupra Leon Sportstourer - Beschreibung: "TSI" UND "e-HYBRID"
		307 => array( 'Kompakt', array( 'Benzin', 'Hybrid' ) ), // Cupra Leon - Beschreibung: "TSI" UND "e-HYBRID"
		64  => array( 'Kompakt', array( 'Elektro' ) ),          // CUPRA Born VZ - Born ist ausschließlich als Elektrofahrzeug erhältlich
	);

	foreach ( $zuordnung as $post_id => $werte ) {
		if ( 'angebot' !== get_post_type( $post_id ) ) {
			continue;
		}

		list( $karosserie, $antriebe ) = $werte;

		wp_set_object_terms( $post_id, $karosserie, 'karosserie', false );

		if ( ! empty( $antriebe ) ) {
			wp_set_object_terms( $post_id, $antriebe, 'antrieb', false );
		}
	}

	update_option( 'auto_emotion_angebot_filter_terms_seeded', '1' );
}
add_action( 'init', 'auto_emotion_seed_angebot_filter_terms', 20 );

/**
 * Korrektur zur ersten Einordnung oben: beim ersten Durchlauf wurden
 * nur die Angebots-TITEL geprüft. Die echten Beschreibungstexte
 * (Post-Excerpt/-Content) nennen den tatsächlichen Antrieb aber oft
 * explizit (z.B. "Mild-Hybrid ... Benziner", "vollelektrisches
 * Stadtauto ... Elektrisch") - diese vier Fälle waren dadurch falsch
 * oder unnötig leer. Läuft, weil der erste Durchlauf (Options-Flag
 * oben) bereits erfolgt ist, als eigene einmalige Korrektur statt
 * einer erneuten Komplett-Zuordnung.
 */
function auto_emotion_fix_angebot_antrieb_terms() {
	if ( get_option( 'auto_emotion_angebot_antrieb_fixed_v2' ) ) {
		return;
	}

	auto_emotion_register_cpt();

	$korrekturen = array(
		316 => array( 'Elektro' ),          // Nissan Micra Engage - Beschreibung: "vollelektrisches Stadtauto ... Elektrisch"
		322 => array( 'Hybrid', 'Benzin' ), // Nissan Qashqai Acenta - Beschreibung: "Mild-Hybrid ... Benziner"
		323 => array( 'Hybrid', 'Benzin' ), // Nissan X-Trail e-POWER - Beschreibung: "e-POWER ... Benziner"
		310 => array( 'Hybrid', 'Benzin' ), // Cupra Terramar - Beschreibung: "1.5 eTSI" UND "e-HYBRID"
	);

	foreach ( $korrekturen as $post_id => $antriebe ) {
		if ( 'angebot' !== get_post_type( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, $antriebe, 'antrieb', false );
	}

	update_option( 'auto_emotion_angebot_antrieb_fixed_v2', '1' );
}
add_action( 'init', 'auto_emotion_fix_angebot_antrieb_terms', 21 );

/**
 * Fahrzeugsuche: filtert das Angebot-Archiv nach Marke, Karosserieform
 * und/oder Antriebsart (jeweils per GET-Parameter, Karosserie/Antrieb
 * auch mehrfach wählbar).
 */
function auto_emotion_filter_angebote_by_marke( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( 'angebot' ) ) {
		return;
	}

	$tax_query = array();

	$marke = isset( $_GET['marke'] ) ? sanitize_title( wp_unslash( $_GET['marke'] ) ) : '';
	if ( $marke && term_exists( $marke, 'marke' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'marke',
			'field'    => 'slug',
			'terms'    => $marke,
		);
	}

	$karosserie = isset( $_GET['karosserie'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET['karosserie'] ) ) : array();
	$karosserie = array_filter( $karosserie, fn( $slug ) => term_exists( $slug, 'karosserie' ) );
	if ( $karosserie ) {
		$tax_query[] = array(
			'taxonomy' => 'karosserie',
			'field'    => 'slug',
			'terms'    => $karosserie,
		);
	}

	$antrieb = isset( $_GET['antrieb'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET['antrieb'] ) ) : array();
	$antrieb = array_filter( $antrieb, fn( $slug ) => term_exists( $slug, 'antrieb' ) );
	if ( $antrieb ) {
		$tax_query[] = array(
			'taxonomy' => 'antrieb',
			'field'    => 'slug',
			'terms'    => $antrieb,
		);
	}

	if ( $tax_query ) {
		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'AND';
		}
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'auto_emotion_filter_angebote_by_marke' );

/**
 * Meta-Feld "Elektrofahrzeug": steuert, ob der Förderhinweis
 * (staatliche E-Auto-Förderung) auf der Angebots-Einzelseite
 * erscheint – nur bei echten E-Fahrzeugen, nicht bei jedem Angebot.
 */
function auto_emotion_register_angebot_meta() {
	register_post_meta(
		'angebot',
		'_auto_emotion_ist_elektro',
		array(
			'type'          => 'boolean',
			'single'        => true,
			'show_in_rest'  => true,
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'auto_emotion_register_angebot_meta' );

function auto_emotion_angebot_meta_box() {
	add_meta_box(
		'auto_emotion_angebot_elektro',
		__( 'Antrieb', 'auto-emotion' ),
		'auto_emotion_render_angebot_meta_box',
		'angebot',
		'side'
	);
}
add_action( 'add_meta_boxes', 'auto_emotion_angebot_meta_box' );

function auto_emotion_render_angebot_meta_box( $post ) {
	wp_nonce_field( 'auto_emotion_angebot_meta', 'auto_emotion_angebot_meta_nonce' );
	$ist_elektro = get_post_meta( $post->ID, '_auto_emotion_ist_elektro', true );
	?>
	<label>
		<input type="checkbox" name="auto_emotion_ist_elektro" value="1" <?php checked( $ist_elektro, '1' ); ?>>
		<?php esc_html_e( 'Elektrofahrzeug (zeigt Förderhinweis auf der Angebotsseite)', 'auto-emotion' ); ?>
	</label>
	<?php
}

function auto_emotion_save_angebot_meta( $post_id ) {
	if ( ! isset( $_POST['auto_emotion_angebot_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_angebot_meta_nonce'] ) ), 'auto_emotion_angebot_meta' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_auto_emotion_ist_elektro', ! empty( $_POST['auto_emotion_ist_elektro'] ) ? '1' : '' );
}
add_action( 'save_post_angebot', 'auto_emotion_save_angebot_meta' );
