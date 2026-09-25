<?php
/**
 * Archive template for the "marke" taxonomy (Cupra, Seat, Nissan).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_term = get_queried_object();

/**
 * Echte Fotos aus dem Showroom statt generischer KI-Bilder, wo
 * bereits welche vorliegen – pro Marke einzeln gepflegt.
 */
$auto_emotion_marke_headers = array(
	'nissan' => array(
		'image' => 'nissan-showroom-juke.jpg',
		'alt'   => 'Nissan-Bereich im Auto Emotion Showroom mit Nissan Juke und Design Lab',
	),
	'seat'   => array(
		'image' => 'marke-seat-header.jpg',
		'alt'   => 'Seat-Bereich im Auto Emotion Showroom mit Seat Arona und Leon',
	),
	'cupra'  => array(
		'image' => 'marke-cupra-header.jpg',
		'alt'   => 'Cupra-Bereich im Auto Emotion Showroom mit Cupra Formentor und Arona zum 25-jährigen Jubiläum',
	),
);
$auto_emotion_marke_header  = $auto_emotion_marke_headers[ $auto_emotion_term->slug ] ?? null;
?>

<?php if ( $auto_emotion_marke_header ) : ?>
	<img class="content-header-image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_marke_header['image'] ); ?>" alt="<?php echo esc_attr( $auto_emotion_marke_header['alt'] ); ?>" loading="lazy">
<?php endif; ?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php echo esc_html( $auto_emotion_term->name ); ?></h1>
</div>

<?php if ( $auto_emotion_term->description ) : ?>
	<div class="archive-description"><?php echo wp_kses_post( wpautop( $auto_emotion_term->description ) ); ?></div>
<?php endif; ?>

<?php
$auto_emotion_marke_modelle = array(
	'nissan' => array(
		array(
			'image' => 'nissan-modell-juke.jpg',
			'name'  => 'Nissan Juke',
		),
		array(
			'image' => 'nissan-modell-qashqai.jpg',
			'name'  => 'Nissan Qashqai',
		),
		array(
			'image' => 'nissan-modell-xtrail.jpg',
			'name'  => 'Nissan X-Trail',
		),
		array(
			'image' => 'nissan-modell-ariya.jpg',
			'name'  => 'Nissan Ariya',
		),
	),
	'seat'   => array(
		array(
			'image' => 'seat-modell-arona.jpg',
			'name'  => 'Seat Arona',
		),
		array(
			'image' => 'seat-modell-ateca.jpg',
			'name'  => 'Seat Ateca',
		),
		array(
			'image' => 'seat-modell-ibiza.jpg',
			'name'  => 'Seat Ibiza',
		),
		array(
			'image' => 'seat-modell-leon.jpg',
			'name'  => 'Seat Leon',
		),
		array(
			'image' => 'seat-modell-leon-sportstourer.jpg',
			'name'  => 'Seat Leon Sportstourer',
		),
	),
	'cupra'  => array(
		array(
			'image' => 'cupra-modell-born.jpg',
			'name'  => 'Cupra Born',
		),
		array(
			'image' => 'cupra-modell-tavascan.jpg',
			'name'  => 'Cupra Tavascan',
		),
		array(
			'image' => 'cupra-modell-terramar.jpg',
			'name'  => 'Cupra Terramar',
		),
		array(
			'image' => 'cupra-modell-formentor.jpg',
			'name'  => 'Cupra Formentor',
		),
		array(
			'image' => 'cupra-modell-leon.jpg',
			'name'  => 'Cupra Leon',
		),
		array(
			'image' => 'cupra-modell-leon-sportstourer.jpg',
			'name'  => 'Cupra Leon Sportstourer',
		),
	),
);
$auto_emotion_modelle       = $auto_emotion_marke_modelle[ $auto_emotion_term->slug ] ?? array();
?>

<?php if ( $auto_emotion_modelle ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title">
			<?php
			/* translators: %s: brand name, e.g. "Seat" */
			printf( esc_html__( 'Unsere %s-Modelle', 'auto-emotion' ), esc_html( $auto_emotion_term->name ) );
			?>
		</h2>
	</div>
	<div class="photo-gallery photo-gallery--products">
		<?php foreach ( $auto_emotion_modelle as $auto_emotion_modell ) : ?>
			<figure>
				<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_modell['image'] ); ?>" alt="<?php echo esc_attr( $auto_emotion_modell['name'] . ', offizielles Herstellerfoto' ); ?>" loading="lazy">
				<figcaption><?php echo esc_html( $auto_emotion_modell['name'] ); ?></figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php
$auto_emotion_angebote = new WP_Query(
	array(
		'post_type'      => 'angebot',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'marke',
				'field'    => 'term_id',
				'terms'    => $auto_emotion_term->term_id,
			),
		),
	)
);
?>

<?php if ( $auto_emotion_angebote->have_posts() ) : ?>
	<div class="story-grid">
		<?php while ( $auto_emotion_angebote->have_posts() ) : $auto_emotion_angebote->the_post(); ?>
			<article class="product-tile">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
				<?php endif; ?>
				<h2 class="product-tile__caption"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</article>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title"><?php esc_html_e( 'News', 'auto-emotion' ); ?></h2>
	</div>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content' ); ?>
	<?php endwhile; ?>

	<?php the_posts_pagination(); ?>
<?php endif; ?>

<?php
get_footer();
