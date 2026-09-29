<?php
/**
 * Recruiting-Backend: interner Bereich für "Suchprofile" – Positionen,
 * die Auto Emotion aktiv besetzen möchte, mit fertigen Such-Links für
 * LinkedIn, Xing & Co.
 *
 * Bewusst ohne Speicherung von Bewerber-Daten: hier werden nur die
 * eigenen Such-Kriterien des Unternehmens gepflegt, nie Kandidaten-
 * Datensätze. Die bestehende E-Mail-only-Bewerbungsstrecke
 * (inc/recruiting.php) bleibt davon komplett unberührt. Der Bereich ist
 * nicht öffentlich erreichbar (kein Archiv, keine Einzelseiten-URL) und
 * nur im wp-admin für eingeloggte Mitarbeiter sichtbar.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_register_suchprofil_cpt() {
	register_post_type(
		'suchprofil',
		array(
			'labels'                => array(
				'name'          => __( 'Suchprofile', 'auto-emotion' ),
				'singular_name' => __( 'Suchprofil', 'auto-emotion' ),
				'add_new_item'  => __( 'Neues Suchprofil', 'auto-emotion' ),
				'edit_item'     => __( 'Suchprofil bearbeiten', 'auto-emotion' ),
				'all_items'     => __( 'Suchprofile', 'auto-emotion' ),
				'menu_name'     => __( 'Recruiting', 'auto-emotion' ),
			),
			'public'                => false,
			'publicly_queryable'    => false,
			'exclude_from_search'   => true,
			'show_in_nav_menus'     => false,
			'show_in_admin_bar'     => false,
			'show_in_rest'          => false,
			'show_ui'               => true,
			'capability_type'       => 'post',
			'menu_icon'             => 'dashicons-groups',
			'menu_position'         => 26,
			'has_archive'           => false,
			'rewrite'               => false,
			'supports'              => array( 'title' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_suchprofil_cpt' );

/**
 * Meta-Felder eines Suchprofils: Standort, Anstellungsart, Status und
 * die Stichworte/Skills, aus denen die Such-Links gebaut werden.
 */
function auto_emotion_suchprofil_meta_fields() {
	return array(
		'_suchprofil_standort'       => __( 'Standort', 'auto-emotion' ),
		'_suchprofil_anstellungsart' => __( 'Anstellungsart', 'auto-emotion' ),
		'_suchprofil_status'         => __( 'Status', 'auto-emotion' ),
		'_suchprofil_stichworte'     => __( 'Gesuchte Skills / Stichworte', 'auto-emotion' ),
	);
}

