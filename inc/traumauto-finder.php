<?php
/**
 * Traumauto-Finder: KI-gestützter 2-Schritt-Fahrzeug-Finder auf der
 * Startseite.
 *
 * Grundsatz wie beim Chat-Assistenten (inc/chatbot.php): die KI bekommt
 * ausschließlich den echten, aktuellen Angebot-Bestand als Datenbasis und
 * wählt NUR daraus aus - erfindet keine Fahrzeuge, Preise oder
 * Ausstattungsdetails. Gibt es keinen passenden Treffer im Bestand, wird
 * das ehrlich gesagt statt eine Notlösung vorzutäuschen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_traumauto_usage_labels() {
	return array(
		'familie'     => __( 'Familie', 'auto-emotion' ),
		'geschaeft'   => __( 'Geschäft', 'auto-emotion' ),
		'transporter' => __( 'Transporter', 'auto-emotion' ),
		'single'      => __( 'Single', 'auto-emotion' ),
		'sportlich'   => __( 'Sportlich', 'auto-emotion' ),
	);
}

function auto_emotion_traumauto_priority_labels() {
	return array(
		'sparsam' => __( 'Sparsam', 'auto-emotion' ),
		'power'   => __( 'Power', 'auto-emotion' ),
		'elektro' => __( 'Elektro', 'auto-emotion' ),
	);
}

function auto_emotion_register_traumauto_route() {
	register_rest_route(
		'auto-emotion/v1',
		'/traumauto-match',
		array(
			'methods'             => 'POST',
			'callback'            => 'auto_emotion_handle_traumauto_request',
			'permission_callback' => '__return_true',
			'args'                => array(
				'usage'    => array(
					'required' => true,
					'type'     => 'string',
					'enum'     => array_keys( auto_emotion_traumauto_usage_labels() ),
				),
				'priority' => array(
					'required' => true,
					'type'     => 'string',
					'enum'     => array_keys( auto_emotion_traumauto_priority_labels() ),
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'auto_emotion_register_traumauto_route' );

/**
 * Eigenes, kleines IP-Rate-Limit statt des Chat-Limits aus
 * inc/chatbot.php: andere Transient-Namespace, eigener Kontext (2 Klicks
 * statt freiem Chat-Verlauf), deshalb bewusst eine eigene, unabhängige
 * Implementierung statt geteilter Funktion.
 */
function auto_emotion_traumauto_rate_limit_exceeded() {
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key   = 'ae_traumauto_rl_' . md5( $ip );
	$count = (int) get_transient( $key );

	if ( $count >= 15 ) {
		return true;
	}

	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	return false;
}

/**
 * Baut die echte, aktuelle Bestandsliste für den Prompt: Titel, Marke,
 * kurze Beschreibung aus dem Excerpt und das echte Elektro-Flag
 * (_auto_emotion_ist_elektro, bereits strukturiert im CPT gepflegt -
 * zuverlässiger als die KI aus dem Titel raten zu lassen).
 */
