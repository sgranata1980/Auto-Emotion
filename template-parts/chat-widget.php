<?php
/**
 * Chat-Widget (Auto Emotion Assistent). Icon, Video-Avatar und
 * Chat-Oberfläche sind immer sichtbar; nur das tatsächliche Senden
 * einer Nachricht schlägt fehl, solange kein Claude API-Key im
 * Customizer hinterlegt ist (siehe inc/chatbot.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="chat-widget" data-state="closed">
	<button type="button" class="chat-widget__toggle" aria-expanded="false" aria-controls="chat-widget-panel">
		<span class="chat-widget__toggle-icon" aria-hidden="true"></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Chat öffnen', 'auto-emotion' ); ?></span>
	</button>

	<div id="chat-widget-panel" class="chat-widget__panel" data-state="closed">
		<div class="chat-widget__avatar">
			<video
				id="chat-widget-avatar-video"
				class="chat-widget__avatar-video"
				playsinline
				data-greeting-src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/videos/emo-greeting.mp4?ver=' . AUTO_EMOTION_VERSION ); ?>"
				data-idle-src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/videos/emo-idle.mp4?ver=' . AUTO_EMOTION_VERSION ); ?>"
			></video>
		</div>
		<div class="chat-widget__header">
			<span><?php esc_html_e( 'Emo – Auto Emotion Assistent', 'auto-emotion' ); ?></span>
			<button type="button" class="chat-widget__close" aria-label="<?php esc_attr_e( 'Chat schließen', 'auto-emotion' ); ?>">&times;</button>
		</div>
		<div class="chat-widget__messages" id="chat-widget-messages">
			<div class="chat-widget__message chat-widget__message--bot">
				<?php esc_html_e( 'Willkommen auf unserer neuen Website! Ich bin Emo, euer Auto-Emotion-Chatbot. Meld dich einfach, wann immer du eine Frage hast – ich helfe dir gerne weiter.', 'auto-emotion' ); ?>
			</div>
		</div>
		<form id="chat-widget-form" class="chat-widget__form">
			<label class="screen-reader-text" for="chat-widget-input"><?php esc_html_e( 'Deine Nachricht', 'auto-emotion' ); ?></label>
			<input type="text" id="chat-widget-input" autocomplete="off" placeholder="<?php esc_attr_e( 'Deine Frage …', 'auto-emotion' ); ?>" maxlength="500" required>
			<button type="submit"><?php esc_html_e( 'Senden', 'auto-emotion' ); ?></button>
		</form>
	</div>
</div>
