<?php
/**
 * Feedback-Popup (nach dem Vorbild "Wir bitten um Ihr Feedback", vom
 * Nutzer auf einer VW-Referenzseite gezeigt) - erscheint zeitversetzt,
 * lässt sich wegklicken und merkt sich die Ablehnung für eine Weile
 * (siehe assets/js/feedback-popup.js). Rückmeldung geht per Mail an
 * Auto Emotion (siehe inc/feedback.php), keine Pflichtangaben außer
 * der Nachricht selbst.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_feedback_status = isset( $_GET['feedback'] ) ? sanitize_text_field( wp_unslash( $_GET['feedback'] ) ) : '';
?>
<div id="feedback-popup" class="feedback-popup" data-state="hidden" role="dialog" aria-modal="true" aria-labelledby="feedback-popup-title">
	<div class="feedback-popup__dialog">
		<button type="button" class="feedback-popup__close" aria-label="<?php esc_attr_e( 'Schließen', 'auto-emotion' ); ?>">&times;</button>

		<?php if ( 'ok' === $auto_emotion_feedback_status ) : ?>
			<p id="feedback-popup-title" class="feedback-popup__title"><?php esc_html_e( 'Danke für Ihr Feedback!', 'auto-emotion' ); ?></p>
			<p><?php esc_html_e( 'Wir lesen jede Rückmeldung und nutzen sie, um die Website zu verbessern.', 'auto-emotion' ); ?></p>
		<?php else : ?>
			<p id="feedback-popup-title" class="feedback-popup__title"><?php esc_html_e( 'Wir bitten um Ihr Feedback', 'auto-emotion' ); ?></p>
			<p class="feedback-popup__intro"><?php esc_html_e( 'Ihre Meinung hilft uns, diese Website weiter zu verbessern. Es dauert nur eine Minute.', 'auto-emotion' ); ?></p>

			<?php if ( 'fehler' === $auto_emotion_feedback_status ) : ?>
				<p class="feedback-popup__error"><?php esc_html_e( 'Bitte eine Nachricht eingeben und der Verarbeitung zustimmen.', 'auto-emotion' ); ?></p>
			<?php endif; ?>

			<form class="feedback-popup__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="auto_emotion_feedback">
				<input type="hidden" name="feedback_seite" value="">
				<?php wp_nonce_field( 'auto_emotion_feedback', 'auto_emotion_feedback_nonce' ); ?>

				<p class="feedback-popup__honeypot" aria-hidden="true">
					<label for="feedback_website"><?php esc_html_e( 'Bitte freilassen', 'auto-emotion' ); ?></label>
					<input type="text" id="feedback_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
				</p>

				<label class="screen-reader-text" for="feedback_nachricht"><?php esc_html_e( 'Ihr Feedback', 'auto-emotion' ); ?></label>
				<textarea id="feedback_nachricht" name="feedback_nachricht" rows="4" placeholder="<?php esc_attr_e( 'Was können wir besser machen?', 'auto-emotion' ); ?>" required></textarea>

				<label class="screen-reader-text" for="feedback_email"><?php esc_html_e( 'E-Mail (optional, für eine Antwort)', 'auto-emotion' ); ?></label>
				<input type="email" id="feedback_email" name="feedback_email" placeholder="<?php esc_attr_e( 'E-Mail (optional, für eine Antwort)', 'auto-emotion' ); ?>">

				<label class="feedback-popup__consent">
					<input type="checkbox" name="feedback_dsgvo" value="1" required>
					<?php esc_html_e( 'Ich bin einverstanden, dass meine Angaben zur Bearbeitung dieses Feedbacks verwendet werden.', 'auto-emotion' ); ?>
				</label>

				<div class="feedback-popup__actions">
					<button type="submit" class="btn btn-giallo"><?php esc_html_e( 'Absenden', 'auto-emotion' ); ?></button>
					<button type="button" class="btn btn-outline feedback-popup__dismiss"><?php esc_html_e( 'Nicht jetzt', 'auto-emotion' ); ?></button>
				</div>
			</form>
		<?php endif; ?>
	</div>
</div>
