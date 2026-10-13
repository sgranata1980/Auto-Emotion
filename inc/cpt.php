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
		333 => array( 'Kleinwagen', array( 'Benzin' ) ),       // Seat Ibiza FR
		332 => array( 'SUV', array( 'Benzin' ) ),               // CUPRA Formentor VZ Custom by ABT
		330 => array( 'Nutzfahrzeug', array( 'Diesel' ) ),      // Nissan Interstar Kasten
		329 => array( 'Nutzfahrzeug', array( 'Diesel' ) ),      // Nissan Primastar Kasten
		328 => array( 'Nutzfahrzeug', array() ),                // Nissan Townstar Kasten - Diesel oder EV, unklar
		324 => array( 'Kompakt', array( 'Elektro' ) ),          // Nissan Leaf Engage
		323 => array( 'SUV', array( 'Hybrid' ) ),               // Nissan X-Trail e-POWER
		322 => array( 'SUV', array( 'Hybrid' ) ),               // Nissan Qashqai Acenta (Mild-Hybrid-Antrieb)
		321 => array( 'SUV', array( 'Benzin' ) ),               // Nissan Juke N-Tec
		316 => array( 'Kompakt', array() ),                     // Nissan Micra Engage - Generation/Antrieb unklar
		315 => array( 'Kombi', array( 'Benzin' ) ),             // Seat Leon Sportstourer FR Black Edition
		314 => array( 'Kompakt', array( 'Benzin' ) ),           // Seat Leon FR Black Edition
		313 => array( 'SUV', array( 'Benzin' ) ),               // Seat Arona FR Black Edition
		312 => array( 'Kleinwagen', array( 'Benzin' ) ),        // Seat Ibiza FR Black Edition
		311 => array( 'SUV', array( 'Elektro' ) ),              // Cupra Tavascan
		310 => array( 'SUV', array() ),                         // Cupra Terramar - Antrieb im Titel nicht spezifiziert
		309 => array( 'SUV', array( 'Benzin', 'Hybrid' ) ),     // Cupra Formentor: TSI und e-HYBRID
		308 => array( 'Kombi', array( 'Benzin', 'Hybrid' ) ),   // Cupra Leon Sportstourer: TSI und e-HYBRID
		307 => array( 'Kompakt', array( 'Benzin', 'Hybrid' ) ), // Cupra Leon: TSI und e-HYBRID
		64  => array( 'Kompakt', array( 'Elektro' ) ),          // CUPRA Born VZ
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
