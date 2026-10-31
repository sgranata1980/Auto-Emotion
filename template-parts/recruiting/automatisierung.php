<?php
/**
 * Automatisierung & KI: Statusübersicht als Kartenraster mit Icons.
 * Erwartet: $auto_emotion_funktionen (array), $auto_emotion_status_labels (array),
 * $auto_emotion_dsgvo_log (array)
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

/**
 * Kleine, einheitliche 24x24-Strich-Icons je Funktion – rein
 * dekorativ (aria-hidden), identischer Stil wie die KPI-Icons im
 * Dashboard (stroke-width 1.6, currentColor).
 */
function auto_emotion_automatisierung_icon( $slug ) {
	$icons = array(
		'anzeige'     => '<path d="M6 2h9l5 5v15H6V2Z" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M9 12h8M9 16h8M9 8h4" stroke="currentColor" stroke-width="1.6"/>',
		'multiposting' => '<circle cx="5.5" cy="12" r="2.3" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="5.5" r="2.3" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18.5" r="2.3" stroke="currentColor" stroke-width="1.6"/><path d="m7.5 10.8 7.8-4.3M7.5 13.2l7.8 4.3" stroke="currentColor" stroke-width="1.6"/>',
		'social'      => '<path d="M3 10v4h3l5 4V6L6 10H3Z" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M16 9c1 1 1 5 0 6M19 6.5c2 2.5 2 8.5 0 11" stroke="currentColor" stroke-width="1.6" fill="none"/>',
		'funnel'      => '<path d="M4 4h16l-6 8v6l-4 2v-8L4 4Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/>',
		'erstkontakt' => '<path d="M4 6h12v11H4z" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="m4 6 6 6 6-6" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M18.5 3.5 16 9h3l-2.5 5.5" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/>',
		'whatsapp'    => '<path d="M5 19l1.3-3.8A8 8 0 1 1 9.3 18L5 19Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/><path d="M9 10.5c0 2.8 2.2 5 5 5" stroke="currentColor" stroke-width="1.6"/>',
		'telefon'     => '<path d="M6 3h4l1.5 4L9 9c1 2.5 2.5 4 5 5l2-2.5 4 1.5v4c0 1-1 2-2 2C11.5 19 5 12.5 5 6c0-1 1-2 1-3Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/>',
		'ki'          => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M18.4 5.6l-2.1 2.1M7.7 16.3l-2.1 2.1" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>',
		'termin'      => '<rect x="4" y="5" width="16" height="15" rx="1.5" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M4 9.5h16M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.6"/><path d="M9 14l2 2 4-4" stroke="currentColor" stroke-width="1.6" fill="none"/>',
		'herkunft'    => '<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="m15 9-2 6-6 2 2-6 6-2Z" stroke="currentColor" stroke-width="1.4" fill="none" stroke-linejoin="round"/>',
		'dubletten'   => '<rect x="4" y="4" width="12" height="12" rx="1.5" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M8 20h10a1.5 1.5 0 0 0 1.5-1.5V8" stroke="currentColor" stroke-width="1.6" fill="none"/>',
		'talentpool'  => '<path d="m12 3 2.6 5.6 6.1.7-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6-4.5-4.2 6.1-.7L12 3Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>',
		'dsgvo'       => '<path d="M12 3 5 6v6c0 4.5 3 7.5 7 9 4-1.5 7-4.5 7-9V6l-7-3Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/><path d="m9.5 12 1.8 1.8L15 10" stroke="currentColor" stroke-width="1.6" fill="none"/>',
	);

	return isset( $icons[ $slug ] ) ? $icons[ $slug ] : $icons['anzeige'];
}

auto_emotion_staff_shell_start( __( 'Automatisierung & KI', 'auto-emotion' ), 'automatisierung' );
?>

<h1><?php esc_html_e( 'Automatisierung & KI', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Ehrlicher Stand zu den Funktionen, die moderne Recruiting-Plattformen bewerben – was bei uns bereits läuft, was manuell/teilweise geht, und was echte, bisher fehlende Voraussetzungen bräuchte (API-Zugänge, Portal-Partnerschaften, eine Entscheidung für einen KI-Anbieter). Keine erfundenen Live-Status.', 'auto-emotion' ); ?>
</p>

<div class="ae-automation-grid">
	<?php foreach ( $auto_emotion_funktionen as $auto_emotion_f ) : ?>
		<?php
		$auto_emotion_css_suffix = isset( $auto_emotion_status_css[ $auto_emotion_f['status'] ] ) ? $auto_emotion_status_css[ $auto_emotion_f['status'] ] : 'pausiert';
		$auto_emotion_icon_slug  = isset( $auto_emotion_f['icon'] ) ? $auto_emotion_f['icon'] : 'anzeige';
		?>
		<div class="ae-automation-card ae-automation-card--<?php echo esc_attr( $auto_emotion_f['status'] ); ?>">
			<div class="ae-automation-card__top">
				<span class="ae-automation-card__icon" aria-hidden="true">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><?php echo auto_emotion_automatisierung_icon( $auto_emotion_icon_slug ); // phpcs:ignore WordPress.Security.EscapeOutput -- fest definierte, eigene SVG-Pfade ohne Nutzereingabe. ?></svg>
				</span>
				<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_css_suffix ); ?>"><?php echo esc_html( $auto_emotion_status_labels[ $auto_emotion_f['status'] ] ); ?></span>
			</div>
			<p class="ae-automation-card__title"><?php echo esc_html( $auto_emotion_f['titel'] ); ?></p>
			<p class="ae-automation-card__beschreibung"><?php echo esc_html( $auto_emotion_f['beschreibung'] ); ?></p>
			<?php if ( ! empty( $auto_emotion_f['link'] ) ) : ?>
				<a class="ae-btn ae-btn--ghost" style="width:auto; margin-top:auto;" href="<?php echo esc_url( home_url( $auto_emotion_f['link'] ) ); ?>"><?php echo esc_html( $auto_emotion_f['link_label'] ); ?></a>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>

<?php if ( ! empty( $auto_emotion_dsgvo_log ) ) : ?>
	<div class="ae-card" style="margin-top:32px;">
		<h2><?php esc_html_e( 'DSGVO-Lösch-Protokoll', 'auto-emotion' ); ?></h2>
		<p class="ae-list__meta" style="margin:-4px 0 12px;"><?php esc_html_e( 'Nachweis ausgeführter Löschanträge – bewusst ohne Name, E-Mail oder Telefon der betroffenen Person, nur Datum, Bearbeiter und Position.', 'auto-emotion' ); ?></p>
		<ul style="margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:8px;">
			<?php foreach ( array_slice( $auto_emotion_dsgvo_log, 0, 10 ) as $auto_emotion_log_eintrag ) : ?>
				<li class="ae-list__meta">
					<?php echo esc_html( mysql2date( 'd.m.Y H:i', $auto_emotion_log_eintrag['datum'] ) ); ?> Uhr
					· <?php echo esc_html( $auto_emotion_log_eintrag['bearbeiter'] ); ?>
					<?php if ( ! empty( $auto_emotion_log_eintrag['position'] ) ) : ?>
						· <?php echo esc_html( $auto_emotion_log_eintrag['position'] ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
