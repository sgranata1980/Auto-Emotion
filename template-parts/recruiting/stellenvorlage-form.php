<?php
/**
 * Formular (Neu & Bearbeiten) für einen Eintrag der Stellenbibliothek.
 * Erwartet: $auto_emotion_vorlage_post (WP_Post|null)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_is_edit  = ! empty( $auto_emotion_vorlage_post );
$auto_emotion_post_id  = $auto_emotion_is_edit ? $auto_emotion_vorlage_post->ID : 0;

$auto_emotion_titel         = $auto_emotion_is_edit ? $auto_emotion_vorlage_post->post_title : '';
$auto_emotion_kategorie     = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_vorlage_kategorie', true ) : '';
$auto_emotion_anstellungsart = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_vorlage_anstellungsart', true ) : 'vollzeit';
$auto_emotion_stichworte    = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_vorlage_stichworte', true ) : '';
$auto_emotion_aufgaben      = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_vorlage_aufgaben', true ) : '';
$auto_emotion_anforderungen = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_vorlage_anforderungen', true ) : '';

$auto_emotion_kategorien = auto_emotion_stellenbibliothek_kategorien();

$auto_emotion_art_optionen = array(
	'vollzeit'    => __( 'Vollzeit', 'auto-emotion' ),
	'teilzeit'    => __( 'Teilzeit', 'auto-emotion' ),
	'ausbildung'  => __( 'Ausbildung', 'auto-emotion' ),
	'werkstudent' => __( 'Werkstudent/in', 'auto-emotion' ),
	'praktikum'   => __( 'Praktikum', 'auto-emotion' ),
);

$auto_emotion_seite_titel = $auto_emotion_is_edit ? $auto_emotion_titel : __( 'Neue Stellenvorlage', 'auto-emotion' );
auto_emotion_staff_shell_start( $auto_emotion_seite_titel, 'stellenbibliothek' );

$auto_emotion_vorlage_text = '';
if ( $auto_emotion_is_edit ) {
	$auto_emotion_vorlage_text  = __( 'Aufgaben:', 'auto-emotion' ) . "\n";
	foreach ( array_filter( array_map( 'trim', explode( "\n", $auto_emotion_aufgaben ) ) ) as $auto_emotion_zeile ) {
		$auto_emotion_vorlage_text .= '– ' . $auto_emotion_zeile . "\n";
	}
	$auto_emotion_vorlage_text .= "\n" . __( 'Anforderungen:', 'auto-emotion' ) . "\n";
	foreach ( array_filter( array_map( 'trim', explode( "\n", $auto_emotion_anforderungen ) ) ) as $auto_emotion_zeile ) {
		$auto_emotion_vorlage_text .= '– ' . $auto_emotion_zeile . "\n";
	}
}
?>

<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/stellenbibliothek/' ) ); ?>">← <?php esc_html_e( 'Zurück zur Stellenbibliothek', 'auto-emotion' ); ?></a>

<h1><?php echo esc_html( $auto_emotion_seite_titel ); ?></h1>

<?php if ( $auto_emotion_is_edit ) : ?>
	<div class="ae-card">
		<h2><?php esc_html_e( 'Für neues Suchprofil verwenden', 'auto-emotion' ); ?></h2>
		<p class="ae-intro" style="margin:0 0 12px;"><?php esc_html_e( 'Übernimmt Titel, Stichworte und Anstellungsart als Startpunkt für ein neues Suchprofil.', 'auto-emotion' ); ?></p>
		<a class="ae-btn" style="width:auto;" href="<?php echo esc_url( add_query_arg( array( 'vorlage_titel' => rawurlencode( $auto_emotion_titel ), 'vorlage_stichworte' => rawurlencode( $auto_emotion_stichworte ), 'vorlage_art' => rawurlencode( $auto_emotion_anstellungsart ) ), home_url( '/mitarbeiter/recruiting/neu/' ) ) ); ?>"><?php esc_html_e( 'Neues Suchprofil mit dieser Vorlage', 'auto-emotion' ); ?></a>

		<div class="ae-field ae-field--full" style="margin-top:20px;">
			<label for="ae_vorlage_copytext"><?php esc_html_e( 'Fertiger Text zum Kopieren (z. B. für eine Stellenanzeige)', 'auto-emotion' ); ?></label>
			<textarea id="ae_vorlage_copytext" rows="12" readonly onclick="this.select();"><?php echo esc_textarea( trim( $auto_emotion_vorlage_text ) ); ?></textarea>
		</div>
	</div>
<?php endif; ?>

<div class="ae-card">
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="auto_emotion_stellenvorlage_speichern">
		<input type="hidden" name="ae_vorlage_id" value="<?php echo esc_attr( $auto_emotion_post_id ); ?>">
		<?php wp_nonce_field( 'auto_emotion_stellenvorlage_speichern', 'auto_emotion_stellenvorlage_nonce' ); ?>

		<div class="ae-field ae-field--full">
			<label for="ae_vorlage_titel"><?php esc_html_e( 'Berufsbezeichnung', 'auto-emotion' ); ?></label>
			<input type="text" id="ae_vorlage_titel" name="ae_vorlage_titel" value="<?php echo esc_attr( $auto_emotion_titel ); ?>" placeholder="z. B. Kfz-Mechatroniker/in" required>
		</div>

		<div class="ae-form-grid">
			<div class="ae-field">
				<label for="ae_vorlage_kategorie"><?php esc_html_e( 'Kategorie', 'auto-emotion' ); ?></label>
				<select id="ae_vorlage_kategorie" name="ae_vorlage_kategorie">
					<?php foreach ( $auto_emotion_kategorien as $auto_emotion_kat_key => $auto_emotion_kat_label ) : ?>
						<option value="<?php echo esc_attr( $auto_emotion_kat_key ); ?>" <?php selected( $auto_emotion_kategorie, $auto_emotion_kat_key ); ?>><?php echo esc_html( $auto_emotion_kat_label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="ae-field">
				<label for="ae_vorlage_anstellungsart"><?php esc_html_e( 'Übliche Anstellungsart', 'auto-emotion' ); ?></label>
				<select id="ae_vorlage_anstellungsart" name="ae_vorlage_anstellungsart">
					<?php foreach ( $auto_emotion_art_optionen as $auto_emotion_art_key => $auto_emotion_art_label ) : ?>
						<option value="<?php echo esc_attr( $auto_emotion_art_key ); ?>" <?php selected( $auto_emotion_anstellungsart, $auto_emotion_art_key ); ?>><?php echo esc_html( $auto_emotion_art_label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_vorlage_stichworte"><?php esc_html_e( 'Stichworte', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_vorlage_stichworte" name="ae_vorlage_stichworte" value="<?php echo esc_attr( $auto_emotion_stichworte ); ?>">
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_vorlage_aufgaben"><?php esc_html_e( 'Aufgaben (eine pro Zeile)', 'auto-emotion' ); ?></label>
				<textarea id="ae_vorlage_aufgaben" name="ae_vorlage_aufgaben" rows="6"><?php echo esc_textarea( $auto_emotion_aufgaben ); ?></textarea>
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_vorlage_anforderungen"><?php esc_html_e( 'Anforderungen (eine pro Zeile)', 'auto-emotion' ); ?></label>
				<textarea id="ae_vorlage_anforderungen" name="ae_vorlage_anforderungen" rows="6"><?php echo esc_textarea( $auto_emotion_anforderungen ); ?></textarea>
			</div>
		</div>

		<div class="ae-form-actions">
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Speichern', 'auto-emotion' ); ?></button>
			<?php if ( $auto_emotion_is_edit ) : ?>
				<a class="ae-btn ae-btn--danger" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_stellenvorlage_delete&ae_vorlage_id=' . $auto_emotion_post_id ), 'auto_emotion_stellenvorlage_delete_' . $auto_emotion_post_id ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Vorlage wirklich in den Papierkorb verschieben?', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'Löschen', 'auto-emotion' ); ?></a>
			<?php endif; ?>
		</div>
	</form>
</div>

<?php auto_emotion_staff_shell_end(); ?>
