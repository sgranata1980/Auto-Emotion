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

$auto_emotion_feedback_angefragt_am  = get_post_meta( $auto_emotion_id, '_bewerbung_feedback_angefragt_am', true );
$auto_emotion_feedback_beantwortet   = get_post_meta( $auto_emotion_id, '_bewerbung_feedback_beantwortet', true );
$auto_emotion_feedback_score         = get_post_meta( $auto_emotion_id, '_bewerbung_feedback_score', true );
$auto_emotion_feedback_kommentar     = get_post_meta( $auto_emotion_id, '_bewerbung_feedback_kommentar', true );
$auto_emotion_feedback_token         = get_post_meta( $auto_emotion_id, '_bewerbung_feedback_token', true );
$auto_emotion_feedback_link          = $auto_emotion_feedback_token ? home_url( '/bewerbung-feedback/' . $auto_emotion_feedback_token . '/' ) : '';

$auto_emotion_ki_prozent    = get_post_meta( $auto_emotion_id, '_bewerbung_ki_einschaetzung_prozent', true );
$auto_emotion_ki_text       = get_post_meta( $auto_emotion_id, '_bewerbung_ki_einschaetzung_text', true );
$auto_emotion_ki_staerken   = get_post_meta( $auto_emotion_id, '_bewerbung_ki_staerken', true );
$auto_emotion_ki_luecken    = get_post_meta( $auto_emotion_id, '_bewerbung_ki_luecken', true );
$auto_emotion_ki_empfehlung = get_post_meta( $auto_emotion_id, '_bewerbung_ki_empfehlung', true );
$auto_emotion_ki_datum      = get_post_meta( $auto_emotion_id, '_bewerbung_ki_datum', true );
$auto_emotion_ki_empfehlung_labels = array(
	'einladen'      => __( 'Einladen', 'auto-emotion' ),
	'pruefen'       => __( 'Genauer prüfen', 'auto-emotion' ),
	'eher_absagen'  => __( 'Eher absagen', 'auto-emotion' ),
);

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
<?php if ( isset( $_GET['feedback_angefragt'] ) ) : ?>
	<p class="ae-notice"><?php esc_html_e( 'Feedback-Anfrage wurde per E-Mail versendet.', 'auto-emotion' ); ?></p>
<?php endif; ?>
<?php if ( isset( $_GET['ki_erstellt'] ) ) : ?>
	<p class="ae-notice"><?php esc_html_e( 'KI-Einschätzung wurde erstellt.', 'auto-emotion' ); ?></p>
<?php endif; ?>
<?php if ( isset( $_GET['ki_fehler'] ) ) : ?>
	<p class="ae-notice" style="background:var(--ae-danger-soft); border-color:var(--ae-danger); color:var(--ae-danger);"><?php echo esc_html( sprintf( __( 'KI-Einschätzung fehlgeschlagen: %s', 'auto-emotion' ), sanitize_text_field( wp_unslash( $_GET['ki_fehler'] ) ) ) ); ?></p>
<?php endif; ?>

