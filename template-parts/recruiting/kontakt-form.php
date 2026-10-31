<?php
/**
 * Formular (Neu & Bearbeiten) für einen Adressbuch-Kontakt.
 * Erwartet: $auto_emotion_kontakt_post (WP_Post|null)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_is_edit = ! empty( $auto_emotion_kontakt_post );
$auto_emotion_post_id = $auto_emotion_is_edit ? $auto_emotion_kontakt_post->ID : 0;

$auto_emotion_name    = $auto_emotion_is_edit ? $auto_emotion_kontakt_post->post_title : '';
$auto_emotion_firma   = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_kontakt_firma', true ) : '';
$auto_emotion_rolle   = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_kontakt_rolle', true ) : '';
$auto_emotion_telefon = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_kontakt_telefon', true ) : '';
$auto_emotion_email   = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_kontakt_email', true ) : '';
$auto_emotion_notiz   = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_kontakt_notiz', true ) : '';

$auto_emotion_seite_titel = $auto_emotion_is_edit ? __( 'Kontakt bearbeiten', 'auto-emotion' ) : __( 'Neuer Kontakt', 'auto-emotion' );
auto_emotion_staff_shell_start( $auto_emotion_seite_titel, 'kontakte' );
?>

<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/kontakte/' ) ); ?>">← <?php esc_html_e( 'Zurück zum Adressbuch', 'auto-emotion' ); ?></a>

<h1><?php echo esc_html( $auto_emotion_seite_titel ); ?></h1>

<div class="ae-card">
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="auto_emotion_kontakt_speichern">
		<input type="hidden" name="ae_kontakt_id" value="<?php echo esc_attr( $auto_emotion_post_id ); ?>">
		<?php wp_nonce_field( 'auto_emotion_kontakt_speichern', 'auto_emotion_kontakt_nonce' ); ?>

		<div class="ae-field ae-field--full">
			<label for="ae_kontakt_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
			<input type="text" id="ae_kontakt_name" name="ae_kontakt_name" value="<?php echo esc_attr( $auto_emotion_name ); ?>" required>
		</div>

		<div class="ae-form-grid">
			<div class="ae-field">
				<label for="ae_kontakt_firma"><?php esc_html_e( 'Firma / Institution', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_kontakt_firma" name="ae_kontakt_firma" value="<?php echo esc_attr( $auto_emotion_firma ); ?>" placeholder="z. B. StepStone, Arbeitsagentur Offenbach">
			</div>
			<div class="ae-field">
				<label for="ae_kontakt_rolle"><?php esc_html_e( 'Rolle / Position', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_kontakt_rolle" name="ae_kontakt_rolle" value="<?php echo esc_attr( $auto_emotion_rolle ); ?>" placeholder="z. B. Kundenberater/in">
			</div>
			<div class="ae-field">
				<label for="ae_kontakt_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_kontakt_telefon" name="ae_kontakt_telefon" value="<?php echo esc_attr( $auto_emotion_telefon ); ?>">
			</div>
			<div class="ae-field">
				<label for="ae_kontakt_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
				<input type="email" id="ae_kontakt_email" name="ae_kontakt_email" value="<?php echo esc_attr( $auto_emotion_email ); ?>">
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_kontakt_notiz"><?php esc_html_e( 'Notiz', 'auto-emotion' ); ?></label>
				<textarea id="ae_kontakt_notiz" name="ae_kontakt_notiz" rows="4"><?php echo esc_textarea( $auto_emotion_notiz ); ?></textarea>
			</div>
		</div>

		<div class="ae-form-actions">
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Speichern', 'auto-emotion' ); ?></button>
			<?php if ( $auto_emotion_is_edit ) : ?>
				<a class="ae-btn ae-btn--danger" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_kontakt_delete&ae_kontakt_id=' . $auto_emotion_post_id ), 'auto_emotion_kontakt_delete_' . $auto_emotion_post_id ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Kontakt wirklich in den Papierkorb verschieben?', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'Löschen', 'auto-emotion' ); ?></a>
			<?php endif; ?>
		</div>
	</form>
</div>

<?php auto_emotion_staff_shell_end(); ?>
