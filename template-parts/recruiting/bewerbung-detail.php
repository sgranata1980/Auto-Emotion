<?php
/**
 * Detailansicht einer gespeicherten Bewerbung.
 * Erwartet: $auto_emotion_bewerbung_post (WP_Post)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_id           = $auto_emotion_bewerbung_post->ID;
$auto_emotion_name         = get_post_meta( $auto_emotion_id, '_bewerbung_name', true );
$auto_emotion_telefon      = get_post_meta( $auto_emotion_id, '_bewerbung_telefon', true );
$auto_emotion_kontakt_pref = get_post_meta( $auto_emotion_id, '_bewerbung_kontakt_pref', true );
$auto_emotion_position     = get_post_meta( $auto_emotion_id, '_bewerbung_position', true );
$auto_emotion_nachricht    = get_post_meta( $auto_emotion_id, '_bewerbung_nachricht', true );
$auto_emotion_dateien      = get_post_meta( $auto_emotion_id, '_bewerbung_dateien', true );
if ( ! is_array( $auto_emotion_dateien ) ) {
	$auto_emotion_dateien = array();
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( $auto_emotion_name ); ?> – <?php esc_html_e( 'Bewerbung', 'auto-emotion' ); ?> – <?php bloginfo( 'name' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/tokens.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
</head>
<body class="ae-staff">
	<?php get_template_part( 'template-parts/recruiting/staff-nav' ); ?>

	<main class="ae-staff-main">
		<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>">← <?php esc_html_e( 'Zurück zur Übersicht', 'auto-emotion' ); ?></a>

		<h1><?php echo esc_html( $auto_emotion_name ); ?></h1>

		<?php if ( isset( $_GET['weitergeleitet'] ) ) : ?>
			<p class="ae-notice"><?php esc_html_e( 'Bewerbung wurde weitergeleitet.', 'auto-emotion' ); ?></p>
		<?php endif; ?>

		<dl class="ae-detail-block">
			<dt><?php esc_html_e( 'Stelle', 'auto-emotion' ); ?></dt>
			<dd><?php echo esc_html( $auto_emotion_position ); ?></dd>
		</dl>
		<dl class="ae-detail-block">
			<dt><?php esc_html_e( 'Telefon / WhatsApp', 'auto-emotion' ); ?></dt>
			<dd><?php echo esc_html( $auto_emotion_telefon ); ?></dd>
		</dl>
		<dl class="ae-detail-block">
			<dt><?php esc_html_e( 'Bevorzugter Kontakt', 'auto-emotion' ); ?></dt>
			<dd><?php echo esc_html( $auto_emotion_kontakt_pref ); ?></dd>
		</dl>
		<dl class="ae-detail-block">
			<dt><?php esc_html_e( 'Eingegangen am', 'auto-emotion' ); ?></dt>
			<dd><?php echo esc_html( get_the_date( 'd.m.Y H:i', $auto_emotion_bewerbung_post ) ); ?> Uhr</dd>
		</dl>
		<?php if ( $auto_emotion_nachricht ) : ?>
			<dl class="ae-detail-block">
				<dt><?php esc_html_e( 'Nachricht', 'auto-emotion' ); ?></dt>
				<dd><?php echo esc_html( $auto_emotion_nachricht ); ?></dd>
			</dl>
		<?php endif; ?>

		<dl class="ae-detail-block">
			<dt><?php esc_html_e( 'Unterlagen', 'auto-emotion' ); ?></dt>
			<dd>
				<?php if ( empty( $auto_emotion_dateien ) ) : ?>
					<?php esc_html_e( 'Keine Dateien hochgeladen.', 'auto-emotion' ); ?>
				<?php else : ?>
					<ul class="ae-file-list">
						<?php foreach ( $auto_emotion_dateien as $auto_emotion_index => $auto_emotion_datei ) : ?>
							<li>
								<a href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' . $auto_emotion_id . '/datei/' . $auto_emotion_index . '/' ) ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( $auto_emotion_datei['original'] ); ?> ↗
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</dd>
		</dl>

		<h2 style="margin-top: var(--spacing-40); font-family: var(--font-lambotype); text-transform: uppercase; font-size: var(--text-subheading);"><?php esc_html_e( 'An Kollegen weiterleiten', 'auto-emotion' ); ?></h2>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ae-inline-form">
			<input type="hidden" name="action" value="auto_emotion_bewerbung_weiterleiten">
			<input type="hidden" name="ae_bewerbung_id" value="<?php echo esc_attr( $auto_emotion_id ); ?>">
			<?php wp_nonce_field( 'auto_emotion_bewerbung_weiterleiten_' . $auto_emotion_id, 'auto_emotion_bewerbung_weiterleiten_nonce' ); ?>
			<div class="ae-field">
				<label for="ae_weiterleiten_email"><?php esc_html_e( 'E-Mail-Adresse des Kollegen', 'auto-emotion' ); ?></label>
				<input type="email" id="ae_weiterleiten_email" name="ae_weiterleiten_email" required>
			</div>
			<button type="submit" class="ae-btn"><?php esc_html_e( 'Weiterleiten', 'auto-emotion' ); ?></button>
		</form>

		<div class="ae-form-actions">
			<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_bewerbung_delete&ae_bewerbung_id=' . $auto_emotion_id ), 'auto_emotion_bewerbung_delete_' . $auto_emotion_id ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Bewerbung wirklich in den Papierkorb verschieben? Unterlagen werden nach 30 Tagen endgültig gelöscht.', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'In den Papierkorb', 'auto-emotion' ); ?></a>
		</div>
	</main>
</body>
</html>
