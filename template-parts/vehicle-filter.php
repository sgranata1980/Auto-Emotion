<?php
/**
 * Fahrzeug-Filter (Angebote-Archiv): Kachel-UI im bmw.de-Stil
 * (Icon-Kacheln für Karosserieform/Antriebsart, Textkacheln für
 * Marke), angepasst an unsere eckige Dark-Theater-Formensprache statt
 * BMWs abgerundeten Karten. Filtert per GET-Parameter
 * (marke/karosserie[]/antrieb[]) dasselbe Angebot-Archiv wie die
 * Fahrzeugsuche auf der Startseite (siehe inc/cpt.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_marken      = get_terms( array( 'taxonomy' => 'marke', 'hide_empty' => false ) );
$auto_emotion_karosserien = get_terms( array( 'taxonomy' => 'karosserie', 'hide_empty' => false ) );
$auto_emotion_antriebe    = get_terms( array( 'taxonomy' => 'antrieb', 'hide_empty' => false ) );

$auto_emotion_active_marke      = isset( $_GET['marke'] ) ? sanitize_title( wp_unslash( $_GET['marke'] ) ) : '';
$auto_emotion_active_karosserie = isset( $_GET['karosserie'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET['karosserie'] ) ) : array();
$auto_emotion_active_antrieb    = isset( $_GET['antrieb'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET['antrieb'] ) ) : array();

/**
 * Schlichte Umriss-Icons je Karosserieform/Antriebsart - eigene,
 * einfache Formensprache (kein Fremd-Icon-Set kopiert), passend zum
 * Rest des Themes mit stroke="currentColor".
 */
