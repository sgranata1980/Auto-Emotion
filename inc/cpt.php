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

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'auto_emotion_seed_marke_terms' );

/**
 * Fahrzeugsuche auf der Startseite: filtert das Angebot-Archiv nach
 * Marke, wenn ?marke=<slug> an /angebote/ übergeben wird.
 */
function auto_emotion_filter_angebote_by_marke( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( 'angebot' ) ) {
		return;
	}

	$marke = isset( $_GET['marke'] ) ? sanitize_title( wp_unslash( $_GET['marke'] ) ) : '';

	if ( $marke && term_exists( $marke, 'marke' ) ) {
		$query->set(
			'tax_query',
			array(
				array(
					'taxonomy' => 'marke',
					'field'    => 'slug',
					'terms'    => $marke,
				),
			)
		);
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
