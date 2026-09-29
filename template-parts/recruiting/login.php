<?php
/**
 * Login-Ansicht des Mitarbeiterbereichs.
 * Erwartet: $auto_emotion_login_error (bool)
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
	<title><?php esc_html_e( 'Mitarbeiter-Login – Auto Emotion', 'auto-emotion' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/tokens.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
</head>
<body class="ae-staff">
	<div class="ae-staff-login">
		<div class="ae-staff-login__card">
			<span class="ae-staff-login__brand"><?php bloginfo( 'name' ); ?></span>
			<p class="ae-staff-login__hint"><?php esc_html_e( 'Mitarbeiterbereich · Recruiting', 'auto-emotion' ); ?></p>

			<?php if ( ! empty( $auto_emotion_login_error ) ) : ?>
				<p class="ae-staff-login__error"><?php esc_html_e( 'Login fehlgeschlagen. Bitte Benutzername und Passwort prüfen.', 'auto-emotion' ); ?></p>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="auto_emotion_recruiting_login">
				<?php wp_nonce_field( 'auto_emotion_recruiting_login', 'auto_emotion_recruiting_login_nonce' ); ?>

				<div class="ae-field">
					<label for="ae_login_user"><?php esc_html_e( 'Benutzername', 'auto-emotion' ); ?></label>
					<input type="text" id="ae_login_user" name="ae_login_user" autocomplete="username" required>
				</div>
				<div class="ae-field">
					<label for="ae_login_pass"><?php esc_html_e( 'Passwort', 'auto-emotion' ); ?></label>
					<input type="password" id="ae_login_pass" name="ae_login_pass" autocomplete="current-password" required>
				</div>

				<button type="submit" class="ae-btn"><?php esc_html_e( 'Anmelden', 'auto-emotion' ); ?></button>
			</form>
		</div>
	</div>
</body>
</html>
