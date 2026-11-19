<?php
/**
 * Stellenanzeigen-Text-Generator: fertiger Text zum Kopieren für
 * externe Jobportale und Social Media, kein automatisches Posten.
 * Erwartet: $auto_emotion_form_post (WP_Post)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_post_id = $auto_emotion_form_post->ID;
$auto_emotion_texte    = auto_emotion_stellenanzeige_texte( $auto_emotion_form_post );
$auto_emotion_link     = get_post_meta( $auto_emotion_post_id, '_suchprofil_bewerbungslink', true );

auto_emotion_staff_shell_start( __( 'Stellenanzeige', 'auto-emotion' ) . ' – ' . $auto_emotion_form_post->post_title, 'dashboard' );
?>

<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' . $auto_emotion_post_id . '/' ) ); ?>">← <?php echo esc_html( $auto_emotion_form_post->post_title ); ?></a>

<h1><?php esc_html_e( 'Stellenanzeige', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Fertiger Text zum Kopieren für Bundesagentur für Arbeit (JOBBÖRSE – kostenlos, aber ohne öffentliche Veröffentlichungs-API, daher manuell einfügen), Indeed & Co., sowie eine kürzere Caption für Instagram/TikTok/LinkedIn. Es wird nichts automatisch gepostet.', 'auto-emotion' ); ?>
</p>

<?php if ( ! $auto_emotion_link ) : ?>
	<p class="ae-notice" style="background:rgba(178,80,0,.1); border-color:var(--ae-warning); color:var(--ae-warning);">
		<?php esc_html_e( 'Kein Bewerbungslink im Suchprofil hinterlegt – der Text verweist aktuell nur auf die Startseite. Trag im Suchprofil-Formular am besten die echte Karriere-Seiten-URL ein.', 'auto-emotion' ); ?>
	</p>
<?php endif; ?>

<div class="ae-card">
	<h2><?php esc_html_e( 'Stellenanzeige (Arbeitsagentur, Indeed, StepStone, …)', 'auto-emotion' ); ?></h2>
	<div class="ae-field">
		<textarea rows="12" readonly onclick="this.select();"><?php echo esc_textarea( $auto_emotion_texte['anzeige'] ); ?></textarea>
	</div>
	<div class="ae-toolbar" style="margin-bottom:0;">
		<span class="ae-list__meta"><?php esc_html_e( 'Zum Kopieren anklicken, dann Strg/Cmd+C', 'auto-emotion' ); ?></span>
		<div style="display:flex; gap:8px; flex-wrap:wrap;">
			<a class="ae-btn ae-btn--ghost" href="https://www.arbeitsagentur.de/unternehmen/arbeitskraefte/stellenangebot-melden" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Arbeitsagentur öffnen ↗', 'auto-emotion' ); ?></a>
			<a class="ae-btn ae-btn--ghost" href="https://de.indeed.com/hire" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Indeed öffnen ↗', 'auto-emotion' ); ?></a>
			<a class="ae-btn ae-btn--ghost" href="https://www.stepstone.de/e/jobanzeige-schalten.html" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'StepStone öffnen ↗', 'auto-emotion' ); ?></a>
			<a class="ae-btn ae-btn--ghost" href="https://job-shop.meinestadt.de/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'meinestadt.de öffnen ↗', 'auto-emotion' ); ?></a>
			<a class="ae-btn ae-btn--ghost" href="https://www.jobware.de/fuer-arbeitgeber/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Jobware öffnen ↗', 'auto-emotion' ); ?></a>
		</div>
	</div>
</div>

<div class="ae-card">
	<h2><?php esc_html_e( 'Social-Media-Caption (Instagram/TikTok/LinkedIn)', 'auto-emotion' ); ?></h2>
	<div class="ae-field">
		<textarea rows="6" readonly onclick="this.select();"><?php echo esc_textarea( $auto_emotion_texte['caption'] ); ?></textarea>
	</div>
	<p class="ae-list__meta" style="margin:0;"><?php esc_html_e( 'Passendes Foto/Video (z. B. Team, Werkstatt, Fahrzeug) selbst ergänzen – ein reiner Text-Post performt auf Instagram/TikTok erfahrungsgemäß deutlich schlechter.', 'auto-emotion' ); ?></p>
</div>

<?php auto_emotion_staff_shell_end(); ?>
