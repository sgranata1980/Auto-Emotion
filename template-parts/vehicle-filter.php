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

// auto_emotion_vehicle_filter_icon() ist zentral in inc/cpt.php definiert,
// da auch die Karosserie-Schnellauswahl auf der Startseite sie braucht.
?>
<div class="vehicle-filter">
	<h2 class="vehicle-filter__title"><?php esc_html_e( 'Filter', 'auto-emotion' ); ?></h2>
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
