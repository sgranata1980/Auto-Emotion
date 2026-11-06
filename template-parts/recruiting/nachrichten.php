<?php
/**
 * Interne Team-Pinnwand.
 * Erwartet: $auto_emotion_nachrichten (array<WP_Post>), $auto_emotion_vorausgefuellt (string)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

auto_emotion_staff_shell_start( __( 'Nachrichten', 'auto-emotion' ), 'nachrichten' );
?>

<h1><?php esc_html_e( 'Nachrichten', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Geteilte Pinnwand fürs Team – für alles rund ums Recruiting, das nicht per E-Mail an Bewerber geht.', 'auto-emotion' ); ?>
</p>

<div class="ae-card">
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="auto_emotion_nachricht_senden">
		<?php wp_nonce_field( 'auto_emotion_nachricht_senden', 'auto_emotion_nachricht_nonce' ); ?>
		<div class="ae-field ae-field--full" style="margin-bottom:12px;">
			<textarea name="ae_nachricht_text" rows="3" placeholder="<?php esc_attr_e( 'Nachricht ans Team …', 'auto-emotion' ); ?>" required><?php echo esc_textarea( $auto_emotion_vorausgefuellt ); ?></textarea>
		</div>
		<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Senden', 'auto-emotion' ); ?></button>
	</form>
</div>

<?php if ( empty( $auto_emotion_nachrichten ) ) : ?>
	<p class="ae-empty"><?php esc_html_e( 'Noch keine Nachrichten.', 'auto-emotion' ); ?></p>
<?php else : ?>
	<ul class="ae-list">
		<?php foreach ( $auto_emotion_nachrichten as $auto_emotion_n ) : ?>
			<?php $auto_emotion_autor = get_userdata( $auto_emotion_n->post_author ); ?>
			<li style="align-items:flex-start;">
				<div class="ae-list__main">
					<p class="ae-list__title">
						<?php echo esc_html( $auto_emotion_autor ? $auto_emotion_autor->display_name : __( 'Unbekannt', 'auto-emotion' ) ); ?>
						<span class="ae-list__meta" style="font-weight:400;"><?php echo esc_html( get_the_date( 'd.m.Y H:i', $auto_emotion_n ) ); ?></span>
					</p>
					<p style="white-space:pre-line; margin:4px 0 0;"><?php echo esc_html( $auto_emotion_n->post_content ); ?></p>
				</div>
				<?php if ( (int) $auto_emotion_n->post_author === get_current_user_id() ) : ?>
					<div class="ae-list__actions">
						<a class="ae-remove" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_nachricht_delete&ae_nachricht_id=' . $auto_emotion_n->ID ), 'auto_emotion_nachricht_delete_' . $auto_emotion_n->ID ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Nachricht wirklich löschen?', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'Löschen', 'auto-emotion' ); ?></a>
					</div>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
