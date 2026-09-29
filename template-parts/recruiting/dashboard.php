<?php
/**
 * Dashboard-Ansicht des Mitarbeiterbereichs: Übersicht aller Suchprofile.
 * Erwartet: $auto_emotion_profiles (array<WP_Post>)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_status_labels = array(
	'aktiv'    => __( 'Aktiv', 'auto-emotion' ),
	'pausiert' => __( 'Pausiert', 'auto-emotion' ),
	'besetzt'  => __( 'Besetzt', 'auto-emotion' ),
);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php esc_html_e( 'Recruiting – Mitarbeiterbereich – Auto Emotion', 'auto-emotion' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/tokens.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
</head>
<body class="ae-staff">
	<div class="ae-staff__bar">
		<a class="ae-staff__brand" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' ) ); ?>"><?php bloginfo( 'name' ); ?> · <?php esc_html_e( 'Recruiting', 'auto-emotion' ); ?></a>
		<a class="ae-staff__logout" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_recruiting_logout' ), 'auto_emotion_recruiting_logout' ) ); ?>"><?php esc_html_e( 'Abmelden', 'auto-emotion' ); ?></a>
	</div>

	<main class="ae-staff-main">
		<h1><?php esc_html_e( 'Suchprofile', 'auto-emotion' ); ?></h1>
		<p class="ae-staff-main__intro">
			<?php esc_html_e( 'Interne Übersicht offener Positionen. Für jedes Suchprofil generiert das System fertige Such-Links – es werden keine Bewerber-Daten gespeichert, nur eure eigenen Such-Kriterien.', 'auto-emotion' ); ?>
		</p>

		<div class="ae-staff-toolbar">
			<span></span>
			<a class="ae-btn" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/neu/' ) ); ?>"><?php esc_html_e( '+ Neues Suchprofil', 'auto-emotion' ); ?></a>
		</div>

		<?php if ( empty( $auto_emotion_profiles ) ) : ?>
			<p class="ae-empty"><?php esc_html_e( 'Noch keine Suchprofile angelegt.', 'auto-emotion' ); ?></p>
		<?php else : ?>
			<ul class="ae-profile-list">
				<?php foreach ( $auto_emotion_profiles as $auto_emotion_profile ) : ?>
					<?php
					$auto_emotion_status     = get_post_meta( $auto_emotion_profile->ID, '_suchprofil_status', true );
					$auto_emotion_status     = $auto_emotion_status ? $auto_emotion_status : 'aktiv';
					$auto_emotion_standort   = get_post_meta( $auto_emotion_profile->ID, '_suchprofil_standort', true );
					$auto_emotion_art        = get_post_meta( $auto_emotion_profile->ID, '_suchprofil_anstellungsart', true );
					$auto_emotion_links      = auto_emotion_suchprofil_links( $auto_emotion_profile->ID );
					$auto_emotion_edit_url   = home_url( '/mitarbeiter/recruiting/' . $auto_emotion_profile->ID . '/' );
					?>
					<li>
						<div class="ae-profile-list__main">
							<p class="ae-profile-list__title">
								<a href="<?php echo esc_url( $auto_emotion_edit_url ); ?>"><?php echo esc_html( $auto_emotion_profile->post_title ); ?></a>
								<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_status ); ?>">
									<?php echo esc_html( isset( $auto_emotion_status_labels[ $auto_emotion_status ] ) ? $auto_emotion_status_labels[ $auto_emotion_status ] : $auto_emotion_status ); ?>
								</span>
							</p>
							<p class="ae-profile-list__meta">
								<?php echo esc_html( trim( implode( ' · ', array_filter( array( $auto_emotion_standort, $auto_emotion_art ) ) ) ) ); ?>
							</p>
						</div>
						<div class="ae-profile-list__links">
							<?php foreach ( $auto_emotion_links as $auto_emotion_link ) : ?>
								<a href="<?php echo esc_url( $auto_emotion_link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $auto_emotion_link['label'] ); ?> ↗</a>
							<?php endforeach; ?>
						</div>
						<div class="ae-profile-list__actions">
							<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( $auto_emotion_edit_url ); ?>"><?php esc_html_e( 'Bearbeiten', 'auto-emotion' ); ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</main>
</body>
</html>
