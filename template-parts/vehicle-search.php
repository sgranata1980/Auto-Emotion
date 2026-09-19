<?php
/**
 * Fahrzeugsuche (Startseite) – Marken-Filter auf das echte
 * Angebot-Archiv, mit echter, live gezählter Fahrzeuganzahl statt
 * einer erfundenen Zahl.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_marken = get_terms(
	array(
		'taxonomy'   => 'marke',
		'hide_empty' => false,
	)
);

$auto_emotion_angebot_count = (int) wp_count_posts( 'angebot' )->publish;
?>
<section class="vehicle-search" aria-labelledby="vehicle-search-heading">
	<div class="vehicle-search__grid">
		<div class="vehicle-search__visual">
			<video
				class="vehicle-search__video"
				autoplay
				muted
				loop
				playsinline
				poster="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/cover-reveal.jpg' ); ?>"
			>
				<source src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/videos/cover-reveal.mp4' ); ?>" type="video/mp4">
			</video>
		</div>

		<div class="vehicle-search__inner">
			<h2 id="vehicle-search-heading" class="vehicle-search__headline"><?php esc_html_e( 'Fahrzeugsuche', 'auto-emotion' ); ?></h2>
			<p><?php esc_html_e( 'Fahrzeug finden. Anfragen. Losfahren.', 'auto-emotion' ); ?></p>

			<form class="vehicle-search__form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
				<div class="vehicle-search__field">
					<label for="vehicle-search-marke"><?php esc_html_e( 'Marke', 'auto-emotion' ); ?></label>
					<select id="vehicle-search-marke" name="marke">
						<option value=""><?php esc_html_e( 'Alle', 'auto-emotion' ); ?></option>
						<?php if ( ! is_wp_error( $auto_emotion_marken ) ) : ?>
							<?php foreach ( $auto_emotion_marken as $auto_emotion_marke ) : ?>
								<option value="<?php echo esc_attr( $auto_emotion_marke->slug ); ?>"><?php echo esc_html( $auto_emotion_marke->name ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>

				<p class="vehicle-search__count">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %d: number of available vehicles */
							_n( '%d sofort verfügbares Fahrzeug', '%d sofort verfügbare Fahrzeuge', $auto_emotion_angebot_count, 'auto-emotion' ),
							$auto_emotion_angebot_count
						)
					);
					?>
				</p>

				<button type="submit" class="btn btn-giallo vehicle-search__submit">
					<?php esc_html_e( 'Suchen', 'auto-emotion' ); ?>
					<span class="btn-arrow" aria-hidden="true">&rarr;</span>
				</button>
			</form>
		</div>
	</div>
</section>