function auto_emotion_vehicle_filter_icon( $slug ) {
	$icons = array(
		'suv'          => '<path d="M3 17h18M5 17l1.5-6.5a2 2 0 0 1 1.95-1.5h7.1a2 2 0 0 1 1.95 1.5L19 17M8 10V6h8v4" /><circle cx="7.5" cy="17.5" r="1.5" /><circle cx="16.5" cy="17.5" r="1.5" />',
		'kombi'        => '<path d="M2 16h20M3 16l1-5a2 2 0 0 1 2-1.6h3L10 5h7l3 4.4h0a2 2 0 0 1 2 1.6l1 5" /><circle cx="7" cy="16.5" r="1.5" /><circle cx="17" cy="16.5" r="1.5" />',
		'kompakt'      => '<path d="M2.5 16h19M3.5 16l1-4.5a2 2 0 0 1 2-1.6h2L11 6h4l3 3.9h0.5a2 2 0 0 1 2 1.6l1 4.5" /><circle cx="7.5" cy="16.5" r="1.5" /><circle cx="16.5" cy="16.5" r="1.5" />',
		'kleinwagen'   => '<path d="M3 16h18M4 16l0.8-3.6a2 2 0 0 1 2-1.6h10.4a2 2 0 0 1 2 1.6L20 16M7.5 10.8 9 6.5h6l1.5 4.3" /><circle cx="7.5" cy="16.5" r="1.5" /><circle cx="16.5" cy="16.5" r="1.5" />',
		'nutzfahrzeug' => '<path d="M2 16h2M4 16V7a1 1 0 0 1 1-1h8.5a1 1 0 0 1 .8.4L19 11h1a1 1 0 0 1 1 1v4h-2M4 16h10.5M18 16h-3.5V9h0l3 3.3V16Z" /><circle cx="7" cy="17" r="1.6" /><circle cx="17" cy="17" r="1.6" />',
		'benzin'       => '<path d="M5 20V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M4 20h10M7 20v-6h4v6M15 9l2.3 2.3a1 1 0 0 1 .3.7V17a1.3 1.3 0 0 0 2.6 0v-3.2a1 1 0 0 0-.3-.7L17.5 10.7M8 8h2" />',
		'diesel'       => '<path d="M5 20V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M4 20h10M7 20v-6h4v6M15 9l2.3 2.3a1 1 0 0 1 .3.7V17a1.3 1.3 0 0 0 2.6 0v-3.2a1 1 0 0 0-.3-.7L17.5 10.7M8 8h2M11.5 4.5c0 1-1 1.3-1 2.3a1 1 0 0 0 2 0c0-1-1-1.3-1-2.3Z" />',
		'hybrid'       => '<path d="M13 3 6.5 13h4.5L9 21l8-11h-4.5L15 3Z" />',
		'elektro'      => '<path d="M8 3h7l-1.5 7H17l-9 11 2-9H6.5L8 3Z" />',
	);

	echo $icons[ $slug ] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput -- feste, eigene SVG-Pfade, kein Nutzereingang.
}
?>
<div class="vehicle-filter">
	<form class="vehicle-filter__form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">

		<?php if ( ! is_wp_error( $auto_emotion_karosserien ) && $auto_emotion_karosserien ) : ?>
			<fieldset class="vehicle-filter__group">
				<legend class="vehicle-filter__legend"><?php esc_html_e( 'Karosserie', 'auto-emotion' ); ?></legend>
				<div class="vehicle-filter__tiles vehicle-filter__tiles--icons">
					<?php foreach ( $auto_emotion_karosserien as $auto_emotion_k ) : ?>
						<label class="vehicle-filter__tile">
							<input
								type="checkbox"
								name="karosserie[]"
								value="<?php echo esc_attr( $auto_emotion_k->slug ); ?>"
								<?php checked( in_array( $auto_emotion_k->slug, $auto_emotion_active_karosserie, true ) ); ?>
							>
							<svg class="vehicle-filter__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<?php auto_emotion_vehicle_filter_icon( $auto_emotion_k->slug ); ?>
							</svg>
							<span><?php echo esc_html( $auto_emotion_k->name ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>
		<?php endif; ?>

		<?php if ( ! is_wp_error( $auto_emotion_marken ) && $auto_emotion_marken ) : ?>
			<fieldset class="vehicle-filter__group">
				<legend class="vehicle-filter__legend"><?php esc_html_e( 'Marke', 'auto-emotion' ); ?></legend>
				<div class="vehicle-filter__tiles">
					<label class="vehicle-filter__tile vehicle-filter__tile--text">
						<input type="radio" name="marke" value="" <?php checked( '' === $auto_emotion_active_marke ); ?>>
						<span><?php esc_html_e( 'Alle', 'auto-emotion' ); ?></span>
					</label>
					<?php foreach ( $auto_emotion_marken as $auto_emotion_marke ) : ?>
						<label class="vehicle-filter__tile vehicle-filter__tile--text">
							<input
								type="radio"
								name="marke"
								value="<?php echo esc_attr( $auto_emotion_marke->slug ); ?>"
								<?php checked( $auto_emotion_marke->slug === $auto_emotion_active_marke ); ?>
							>
							<span><?php echo esc_html( $auto_emotion_marke->name ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>
		<?php endif; ?>

		<?php if ( ! is_wp_error( $auto_emotion_antriebe ) && $auto_emotion_antriebe ) : ?>
			<fieldset class="vehicle-filter__group">
				<legend class="vehicle-filter__legend"><?php esc_html_e( 'Antriebsart', 'auto-emotion' ); ?></legend>
				<div class="vehicle-filter__tiles vehicle-filter__tiles--icons">
					<?php foreach ( $auto_emotion_antriebe as $auto_emotion_a ) : ?>
						<label class="vehicle-filter__tile">
							<input
								type="checkbox"
								name="antrieb[]"
								value="<?php echo esc_attr( $auto_emotion_a->slug ); ?>"
								<?php checked( in_array( $auto_emotion_a->slug, $auto_emotion_active_antrieb, true ) ); ?>
							>
							<svg class="vehicle-filter__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<?php auto_emotion_vehicle_filter_icon( $auto_emotion_a->slug ); ?>
							</svg>
							<span><?php echo esc_html( $auto_emotion_a->name ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>
		<?php endif; ?>

		<div class="vehicle-filter__actions">
			<button type="submit" class="btn btn-giallo vehicle-filter__submit">
				<?php esc_html_e( 'Filtern', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</button>
			<?php if ( $auto_emotion_active_marke || $auto_emotion_active_karosserie || $auto_emotion_active_antrieb ) : ?>
				<a class="btn btn-outline vehicle-filter__reset" href="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
					<?php esc_html_e( 'Zurücksetzen', 'auto-emotion' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</form>
</div>
