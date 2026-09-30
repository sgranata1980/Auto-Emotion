<?php
/**
 * Formular-Ansicht (Neu & Bearbeiten) des Mitarbeiterbereichs.
 * Erwartet: $auto_emotion_form_post (WP_Post|null)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_is_edit = ! empty( $auto_emotion_form_post );
$auto_emotion_post_id = $auto_emotion_is_edit ? $auto_emotion_form_post->ID : 0;

$auto_emotion_title       = $auto_emotion_is_edit ? $auto_emotion_form_post->post_title : '';
$auto_emotion_standort    = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_suchprofil_standort', true ) : '';
$auto_emotion_art         = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_suchprofil_anstellungsart', true ) : '';
$auto_emotion_status      = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_suchprofil_status', true ) : 'aktiv';
$auto_emotion_stichworte  = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_suchprofil_stichworte', true ) : '';
$auto_emotion_bewerbungslink = $auto_emotion_is_edit ? get_post_meta( $auto_emotion_post_id, '_suchprofil_bewerbungslink', true ) : '';

if ( ! $auto_emotion_status ) {
	$auto_emotion_status = 'aktiv';
}

$auto_emotion_art_optionen = array(
	''            => __( '– bitte wählen –', 'auto-emotion' ),
	'vollzeit'    => __( 'Vollzeit', 'auto-emotion' ),
	'teilzeit'    => __( 'Teilzeit', 'auto-emotion' ),
	'ausbildung'  => __( 'Ausbildung', 'auto-emotion' ),
	'werkstudent' => __( 'Werkstudent/in', 'auto-emotion' ),
	'praktikum'   => __( 'Praktikum', 'auto-emotion' ),
);

$auto_emotion_status_optionen = array(
	'aktiv'    => __( 'Aktiv', 'auto-emotion' ),
	'pausiert' => __( 'Pausiert', 'auto-emotion' ),
	'besetzt'  => __( 'Besetzt', 'auto-emotion' ),
);
$auto_emotion_seite_titel = $auto_emotion_is_edit ? __( 'Suchprofil bearbeiten', 'auto-emotion' ) : __( 'Neues Suchprofil', 'auto-emotion' );
auto_emotion_staff_shell_start( $auto_emotion_seite_titel, 'dashboard' );
?>

<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' ) ); ?>">← <?php esc_html_e( 'Zurück zur Übersicht', 'auto-emotion' ); ?></a>

<h1><?php echo esc_html( $auto_emotion_seite_titel ); ?></h1>

<?php if ( $auto_emotion_is_edit ) : ?>
	<?php $auto_emotion_bewerbungen_anzahl = count( auto_emotion_bewerbungen_fuer_position( $auto_emotion_title ) ); ?>
	<div class="ae-kpis">
		<div class="ae-kpi">
			<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_bewerbungen_anzahl ); ?></div>
			<div class="ae-kpi__label"><?php esc_html_e( 'Eingegangene Bewerbungen', 'auto-emotion' ); ?></div>
		</div>
		<div class="ae-kpi">
			<div class="ae-kpi__value"><?php echo esc_html( count( auto_emotion_get_kandidaten( $auto_emotion_post_id ) ) ); ?></div>
			<div class="ae-kpi__label"><?php esc_html_e( 'Kandidaten auf der Liste', 'auto-emotion' ); ?></div>
		</div>
	</div>
	<p class="ae-list__meta" style="margin:-16px 0 20px;">
		<?php if ( $auto_emotion_bewerbungen_anzahl > 0 ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'position', rawurlencode( $auto_emotion_title ), home_url( '/mitarbeiter/bewerbungen/' ) ) ); ?>"><?php esc_html_e( 'Bewerbungen zu dieser Stelle ansehen →', 'auto-emotion' ); ?></a>
			·
		<?php endif; ?>
		<a href="<?php echo esc_url( add_query_arg( 'suchprofil_id', $auto_emotion_post_id, home_url( '/mitarbeiter/nachrichten/' ) ) ); ?>"><?php esc_html_e( 'Im Team teilen →', 'auto-emotion' ); ?></a>
	</p>
<?php endif; ?>

<div class="ae-card">
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="auto_emotion_recruiting_save">
		<input type="hidden" name="ae_profile_id" value="<?php echo esc_attr( $auto_emotion_post_id ); ?>">
		<?php wp_nonce_field( 'auto_emotion_recruiting_save', 'auto_emotion_recruiting_save_nonce' ); ?>

		<div class="ae-field ae-field--full">
			<label for="ae_titel"><?php esc_html_e( 'Position / Titel', 'auto-emotion' ); ?></label>
			<input type="text" id="ae_titel" name="ae_titel" value="<?php echo esc_attr( $auto_emotion_title ); ?>" placeholder="z. B. Kfz-Mechatroniker/in Cupra/Seat" required>
		</div>

		<div class="ae-form-grid">
			<div class="ae-field">
				<label for="ae_standort"><?php esc_html_e( 'Standort', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_standort" name="ae_standort" value="<?php echo esc_attr( $auto_emotion_standort ); ?>" placeholder="Offenbach am Main">
			</div>
			<div class="ae-field">
				<label for="ae_anstellungsart"><?php esc_html_e( 'Anstellungsart', 'auto-emotion' ); ?></label>
				<select id="ae_anstellungsart" name="ae_anstellungsart">
					<?php foreach ( $auto_emotion_art_optionen as $wert => $label ) : ?>
						<option value="<?php echo esc_attr( $wert ); ?>" <?php selected( $auto_emotion_art, $wert ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_status"><?php esc_html_e( 'Status', 'auto-emotion' ); ?></label>
				<select id="ae_status" name="ae_status">
					<?php foreach ( $auto_emotion_status_optionen as $wert => $label ) : ?>
						<option value="<?php echo esc_attr( $wert ); ?>" <?php selected( $auto_emotion_status, $wert ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_stichworte"><?php esc_html_e( 'Gesuchte Skills / Stichworte', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_stichworte" name="ae_stichworte" value="<?php echo esc_attr( $auto_emotion_stichworte ); ?>" placeholder="Kfz-Mechatroniker, Diagnose, Service Berater">
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_bewerbungslink"><?php esc_html_e( 'Bewerbungslink (echte Karriere-Seite für diese Position)', 'auto-emotion' ); ?></label>
				<input type="url" id="ae_bewerbungslink" name="ae_bewerbungslink" value="<?php echo esc_attr( $auto_emotion_bewerbungslink ); ?>" placeholder="https://autoemotion.stefanogranata.de/karriere-mechatroniker/">
			</div>
		</div>

		<div class="ae-form-actions">
			<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( 'Speichern', 'auto-emotion' ); ?></button>
			<?php if ( $auto_emotion_is_edit ) : ?>
				<a class="ae-btn ae-btn--danger" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_recruiting_delete&ae_profile_id=' . $auto_emotion_post_id ), 'auto_emotion_recruiting_delete_' . $auto_emotion_post_id ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Suchprofil wirklich in den Papierkorb verschieben?', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'Löschen', 'auto-emotion' ); ?></a>
			<?php endif; ?>
		</div>
	</form>
</div>

<?php auto_emotion_staff_shell_end(); ?>
