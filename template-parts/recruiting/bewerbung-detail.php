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
$auto_emotion_email        = get_post_meta( $auto_emotion_id, '_bewerbung_email', true );
$auto_emotion_kontakt_pref = get_post_meta( $auto_emotion_id, '_bewerbung_kontakt_pref', true );
$auto_emotion_position     = get_post_meta( $auto_emotion_id, '_bewerbung_position', true );
$auto_emotion_nachricht    = get_post_meta( $auto_emotion_id, '_bewerbung_nachricht', true );
$auto_emotion_dateien      = get_post_meta( $auto_emotion_id, '_bewerbung_dateien', true );
if ( ! is_array( $auto_emotion_dateien ) ) {
	$auto_emotion_dateien = array();
}
$auto_emotion_status    = get_post_meta( $auto_emotion_id, '_bewerbung_status', true );
$auto_emotion_status    = $auto_emotion_status ? $auto_emotion_status : 'neu';
$auto_emotion_bewertung = (int) get_post_meta( $auto_emotion_id, '_bewerbung_bewertung', true );
$auto_emotion_notiz     = get_post_meta( $auto_emotion_id, '_bewerbung_notiz', true );
$auto_emotion_vorlagen  = auto_emotion_bewerbung_email_vorlagen( $auto_emotion_name, $auto_emotion_position );

auto_emotion_staff_shell_start( $auto_emotion_name, 'bewerbungen' );
?>

<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>">← <?php esc_html_e( 'Zurück zur Übersicht', 'auto-emotion' ); ?></a>

<h1><?php echo esc_html( $auto_emotion_name ); ?></h1>

<?php if ( isset( $_GET['weitergeleitet'] ) ) : ?>
	<p class="ae-notice"><?php esc_html_e( 'Bewerbung wurde weitergeleitet.', 'auto-emotion' ); ?></p>
<?php endif; ?>
<?php if ( isset( $_GET['gespeichert'] ) ) : ?>
	<p class="ae-notice"><?php esc_html_e( 'Bewertung gespeichert.', 'auto-emotion' ); ?></p>
<?php endif; ?>
<?php if ( isset( $_GET['email_gesendet'] ) ) : ?>
	<p class="ae-notice"><?php esc_html_e( 'E-Mail wurde an den Bewerber gesendet.', 'auto-emotion' ); ?></p>
<?php endif; ?>