function auto_emotion_traumauto_inventory() {
	$query = new WP_Query(
		array(
			'post_type'      => 'angebot',
			'post_status'    => 'publish',
			'posts_per_page' => 40,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);

	$inventory = array();

	foreach ( $query->posts as $post ) {
		$marken       = get_the_terms( $post->ID, 'marke' );
		$marken_namen = ( is_array( $marken ) && ! is_wp_error( $marken ) ) ? wp_list_pluck( $marken, 'name' ) : array();

		$inventory[] = array(
			'id'          => $post->ID,
			'titel'       => get_the_title( $post ),
			'marke'       => implode( ', ', $marken_namen ),
			'beschreibung' => wp_strip_all_tags( get_the_excerpt( $post ) ),
			'elektro'     => (bool) get_post_meta( $post->ID, '_auto_emotion_ist_elektro', true ),
			'link'        => get_permalink( $post ),
			'bild'        => has_post_thumbnail( $post ) ? get_the_post_thumbnail_url( $post, 'large' ) : '',
		);
	}

	wp_reset_postdata();

	return $inventory;
}

function auto_emotion_traumauto_system_prompt( array $inventory ) {
	$usage_labels    = auto_emotion_traumauto_usage_labels();
	$priority_labels = auto_emotion_traumauto_priority_labels();

	$bestand_text = array();
	foreach ( $inventory as $item ) {
		$bestand_text[] = sprintf(
			'ID %1$d: %2$s (%3$s)%4$s – %5$s',
			$item['id'],
			$item['titel'],
			$item['marke'] ? $item['marke'] : 'Marke unbekannt',
			$item['elektro'] ? ', vollelektrisch' : '',
			$item['beschreibung'] ? $item['beschreibung'] : 'keine weitere Beschreibung hinterlegt'
		);
	}

	return "Du hilfst bei Auto Emotion (Seat/Cupra/Nissan-Vertragshändler) Kundinnen und Kunden, aus dem echten aktuellen Fahrzeugbestand passende Vorschläge zu finden.\n\n"
		. "Das ist der VOLLSTÄNDIGE aktuelle Bestand (jede Zeile ein echtes, tatsächlich verfügbares Angebot):\n- "
		. ( $bestand_text ? implode( "\n- ", $bestand_text ) : '(aktuell keine Angebote im System)' ) . "\n\n"
		. "Regeln, unbedingt einhalten:\n"
		. "- Wähle AUSSCHLIESSLICH aus der obigen Liste aus, per ID. Erfinde niemals ein Fahrzeug, eine Ausstattung, einen Preis oder eine Eigenschaft, die nicht explizit oben steht.\n"
		. "- Maximal 3 Treffer, sortiert nach bester Passung zuerst.\n"
		. "- Wenn kein Fahrzeug aus der Liste wirklich passt (oder die Liste leer ist), gib eine leere Treffer-Liste zurück - rate nicht ins Blaue.\n"
		. "- Antworte AUSSCHLIESSLICH mit validem JSON, keine Erklärung davor oder danach, kein Markdown-Codeblock. Format exakt:\n"
		. '{"matches":[{"id":123,"grund":"Kurzer Grund auf Deutsch, max. 1 Satz"}]}' . "\n\n"
		. "Verfügbare Nutzungszwecke: " . implode( ', ', $usage_labels ) . "\n"
		. "Verfügbare Prioritäten: " . implode( ', ', $priority_labels );
}

function auto_emotion_handle_traumauto_request( WP_REST_Request $request ) {
	$api_key = get_theme_mod( 'ae_claude_api_key', '' );

	if ( ! $api_key ) {
		return new WP_Error( 'ae_traumauto_not_configured', __( 'Der Fahrzeug-Finder ist noch nicht eingerichtet.', 'auto-emotion' ), array( 'status' => 503 ) );
	}

	if ( auto_emotion_traumauto_rate_limit_exceeded() ) {
		return new WP_Error( 'ae_traumauto_rate_limited', __( 'Zu viele Anfragen. Bitte in Kürze erneut versuchen.', 'auto-emotion' ), array( 'status' => 429 ) );
	}

	$usage_labels    = auto_emotion_traumauto_usage_labels();
	$priority_labels = auto_emotion_traumauto_priority_labels();
	$usage           = $request->get_param( 'usage' );
	$priority        = $request->get_param( 'priority' );

	$inventory = auto_emotion_traumauto_inventory();

	if ( empty( $inventory ) ) {
		return array(
			'matches' => array(),
			'notice'  => __( 'Aktuell sind keine Angebote im System hinterlegt. Bitte kontaktieren Sie uns direkt, wir finden gemeinsam das passende Fahrzeug.', 'auto-emotion' ),
		);
	}

	/**
	 * Nur 5×3=15 mögliche Antwortkombinationen, der Bestand ändert sich
	 * nicht minütlich - Ergebnis 2 Stunden cachen, spart bei mehreren
	 * Besuchern mit derselben Kombination echte API-Kosten. Cache-Key
	 * hängt zusätzlich an allen Bestand-IDs, damit jede Änderung am
	 * Bestand (neu, entfernt, oder mittendrin ausgetauscht) den Cache
	 * zuverlässig invalidiert statt nur Anzahl/erste ID zu prüfen.
	 */
	$inventory_fingerprint = implode( ',', wp_list_pluck( $inventory, 'id' ) );
	$cache_key              = 'ae_traumauto_' . md5( $usage . '|' . $priority . '|' . $inventory_fingerprint );
	$cached    = get_transient( $cache_key );
	if ( false !== $cached ) {
		return $cached;
	}

	$user_message = sprintf(
		'Nutzungszweck: %1$s. Priorität: %2$s. Welche Fahrzeuge aus dem Bestand passen am besten?',
		$usage_labels[ $usage ],
		$priority_labels[ $priority ]
	);

	$response = wp_remote_post(
		'https://api.anthropic.com/v1/messages',
		array(
			'timeout' => 20,
			'headers' => array(
				'x-api-key'         => $api_key,
				'anthropic-version' => '2023-06-01',
				'content-type'      => 'application/json',
			),
			'body'    => wp_json_encode(
				array(
					'model'      => 'claude-haiku-4-5-20251001',
					'max_tokens' => 500,
					'system'     => array(
						array(
							'type'          => 'text',
							'text'          => auto_emotion_traumauto_system_prompt( $inventory ),
							'cache_control' => array( 'type' => 'ephemeral' ),
						),
					),
					'messages'   => array(
						array(
							'role'    => 'user',
							'content' => $user_message,
						),
					),
				)
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'ae_traumauto_upstream_error', __( 'Der Fahrzeug-Finder ist gerade nicht erreichbar.', 'auto-emotion' ), array( 'status' => 502 ) );
	}

	$code = wp_remote_retrieve_response_code( $response );
	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( $code < 200 || $code >= 300 || empty( $body['content'][0]['text'] ) ) {
		return new WP_Error( 'ae_traumauto_upstream_error', __( 'Der Fahrzeug-Finder ist gerade nicht erreichbar.', 'auto-emotion' ), array( 'status' => 502 ) );
	}

	$raw_text = trim( $body['content'][0]['text'] );
	// Falls das Modell trotz Anweisung einen Markdown-Codeblock liefert.
	$raw_text = preg_replace( '/^```(?:json)?|```$/m', '', $raw_text );
	$parsed   = json_decode( trim( $raw_text ), true );

	$inventory_by_id = array();
	foreach ( $inventory as $item ) {
		$inventory_by_id[ $item['id'] ] = $item;
	}

	$matches = array();
	if ( is_array( $parsed ) && ! empty( $parsed['matches'] ) && is_array( $parsed['matches'] ) ) {
		foreach ( array_slice( $parsed['matches'], 0, 3 ) as $match ) {
			$id = isset( $match['id'] ) ? (int) $match['id'] : 0;
			// Nur IDs akzeptieren, die wirklich im Bestand stehen - schützt
			// davor, dass eine halluzinierte ID ungeprüft durchgereicht wird.
			if ( ! isset( $inventory_by_id[ $id ] ) ) {
				continue;
			}
			$matches[] = array(
				'id'     => $id,
				'titel'  => $inventory_by_id[ $id ]['titel'],
				'marke'  => $inventory_by_id[ $id ]['marke'],
				'link'   => $inventory_by_id[ $id ]['link'],
				'bild'   => $inventory_by_id[ $id ]['bild'],
				'grund'  => isset( $match['grund'] ) ? sanitize_text_field( $match['grund'] ) : '',
			);
		}
	}

	$result = array(
		'matches' => $matches,
		'notice'  => empty( $matches ) ? __( 'Aktuell passt kein Fahrzeug aus unserem Bestand optimal zu Ihrer Auswahl. Sprechen Sie uns gerne direkt an - wir beraten Sie persönlich.', 'auto-emotion' ) : '',
	);

	set_transient( $cache_key, $result, 2 * HOUR_IN_SECONDS );

	return $result;
}