<div class="ae-card">
	<h2><?php esc_html_e( 'KI-Einschätzung (Vorqualifizierung)', 'auto-emotion' ); ?></h2>
	<?php if ( ! auto_emotion_anthropic_configured() ) : ?>
		<p class="ae-intro" style="margin:0 0 12px;"><?php esc_html_e( 'Noch nicht eingerichtet. Trage im WordPress-Customizer unter „Auto Emotion Einstellungen" einen Claude API-Key ein (von console.anthropic.com), dann steht die Funktion sofort zur Verfügung – derselbe Key wird auch für den Chat-Assistenten auf der Website genutzt.', 'auto-emotion' ); ?></p>
		<a class="ae-btn" style="width:auto;" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=ae_claude_api_key&url=' . rawurlencode( home_url( '/' ) ) ) ); ?>" target="_blank"><?php esc_html_e( 'API-Key jetzt eintragen', 'auto-emotion' ); ?></a>
	<?php else : ?>
		<?php if ( $auto_emotion_ki_text ) : ?>
			<div class="ae-kpis" style="margin-bottom:16px;">
				<?php if ( '' !== $auto_emotion_ki_prozent ) : ?>
					<div class="ae-kpi">
						<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_ki_prozent ); ?>%</div>
						<div class="ae-kpi__label"><?php esc_html_e( 'Geschätzte Passung', 'auto-emotion' ); ?></div>
					</div>
				<?php endif; ?>
				<?php if ( $auto_emotion_ki_empfehlung && isset( $auto_emotion_ki_empfehlung_labels[ $auto_emotion_ki_empfehlung ] ) ) : ?>
					<div class="ae-kpi">
						<div class="ae-kpi__value" style="font-size:16px;"><?php echo esc_html( $auto_emotion_ki_empfehlung_labels[ $auto_emotion_ki_empfehlung ] ); ?></div>
						<div class="ae-kpi__label"><?php esc_html_e( 'KI-Empfehlung', 'auto-emotion' ); ?></div>
					</div>
				<?php endif; ?>
			</div>
			<p class="ae-intro" style="margin:0 0 12px;"><?php echo esc_html( $auto_emotion_ki_text ); ?></p>
			<?php if ( $auto_emotion_ki_staerken ) : ?>
				<p class="ae-list__title" style="font-size:13px; margin-bottom:4px;"><?php esc_html_e( 'Stärken', 'auto-emotion' ); ?></p>
				<ul style="margin:0 0 12px; padding-left:18px;">
					<?php foreach ( explode( "\n", $auto_emotion_ki_staerken ) as $auto_emotion_zeile ) : ?>
						<li class="ae-list__meta"><?php echo esc_html( $auto_emotion_zeile ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( $auto_emotion_ki_luecken ) : ?>
				<p class="ae-list__title" style="font-size:13px; margin-bottom:4px;"><?php esc_html_e( 'Mögliche Lücken', 'auto-emotion' ); ?></p>
				<ul style="margin:0 0 12px; padding-left:18px;">
					<?php foreach ( explode( "\n", $auto_emotion_ki_luecken ) as $auto_emotion_zeile ) : ?>
						<li class="ae-list__meta"><?php echo esc_html( $auto_emotion_zeile ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<p class="ae-list__meta" style="margin:0 0 16px;">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: Datum/Uhrzeit */
						__( 'Erstellt am %s · berücksichtigt nur den Bewerbungstext, nicht hochgeladene Dateien.', 'auto-emotion' ),
						mysql2date( 'd.m.Y H:i', $auto_emotion_ki_datum )
					)
				);
				?>
			</p>
		<?php else : ?>
			<p class="ae-intro" style="margin:0 0 12px;"><?php esc_html_e( 'Vergleicht den Bewerbungstext mit dem Anforderungsprofil der Position und gibt eine begründete Einschätzung – berücksichtigt nur den Text aus dem Formular, nicht hochgeladene Dateien.', 'auto-emotion' ); ?></p>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="auto_emotion_bewerbung_einschaetzung">
			<input type="hidden" name="ae_bewerbung_id" value="<?php echo esc_attr( $auto_emotion_id ); ?>">
			<?php wp_nonce_field( 'auto_emotion_bewerbung_einschaetzung_' . $auto_emotion_id, 'auto_emotion_bewerbung_einschaetzung_nonce' ); ?>
			<button type="submit" class="ae-btn <?php echo $auto_emotion_ki_text ? 'ae-btn--ghost' : ''; ?>" style="width:auto;"><?php echo esc_html( $auto_emotion_ki_text ? __( 'Neu generieren', 'auto-emotion' ) : __( 'KI-Einschätzung erstellen', 'auto-emotion' ) ); ?></button>
		</form>
	<?php endif; ?>
</div>

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

