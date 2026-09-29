<?php
/**
 * Übersicht aller gespeicherten Bewerbungen im Mitarbeiterbereich.
 * Erwartet: $auto_emotion_bewerbungen (array<WP_Post>)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php esc_html_e( 'Bewerbungen – Mitarbeiterbereich – Auto Emotion', 'auto-emotion' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/tokens.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
</head>
<body class="ae-staff">
	<?php get_template_part( 'template-parts/recruiting/staff-nav' ); ?>

	<main class="ae-staff-main">
		<h1><?php esc_html_e( 'Bewerbungen', 'auto-emotion' ); ?></h1>
		<p class="ae-staff-main__intro">
			<?php esc_html_e( 'Eingehende Bewerbungen aus den Karriere-Formularen. Unterlagen sind nur hier, geschützt, einsehbar und lassen sich an Kollegen weiterleiten – nie über eine öffentliche URL.', 'auto-emotion' ); ?>
		</p>

		<div class="ae-status-tabs">
			<a href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>" class="<?php echo empty( $auto_emotion_filter_status ) ? 'is-active' : ''; ?>"><?php esc_html_e( 'Alle', 'auto-emotion' ); ?></a>
			<?php foreach ( auto_emotion_bewerbung_status_labels() as $auto_emotion_status_key => $auto_emotion_status_label ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'status', $auto_emotion_status_key, home_url( '/mitarbeiter/bewerbungen/' ) ) ); ?>" class="<?php echo $auto_emotion_filter_status === $auto_emotion_status_key ? 'is-active' : ''; ?>"><?php echo esc_html( $auto_emotion_status_label ); ?></a>
			<?php endforeach; ?>
		</div>

		<?php if ( empty( $auto_emotion_bewerbungen ) ) : ?>
			<p class="ae-empty"><?php esc_html_e( 'Noch keine Bewerbungen eingegangen.', 'auto-emotion' ); ?></p>
			<?php if ( empty( $auto_emotion_filter_status ) ) : ?>
				<p class="ae-empty"><a class="ae-btn ae-btn--ghost" style="width:auto;" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_recruiting_seed_demo' ), 'auto_emotion_recruiting_seed_demo' ) ); ?>"><?php esc_html_e( 'Testdaten laden (temporär)', 'auto-emotion' ); ?></a></p>
			<?php endif; ?>
		<?php else : ?>
			<ul class="ae-profile-list">
				<?php foreach ( $auto_emotion_bewerbungen as $auto_emotion_bewerbung ) : ?>
					<?php
					$auto_emotion_position = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_position', true );
					$auto_emotion_telefon  = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_telefon', true );
					$auto_emotion_dateien  = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_dateien', true );
					$auto_emotion_detail_url = home_url( '/mitarbeiter/bewerbungen/' . $auto_emotion_bewerbung->ID . '/' );
					?>
					<li>
						<?php
						$auto_emotion_status_val    = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_status', true );
						$auto_emotion_status_val    = $auto_emotion_status_val ? $auto_emotion_status_val : 'neu';
						$auto_emotion_status_labels = auto_emotion_bewerbung_status_labels();
						$auto_emotion_bewertung_val = (int) get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_bewertung', true );
						?>
						<div class="ae-profile-list__main">
							<p class="ae-profile-list__title">
								<a href="<?php echo esc_url( $auto_emotion_detail_url ); ?>"><?php echo esc_html( get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_name', true ) ); ?></a>
								<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_status_val ); ?>"><?php echo esc_html( isset( $auto_emotion_status_labels[ $auto_emotion_status_val ] ) ? $auto_emotion_status_labels[ $auto_emotion_status_val ] : $auto_emotion_status_val ); ?></span>
								<?php if ( $auto_emotion_bewertung_val > 0 ) : ?>
									<span class="ae-sterne" aria-label="<?php echo esc_attr( $auto_emotion_bewertung_val . ' von 5 Sternen' ); ?>"><?php echo esc_html( str_repeat( '★', $auto_emotion_bewertung_val ) . str_repeat( '☆', 5 - $auto_emotion_bewertung_val ) ); ?></span>
								<?php endif; ?>
							</p>
							<p class="ae-profile-list__meta">
								<?php echo esc_html( trim( implode( ' · ', array_filter( array( $auto_emotion_position, $auto_emotion_telefon, get_the_date( 'd.m.Y', $auto_emotion_bewerbung ) ) ) ) ) ); ?>
								<?php if ( ! empty( $auto_emotion_dateien ) ) : ?>
									· <?php echo esc_html( sprintf( _n( '%d Datei', '%d Dateien', count( $auto_emotion_dateien ), 'auto-emotion' ), count( $auto_emotion_dateien ) ) ); ?>
								<?php endif; ?>
							</p>
						</div>
						<div class="ae-profile-list__actions">
							<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( $auto_emotion_detail_url ); ?>"><?php esc_html_e( 'Ansehen', 'auto-emotion' ); ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</main>
</body>
</html>
