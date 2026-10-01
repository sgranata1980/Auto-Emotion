<?php
/**
 * Recruiting-Backend: eigenständiger Mitarbeiterbereich unter /mitarbeiter/
 * für "Suchprofile" – Positionen, die Auto Emotion aktiv besetzen möchte,
 * mit fertigen Such-Links für LinkedIn, Xing & Co.
 *
 * Bewusst KEIN wp-admin-Bereich: eigene Login-Seite, eigenes Dashboard,
 * eigenes Design – nicht die WordPress-Optik. Technisch läuft es über
 * dieses Theme (eigene Rewrite-Routen + eigene Templates), aber ohne
 * jede sichtbare WordPress-Oberfläche.
 *
 * Bewusst ohne Speicherung von Bewerber-Daten: hier werden nur die
 * eigenen Such-Kriterien des Unternehmens gepflegt, nie Kandidaten-
 * Datensätze. Die bestehende E-Mail-only-Bewerbungsstrecke
 * (inc/recruiting.php) bleibt davon komplett unberührt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Eigene, klar benannte Berechtigung statt der generischen "kann
 * Inhalte bearbeiten"-Fähigkeit – Zugriff auf den Recruiting-Bereich
 * ist dadurch unabhängig von sonstigen Redaktionsrechten auf der
 * Website steuerbar. Wird automatisch an Administrator und Redakteur
 * vergeben; weitere Nutzer erhalten sie, indem man ihnen die Rolle
 * "Redakteur" gibt, oder gezielt einzeln über die Nutzerverwaltung.
 */
function auto_emotion_grant_recruiting_capability() {
	$needed_version = '1';
	if ( get_option( 'auto_emotion_recruiting_cap_version' ) === $needed_version ) {
		return;
	}

	foreach ( array( 'administrator', 'editor' ) as $role_name ) {
		$role = get_role( $role_name );
		if ( $role ) {
			$role->add_cap( 'ae_recruiting_zugriff' );
		}
	}

	update_option( 'auto_emotion_recruiting_cap_version', $needed_version );
}
add_action( 'init', 'auto_emotion_grant_recruiting_capability' );

/**
 * Custom Post Type als reiner Datenspeicher für Suchprofile – kein
 * wp-admin-UI, keine öffentliche URL, kein Archiv.
 */
