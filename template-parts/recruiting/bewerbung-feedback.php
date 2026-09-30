<?php
/**
 * Öffentliche, nicht eingeloggte Feedback-Seite für Bewerber:innen.
 * Erwartet: $auto_emotion_feedback_post (WP_Post|null), $auto_emotion_feedback_token (string)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_gueltig      = ! empty( $auto_emotion_feedback_post );
$auto_emotion_beantwortet  = $auto_emotion_gueltig && get_post_meta( $auto_emotion_feedback_post->ID, '_bewerbung_feedback_beantwortet', true );
$auto_emotion_name         = $auto_emotion_gueltig ? get_post_meta( $auto_emotion_feedback_post->ID, '_bewerbung_name', true ) : '';
$auto_emotion_vorname      = $auto_emotion_name ? trim( strtok( $auto_emotion_name, ' ' ) ) : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php esc_html_e( 'Dein Feedback', 'auto-emotion' ); ?> – <?php bloginfo( 'name' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
	<style>
		body.ae-feedback-body { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 24px; }
		.ae-feedback-wrap { width: 100%; max-width: 560px; }
		.ae-feedback-logo { display: flex; align-items: center; gap: 10px; justify-content: center; margin-bottom: 28px; font-weight: 600; font-size: 15px; }
		.ae-nps { display: flex; flex-wrap: wrap; gap: 6px; margin: 16px 0 22px; }
		.ae-nps label { flex: 1 1 auto; min-width: 34px; text-align: center; }
		.ae-nps input { position: absolute; opacity: 0; pointer-events: none; }
		.ae-nps span { display: block; padding: 10px 0; border-radius: var(--ae-radius-sm); border: 1px solid var(--ae-border); font-size: 13px; font-weight: 500; cursor: pointer; }
		.ae-nps input:checked + span { background: var(--ae-accent); border-color: var(--ae-accent); color: #fff; }
		.ae-nps-scale { display: flex; justify-content: space-between; font-size: 11.5px; color: var(--ae-text-tertiary); margin-top: -12px; margin-bottom: 20px; }
	</style>
</head>
<body class="ae-app ae-feedback-body">
	<div class="ae-feedback-wrap">
		<div class="ae-feedback-logo">
			<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/logo-icon-red.png' ); ?>" alt="" width="22" height="22">
			<?php bloginfo( 'name' ); ?>
		</div>

		<div class="ae-card">
			<?php if ( ! $auto_emotion_gueltig ) : ?>
				<h1 style="font-size:18px; margin:0 0 8px;"><?php esc_html_e( 'Link nicht gültig', 'auto-emotion' ); ?></h1>
				<p class="ae-intro" style="margin:0;"><?php esc_html_e( 'Dieser Feedback-Link ist leider nicht (mehr) gültig.', 'auto-emotion' ); ?></p>
			<?php elseif ( $auto_emotion_beantwortet ) : ?>
				<h1 style="font-size:18px; margin:0 0 8px;"><?php esc_html_e( 'Vielen Dank!', 'auto-emotion' ); ?></h1>
				<p class="ae-intro" style="margin:0;"><?php esc_html_e( 'Dein Feedback wurde bereits übermittelt. Wir schätzen deine Zeit sehr.', 'auto-emotion' ); ?></p>
			<?php else : ?>
				<h1 style="font-size:18px; margin:0 0 8px;">
					<?php
					echo esc_html(
						$auto_emotion_vorname
							/* translators: %s: Vorname */
							? sprintf( __( 'Hallo %s, wie war dein Bewerbungsprozess?', 'auto-emotion' ), $auto_emotion_vorname )
							: __( 'Wie war dein Bewerbungsprozess?', 'auto-emotion' )
					);
					?>
				</h1>
				<p class="ae-intro" style="margin:0 0 4px;"><?php esc_html_e( 'Wie wahrscheinlich ist es, dass du Auto Emotion als Arbeitgeber weiterempfiehlst?', 'auto-emotion' ); ?></p>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="auto_emotion_feedback_absenden">
					<input type="hidden" name="ae_feedback_token" value="<?php echo esc_attr( $auto_emotion_feedback_token ); ?>">
					<?php wp_nonce_field( 'auto_emotion_feedback_absenden_' . $auto_emotion_feedback_token, 'auto_emotion_feedback_absenden_nonce' ); ?>

					<div class="ae-nps">
						<?php for ( $auto_emotion_s = 0; $auto_emotion_s <= 10; $auto_emotion_s++ ) : ?>
							<label>
								<input type="radio" name="ae_feedback_score" value="<?php echo esc_attr( $auto_emotion_s ); ?>" required>
								<span><?php echo esc_html( $auto_emotion_s ); ?></span>
							</label>
						<?php endfor; ?>
					</div>
					<div class="ae-nps-scale">
						<span><?php esc_html_e( 'gar nicht wahrscheinlich', 'auto-emotion' ); ?></span>
						<span><?php esc_html_e( 'auf jeden Fall', 'auto-emotion' ); ?></span>
					</div>

					<div class="ae-field ae-field--full">
						<label for="ae_feedback_kommentar"><?php esc_html_e( 'Möchtest du uns sonst noch etwas mitgeben? (optional)', 'auto-emotion' ); ?></label>
						<textarea id="ae_feedback_kommentar" name="ae_feedback_kommentar" rows="4"></textarea>
					</div>

					<button type="submit" class="ae-btn" style="width:auto; margin-top:8px;"><?php esc_html_e( 'Feedback absenden', 'auto-emotion' ); ?></button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>