function auto_emotion_suchprofil_meta_box() {
	add_meta_box(
		'auto_emotion_suchprofil_details',
		__( 'Such-Kriterien', 'auto-emotion' ),
		'auto_emotion_render_suchprofil_meta_box',
		'suchprofil',
		'normal',
		'high'
	);

	add_meta_box(
		'auto_emotion_suchprofil_links',
		__( 'Such-Links', 'auto-emotion' ),
		'auto_emotion_render_suchprofil_links_box',
		'suchprofil',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'auto_emotion_suchprofil_meta_box' );

function auto_emotion_render_suchprofil_meta_box( $post ) {
	wp_nonce_field( 'auto_emotion_suchprofil_meta', 'auto_emotion_suchprofil_meta_nonce' );

	$standort       = get_post_meta( $post->ID, '_suchprofil_standort', true );
	$anstellungsart = get_post_meta( $post->ID, '_suchprofil_anstellungsart', true );
	$status         = get_post_meta( $post->ID, '_suchprofil_status', true );
	$stichworte     = get_post_meta( $post->ID, '_suchprofil_stichworte', true );

	if ( ! $status ) {
		$status = 'aktiv';
	}
	?>
	<p>
		<label for="auto_emotion_suchprofil_standort"><strong><?php esc_html_e( 'Standort', 'auto-emotion' ); ?></strong></label><br>
		<input type="text" id="auto_emotion_suchprofil_standort" name="auto_emotion_suchprofil_standort" class="widefat" value="<?php echo esc_attr( $standort ); ?>" placeholder="z. B. Offenbach am Main">
	</p>
	<p>
		<label for="auto_emotion_suchprofil_anstellungsart"><strong><?php esc_html_e( 'Anstellungsart', 'auto-emotion' ); ?></strong></label><br>
		<select id="auto_emotion_suchprofil_anstellungsart" name="auto_emotion_suchprofil_anstellungsart" class="widefat">
			<?php
			$optionen = array(
				''            => __( '– bitte wählen –', 'auto-emotion' ),
				'vollzeit'    => __( 'Vollzeit', 'auto-emotion' ),
				'teilzeit'    => __( 'Teilzeit', 'auto-emotion' ),
				'ausbildung'  => __( 'Ausbildung', 'auto-emotion' ),
				'werkstudent' => __( 'Werkstudent/in', 'auto-emotion' ),
				'praktikum'   => __( 'Praktikum', 'auto-emotion' ),
			);
			foreach ( $optionen as $wert => $label ) {
				printf(
					'<option value="%1$s" %2$s>%3$s</option>',
					esc_attr( $wert ),
					selected( $anstellungsart, $wert, false ),
					esc_html( $label )
				);
			}
			?>
		</select>
	</p>
	<p>
		<label for="auto_emotion_suchprofil_status"><strong><?php esc_html_e( 'Status', 'auto-emotion' ); ?></strong></label><br>
		<select id="auto_emotion_suchprofil_status" name="auto_emotion_suchprofil_status" class="widefat">
			<?php
			$status_optionen = array(
				'aktiv'    => __( 'Aktiv', 'auto-emotion' ),
				'pausiert' => __( 'Pausiert', 'auto-emotion' ),
				'besetzt'  => __( 'Besetzt', 'auto-emotion' ),
			);
			foreach ( $status_optionen as $wert => $label ) {
				printf(
					'<option value="%1$s" %2$s>%3$s</option>',
					esc_attr( $wert ),
					selected( $status, $wert, false ),
					esc_html( $label )
				);
			}
			?>
		</select>
	</p>
	<p>
		<label for="auto_emotion_suchprofil_stichworte"><strong><?php esc_html_e( 'Gesuchte Skills / Stichworte', 'auto-emotion' ); ?></strong></label><br>
		<input type="text" id="auto_emotion_suchprofil_stichworte" name="auto_emotion_suchprofil_stichworte" class="widefat" value="<?php echo esc_attr( $stichworte ); ?>" placeholder="z. B. Kfz-Mechatroniker, Diagnose, Service Berater">
		<span class="description"><?php esc_html_e( 'Kommagetrennt. Fließt zusammen mit Titel und Standort in die Such-Links ein.', 'auto-emotion' ); ?></span>
	</p>
	<?php
}

/**
 * Baut reine Such-Links (keine Datenabfrage, keine Kandidaten-Daten) für
 * LinkedIn, Xing und eine Google-X-Ray-Suche aus Titel, Stichworten und
 * Standort des Suchprofils.
 */
function auto_emotion_suchprofil_links( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		return array();
	}

	$standort   = get_post_meta( $post_id, '_suchprofil_standort', true );
	$stichworte = get_post_meta( $post_id, '_suchprofil_stichworte', true );

	$suchbegriffe = trim( $post->post_title . ' ' . $stichworte );

	if ( ! $suchbegriffe ) {
		return array();
	}

	$linkedin_keywords = trim( $suchbegriffe );
	$xing_keywords      = trim( $suchbegriffe );

	$links = array(
		'linkedin' => array(
			'label' => __( 'LinkedIn – Personensuche', 'auto-emotion' ),
			'url'   => add_query_arg(
				array(
					'keywords' => rawurlencode( $linkedin_keywords ),
					'location' => $standort ? rawurlencode( $standort ) : false,
				),
				'https://www.linkedin.com/search/results/people/'
			),
		),
		'xing'     => array(
			'label' => __( 'Xing – Mitgliedersuche', 'auto-emotion' ),
			'url'   => add_query_arg(
				array( 'keywords' => rawurlencode( $xing_keywords ) ),
				'https://www.xing.com/search/members'
			),
		),
		'google'   => array(
			'label' => __( 'Google X-Ray-Suche (LinkedIn-Profile)', 'auto-emotion' ),
			'url'   => 'https://www.google.com/search?q=' . rawurlencode(
				'site:linkedin.com/in ' . $suchbegriffe . ( $standort ? ' ' . $standort : '' )
			),
		),
	);

	return $links;
}

