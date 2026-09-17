<?php
/**
 * Template for the site front page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
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

<?php
get_template_part( 'template-parts/hero' );

$auto_emotion_marken = get_terms(
	array(
		'taxonomy'   => 'marke',
		'hide_empty' => false,
	)
);
?>

<?php if ( ! is_wp_error( $auto_emotion_marken ) && $auto_emotion_marken ) : ?>
	<section id="marken" aria-labelledby="marken-heading">
		<div class="section-heading">
			<h2 id="marken-heading" class="section-heading__title"><?php esc_html_e( 'Unsere Marken', 'auto-emotion' ); ?></h2>
		</div>

		<div class="story-grid">
			<?php foreach ( $auto_emotion_marken as $marke ) : ?>
				<a class="brand-tile" href="<?php echo esc_url( get_term_link( $marke ) ); ?>">
					<span class="brand-tile__name"><?php echo esc_html( $marke->name ); ?></span>
					<span class="btn-arrow" aria-hidden="true">&rarr;</span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php
$auto_emotion_angebote = new WP_Query(
	array(
		'post_type'      => 'angebot',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
?>
<?php if ( $auto_emotion_angebote->have_posts() ) : ?>
	<section aria-labelledby="angebote-heading">
		<div class="section-heading">
			<h2 id="angebote-heading" class="section-heading__title"><?php esc_html_e( 'Aktuelle Angebote', 'auto-emotion' ); ?></h2>
			<a class="btn btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'angebot' ) ); ?>">
				<?php esc_html_e( 'Alle Angebote', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>

		<div class="story-grid">
			<?php while ( $auto_emotion_angebote->have_posts() ) : $auto_emotion_angebote->the_post(); ?>
				<article class="product-tile">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
					<?php endif; ?>
					<h3 class="product-tile__caption"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				</article>
			<?php endwhile; ?>
		</div>
	</section>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php
$auto_emotion_news = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
?>
<?php if ( $auto_emotion_news->have_posts() ) : ?>
	<section aria-labelledby="news-heading">
		<div class="section-heading">
			<h2 id="news-heading" class="section-heading__title"><?php esc_html_e( 'News', 'auto-emotion' ); ?></h2>
			<?php $auto_emotion_blog_page_id = (int) get_option( 'page_for_posts' ); ?>
			<a class="btn btn-ghost" href="<?php echo esc_url( $auto_emotion_blog_page_id ? get_permalink( $auto_emotion_blog_page_id ) : home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Alle News', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>

		<div class="story-grid">
			<?php while ( $auto_emotion_news->have_posts() ) : $auto_emotion_news->the_post(); ?>
				<article class="story-grid__item">
					<span class="story-grid__date"><?php echo esc_html( get_the_date() ); ?></span>
					<h3 class="story-grid__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large' ); ?>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
		</div>
	</section>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<section class="event-banner" aria-labelledby="service-heading">
	<div class="event-banner__content">
		<p class="hero-stage__eyebrow"><?php esc_html_e( 'Service', 'auto-emotion' ); ?></p>
		<h2 id="service-heading" class="event-banner__headline"><?php esc_html_e( 'Werkstatt, Mietwagen, Notdienst.', 'auto-emotion' ); ?></h2>
		<p><?php echo esc_html( sprintf( __( 'Werkstatt geöffnet: %s', 'auto-emotion' ), auto_emotion_contact( 'hours_service' ) ) ); ?></p>
		<a class="btn btn-giallo" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
</section>

<?php
get_footer();