<?php if ( $auto_emotion_email && in_array( $auto_emotion_status, array( 'eingestellt', 'abgesagt' ), true ) ) : ?>
<div class="ae-card">
	<h2><?php esc_html_e( 'Candidate-Feedback', 'auto-emotion' ); ?></h2>
	<?php if ( $auto_emotion_feedback_beantwortet ) : ?>
		<p class="ae-intro" style="margin:0 0 6px;">
			<?php
			echo esc_html(
				sprintf(
					/* translators: %d: Bewertung 0–10 */
					__( 'Bewertung: %d/10', 'auto-emotion' ),
					(int) $auto_emotion_feedback_score
				)
			);
			?>
		</p>
		<?php if ( $auto_emotion_feedback_kommentar ) : ?>
			<p class="ae-intro" style="margin:0;"><?php echo esc_html( $auto_emotion_feedback_kommentar ); ?></p>
		<?php endif; ?>
	<?php elseif ( $auto_emotion_feedback_angefragt_am ) : ?>
		<p class="ae-intro" style="margin:0 0 12px;">
			<?php
			echo esc_html(
				sprintf(
					/* translators: %s: Datum/Uhrzeit */
					__( 'Feedback angefragt am %s – noch keine Antwort.', 'auto-emotion' ),
					mysql2date( 'd.m.Y H:i', $auto_emotion_feedback_angefragt_am )
				)
			);
			?>
		</p>
		<?php if ( $auto_emotion_feedback_link ) : ?>
			<div class="ae-field ae-field--full" style="margin-bottom:12px;">
				<label for="ae_feedback_link"><?php esc_html_e( 'Link (z. B. manuell per WhatsApp teilen)', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_feedback_link" readonly onclick="this.select();" value="<?php echo esc_attr( $auto_emotion_feedback_link ); ?>">
			</div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="auto_emotion_feedback_anfragen">
			<input type="hidden" name="ae_bewerbung_id" value="<?php echo esc_attr( $auto_emotion_id ); ?>">
			<?php wp_nonce_field( 'auto_emotion_feedback_anfragen_' . $auto_emotion_id, 'auto_emotion_feedback_anfragen_nonce' ); ?>
			<button type="submit" class="ae-btn ae-btn--ghost" style="width:auto;"><?php esc_html_e( 'Erneut per E-Mail anfragen', 'auto-emotion' ); ?></button>
		</form>
	<?php else : ?>
		<p class="ae-intro" style="margin:0 0 12px;"><?php esc_html_e( 'Frage eine kurze, freiwillige Rückmeldung zur Bewerbungserfahrung an.', 'auto-emotion' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="auto_emotion_feedback_anfragen">
			<input type="hidden" name="ae_bewerbung_id" value="<?php echo esc_attr( $auto_emotion_id ); ?>">
			<?php wp_nonce_field( 'auto_emotion_feedback_anfragen_' . $auto_emotion_id, 'auto_emotion_feedback_anfragen_nonce' ); ?>
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Feedback anfragen', 'auto-emotion' ); ?></button>
		</form>
	<?php endif; ?>
</div>
<?php endif; ?>

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
	<p class="ae-list__meta" style="margin-top:12px;">
		<a href="<?php echo esc_url( add_query_arg( 'bewerbung_id', $auto_emotion_id, home_url( '/mitarbeiter/nachrichten/' ) ) ); ?>"><?php esc_html_e( 'Oder im Team teilen (interne Nachricht) →', 'auto-emotion' ); ?></a>
	</p>
</div>

<div class="ae-form-actions">
	<a class="ae-btn ae-btn--danger" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_bewerbung_delete&ae_bewerbung_id=' . $auto_emotion_id ), 'auto_emotion_bewerbung_delete_' . $auto_emotion_id ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Bewerbung wirklich in den Papierkorb verschieben? Unterlagen werden nach 30 Tagen endgültig gelöscht.', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'In den Papierkorb', 'auto-emotion' ); ?></a>
</div>

<?php auto_emotion_staff_shell_end(); ?>
