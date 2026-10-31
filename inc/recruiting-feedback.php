<?php
/**
 * Candidate-Experience-Feedback: nach Abschluss eines Bewerbungsprozesses
 * (Absage oder Einstellung) kann ein Mitarbeiter eine kurze, anonyme-für-
 * Dritte Rückmeldungsanfrage an den/die Bewerber:in schicken – angelehnt
 * an "Hiring Intelligence"-Tools wie Starred (Candidate-NPS). Der Link
 * führt auf eine eigenständige, nicht eingeloggte öffentliche Seite
 * (kein Mitarbeiterbereich-Zugang nötig).
 *
 * Bewusst manuell ausgelöst statt automatisch bei jedem Status-Wechsel:
 * die Mitarbeiter entscheiden pro Bewerbung, ob/wann eine Anfrage
 * sinnvoll ist, statt dass Bewerber ungefragt Massen-E-Mails bekommen.
 *
 * Speichert ausschließlich, was der/die Bewerber:in selbst einträgt –
 * keine erfundenen oder automatisch generierten Bewertungen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function auto_emotion_feedback_rewrite_rules() {
	add_rewrite_rule( '^bewerbung-feedback/([a-zA-Z0-9]+)/?$', 'index.php?ae_feedback_token=$matches[1]', 'top' );
}
add_action( 'init', 'auto_emotion_feedback_rewrite_rules' );

function auto_emotion_feedback_query_vars( $vars ) {
	$vars[] = 'ae_feedback_token';
	return $vars;
}
add_filter( 'query_vars', 'auto_emotion_feedback_query_vars' );

function auto_emotion_maybe_flush_feedback_rewrite_rules() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_feedback_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_feedback_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_feedback_rewrite_rules', 20 );

/**
 * Öffentliche, nicht eingeloggte Feedback-Seite. Bewusst kein
 * staff_require_login() – Bewerber haben keinen Mitarbeiterbereich-
 * Zugang, der Token selbst dient als Zugriffsschlüssel.
 */
function auto_emotion_feedback_template_redirect() {
	$token = get_query_var( 'ae_feedback_token' );
	if ( ! $token ) {
		return;
	}

	$treffer = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- eindeutiger Token-Lookup, keine große Ergebnismenge.
				array(
					'key'   => '_bewerbung_feedback_token',
					'value' => $token,
				),
			),
		)
	);

	if ( empty( $treffer ) ) {
		auto_emotion_render_template_part( 'bewerbung-feedback.php', array( 'auto_emotion_feedback_post' => null ) );
		exit;
	}

	auto_emotion_render_template_part(
		'bewerbung-feedback.php',
		array(
			'auto_emotion_feedback_post'  => $treffer[0],
			'auto_emotion_feedback_token' => $token,
		)
	);
	exit;
}
add_action( 'template_redirect', 'auto_emotion_feedback_template_redirect' );

/**
 * Löst eine Feedback-Anfrage aus: erzeugt (falls noch nicht vorhanden)
 * einen Zugriffs-Token und verschickt den Link per E-Mail an die vom
 * Bewerber selbst angegebene Adresse.
 */
function auto_emotion_handle_feedback_anfragen() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_bewerbung_id'] ) ? absint( $_POST['ae_bewerbung_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_feedback_anfragen_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_feedback_anfragen_nonce'] ) ), 'auto_emotion_feedback_anfragen_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post           = get_post( $post_id );
	$bewerber_email = $post ? get_post_meta( $post_id, '_bewerbung_email', true ) : '';

	if ( ! $post || 'bewerbung' !== $post->post_type || ! is_email( $bewerber_email ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) );
		exit;
	}

	$token = get_post_meta( $post_id, '_bewerbung_feedback_token', true );
	if ( ! $token ) {
		$token = bin2hex( random_bytes( 16 ) );
		update_post_meta( $post_id, '_bewerbung_feedback_token', $token );
	}

	$name  = get_post_meta( $post_id, '_bewerbung_name', true );
	$link  = home_url( '/bewerbung-feedback/' . $token . '/' );

	$betreff = __( 'Kurzes Feedback zu deiner Bewerbung bei Auto Emotion', 'auto-emotion' );
	$text    = sprintf(
		/* translators: 1: Name, 2: Link zur Feedback-Seite */
		__( "Liebe/r %1\$s,\n\nwir würden uns sehr über eine kurze, ehrliche Rückmeldung zu deiner Bewerbungserfahrung bei Auto Emotion freuen – das dauert nur eine Minute:\n\n%2\$s\n\nVielen Dank!\nDein Auto Emotion Team", 'auto-emotion' ),
		$name,
		$link
	);

	$eigener_absender = auto_emotion_contact( 'email' );
	$headers          = $eigener_absender ? array( 'Reply-To: ' . $eigener_absender ) : array();
	wp_mail( $bewerber_email, $betreff, $text, $headers );

	update_post_meta( $post_id, '_bewerbung_feedback_angefragt_am', current_time( 'mysql' ) );

	wp_safe_redirect( add_query_arg( 'feedback_angefragt', '1', home_url( '/mitarbeiter/bewerbungen/' . $post_id . '/' ) ) );
	exit;
}
add_action( 'admin_post_auto_emotion_feedback_anfragen', 'auto_emotion_handle_feedback_anfragen' );

