<?php
/**
 * Vehicle strip: latest "Angebot" per brand (Cupra, Seat, Nissan).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="vehicle-strip" aria-label="<?php esc_attr_e( 'Neueste Fahrzeuge je Marke', 'auto-emotion' ); ?>">
	<?php foreach ( array( 'Cupra', 'Seat', 'Nissan' ) as $auto_emotion_marke_name ) : ?>
		<?php
		$auto_emotion_marke_term = get_term_by( 'name', $auto_emotion_marke_name, 'marke' );
		$auto_emotion_latest_kfz = null;

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
				$auto_emotion_latest_kfz = get_post();
			}
			wp_reset_postdata();
		}
		?>
		<?php if ( $auto_emotion_latest_kfz ) : ?>
			<a class="vehicle-strip__item" href="<?php echo esc_url( get_permalink( $auto_emotion_latest_kfz ) ); ?>">
				<?php if ( has_post_thumbnail( $auto_emotion_latest_kfz ) ) : ?>
					<?php echo get_the_post_thumbnail( $auto_emotion_latest_kfz, 'large', array( 'class' => 'vehicle-strip__image' ) ); ?>
				<?php else : ?>
					<span class="vehicle-strip__placeholder"><?php echo esc_html( $auto_emotion_marke_name ); ?></span>
				<?php endif; ?>
				<span class="vehicle-strip__brand"><?php echo esc_html( $auto_emotion_marke_name ); ?></span>
				<h3 class="vehicle-strip__title"><?php echo esc_html( get_the_title( $auto_emotion_latest_kfz ) ); ?></h3>
			</a>
		<?php else : ?>
			<a class="vehicle-strip__item" href="<?php echo esc_url( $auto_emotion_marke_term ? get_term_link( $auto_emotion_marke_term ) : '#' ); ?>">
				<span class="vehicle-strip__placeholder"><?php esc_html_e( 'Demnächst', 'auto-emotion' ); ?></span>
				<span class="vehicle-strip__brand"><?php echo esc_html( $auto_emotion_marke_name ); ?></span>
				<h3 class="vehicle-strip__title"><?php esc_html_e( 'Neue Modelle folgen', 'auto-emotion' ); ?></h3>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
