<?php
/**
 * Chat-Widget (Auto Emotion Assistent). Rendert nichts, solange kein
 * Claude API-Key im Customizer hinterlegt ist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! auto_emotion_chat_is_configured() ) {
	return;
}
?>
<div class="chat-widget" data-state="closed">
	<button type="button" class="chat-widget__toggle" aria-expanded="false" aria-controls="chat-widget-panel">
		<span class="chat-widget__toggle-icon" aria-hidden="true"></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Chat öffnen', 'auto-emotion' ); ?></span>
	</button>

	<div id="chat-widget-panel" class="chat-widget__panel" data-state="closed">
		<div class="chat-widget__header">
			<span><?php esc_html_e( 'Auto Emotion Assistent', 'auto-emotion' ); ?></span>
			<button type="button" class="chat-widget__close" aria-label="<?php esc_attr_e( 'Chat schließen', 'auto-emotion' ); ?>">&times;</button>
		</div>
		<div class="chat-widget__messages" id="chat-widget-messages">
			<div class="chat-widget__message chat-widget__message--bot">
				<?php esc_html_e( 'Hallo! Wie kann ich dir helfen – z. B. zu Öffnungszeiten, Marken oder Terminen?', 'auto-emotion' ); ?>
			</div>
		</div>
		<form id="chat-widget-form" class="chat-widget__form">
			<label class="screen-reader-text" for="chat-widget-input"><?php esc_html_e( 'Deine Nachricht', 'auto-emotion' ); ?></label>
			<input type="text" id="chat-widget-input" autocomplete="off" placeholder="<?php esc_attr_e( 'Deine Frage …', 'auto-emotion' ); ?>" maxlength="500" required>
			<button type="submit"><?php esc_html_e( 'Senden', 'auto-emotion' ); ?></button>
		</form>
	</div>
</div>
