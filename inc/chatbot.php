<?php
/**
 * Auto Emotion Chat-Assistent.
 *
 * Ruft die Claude API (Anthropic) server-seitig auf, mit einem
 * System-Prompt, der ausschließlich auf echten Geschäftsdaten aus
 * inc/contact-info.php basiert – der Assistent soll nichts über
 * Auto Emotion erfinden, was ihm nicht mitgegeben wurde.
 *
 * Bleibt inaktiv (kein Widget, kein API-Aufruf), solange im
 * Customizer kein Claude API-Key hinterlegt ist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_chat_is_configured() {
	return (bool) get_theme_mod( 'ae_claude_api_key', '' );
}

function auto_emotion_chat_system_prompt() {
	$marken = get_terms(
		array(
			'taxonomy'   => 'marke',
			'hide_empty' => false,
			'fields'     => 'names',
		)
	);
	$marken_liste = ! is_wp_error( $marken ) ? implode( ', ', $marken ) : 'Seat, Cupra, Nissan';

	$fakten = array(
		sprintf( 'Firma: %s', auto_emotion_contact( 'company' ) ),
		sprintf( 'Adresse: %s, %s %s', auto_emotion_contact( 'street' ), auto_emotion_contact( 'postal_code' ), auto_emotion_contact( 'city' ) ),
		sprintf( 'Telefon: %s', auto_emotion_contact( 'phone' ) ),
		sprintf( 'E-Mail: %s', auto_emotion_contact( 'email' ) ),
		sprintf( 'Öffnungszeiten Verkauf: %s', auto_emotion_contact( 'hours_sales' ) ),
		sprintf( 'Öffnungszeiten Werkstatt: %s', auto_emotion_contact( 'hours_service' ) ),
		sprintf( 'Vertretene Marken: %s', $marken_liste ),
		'Werkstatt: modern, 12 Hebebühnen, freie Werkstatt (repariert auch Fremdmarken).',
		'Karriere: aktuell Kfz-Mechatroniker (m/w/d) gesucht, Initiativbewerbungen jederzeit möglich (/initiativbewerbung/).',
		'B2B: Nissan-Nutzfahrzeuge (Townstar, Primastar, Interstar/-e) für Gewerbekunden, individuell konfigurierbar (/b2b-nutzfahrzeuge/).',
		'Beklebungsservice: eigene Grafikabteilung entwirft und bringt Fahrzeugbeklebungen an, individuell nach Anfrage (/beklebungsservice/).',
		'Fahrzeugangebote: aktueller Bestand unter /angebote/, wechselt laufend.',
	);

	return "Du bist Emo, der Chat-Assistent von Auto Emotion, einem Autohaus (Seat/Cupra/Nissan-Vertragshändler) in Offenbach.\n\n"
		. "Echte Fakten über das Unternehmen (nutze ausschließlich diese, erfinde nichts Zusätzliches):\n- "
		. implode( "\n- ", $fakten ) . "\n\n"
		. "Regeln:\n"
		. "- Antworte kurz, freundlich, auf Deutsch.\n"
		. "- Nenne niemals konkrete Preise, Rabatte, Lieferzeiten oder Fahrzeugverfügbarkeiten, die dir hier nicht explizit genannt wurden – verweise stattdessen auf einen Anruf oder die passende Seite.\n"
		. "- Wenn du etwas nicht sicher weißt, sag das ehrlich und verweise auf Telefon oder E-Mail.\n"
		. "- Du bist kein Ersatz für eine verbindliche Beratung; bei allem, was Vertragsdetails, Finanzierung oder Termine betrifft, an das Team verweisen.";
}

function auto_emotion_register_chat_route() {
	register_rest_route(
		'auto-emotion/v1',
		'/chat',
		array(
			'methods'             => 'POST',
			'callback'            => 'auto_emotion_handle_chat_request',
			'permission_callback' => '__return_true',
			'args'                => array(
				'message' => array(
					'required'          => true,
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_textarea_field',
				),
				'history' => array(
					'required' => false,
					'type'     => 'array',
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'auto_emotion_register_chat_route' );

/**
 * Simples IP-basiertes Rate-Limit, damit der (kostenpflichtige)
 * API-Zugang nicht durch Missbrauch der öffentlichen Route
 * leergeräumt werden kann.
 */
function auto_emotion_chat_rate_limit_exceeded() {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'ae_chat_rl_' . md5( $ip );
	$count = (int) get_transient( $key );

	if ( $count >= 20 ) {
		return true;
	}

	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	return false;
}

function auto_emotion_handle_chat_request( WP_REST_Request $request ) {
	$api_key = get_theme_mod( 'ae_claude_api_key', '' );

	if ( ! $api_key ) {
		return new WP_Error( 'ae_chat_not_configured', __( 'Der Chat-Assistent ist noch nicht eingerichtet.', 'auto-emotion' ), array( 'status' => 503 ) );
	}

	if ( auto_emotion_chat_rate_limit_exceeded() ) {
		return new WP_Error( 'ae_chat_rate_limited', __( 'Zu viele Anfragen. Bitte später erneut versuchen oder anrufen.', 'auto-emotion' ), array( 'status' => 429 ) );
	}

	$message = $request->get_param( 'message' );
	$history = $request->get_param( 'history' );

	if ( ! $message || mb_strlen( $message ) > 1000 ) {
		return new WP_Error( 'ae_chat_invalid', __( 'Ungültige Nachricht.', 'auto-emotion' ), array( 'status' => 400 ) );
	}

	$messages = array();

	if ( is_array( $history ) ) {
		// Nur die letzten 6 Nachrichten der Historie berücksichtigen, mit
		// erwarteter Form { role: 'user'|'assistant', content: string }.
		$history = array_slice( $history, -6 );
		foreach ( $history as $entry ) {
			if ( ! is_array( $entry ) || empty( $entry['role'] ) || empty( $entry['content'] ) ) {
				continue;
			}
			if ( ! in_array( $entry['role'], array( 'user', 'assistant' ), true ) ) {
				continue;
			}
			$messages[] = array(
				'role'    => $entry['role'],
				'content' => sanitize_textarea_field( $entry['content'] ),
			);
		}
	}

	$messages[] = array(
		'role'    => 'user',
		'content' => $message,
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
					'max_tokens' => 400,
					'system'     => auto_emotion_chat_system_prompt(),
					'messages'   => $messages,
				)
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'ae_chat_upstream_error', __( 'Der Chat-Assistent ist gerade nicht erreichbar.', 'auto-emotion' ), array( 'status' => 502 ) );
	}

	$code = wp_remote_retrieve_response_code( $response );
	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( $code < 200 || $code >= 300 || empty( $body['content'][0]['text'] ) ) {
		return new WP_Error( 'ae_chat_upstream_error', __( 'Der Chat-Assistent ist gerade nicht erreichbar.', 'auto-emotion' ), array( 'status' => 502 ) );
	}

	return array( 'reply' => $body['content'][0]['text'] );
}
