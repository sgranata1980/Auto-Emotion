<?php
/**
 * Vorqualifizierung & KI-Einschätzung: vergleicht den Bewerbungstext
 * mit dem Anforderungsprofil der Position (aus einem passenden
 * Suchprofil oder der Stellenbibliothek) über die Anthropic Claude
 * API und liefert eine begründete, auf dem echten Text basierende
 * Einschätzung – kein erfundener Score ohne Grundlage.
 *
 * Braucht einen eigenen Anthropic-API-Key, der NICHT im Theme-Code
 * oder in git landet: entweder als PHP-Konstante in wp-config.php
 * ( define( 'AUTO_EMOTION_ANTHROPIC_API_KEY', 'sk-ant-...' ); ) oder
 * als Server-Umgebungsvariable ANTHROPIC_API_KEY. Ohne Key bleibt die
 * Funktion inaktiv und zeigt im Mitarbeiterbereich eine klare
 * Anleitung statt eines erfundenen Ergebnisses.
 *
 * Bewusst KEIN Composer-SDK: dieses Theme wird per Git-Push (WP
 * Pusher) ohne Build-Schritt deployt, ein vendor/-Verzeichnis gäbe es
 * nur, wenn man es mit in git einchecken würde. Stattdessen direkter
 * HTTP-Aufruf über die eingebaute WordPress-HTTP-API (wp_remote_post).
 *
 * Berücksichtigt bewusst nur den Bewerbungstext aus dem Formular,
 * NICHT den Inhalt hochgeladener Dateien (Lebenslauf/Zeugnisse) – für
 * eine Dokumentenauswertung bräuchte es eine eigene PDF/Word-Text-
 * Extraktion, die hier (noch) nicht eingebaut ist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_anthropic_api_key() {
	if ( defined( 'AUTO_EMOTION_ANTHROPIC_API_KEY' ) && AUTO_EMOTION_ANTHROPIC_API_KEY ) {
		return AUTO_EMOTION_ANTHROPIC_API_KEY;
	}

	$env_key = getenv( 'ANTHROPIC_API_KEY' );
	return $env_key ? $env_key : '';
}

function auto_emotion_anthropic_configured() {
	return (bool) auto_emotion_anthropic_api_key();
}

/**
 * Ruft die Anthropic Messages API direkt per HTTP auf. Erwartet vom
 * Modell reines JSON als Antwort (Anweisung steckt im System-Prompt);
 * das Parsen/Validieren übernimmt der Aufrufer.
 *
 * @return array{text: string, error: string}
 */
