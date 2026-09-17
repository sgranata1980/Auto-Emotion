<?php
/**
 * Model Showcase: ein Fahrzeug pro Marke (Cupra, Seat, Nissan) im
 * Lamborghini-Referenzmuster (Badge, Headline, Foto, CTA-Reihen, Dots).
 *
 * Zeigt je Marke das neueste "Angebot"; ohne Eintrag ein ehrlicher
 * "Demnächst"-Zustand statt erfundener Inhalte.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_showcase_brands = array( 'Cupra', 'Seat', 'Nissan' );
$auto_emotion_showcase_slides = array();

foreach ( $auto_emotion_showcase_brands as $auto_emotion_marke_name ) {
	$auto_emotion_marke_term = get_term_by( 'name', $auto_emotion_marke_name, 'marke' );
	$auto_emotion_kfz        = null;

	if ( $auto_emotion_marke_term ) {
		$auto_emotion_kfz_query = new WP_Query(
			array(
				'post_type'      => 'angebot',
				'posts_per_page' => 1,
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy' => 'marke',
						'field'    => 'term_id',
						'terms'    => $auto_emotion_marke_term->term_id,
					),
				),
			)
		);

		if ( $auto_emotion_kfz_query->have_posts() ) {
			$auto_emotion_kfz_query->the_post();
			$auto_emotion_kfz = get_post();
			wp_reset_postdata();
		}
	}

	$auto_emotion_showcase_slides[] = array(
		'brand' => $auto_emotion_marke_name,
		'post'  => $auto_emotion_kfz,
		'term'  => $auto_emotion_marke_term,
	);
}
?>
<section class="model-showcase" aria-label="<?php esc_attr_e( 'Aktuelles Modell', 'auto-emotion' ); ?>">
	<?php foreach ( $auto_emotion_showcase_slides as $auto_emotion_index => $auto_emotion_slide ) : ?>
		<?php
		$auto_emotion_is_active = ( 0 === $auto_emotion_index );
		$auto_emotion_kfz       = $auto_emotion_slide['post'];
		?>
		<div class="model-showcase__slide" data-slide="<?php echo (int) $auto_emotion_index; ?>" <?php echo $auto_emotion_is_active ? '' : 'hidden'; ?>>
			<?php if ( $auto_emotion_kfz ) : ?>
				<p class="model-showcase__eyebrow"><?php echo esc_html( $auto_emotion_slide['brand'] ); ?></p>
				<h2 class="model-showcase__badge"><?php echo esc_html( get_the_title( $auto_emotion_kfz ) ); ?></h2>
				<p class="model-showcase__headline"><?php echo esc_html( get_the_excerpt( $auto_emotion_kfz ) ); ?></p>

				<?php if ( has_post_thumbnail( $auto_emotion_kfz ) ) : ?>
					<?php echo get_the_post_thumbnail( $auto_emotion_kfz, 'large', array( 'class' => 'model-showcase__photo' ) ); ?>
				<?php endif; ?>

				<a class="btn btn-giallo model-showcase__cta" href="<?php echo esc_url( get_permalink( $auto_emotion_kfz ) ); ?>">
					<?php esc_html_e( 'Modell erkunden', 'auto-emotion' ); ?>
					<span class="btn-arrow" aria-hidden="true">&rarr;</span>
				</a>

				<div class="model-showcase__links">
					<a class="model-showcase__link" href="<?php echo esc_url( auto_emotion_contact( 'email' ) ? 'mailto:' . auto_emotion_contact( 'email' ) . '?subject=' . rawurlencode( 'Konfiguration ' . get_the_title( $auto_emotion_kfz ) ) : '#kontakt' ); ?>">
						<?php esc_html_e( 'Konfiguration starten', 'auto-emotion' ); ?>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 2 21 7v10l-9 5-9-5V7z" stroke="currentColor" stroke-width="1.25"/><path d="M12 2v10m0 0 9-5M12 12 3 7m9 5v10" stroke="currentColor" stroke-width="1.25"/></svg>
					</a>
					<a class="model-showcase__link" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo esc_attr( rawurlencode( 'Anfrage ' . get_the_title( $auto_emotion_kfz ) ) ); ?>">
						<?php esc_html_e( 'Anfrage stellen', 'auto-emotion' ); ?>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="2.5" y="4.5" width="19" height="15" rx="1" stroke="currentColor" stroke-width="1.25"/><path d="m3 5.5 9 7 9-7" stroke="currentColor" stroke-width="1.25"/></svg>
					</a>
				</div>

				<?php if ( get_the_content( null, false, $auto_emotion_kfz ) ) : ?>
					<p class="model-showcase__disclaimer"><?php echo esc_html( wp_strip_all_tags( get_the_content( null, false, $auto_emotion_kfz ) ) ); ?></p>
				<?php endif; ?>
			<?php else : ?>
				<p class="model-showcase__eyebrow"><?php echo esc_html( $auto_emotion_slide['brand'] ); ?></p>
				<h2 class="model-showcase__badge"><?php esc_html_e( 'Demnächst', 'auto-emotion' ); ?></h2>
				<p class="model-showcase__headline"><?php esc_html_e( 'Neue Modelle folgen in Kürze.', 'auto-emotion' ); ?></p>
				<div class="model-showcase__placeholder-photo"><?php esc_html_e( 'Bild folgt', 'auto-emotion' ); ?></div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>

	<?php if ( count( $auto_emotion_showcase_slides ) > 1 ) : ?>
		<div class="model-showcase__dots" role="tablist" aria-label="<?php esc_attr_e( 'Marke wählen', 'auto-emotion' ); ?>">
			<?php foreach ( $auto_emotion_showcase_slides as $auto_emotion_index => $auto_emotion_slide ) : ?>
				<button
					type="button"
					class="model-showcase__dot"
					data-slide-target="<?php echo (int) $auto_emotion_index; ?>"
					aria-current="<?php echo 0 === $auto_emotion_index ? 'true' : 'false'; ?>"
					aria-label="<?php echo esc_attr( $auto_emotion_slide['brand'] ); ?>"
				></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
