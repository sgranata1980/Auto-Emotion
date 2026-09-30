<?php
/**
 * "Mein Profil": eigener Anzeigename, E-Mail, Passwort.
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_user = wp_get_current_user();

$auto_emotion_profil_fehler = isset( $_GET['profil_fehler'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_GET['profil_fehler'] ) ) ) : array();
$auto_emotion_passwort_fehler = isset( $_GET['passwort_fehler'] ) ? sanitize_key( wp_unslash( $_GET['passwort_fehler'] ) ) : '';

auto_emotion_staff_shell_start( __( 'Mein Profil', 'auto-emotion' ), 'profil' );
?>

<h1><?php esc_html_e( 'Mein Profil', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Deine eigenen Zugangsdaten für den Mitarbeiterbereich.', 'auto-emotion' ); ?>
</p>

<?php if ( isset( $_GET['profil_gespeichert'] ) ) : ?>
	<p class="ae-notice"><?php esc_html_e( 'Profil gespeichert.', 'auto-emotion' ); ?></p>
<?php endif; ?>

<?php if ( in_array( 'name', $auto_emotion_profil_fehler, true ) ) : ?>
	<p class="ae-staff-login__error"><?php esc_html_e( 'Bitte einen Namen angeben.', 'auto-emotion' ); ?></p>
<?php endif; ?>
<?php if ( in_array( 'email', $auto_emotion_profil_fehler, true ) ) : ?>
	<p class="ae-staff-login__error"><?php esc_html_e( 'Bitte eine gültige E-Mail-Adresse angeben.', 'auto-emotion' ); ?></p>
<?php endif; ?>
<?php if ( in_array( 'email_vergeben', $auto_emotion_profil_fehler, true ) ) : ?>
	<p class="ae-staff-login__error"><?php esc_html_e( 'Diese E-Mail-Adresse wird bereits von einem anderen Konto verwendet.', 'auto-emotion' ); ?></p>
<?php endif; ?>

<div class="ae-card">
	<h2><?php esc_html_e( 'Name & E-Mail', 'auto-emotion' ); ?></h2>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ae-form-grid">
		<input type="hidden" name="action" value="auto_emotion_profil_speichern">
		<?php wp_nonce_field( 'auto_emotion_profil_speichern', 'auto_emotion_profil_nonce' ); ?>
		<div class="ae-field">
			<label for="ae_profil_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
			<input type="text" id="ae_profil_name" name="ae_profil_name" value="<?php echo esc_attr( $auto_emotion_user->display_name ); ?>" required>
		</div>
		<div class="ae-field">
			<label for="ae_profil_email"><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></label>
			<input type="email" id="ae_profil_email" name="ae_profil_email" value="<?php echo esc_attr( $auto_emotion_user->user_email ); ?>" required>
		</div>
		<div class="ae-field ae-field--full">
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Speichern', 'auto-emotion' ); ?></button>
		</div>
	</form>
</div>

<div class="ae-card">
	<h2><?php esc_html_e( 'Passwort ändern', 'auto-emotion' ); ?></h2>
	<?php if ( 'aktuell' === $auto_emotion_passwort_fehler ) : ?>
		<p class="ae-staff-login__error"><?php esc_html_e( 'Aktuelles Passwort ist nicht korrekt.', 'auto-emotion' ); ?></p>
	<?php elseif ( 'neu' === $auto_emotion_passwort_fehler ) : ?>
		<p class="ae-staff-login__error"><?php esc_html_e( 'Neues Passwort muss mindestens 8 Zeichen haben und in beiden Feldern übereinstimmen.', 'auto-emotion' ); ?></p>
	<?php endif; ?>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ae-form-grid">
		<input type="hidden" name="action" value="auto_emotion_profil_passwort">
		<?php wp_nonce_field( 'auto_emotion_profil_passwort', 'auto_emotion_profil_passwort_nonce' ); ?>
		<div class="ae-field ae-field--full">
			<label for="ae_passwort_aktuell"><?php esc_html_e( 'Aktuelles Passwort', 'auto-emotion' ); ?></label>
			<input type="password" id="ae_passwort_aktuell" name="ae_passwort_aktuell" autocomplete="current-password" required>
		</div>
		<div class="ae-field">
			<label for="ae_passwort_neu"><?php esc_html_e( 'Neues Passwort', 'auto-emotion' ); ?></label>
			<input type="password" id="ae_passwort_neu" name="ae_passwort_neu" autocomplete="new-password" minlength="8" required>
		</div>
		<div class="ae-field">
			<label for="ae_passwort_neu_wiederholen"><?php esc_html_e( 'Neues Passwort wiederholen', 'auto-emotion' ); ?></label>
			<input type="password" id="ae_passwort_neu_wiederholen" name="ae_passwort_neu_wiederholen" autocomplete="new-password" minlength="8" required>
		</div>
		<div class="ae-field ae-field--full">
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Passwort ändern', 'auto-emotion' ); ?></button>
		</div>
	</form>
</div>

<?php auto_emotion_staff_shell_end(); ?>