function auto_emotion_register_suchprofil_cpt() {
	register_post_type(
		'suchprofil',
		array(
			'labels'             => array(
				'name'          => __( 'Suchprofile', 'auto-emotion' ),
				'singular_name' => __( 'Suchprofil', 'auto-emotion' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_in_nav_menus'  => false,
			'show_in_admin_bar'  => false,
			'show_in_rest'       => false,
			'show_ui'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'rewrite'            => false,
			'supports'           => array( 'title' ),
		)
	);
}
add_action( 'init', 'auto_emotion_register_suchprofil_cpt' );

/**
 * Reine Such-Links (keine Datenabfrage, keine Kandidaten-Daten) für
 * LinkedIn, Xing und eine Google-X-Ray-Suche aus Titel, Stichworten und
 * Standort eines Suchprofils.
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

	return array(
		'linkedin' => array(
			'label' => __( 'LinkedIn – Personensuche', 'auto-emotion' ),
			'url'   => add_query_arg(
				array(
					'keywords' => rawurlencode( $suchbegriffe ),
					'location' => $standort ? rawurlencode( $standort ) : false,
				),
				'https://www.linkedin.com/search/results/people/'
			),
		),
		'xing'     => array(
			'label' => __( 'Xing – Mitgliedersuche', 'auto-emotion' ),
			'url'   => add_query_arg(
				array( 'keywords' => rawurlencode( $suchbegriffe ) ),
				'https://www.xing.com/search/members'
			),
		),
		'google'   => array(
			'label' => __( 'Google X-Ray-Suche (LinkedIn-Profile)', 'auto-emotion' ),
			'url'   => 'https://www.google.com/search?q=' . rawurlencode(
				'site:linkedin.com/in ' . $suchbegriffe . ( $standort ? ' ' . $standort : '' )
			),
		),
		'indeed'   => array(
			'label'   => __( 'Indeed Smart Sourcing – Lebenslauf-Datenbank (Login erforderlich)', 'auto-emotion' ),
			'url'     => add_query_arg(
				array(
					'co' => 'DE',
					'hl' => 'de',
					'q'  => rawurlencode( $suchbegriffe ),
					'l'  => $standort ? rawurlencode( $standort ) : false,
				),
				'https://resumes.indeed.com/'
			),
			'hinweis' => __( 'Noch kein Arbeitgeber-Konto bei Indeed Smart Sourcing eingerichtet – bitte draufklicken und dort einmalig anlegen.', 'auto-emotion' ),
		),
		'arbeitsagentur' => array(
			'label'   => __( 'Bundesagentur für Arbeit – Bewerberbörse (Login erforderlich)', 'auto-emotion' ),
			'url'     => 'https://www.arbeitsagentur.de/bewerberboerse/',
			'hinweis' => __( 'Noch kein Arbeitgeber-Zugang zur Bewerberbörse eingerichtet – bitte draufklicken und dort einmalig anlegen.', 'auto-emotion' ),
		),
		'stepstone' => array(
			'label'   => __( 'StepStone – CV-Center (Login erforderlich)', 'auto-emotion' ),
			'url'     => 'https://www.stepstone.de/e-recruiting/',
			'hinweis' => __( 'Noch kein Arbeitgeber-Konto bei StepStone eingerichtet – bitte draufklicken und dort einmalig anlegen.', 'auto-emotion' ),
		),
	);
}

/**
 * Eigene Rewrite-Routen unter /mitarbeiter/ – bewusst ohne
 * WordPress-Seiten/Templates im üblichen Sinn, damit der Bereich sich
 * wie eine eigenständige Anwendung anfühlt, nicht wie eine WP-Seite.
 */
function auto_emotion_recruiting_rewrite_rules() {
	add_rewrite_rule( '^mitarbeiter/?$', 'index.php?ae_staff_route=login', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/?$', 'index.php?ae_staff_route=dashboard', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/neu/?$', 'index.php?ae_staff_route=neu', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/([0-9]+)/?$', 'index.php?ae_staff_route=bearbeiten&ae_staff_id=$matches[1]', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/([0-9]+)/kandidaten/export/?$', 'index.php?ae_staff_route=kandidaten_export&ae_staff_id=$matches[1]', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/([0-9]+)/kandidaten/?$', 'index.php?ae_staff_route=kandidaten&ae_staff_id=$matches[1]', 'top' );
	add_rewrite_rule( '^mitarbeiter/recruiting/([0-9]+)/anzeige/?$', 'index.php?ae_staff_route=anzeige&ae_staff_id=$matches[1]', 'top' );
	add_rewrite_rule( '^mitarbeiter/papierkorb/?$', 'index.php?ae_staff_route=papierkorb', 'top' );
	add_rewrite_rule( '^mitarbeiter/uebersicht/?$', 'index.php?ae_staff_route=uebersicht', 'top' );
}
add_action( 'init', 'auto_emotion_recruiting_rewrite_rules' );

function auto_emotion_recruiting_query_vars( $vars ) {
	$vars[] = 'ae_staff_route';
	$vars[] = 'ae_staff_id';
	return $vars;
}
add_filter( 'query_vars', 'auto_emotion_recruiting_query_vars' );

/**
 * Rewrite-Regeln ändern sich nur mit Theme-Updates, nicht bei jedem
 * Request – ohne wp-admin-Zugriff kann hier niemand manuell auf
 * "Permalinks speichern" klicken, daher automatischer Flush bei
 * Versionswechsel.
 */
function auto_emotion_maybe_flush_recruiting_rewrite_rules() {
	$needed_version = '5';
	if ( get_option( 'auto_emotion_staff_rewrite_version' ) !== $needed_version ) {
		flush_rewrite_rules();
		update_option( 'auto_emotion_staff_rewrite_version', $needed_version );
	}
}
add_action( 'init', 'auto_emotion_maybe_flush_recruiting_rewrite_rules', 20 );

/**
 * Zugriffsschutz: nur eingeloggte Mitarbeiter mit Bearbeitungsrecht
 * dürfen Dashboard/Formulare sehen, alle anderen landen beim Login.
 */
function auto_emotion_staff_require_login() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}
}

function auto_emotion_render_template_part( $relative_path, $vars = array() ) {
	extract( $vars ); // phpcs:ignore -- gezielt für die drei bekannten Template-Variablen dieser Datei.
	include AUTO_EMOTION_DIR . '/template-parts/recruiting/' . $relative_path;
}

/**
 * App-Shell (Sidebar + Content-Rahmen) für alle eingeloggten
 * /mitarbeiter/-Seiten – bewusst wie eine native Desktop-Anwendung
 * gestaltet (Sidebar-Navigation, Karten, System-Schriftart), nicht wie
 * eine Website mit Formularen. auto_emotion_staff_shell_start() öffnet
 * <html>/<body> und die Sidebar, auto_emotion_staff_shell_end()
 * schließt alles wieder – der Seiteninhalt dazwischen bleibt Sache des
 * jeweiligen Templates.
 */
function auto_emotion_staff_shell_start( $title, $active = '' ) {
	$neue_bewerbungen = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'   => '_bewerbung_status',
					'value' => 'neu',
				),
			),
		)
	);
	$neue_anzahl = count( $neue_bewerbungen );
	?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( $title ); ?> – <?php bloginfo( 'name' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
</head>
<body class="ae-app">
	<div class="ae-shell">
		<aside class="ae-sidebar">
			<a class="ae-sidebar__brand" href="<?php echo esc_url( home_url( '/mitarbeiter/uebersicht/' ) ); ?>">
				<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/logo-icon-red.png' ); ?>" alt="" width="22" height="22">
				<span>
					<?php bloginfo( 'name' ); ?>
					<small><?php esc_html_e( 'Recruiting', 'auto-emotion' ); ?></small>
				</span>
			</a>
			<nav class="ae-sidebar__nav">
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/uebersicht/' ) ); ?>" class="<?php echo 'uebersicht' === $active ? 'is-active' : ''; ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 11L12 3l9 8M5 10v10h14V10" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>
					<?php esc_html_e( 'Übersicht', 'auto-emotion' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' ) ); ?>" class="<?php echo 'dashboard' === $active ? 'is-active' : ''; ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 13h6V4H4v9Zm0 7h6v-5H4v5Zm10 0h6v-9h-6v9Zm0-16v5h6V4h-6Z" fill="currentColor"/></svg>
					<?php esc_html_e( 'Suchprofile', 'auto-emotion' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/stellenbibliothek/' ) ); ?>" class="<?php echo 'stellenbibliothek' === $active ? 'is-active' : ''; ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 19.5V4.5C4 3.67 4.67 3 5.5 3H18a1 1 0 0 1 1 1v15" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M6.5 3v18M6.5 17H19a2 2 0 0 1 2 2v1H6.5" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>
					<?php esc_html_e( 'Stellenbibliothek', 'auto-emotion' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>" class="<?php echo in_array( $active, array( 'bewerbungen', 'bewerbung' ), true ) ? 'is-active' : ''; ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 2h9l5 5v15H6V2Z" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M9 12h8M9 16h8M9 8h4" stroke="currentColor" stroke-width="1.6"/></svg>
					<?php esc_html_e( 'Bewerbungen', 'auto-emotion' ); ?>
					<?php if ( $neue_anzahl > 0 ) : ?>
						<span class="ae-sidebar__badge"><?php echo esc_html( $neue_anzahl ); ?></span>
					<?php endif; ?>
				</a>
				<div class="ae-sidebar__section"><?php esc_html_e( 'Team', 'auto-emotion' ); ?></div>
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/nachrichten/' ) ); ?>" class="<?php echo 'nachrichten' === $active ? 'is-active' : ''; ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 4h16v12H8l-4 4V4Z" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>
					<?php esc_html_e( 'Nachrichten', 'auto-emotion' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/kontakte/' ) ); ?>" class="<?php echo in_array( $active, array( 'kontakte', 'kontakt' ), true ) ? 'is-active' : ''; ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.6"/><path d="M5 20c1.2-4 4.2-6 7-6s5.8 2 7 6" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>
					<?php esc_html_e( 'Adressbuch', 'auto-emotion' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/papierkorb/' ) ); ?>" class="<?php echo 'papierkorb' === $active ? 'is-active' : ''; ?>" style="margin-top:auto;">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>
					<?php esc_html_e( 'Papierkorb', 'auto-emotion' ); ?>
				</a>
			</nav>
			<div class="ae-sidebar__footer">
				<a href="<?php echo esc_url( home_url( '/mitarbeiter/profil/' ) ); ?>" style="color:<?php echo 'profil' === $active ? 'var(--ae-accent)' : 'var(--ae-text-secondary)'; ?>;"><?php echo esc_html( wp_get_current_user()->display_name ); ?></a>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_recruiting_logout' ), 'auto_emotion_recruiting_logout' ) ); ?>"><?php esc_html_e( 'Abmelden', 'auto-emotion' ); ?></a>
			</div>
		</aside>
		<main class="ae-content">
			<div class="ae-topbar">
				<a class="ae-topbar__user" href="<?php echo esc_url( home_url( '/mitarbeiter/profil/' ) ); ?>">
					<?php echo get_avatar( get_current_user_id(), 32 ); ?>
					<span class="ae-topbar__userinfo">
						<strong><?php echo esc_html( wp_get_current_user()->display_name ); ?></strong>
						<small><?php echo esc_html( wp_get_current_user()->user_email ); ?></small>
					</span>
				</a>
			</div>
	<?php
}

function auto_emotion_staff_shell_end() {
	?>
			<footer class="ae-footer">
				<span><?php echo esc_html( auto_emotion_contact( 'company' ) ); ?> · <?php echo esc_html( auto_emotion_contact( 'street' ) ); ?>, <?php echo esc_html( auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?></span>
				<nav class="ae-footer__links">
					<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
					<?php $auto_emotion_impressum_url = auto_emotion_page_template_url( 'page-impressum.php' ); ?>
					<?php if ( $auto_emotion_impressum_url ) : ?>
						<a href="<?php echo esc_url( $auto_emotion_impressum_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Impressum', 'auto-emotion' ); ?></a>
					<?php endif; ?>
					<?php $auto_emotion_datenschutz_url = auto_emotion_page_template_url( 'page-datenschutz.php' ); ?>
					<?php if ( $auto_emotion_datenschutz_url ) : ?>
						<a href="<?php echo esc_url( $auto_emotion_datenschutz_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Datenschutz', 'auto-emotion' ); ?></a>
					<?php endif; ?>
				</nav>
			</footer>
		</main>
	</div>
</body>
</html>
	<?php
}

/**
 * Ermittelt die echte, tatsächlich veröffentlichte URL einer Seite anhand
 * ihres zugewiesenen Seitenvorlagen-Dateinamens (z. B. "page-impressum.php").
 * Bewusst dynamisch statt eines hartcodierten Pfads wie "/impressum/" –
 * verhindert einen toten oder falschen Link im Recruiting-Footer, falls
 * sich der Permalink der echten Seite im WP-Admin je ändert. Liefert
 * false, wenn keine Seite mit dieser Vorlage existiert (Link wird dann
 * im Footer schlicht ausgeblendet statt eine erfundene URL zu zeigen).
 */
function auto_emotion_page_template_url( $template_file ) {
	static $cache = array();
	if ( isset( $cache[ $template_file ] ) ) {
		return $cache[ $template_file ];
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $template_file,
			'fields'         => 'ids',
		)
	);

	$url                     = ! empty( $pages ) ? get_permalink( $pages[0] ) : false;
	$cache[ $template_file ] = $url;

	return $url;
}

/**
 * Sammelt die echten Kennzahlen für die Übersichts-/Dashboard-Startseite:
 * Suchprofile, Bewerbungen, Status-Verteilung, neueste Bewerbungen.
 * Bewusst ausschließlich eigene, real vorhandene Daten – keine
 * erfundenen Kennzahlen wie Antwortquote/Conversion, die wir mangels
 * eigener Kampagnen-/Tracking-Daten gar nicht ehrlich berechnen können.
 */
function auto_emotion_uebersicht_daten() {
	$suchprofile = get_posts(
		array(
			'post_type'      => 'suchprofil',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		)
	);

	$aktive_suchprofile = 0;
	foreach ( $suchprofile as $profil ) {
		$status = get_post_meta( $profil->ID, '_suchprofil_status', true );
		if ( ! $status || 'aktiv' === $status ) {
			++$aktive_suchprofile;
		}
	}

	$alle_bewerbungen = get_posts(
		array(
			'post_type'      => 'bewerbung',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	$status_labels     = function_exists( 'auto_emotion_bewerbung_status_labels' ) ? auto_emotion_bewerbung_status_labels() : array();
	$status_verteilung = array_fill_keys( array_keys( $status_labels ), 0 );

	$diese_woche_start = strtotime( 'monday this week', current_time( 'timestamp' ) ); // phpcs:ignore -- lokale Wochenauswertung, keine Zeitzonen-Sonderfälle relevant.
	$bewerbungen_diese_woche = 0;

	foreach ( $alle_bewerbungen as $bewerbung ) {
		$status = get_post_meta( $bewerbung->ID, '_bewerbung_status', true );
		$status = $status ? $status : 'neu';
		if ( isset( $status_verteilung[ $status ] ) ) {
			++$status_verteilung[ $status ];
		}
		if ( get_the_date( 'U', $bewerbung ) >= $diese_woche_start ) {
			++$bewerbungen_diese_woche;
		}
	}

	$auto_emotion_feedback = function_exists( 'auto_emotion_feedback_kennzahlen' ) ? auto_emotion_feedback_kennzahlen() : array(
		'anzahl'       => 0,
		'nps'          => 0,
		'durchschnitt' => 0,
	);

	return array(
		'auto_emotion_suchprofile_gesamt'    => count( $suchprofile ),
		'auto_emotion_suchprofile_aktiv'     => $aktive_suchprofile,
		'auto_emotion_bewerbungen_gesamt'    => count( $alle_bewerbungen ),
		'auto_emotion_bewerbungen_woche'     => $bewerbungen_diese_woche,
		'auto_emotion_status_verteilung'     => $status_verteilung,
		'auto_emotion_status_labels'         => $status_labels,
		'auto_emotion_neueste_bewerbungen'   => array_slice( $alle_bewerbungen, 0, 6 ),
		'auto_emotion_feedback'              => $auto_emotion_feedback,
	);
}

/**
 * Router für die /mitarbeiter/-Routen. Gibt komplett eigenständiges
 * HTML aus (kein get_header()/get_footer(), keine WP-Theme-Chrome).
 */
function auto_emotion_recruiting_template_redirect() {
	$route = get_query_var( 'ae_staff_route' );

	if ( ! $route ) {
		return;
	}

	switch ( $route ) {

		case 'login':
			if ( is_user_logged_in() && current_user_can( 'ae_recruiting_zugriff' ) ) {
				wp_safe_redirect( home_url( '/mitarbeiter/uebersicht/' ) );
				exit;
			}
			$auto_emotion_login_error      = isset( $_GET['login_failed'] );
			$auto_emotion_passwort_geaendert = isset( $_GET['passwort_geaendert'] );
			auto_emotion_render_template_part(
				'login.php',
				array(
					'auto_emotion_login_error'        => $auto_emotion_login_error,
					'auto_emotion_passwort_geaendert' => $auto_emotion_passwort_geaendert,
				)
			);
			exit;

		case 'dashboard':
			auto_emotion_staff_require_login();
			$auto_emotion_profiles = get_posts(
				array(
					'post_type'      => 'suchprofil',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				)
			);
			auto_emotion_render_template_part( 'dashboard.php', array( 'auto_emotion_profiles' => $auto_emotion_profiles ) );
			exit;

		case 'uebersicht':
			auto_emotion_staff_require_login();
			auto_emotion_render_template_part( 'uebersicht.php', auto_emotion_uebersicht_daten() );
			exit;

		case 'neu':
			auto_emotion_staff_require_login();
			auto_emotion_render_template_part( 'form.php', array( 'auto_emotion_form_post' => null ) );
			exit;

		case 'bearbeiten':
			auto_emotion_staff_require_login();
			$auto_emotion_id   = absint( get_query_var( 'ae_staff_id' ) );
			$auto_emotion_post = get_post( $auto_emotion_id );
			if ( ! $auto_emotion_post || 'suchprofil' !== $auto_emotion_post->post_type ) {
				wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
				exit;
			}
			auto_emotion_render_template_part( 'form.php', array( 'auto_emotion_form_post' => $auto_emotion_post ) );
			exit;

		case 'kandidaten':
		case 'kandidaten_export':
			auto_emotion_staff_require_login();
			$auto_emotion_id   = absint( get_query_var( 'ae_staff_id' ) );
			$auto_emotion_post = get_post( $auto_emotion_id );
			if ( ! $auto_emotion_post || 'suchprofil' !== $auto_emotion_post->post_type ) {
				wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
				exit;
			}

			if ( 'kandidaten_export' === $route ) {
				auto_emotion_export_kandidaten_csv( $auto_emotion_post );
				exit;
			}

			auto_emotion_render_template_part( 'kandidaten.php', array( 'auto_emotion_form_post' => $auto_emotion_post ) );
			exit;

		case 'anzeige':
			auto_emotion_staff_require_login();
			$auto_emotion_id   = absint( get_query_var( 'ae_staff_id' ) );
			$auto_emotion_post = get_post( $auto_emotion_id );
			if ( ! $auto_emotion_post || 'suchprofil' !== $auto_emotion_post->post_type ) {
				wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
				exit;
			}
			auto_emotion_render_template_part( 'anzeige.php', array( 'auto_emotion_form_post' => $auto_emotion_post ) );
			exit;

		case 'papierkorb':
			auto_emotion_staff_require_login();
			$auto_emotion_papierkorb_items = get_posts(
				array(
					'post_type'      => array( 'suchprofil', 'bewerbung', 'kontakt', 'nachricht', 'stellenvorlage' ),
					'post_status'    => 'trash',
					'posts_per_page' => -1,
					'orderby'        => 'modified',
					'order'          => 'DESC',
				)
			);
			auto_emotion_render_template_part( 'papierkorb.php', array( 'auto_emotion_papierkorb_items' => $auto_emotion_papierkorb_items ) );
			exit;
	}
}
add_action( 'template_redirect', 'auto_emotion_recruiting_template_redirect' );

/**
 * Generiert fertigen, kopierbaren Text für die manuelle Veröffentlichung
 * einer Stelle auf externen Portalen (Bundesagentur für Arbeit/
 * JOBBÖRSE, Indeed, StepStone) sowie eine kürzere Caption für Social
 * Media (Instagram/TikTok/LinkedIn). Bewusst nur Text-Generierung, kein
 * automatisches Posten – dafür gibt es keine öffentliche Schreib-API
 * der Bundesagentur, und ein automatisiertes Posten auf Social Media
 * bräuchte eigene, von Auto Emotion selbst zu beantragende
 * Business-API-Zugänge je Plattform.
 */
function auto_emotion_stellenanzeige_texte( $post ) {
	$standort      = get_post_meta( $post->ID, '_suchprofil_standort', true );
	$standort      = $standort ? $standort : 'Offenbach am Main';
	$anstellungsart_labels = array(
		'vollzeit'    => 'Vollzeit',
		'teilzeit'    => 'Teilzeit',
		'ausbildung'  => 'Ausbildung',
		'werkstudent' => 'Werkstudent/in',
		'praktikum'   => 'Praktikum',
	);
	$art_key       = get_post_meta( $post->ID, '_suchprofil_anstellungsart', true );
	$art           = isset( $anstellungsart_labels[ $art_key ] ) ? $anstellungsart_labels[ $art_key ] : '';
	$stichworte    = get_post_meta( $post->ID, '_suchprofil_stichworte', true );
	$bewerbungslink = get_post_meta( $post->ID, '_suchprofil_bewerbungslink', true );
	$bewerbungslink = $bewerbungslink ? $bewerbungslink : home_url( '/' );

	$anzeige  = $post->post_title . "\n";
	$anzeige .= $standort . ( $art ? ' · ' . $art : '' ) . "\n\n";
	$anzeige .= "Auto Emotion GmbH & Co. KG ist seit 2001 SEAT-, CUPRA- und NISSAN-Partner in Offenbach am Main. Für unser Team suchen wir Verstärkung als " . $post->post_title . ".\n\n";

	if ( $stichworte ) {
		$anzeige .= "Was du mitbringst: " . $stichworte . "\n\n";
	}

	$anzeige .= "Interesse? Jetzt bewerben: " . $bewerbungslink . "\n";
	$anzeige .= "Oder direkt anrufen: " . auto_emotion_contact( 'phone' ) . "\n";

	$caption  = '🔧 Wir suchen: ' . $post->post_title . "\n📍 " . $standort . "\n\n";
	$caption .= "Lust auf einen Job bei SEAT, CUPRA & NISSAN in Offenbach? Jetzt bewerben – Link in der Bio / " . $bewerbungslink . "\n\n";
	$stellen_hashtag = str_replace( array( ' ', '-' ), '', ucwords( str_replace( array( '(m/w/d)', '/', '-' ), ' ', $post->post_title ) ) );
	$caption        .= '#AutoEmotion #Jobs' . $stellen_hashtag . ' #Offenbach #Seat #Cupra #Nissan #Autohaus #Stellenangebot';

	return array(
		'anzeige' => $anzeige,
		'caption' => $caption,
	);
}

/**
 * Manuelle Kandidatenliste pro Suchprofil: die Mitarbeiter klicken sich
 * selbst über die generierten Such-Links durch LinkedIn/Xing und tragen
 * vielversprechende Kandidaten hier von Hand ein – bewusst KEIN
 * automatisches Sammeln/Scrapen von Profildaten (verstieße gegen die
 * Nutzungsbedingungen der Plattformen).
 */
function auto_emotion_get_kandidaten( $post_id ) {
	$kandidaten = get_post_meta( $post_id, '_suchprofil_kandidaten', true );
	return is_array( $kandidaten ) ? $kandidaten : array();
}

function auto_emotion_handle_kandidat_save() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_POST['ae_suchprofil_id'] ) ? absint( $_POST['ae_suchprofil_id'] ) : 0;

	if ( ! isset( $_POST['auto_emotion_kandidat_save_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_kandidat_save_nonce'] ) ), 'auto_emotion_kandidat_save_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || 'suchprofil' !== $post->post_type ) {
		wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
		exit;
	}

	$name       = isset( $_POST['ae_kandidat_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_kandidat_name'] ) ) : '';
	$profil_url = isset( $_POST['ae_kandidat_profil'] ) ? esc_url_raw( wp_unslash( $_POST['ae_kandidat_profil'] ) ) : '';
	$notiz      = isset( $_POST['ae_kandidat_notiz'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_kandidat_notiz'] ) ) : '';

	if ( $name ) {
		$kandidaten   = auto_emotion_get_kandidaten( $post_id );
		$kandidaten[] = array(
			'id'         => wp_generate_password( 12, false ),
			'name'       => $name,
			'profil_url' => $profil_url,
			'notiz'      => $notiz,
			'hinzugefuegt_am' => current_time( 'd.m.Y' ),
		);
		update_post_meta( $post_id, '_suchprofil_kandidaten', $kandidaten );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' . $post_id . '/kandidaten/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_kandidat_save', 'auto_emotion_handle_kandidat_save' );

function auto_emotion_handle_kandidat_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id     = isset( $_GET['ae_suchprofil_id'] ) ? absint( $_GET['ae_suchprofil_id'] ) : 0;
	$kandidat_id = isset( $_GET['ae_kandidat_id'] ) ? sanitize_text_field( wp_unslash( $_GET['ae_kandidat_id'] ) ) : '';

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_kandidat_delete_' . $post_id . '_' . $kandidat_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$kandidaten = auto_emotion_get_kandidaten( $post_id );
	$kandidaten = array_values(
		array_filter(
			$kandidaten,
			function ( $kandidat ) use ( $kandidat_id ) {
				return $kandidat['id'] !== $kandidat_id;
			}
		)
	);
	update_post_meta( $post_id, '_suchprofil_kandidaten', $kandidaten );

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' . $post_id . '/kandidaten/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_kandidat_delete', 'auto_emotion_handle_kandidat_delete' );

/**
 * Streamt die Kandidatenliste eines Suchprofils als CSV-Download.
 */
function auto_emotion_export_kandidaten_csv( $post ) {
	$kandidaten = auto_emotion_get_kandidaten( $post->ID );

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="kandidaten-' . sanitize_title( $post->post_title ) . '.csv"' );

	$out = fopen( 'php://output', 'w' ); // phpcs:ignore -- gezielter CSV-Stream, kein WP_Filesystem nötig.
	fputcsv( $out, array( 'Name', 'Profil-Link', 'Notiz', 'Hinzugefügt am' ) );
	foreach ( $kandidaten as $kandidat ) {
		fputcsv( $out, array( $kandidat['name'], $kandidat['profil_url'], $kandidat['notiz'], $kandidat['hinzugefuegt_am'] ) );
	}
	fclose( $out ); // phpcs:ignore
}

/**
 * Login-Handler: authentifiziert gegen die bestehenden WordPress-
 * Benutzerkonten (wp_signon) – kein separates Zugangssystem nötig.
 */
function auto_emotion_handle_recruiting_login() {
	if ( ! isset( $_POST['auto_emotion_recruiting_login_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_recruiting_login_nonce'] ) ), 'auto_emotion_recruiting_login' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/?login_failed=1' ) );
		exit;
	}

	$creds = array(
		'user_login'    => isset( $_POST['ae_login_user'] ) ? sanitize_user( wp_unslash( $_POST['ae_login_user'] ) ) : '',
		'user_password' => isset( $_POST['ae_login_pass'] ) ? (string) wp_unslash( $_POST['ae_login_pass'] ) : '',
		'remember'      => true,
	);

	$user = wp_signon( $creds, is_ssl() );

	if ( is_wp_error( $user ) || ! user_can( $user, 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/?login_failed=1' ) );
		exit;
	}

	wp_safe_redirect( home_url( '/mitarbeiter/uebersicht/' ) );
	exit;
}
add_action( 'admin_post_nopriv_auto_emotion_recruiting_login', 'auto_emotion_handle_recruiting_login' );
add_action( 'admin_post_auto_emotion_recruiting_login', 'auto_emotion_handle_recruiting_login' );

function auto_emotion_handle_recruiting_logout() {
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_recruiting_logout' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	wp_logout();
	wp_safe_redirect( home_url( '/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_recruiting_logout', 'auto_emotion_handle_recruiting_logout' );

/**
 * Speichert ein Suchprofil (neu oder bestehend).
 */
function auto_emotion_handle_recruiting_save() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	if ( ! isset( $_POST['auto_emotion_recruiting_save_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['auto_emotion_recruiting_save_nonce'] ) ), 'auto_emotion_recruiting_save' ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen. Bitte zurückgehen und erneut versuchen.', 'auto-emotion' ) );
	}

	$post_id = isset( $_POST['ae_profile_id'] ) ? absint( $_POST['ae_profile_id'] ) : 0;
	$titel   = isset( $_POST['ae_titel'] ) ? sanitize_text_field( wp_unslash( $_POST['ae_titel'] ) ) : '';

	if ( ! $titel ) {
		wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
		exit;
	}

	$post_data = array(
		'post_title'  => $titel,
		'post_type'   => 'suchprofil',
		'post_status' => 'publish',
	);

	if ( $post_id ) {
		$existing = get_post( $post_id );
		if ( ! $existing || 'suchprofil' !== $existing->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
			exit;
		}
		$post_data['ID'] = $post_id;
		wp_update_post( $post_data );
	} else {
		$post_id = wp_insert_post( $post_data );
	}

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		$felder = array(
			'ae_standort'         => '_suchprofil_standort',
			'ae_anstellungsart'   => '_suchprofil_anstellungsart',
			'ae_status'           => '_suchprofil_status',
			'ae_stichworte'       => '_suchprofil_stichworte',
			'ae_bewerbungslink'   => '_suchprofil_bewerbungslink',
		);
		foreach ( $felder as $feld_name => $meta_key ) {
			if ( isset( $_POST[ $feld_name ] ) ) {
				$wert = '_suchprofil_bewerbungslink' === $meta_key ? esc_url_raw( wp_unslash( $_POST[ $feld_name ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $feld_name ] ) );
				update_post_meta( $post_id, $meta_key, $wert );
			}
		}
	}

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_recruiting_save', 'auto_emotion_handle_recruiting_save' );

/**
 * Verschiebt ein Suchprofil in den Papierkorb (reversibel, kein
 * endgültiges Löschen).
 */
function auto_emotion_handle_recruiting_delete() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_profile_id'] ) ? absint( $_GET['ae_profile_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_recruiting_delete_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && 'suchprofil' === $post->post_type && current_user_can( 'edit_post', $post_id ) ) {
		wp_trash_post( $post_id );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/recruiting/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_recruiting_delete', 'auto_emotion_handle_recruiting_delete' );

/**
 * Sichtbarer, aber schlichter Einstiegspunkt im Footer – führt zur
 * eigenen Login-Seite des Mitarbeiterbereichs (nicht wp-login.php).
 */
function auto_emotion_staff_login_url() {
	return home_url( '/mitarbeiter/' );
}

/**
 * Papierkorb: Suchprofile und Bewerbungen landen beim Löschen zunächst
 * hier (reversibel), statt endgültig zu verschwinden. WordPress räumt
 * den Papierkorb ohnehin nach 30 Tagen automatisch ab (inkl. der
 * zugehörigen Bewerbungs-Dateien, siehe before_delete_post-Hook in
 * inc/recruiting-bewerbungen.php).
 */
function auto_emotion_handle_papierkorb_wiederherstellen() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_post_id'] ) ? absint( $_GET['ae_post_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_papierkorb_wiederherstellen_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && in_array( $post->post_type, array( 'suchprofil', 'bewerbung', 'kontakt', 'nachricht', 'stellenvorlage' ), true ) ) {
		wp_untrash_post( $post_id );
		/**
		 * wp_untrash_post() verlässt sich auf den vor dem Löschen
		 * gespeicherten Status (_wp_trash_meta_status) – bei diesen
		 * beiden Custom Post Types kam das unzuverlässig leer zurück,
		 * sodass der Eintrag zwar nicht mehr im Papierkorb war, aber
		 * auch nirgends sonst auftauchte. Status hier explizit
		 * erzwingen, damit er garantiert wieder sichtbar ist.
		 */
		wp_update_post(
			array(
				'ID'          => $post_id,
				'post_status' => 'publish',
			)
		);
	}

	wp_safe_redirect( home_url( '/mitarbeiter/papierkorb/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_papierkorb_wiederherstellen', 'auto_emotion_handle_papierkorb_wiederherstellen' );

function auto_emotion_handle_papierkorb_endgueltig_loeschen() {
	if ( ! is_user_logged_in() || ! current_user_can( 'ae_recruiting_zugriff' ) ) {
		wp_safe_redirect( home_url( '/mitarbeiter/' ) );
		exit;
	}

	$post_id = isset( $_GET['ae_post_id'] ) ? absint( $_GET['ae_post_id'] ) : 0;

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'auto_emotion_papierkorb_loeschen_' . $post_id ) ) {
		wp_die( esc_html__( 'Sicherheitsprüfung fehlgeschlagen.', 'auto-emotion' ) );
	}

	$post = get_post( $post_id );
	if ( $post && in_array( $post->post_type, array( 'suchprofil', 'bewerbung', 'kontakt', 'nachricht', 'stellenvorlage' ), true ) ) {
		wp_delete_post( $post_id, true );
	}

	wp_safe_redirect( home_url( '/mitarbeiter/papierkorb/' ) );
	exit;
}
add_action( 'admin_post_auto_emotion_papierkorb_endgueltig_loeschen', 'auto_emotion_handle_papierkorb_endgueltig_loeschen' );