function auto_emotion_render_suchprofil_links_box( $post ) {
	if ( 'auto-draft' === $post->post_status ) {
		echo '<p>' . esc_html__( 'Erst speichern, dann erscheinen hier die passenden Such-Links.', 'auto-emotion' ) . '</p>';
		return;
	}

	$links = auto_emotion_suchprofil_links( $post->ID );

	if ( empty( $links ) ) {
		echo '<p>' . esc_html__( 'Titel oder Stichworte eintragen, um Such-Links zu erzeugen.', 'auto-emotion' ) . '</p>';
		return;
	}

	echo '<ul style="margin:0;">';
	foreach ( $links as $link ) {
		printf(
			'<li style="margin-bottom:8px;"><a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s ↗</a></li>',
			esc_url( $link['url'] ),
			esc_html( $link['label'] )
		);
	}
	echo '</ul>';
	echo '<p class="description">' . esc_html__( 'Reine Such-Links – es werden keine Kandidaten-Daten abgerufen oder gespeichert.', 'auto-emotion' ) . '</p>';
}

function auto_emotion_save_suchprofil_meta( $post_id ) {
	if ( ! isset( $_POST['auto_emotion_suchprofil_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_suchprofil_meta_nonce'] ) ), 'auto_emotion_suchprofil_meta' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$felder = array(
		'auto_emotion_suchprofil_standort'       => '_suchprofil_standort',
		'auto_emotion_suchprofil_anstellungsart' => '_suchprofil_anstellungsart',
		'auto_emotion_suchprofil_status'         => '_suchprofil_status',
		'auto_emotion_suchprofil_stichworte'     => '_suchprofil_stichworte',
	);

	foreach ( $felder as $feld_name => $meta_key ) {
		if ( isset( $_POST[ $feld_name ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $feld_name ] ) ) );
		}
	}
}
add_action( 'save_post_suchprofil', 'auto_emotion_save_suchprofil_meta' );

/**
 * Admin-Liste: Status und Standort direkt in der Übersicht anzeigen,
 * damit man nicht jedes Suchprofil einzeln öffnen muss.
 */
function auto_emotion_suchprofil_columns( $columns ) {
	$neue_spalten = array();
	foreach ( $columns as $key => $label ) {
		$neue_spalten[ $key ] = $label;
		if ( 'title' === $key ) {
			$neue_spalten['suchprofil_status']   = __( 'Status', 'auto-emotion' );
			$neue_spalten['suchprofil_standort'] = __( 'Standort', 'auto-emotion' );
		}
	}
	return $neue_spalten;
}
add_filter( 'manage_suchprofil_posts_columns', 'auto_emotion_suchprofil_columns' );

function auto_emotion_suchprofil_column_content( $column, $post_id ) {
	if ( 'suchprofil_status' === $column ) {
		$status_labels = array(
			'aktiv'    => __( 'Aktiv', 'auto-emotion' ),
			'pausiert' => __( 'Pausiert', 'auto-emotion' ),
			'besetzt'  => __( 'Besetzt', 'auto-emotion' ),
		);
		$status = get_post_meta( $post_id, '_suchprofil_status', true );
		echo esc_html( isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : $status_labels['aktiv'] );
	}

	if ( 'suchprofil_standort' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_suchprofil_standort', true ) );
	}
}
add_action( 'manage_suchprofil_posts_custom_column', 'auto_emotion_suchprofil_column_content', 10, 2 );

/**
 * Login-Link im Footer: einfach auffindbar statt versteckt – führt
 * eingeloggte Mitarbeiter direkt in die Suchprofil-Übersicht, meldet
 * alle anderen zunächst regulär über wp-login.php an.
 */
function auto_emotion_staff_login_url() {
	return wp_login_url( admin_url( 'edit.php?post_type=suchprofil' ) );
}