/**
 * Nimmt die Antwort eines Bewerbers entgegen. Öffentlich erreichbar
 * (admin_post_nopriv), der Token übernimmt die Zugriffskontrolle. Jeder
 * Token kann nur einmal beantwortet werden.
 */
function auto_emotion_handle_feedback_absenden() {
	$token = isset( $_POST['ae_feedback_token'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_feedback_token'] ) ) : '';

	if ( ! $token ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	$treffer = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- eindeutiger Token-Lookup, keine große Ergebnismenge.
				array(
					'key'   => '_bewerbung_feedback_token',
					'value' => $token,
				),
			),
		)
	);

	if ( empty( $treffer ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	$post_id = $treffer[0]->ID;

	if ( ! get_post_meta( $post_id, '_bewerbung_feedback_beantwortet', true )
		&& isset( $_POST['auto_emotion_feedback_absenden_nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_feedback_absenden_nonce'] ) ), 'auto_emotion_feedback_absenden_' . $token )
	) {
		$score = isset( $_POST['ae_feedback_score'] ) ? absint( $_POST['ae_feedback_score'] ) : -1;

		if ( $score >= 0 && $score <= 10 ) {
			$kommentar = isset( $_POST['ae_feedback_kommentar'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ae_feedback_kommentar'] ) ) : '';

			update_post_meta( $post_id, '_bewerbung_feedback_score', $score );
			update_post_meta( $post_id, '_bewerbung_feedback_kommentar', $kommentar );
			update_post_meta( $post_id, '_bewerbung_feedback_beantwortet', 1 );
			update_post_meta( $post_id, '_bewerbung_feedback_beantwortet_am', current_time( 'mysql' ) );
		}
	}

	wp_safe_redirect( home_url( '/bewerbung-feedback/' . $token . '/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_feedback_absenden', 'auto_emotion_handle_feedback_absenden' );
add_action( 'admin_post_nopriv_auto_emotion_feedback_absenden', 'auto_emotion_handle_feedback_absenden' );

/**
 * Candidate-Experience-Kennzahlen fürs Dashboard: Net Promoter Score
 * (Promotoren 9–10 minus Detraktoren 0–6, in Prozent) plus
 * Durchschnittswert und Anzahl echter Rückmeldungen. Liefert 'anzahl'
 * = 0, wenn noch niemand geantwortet hat – die Übersicht zeigt dann
 * bewusst "noch keine Rückmeldungen" statt einer erfundenen Zahl.
 */
function auto_emotion_feedback_kennzahlen() {
	$antworten = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- kleine, interne Ergebnismenge (eigene Bewerbungen).
				array(
					'key'   => '_bewerbung_feedback_beantwortet',
					'value' => 1,
				),
			),
		)
	);

	$anzahl     = count( $antworten );
	$promotoren = 0;
	$detraktoren = 0;
	$summe      = 0;

	foreach ( $antworten as $antwort ) {
		$score = (int) get_post_meta( $antwort->ID, '_bewerbung_feedback_score', true );
		$summe += $score;
		if ( $score >= 9 ) {
			++$promotoren;
		} elseif ( $score <= 6 ) {
			++$detraktoren;
		}
	}

	$nps         = $anzahl > 0 ? (int) round( ( ( $promotoren - $detraktoren ) / $anzahl ) * 100 ) : 0;
	$durchschnitt = $anzahl > 0 ? round( $summe / $anzahl, 1 ) : 0;

	return array(
		'anzahl'       => $anzahl,
		'nps'          => $nps,
		'durchschnitt' => $durchschnitt,
	);
}
