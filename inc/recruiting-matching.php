<?php
/**
 * Vorqualifizierung & KI-Einschätzung: vergleicht den Bewerbungstext
 * mit dem Anforderungsprofil der Position (aus einem passenden
 * Suchprofil oder der Stellenbibliothek) über die Anthropic Claude
 * API und liefert eine begründete, auf dem echten Text basierende
 * Einschätzung – kein erfundener Score ohne Grundlage.
 *
 * Braucht einen Anthropic-API-Key, der NICHT im Theme-Code oder in
 * git landet: hinterlegt im WordPress-Customizer ("Auto Emotion
 * Einstellungen" → Feld "Claude API-Key", type=password, dieselbe
 * Einstellung wie für den Chat-Assistenten in inc/chatbot.php – ein
 * Key für beide Funktionen). Alternativ für Fortgeschrittene auch als
 * PHP-Konstante in wp-config.php oder Server-Umgebungsvariable
 * möglich. Ohne Key bleibt die Funktion inaktiv und zeigt im
 * Mitarbeiterbereich eine klare Anleitung statt eines erfundenen
 * Ergebnisses.
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
	$theme_mod_key = get_theme_mod( 'ae_claude_api_key', '' );
	if ( $theme_mod_key ) {
		return $theme_mod_key;
	}

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
 * Sucht die einzelnen Anforderungskriterien zur Positionsbezeichnung
 * einer Bewerbung – erst die Stichworte aus dem eigenen Suchprofil
 * (kommagetrennt), dann die Anforderungen aus der Stellenbibliothek
 * (eine pro Zeile). Liefert ein leeres Array, wenn nichts Passendes
 * gefunden wird (dann bewertet die KI nur anhand des Positionstitels,
 * ohne erfundene Anforderungen). Auf maximal 12 Kriterien begrenzt,
 * damit die KI-Antwort nicht ausufert.
 */