<div class="ae-card">
	<h2><?php esc_html_e( 'Bewertung', 'auto-emotion' ); ?></h2>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ae-form-grid">
		<input type="hidden" name="action" value="auto_emotion_bewerbung_bewerten">
		<input type="hidden" name="ae_bewerbung_id" value="<?php echo esc_attr( $auto_emotion_id ); ?>">
		<?php wp_nonce_field( 'auto_emotion_bewerbung_bewerten_' . $auto_emotion_id, 'auto_emotion_bewerbung_bewerten_nonce' ); ?>

		<div class="ae-field">
			<label for="ae_bewerbung_status"><?php esc_html_e( 'Status', 'auto-emotion' ); ?></label>
			<select id="ae_bewerbung_status" name="ae_bewerbung_status">
				<?php foreach ( auto_emotion_bewerbung_status_labels() as $auto_emotion_status_key => $auto_emotion_status_label ) : ?>
					<option value="<?php echo esc_attr( $auto_emotion_status_key ); ?>" <?php selected( $auto_emotion_status, $auto_emotion_status_key ); ?>><?php echo esc_html( $auto_emotion_status_label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="ae-field">
			<label for="ae_bewerbung_bewertung"><?php esc_html_e( 'Bewertung', 'auto-emotion' ); ?></label>
			<select id="ae_bewerbung_bewertung" name="ae_bewerbung_bewertung">
				<option value="0" <?php selected( $auto_emotion_bewertung, 0 ); ?>><?php esc_html_e( 'Keine Bewertung', 'auto-emotion' ); ?></option>
				<?php for ( $auto_emotion_stern = 1; $auto_emotion_stern <= 5; $auto_emotion_stern++ ) : ?>
					<option value="<?php echo esc_attr( $auto_emotion_stern ); ?>" <?php selected( $auto_emotion_bewertung, $auto_emotion_stern ); ?>><?php echo esc_html( str_repeat( '★', $auto_emotion_stern ) . str_repeat( '☆', 5 - $auto_emotion_stern ) ); ?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="ae-field ae-field--full">
			<label for="ae_bewerbung_notiz"><?php esc_html_e( 'Interne Notiz (nur für Kollegen sichtbar)', 'auto-emotion' ); ?></label>
			<textarea id="ae_bewerbung_notiz" name="ae_bewerbung_notiz" rows="4"><?php echo esc_textarea( $auto_emotion_notiz ); ?></textarea>
		</div>
		<div class="ae-field ae-field--full">
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Bewertung speichern', 'auto-emotion' ); ?></button>
		</div>
	</form>
</div>

<div class="ae-card">
	<dl class="ae-detail-block">
		<dt><?php esc_html_e( 'Stelle', 'auto-emotion' ); ?></dt>
		<dd><?php echo esc_html( $auto_emotion_position ); ?></dd>
	</dl>
	<dl class="ae-detail-block">
		<dt><?php esc_html_e( 'Telefon / WhatsApp', 'auto-emotion' ); ?></dt>
		<dd><?php echo esc_html( $auto_emotion_telefon ); ?></dd>
	</dl>
	<?php if ( $auto_emotion_email ) : ?>
		<dl class="ae-detail-block">
			<dt><?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?></dt>
			<dd><?php echo esc_html( $auto_emotion_email ); ?></dd>
		</dl>
	<?php endif; ?>
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
</div>

<div class="ae-card">
	<h2><?php esc_html_e( 'Bewerber kontaktieren', 'auto-emotion' ); ?></h2>
	<?php if ( ! $auto_emotion_email ) : ?>
		<p class="ae-intro" style="margin-bottom:0;">
			<?php esc_html_e( 'Keine E-Mail-Adresse hinterlegt – bitte telefonisch bzw. per WhatsApp kontaktieren:', 'auto-emotion' ); ?> <strong><?php echo esc_html( $auto_emotion_telefon ); ?></strong>
		</p>
	<?php else : ?>
		<?php foreach ( $auto_emotion_vorlagen as $auto_emotion_vorlage_key => $auto_emotion_vorlage ) : ?>
			<details style="margin-bottom:12px;">
				<summary style="cursor:pointer; font-weight:500; padding:6px 0;"><?php echo esc_html( $auto_emotion_vorlage['label'] ); ?></summary>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:10px;">
					<input type="hidden" name="action" value="auto_emotion_bewerbung_email_senden">
					<input type="hidden" name="ae_bewerbung_id" value="<?php echo esc_attr( $auto_emotion_id ); ?>">
					<?php wp_nonce_field( 'auto_emotion_bewerbung_email_' . $auto_emotion_id, 'auto_emotion_bewerbung_email_nonce' ); ?>
					<div class="ae-field">
						<label><?php esc_html_e( 'Betreff', 'auto-emotion' ); ?></label>
						<input type="text" name="ae_email_betreff" value="<?php echo esc_attr( $auto_emotion_vorlage['betreff'] ); ?>">
					</div>
					<div class="ae-field">
						<label><?php esc_html_e( 'Text (vor dem Senden anpassbar)', 'auto-emotion' ); ?></label>
						<textarea name="ae_email_text" rows="10"><?php echo esc_textarea( $auto_emotion_vorlage['text'] ); ?></textarea>
					</div>
					<button type="submit" class="ae-btn" style="width:auto;"><?php echo esc_html( sprintf( __( '"%s" an %s senden', 'auto-emotion' ), $auto_emotion_vorlage['label'], $auto_emotion_email ) ); ?></button>
				</form>
			</details>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="ae-card">
	<h2><?php esc_html_e( 'An Kollegen weiterleiten', 'auto-emotion' ); ?></h2>
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
</div>

<div class="ae-form-actions">
	<a class="ae-btn ae-btn--danger" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_bewerbung_delete&ae_bewerbung_id=' . $auto_emotion_id ), 'auto_emotion_bewerbung_delete_' . $auto_emotion_id ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Bewerbung wirklich in den Papierkorb verschieben? Unterlagen werden nach 30 Tagen endgültig gelöscht.', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'In den Papierkorb', 'auto-emotion' ); ?></a>
</div>

<?php auto_emotion_staff_shell_end(); ?>
