<?php
/**
 * Automatisierung & KI: Statusübersicht.
 * Erwartet: $auto_emotion_funktionen (array), $auto_emotion_status_labels (array)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_status_css = array(
	'live'      => 'eingestellt',
	'teilweise' => 'interview',
	'geplant'   => 'pausiert',
);

auto_emotion_staff_shell_start( __( 'Automatisierung & KI', 'auto-emotion' ), 'automatisierung' );
?>

<h1><?php esc_html_e( 'Automatisierung & KI', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Ehrlicher Stand zu den Funktionen, die moderne Recruiting-Plattformen bewerben – was bei uns bereits läuft, was manuell/teilweise geht, und was echte, bisher fehlende Voraussetzungen bräuchte (API-Zugänge, Portal-Partnerschaften, eine Entscheidung für einen KI-Anbieter). Keine erfundenen Live-Status.', 'auto-emotion' ); ?>
</p>

<ul class="ae-list">
	<?php foreach ( $auto_emotion_funktionen as $auto_emotion_f ) : ?>
		<?php $auto_emotion_css_suffix = isset( $auto_emotion_status_css[ $auto_emotion_f['status'] ] ) ? $auto_emotion_status_css[ $auto_emotion_f['status'] ] : 'pausiert'; ?>
		<li>
			<div class="ae-list__main">
				<p class="ae-list__title">
					<?php echo esc_html( $auto_emotion_f['titel'] ); ?>
					<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_css_suffix ); ?>"><?php echo esc_html( $auto_emotion_status_labels[ $auto_emotion_f['status'] ] ); ?></span>
				</p>
				<p class="ae-list__meta" style="max-width:62ch;"><?php echo esc_html( $auto_emotion_f['beschreibung'] ); ?></p>
			</div>
			<?php if ( ! empty( $auto_emotion_f['link'] ) ) : ?>
				<div class="ae-list__actions">
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( home_url( $auto_emotion_f['link'] ) ); ?>"><?php echo esc_html( $auto_emotion_f['link_label'] ); ?></a>
				</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

<?php auto_emotion_staff_shell_end(); ?>