function auto_emotion_anforderungskriterien_fuer_position( $position_titel ) {
	if ( ! $position_titel ) {
		return array();
	}

	$kriterien = array();

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
			$kriterien = array_merge( $kriterien, explode( ',', $stichworte ) );
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
		$anforderungen = get_post_meta( $vorlage_treffer[0]->ID, '_vorlage_anforderungen', true );
		if ( $anforderungen ) {
			$kriterien = array_merge( $kriterien, explode( "\n", $anforderungen ) );
		}
	}

	$kriterien = array_map( 'trim', $kriterien );
	$kriterien = array_values( array_unique( array_filter( $kriterien ) ) );

	return array_slice( $kriterien, 0, 12 );
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

	$name      = get_post_meta( $post_id, '_bewerbung_name', true );
	$position  = get_post_meta( $post_id, '_bewerbung_position', true );
	$nachricht = get_post_meta( $post_id, '_bewerbung_nachricht', true );
	$kriterien = auto_emotion_anforderungskriterien_fuer_position( $position );

	$system_prompt = "Du unterstützt das Recruiting-Team eines Autohauses (Auto Emotion) bei der Vorqualifizierung einer Bewerbung. "
		. "Bewerte ausschließlich anhand des gegebenen Bewerbungstextes und der Kriterienliste – erfinde keine Fähigkeiten, Erfahrungen oder Qualifikationen, die nicht genannt sind. "
		. "Bewerte jedes Kriterium einzeln: 'match' wenn der Text es klar belegt, 'partial' wenn teilweise oder unklar belegt, 'no_match' wenn der Text ihm klar widerspricht, 'unknown' wenn der Text dazu schlicht keine Information enthält. "
		. "WICHTIG: 'unknown' ist nicht dasselbe wie 'no_match' – fehlende Information bedeutet nicht automatisch, dass das Kriterium nicht erfüllt ist, das muss klar unterschieden werden. "
		. "Wenn der Bewerbungstext knapp ist oder wenig Information enthält, sage das ehrlich statt zu spekulieren. "
		. "Dies ist eine unterstützende Einschätzung für die Vorauswahl, keine abschließende Entscheidung. "
		. 'Antworte ausschließlich mit einem einzigen JSON-Objekt, exakt in dieser Form, ohne Markdown-Codeblock und ohne weiteren Text: '
		. '{"einschaetzung_prozent": <ganzzahl 0-100, wie gut der Text insgesamt passt>, "einschaetzung_text": "<2-4 Sätze Gesamteinschätzung>", "kriterien": [{"kriterium": "<genauer Wortlaut aus der Liste>", "status": "<match|partial|no_match|unknown>", "begruendung": "<ein kurzer Satz mit Bezug auf den Text>"}, ...], "empfehlung": "<einer von: einladen, pruefen, eher_absagen>"}';

	$kriterien_text = $kriterien
		? "Zu bewertende Kriterien (eines pro Zeile):\n" . implode( "\n", $kriterien )
		: 'Kein hinterlegtes Anforderungsprofil zu dieser Position gefunden – liefere eine leere "kriterien"-Liste und bewerte nur anhand des Positionstitels.';

	$user_message = 'Position: ' . ( $position ? $position : '(nicht angegeben)' ) . "\n\n"
		. $kriterien_text . "\n\n"
		. "Bewerbungstext (Nachricht aus dem Formular):\n"
		. ( $nachricht ? $nachricht : '(Bewerber hat keine Nachricht hinterlassen – Bewertung nur anhand des Positionstitels möglich.)' );

	$ergebnis = auto_emotion_anthropic_request( $system_prompt, $user_message, 1400 );

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

	$erlaubte_kriterien_status = array( 'match', 'partial', 'no_match', 'unknown' );
	$kriterien_ergebnis        = array();
	if ( isset( $geparst['kriterien'] ) && is_array( $geparst['kriterien'] ) ) {
		foreach ( $geparst['kriterien'] as $kriterien_eintrag ) {
			if ( ! is_array( $kriterien_eintrag ) || empty( $kriterien_eintrag['kriterium'] ) ) {
				continue;
			}
			$kriterien_status = isset( $kriterien_eintrag['status'] ) ? sanitize_key( $kriterien_eintrag['status'] ) : 'unknown';
			if ( ! in_array( $kriterien_status, $erlaubte_kriterien_status, true ) ) {
				$kriterien_status = 'unknown';
			}
			$kriterien_ergebnis[] = array(
				'kriterium'   => sanitize_text_field( $kriterien_eintrag['kriterium'] ),
				'status'      => $kriterien_status,
				'begruendung' => isset( $kriterien_eintrag['begruendung'] ) ? sanitize_text_field( $kriterien_eintrag['begruendung'] ) : '',
			);
		}
	}

	update_post_meta( $post_id, '_bewerbung_ki_einschaetzung_prozent', isset( $geparst['einschaetzung_prozent'] ) ? absint( $geparst['einschaetzung_prozent'] ) : '' );
	update_post_meta( $post_id, '_bewerbung_ki_einschaetzung_text', sanitize_textarea_field( $geparst['einschaetzung_text'] ) );
	update_post_meta( $post_id, '_bewerbung_ki_kriterien', $kriterien_ergebnis );
	update_post_meta( $post_id, '_bewerbung_ki_empfehlung', isset( $geparst['empfehlung'] ) ? sanitize_key( $geparst['empfehlung'] ) : '' );
	update_post_meta( $post_id, '_bewerbung_ki_datum', current_time( 'mysql' ) );
	delete_post_meta( $post_id, '_bewerbung_ki_rohtext' );
	delete_post_meta( $post_id, '_bewerbung_ki_staerken' );
	delete_post_meta( $post_id, '_bewerbung_ki_luecken' );

	wp_safe_redirect( add_query_arg( 'ki_erstellt', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_einschaetzung', 'auto_emotion_handle_bewerbung_einschaetzung' );

/**
 * Erlaubt Recruitern, den Status eines einzelnen KI-Kriteriums von Hand
 * zu übersteuern (z. B. wenn die KI ein Kriterium mangels Information
 * als "unknown" einstuft, der Recruiter aber aus einem Telefonat oder
 * den Unterlagen mehr weiß). Verändert bewusst NICHT den von der KI
 * berechneten Gesamt-Prozentwert/die Empfehlung – eine nachträgliche
 * Neuberechnung würde eine Genauigkeit vortäuschen, die wir ohne
 * bekannte Gewichtung der Kriterien nicht hätten. Die Korrektur steht
 * stattdessen sichtbar neben der ursprünglichen KI-Einschätzung.
 */
function auto_emotion_handle_bewerbung_kriterium_korrigieren() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_bewerbung_kriterien_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_bewerbung_kriterien_nonce'] ) ), 'auto_emotion_bewerbung_kriterien_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || 'bewerbung' !== $post->post_type ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' ) );
		exit;
	}

	$kriterien = get_post_meta( $post_id, '_bewerbung_ki_kriterien', true );
	if ( ! is_array( $kriterien ) ) {
		$kriterien = array();
	}

	$erlaubte_status   = array( 'match', 'partial', 'no_match', 'unknown' );
	$eingereicht       = isset( $_POST['ae_kriterium_status'] ) && is_array( $_POST['ae_kriterium_status'] ) ? wp_unslash( $_POST['ae_kriterium_status'] ) : array();
	$aktueller_nutzer  = wp_get_current_user();
	$etwas_geaendert   = false;

	foreach ( $eingereicht as $index => $neuer_status ) {
		$index       = absint( $index );
		$neuer_status = sanitize_key( $neuer_status );

		if ( ! isset( $kriterien[ $index ] ) || ! in_array( $neuer_status, $erlaubte_status, true ) ) {
			continue;
		}

		if ( $kriterien[ $index ]['status'] === $neuer_status ) {
			continue;
		}

		$kriterien[ $index ]['status']           = $neuer_status;
		$kriterien[ $index ]['korrigiert_von']    = $aktueller_nutzer->display_name;
		$kriterien[ $index ]['korrigiert_am']     = current_time( 'mysql' );
		$etwas_geaendert = true;
	}

	if ( $etwas_geaendert ) {
		update_post_meta( $post_id, '_bewerbung_ki_kriterien', $kriterien );
	}

	wp_safe_redirect( add_query_arg( 'kriterien_korrigiert', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_bewerbung_kriterium_korrigieren', 'auto_emotion_handle_bewerbung_kriterium_korrigieren' );