function auto_emotion_anthropic_request( $system_prompt, $user_message, $max_tokens = 1024 ) {
	$api_key = auto_emotion_anthropic_api_key();
	if ( ! $api_key ) {
		return array(
			'text'  => '',
			'error' => __( 'Kein Anthropic-API-Key konfiguriert.', 'auto-emotion' ),
		);
	}

	$response = wp_remote_post(
		'https://api.anthropic.com/v1/messages',
		array(
			'timeout' => 45,
			'headers' => array(
				'content-type'      => 'application/json',
				'x-api-key'         => $api_key,
				'anthropic-version' => '2023-06-01',
			),
			'body'    => wp_json_encode(
				array(
					'model'      => 'claude-opus-5-5',
					'max_tokens' => $max_tokens,
					'system'     => $system_prompt,
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
		return array(
			'text'  => '',
			'error' => $response->get_error_message(),
		);
	}

	$status = wp_remote_retrieve_response_code( $response );
	$data   = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( 200 !== $status ) {
		$fehler = isset( $data['error']['message'] ) ? $data['error']['message'] : sprintf( 'HTTP %d', $status );
		return array(
			'text'  => '',
			'error' => $fehler,
		);
	}

	$text = '';
	if ( ! empty( $data['content'] ) && is_array( $data['content'] ) ) {
		foreach ( $data['content'] as $block ) {
			if ( isset( $block['type'], $block['text'] ) && 'text' === $block['type'] ) {
				$text .= $block['text'];
			}
		}
	}

	if ( ! $text ) {
		return array(
			'text'  => '',
			'error' => __( 'Leere Antwort von der KI erhalten.', 'auto-emotion' ),
		);
	}

	return array(
		'text'  => $text,
		'error' => '',
	);
}

/**
 * Sucht ein Anforderungsprofil (Stichworte/Aufgaben/Anforderungen) zur
 * Positionsbezeichnung einer Bewerbung – erst im eigenen Suchprofil,
 * dann in der Stellenbibliothek. Liefert leeren String, wenn nichts
 * Passendes gefunden wird (dann bewertet die KI nur anhand des
 * Positionstitels, ohne erfundene Anforderungen).
 */
function auto_emotion_anforderungsprofil_fuer_position( $position_titel ) {
	if ( ! $position_titel ) {
		return '';
	}

	$suchprofil_treffer = get_posts(
		array(
			'post_type'      => 'suchprofil',
			'post_status'    => 'publish',
			'title'          => $position_titel,
			'posts_per_page' => 1,
		)
	);
	if ( $suchprofil_treffer ) {
		$stichworte = get_post_meta( $suchprofil_treffer[0]->ID, '_suchprofil_stichworte', true );
		if ( $stichworte ) {
			return __( 'Gesuchte Skills/Stichworte laut Suchprofil: ', 'auto-emotion' ) . $stichworte;
		}
	}

	$vorlage_treffer = get_posts(
		array(
			'post_type'      => 'stellenvorlage',
			'post_status'    => 'publish',
			'title'          => $position_titel,
			'posts_per_page' => 1,
		)
	);
	if ( $vorlage_treffer ) {
		$aufgaben      = get_post_meta( $vorlage_treffer[0]->ID, '_vorlage_aufgaben', true );
		$anforderungen = get_post_meta( $vorlage_treffer[0]->ID, '_vorlage_anforderungen', true );
		$text          = '';
		if ( $aufgaben ) {
			$text .= __( 'Typische Aufgaben:', 'auto-emotion' ) . "\n" . $aufgaben . "\n\n";
		}
		if ( $anforderungen ) {
			$text .= __( 'Anforderungen:', 'auto-emotion' ) . "\n" . $anforderungen;
		}
		return $text;
	}

	return '';
}

function auto_emotion_handle_bewerbung_einschaetzung() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_einschaetzung_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_einschaetzung_nonce'] ) ), 'auto_emotion_bewerbung_einschaetzung_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || 'bewerbung' !== $post->post_type ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' ) );
		exit;
	}

	if ( ! auto_emotion_anthropic_configured() ) {
		wp_safe_redirect( add_query_arg( 'ki_fehler', rawurlencode( __( 'Kein API-Key konfiguriert.', 'auto-emotion' ) ), home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
		exit;
	}

	$name          = get_post_meta( $post_id, '_bewerbung_name', true );
	$position      = get_post_meta( $post_id, '_bewerbung_position', true );
	$nachricht     = get_post_meta( $post_id, '_bewerbung_nachricht', true );
	$anforderungen = auto_emotion_anforderungsprofil_fuer_position( $position );

	$system_prompt = "Du unterstützt das Recruiting-Team eines Autohauses (Auto Emotion) bei der Vorqualifizierung einer Bewerbung. "
		. "Bewerte ausschließlich anhand des gegebenen Bewerbungstextes und Anforderungsprofils – erfinde keine Fähigkeiten, Erfahrungen oder Qualifikationen, die nicht genannt sind. "
		. "Wenn der Bewerbungstext knapp ist oder wenig Information enthält, sage das ehrlich statt zu spekulieren. "
		. "Dies ist eine unterstützende Einschätzung für die Vorauswahl, keine abschließende Entscheidung. "
		. 'Antworte ausschließlich mit einem einzigen JSON-Objekt, exakt in dieser Form, ohne Markdown-Codeblock und ohne weiteren Text: '
		. '{"einschaetzung_prozent": <ganzzahl 0-100, wie gut der Text zum Anforderungsprofil passt>, "einschaetzung_text": "<2-4 Sätze Begründung>", "staerken": ["<Stichpunkt>", ...], "moegliche_luecken": ["<Stichpunkt>", ...], "empfehlung": "<einer von: einladen, pruefen, eher_absagen>"}';

	$user_message = 'Position: ' . ( $position ? $position : '(nicht angegeben)' ) . "\n\n"
		. ( $anforderungen ? $anforderungen . "\n\n" : "Kein hinterlegtes Anforderungsprofil zu dieser Position gefunden.\n\n" )
		. "Bewerbungstext (Nachricht aus dem Formular):\n"
		. ( $nachricht ? $nachricht : '(Bewerber hat keine Nachricht hinterlassen – Bewertung nur anhand des Positionstitels möglich.)' );

	$ergebnis = auto_emotion_anthropic_request( $system_prompt, $user_message, 700 );

	if ( $ergebnis['error'] ) {
		wp_safe_redirect( add_query_arg( 'ki_fehler', rawurlencode( $ergebnis['error'] ), home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
		exit;
	}

	$geparst = json_decode( $ergebnis['text'], true );

	if ( ! is_array( $geparst ) || ! isset( $geparst['einschaetzung_text'] ) ) {
		update_post_meta( $post_id, '_bewerbung_ki_rohtext', $ergebnis['text'] );
		update_post_meta( $post_id, '_bewerbung_ki_einschaetzung_text', '' );
		wp_safe_redirect( add_query_arg( 'ki_fehler', rawurlencode( __( 'Antwort der KI konnte nicht gelesen werden – Rohtext wurde gespeichert.', 'auto-emotion' ) ), home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
		exit;
	}

	update_post_meta( $post_id, '_bewerbung_ki_einschaetzung_prozent', isset( $geparst['einschaetzung_prozent'] ) ? absint( $geparst['einschaetzung_prozent'] ) : '' );
	update_post_meta( $post_id, '_bewerbung_ki_einschaetzung_text', sanitize_textarea_field( $geparst['einschaetzung_text'] ) );
	update_post_meta( $post_id, '_bewerbung_ki_staerken', isset( $geparst['staerken'] ) && is_array( $geparst['staerken'] ) ? implode( "\n", array_map( 'sanitize_text_field', $geparst['staerken'] ) ) : '' );
	update_post_meta( $post_id, '_bewerbung_ki_luecken', isset( $geparst['moegliche_luecken'] ) && is_array( $geparst['moegliche_luecken'] ) ? implode( "\n", array_map( 'sanitize_text_field', $geparst['moegliche_luecken'] ) ) : '' );
	update_post_meta( $post_id, '_bewerbung_ki_empfehlung', isset( $geparst['empfehlung'] ) ? sanitize_key( $geparst['empfehlung'] ) : '' );
	update_post_meta( $post_id, '_bewerbung_ki_datum', current_time( 'mysql' ) );
	delete_post_meta( $post_id, '_bewerbung_ki_rohtext' );

	wp_safe_redirect( add_query_arg( 'ki_erstellt', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_einschaetzung', 'auto_emotion_handle_bewerbung_einschaetzung' );
