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
/**
 * Modellübersicht je Marke. "specs" sind kurze, allgemein bekannte
 * Herstellerangaben (Motorisierung, Verbrauch/Reichweite) ohne
 * Preise – Details klappen pro Kachel per <details> auf, ganz ohne
 * eigenes JavaScript.
 */
$auto_emotion_marke_modelle = array(
	'nissan' => array(
		array(
			'image'       => 'nissan-modell-juke.jpg',
			'name'        => 'Nissan Juke',
			'description' => __( 'Coupé-SUV mit auffälligem Design und wendigem Fahrverhalten im Stadtverkehr.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.0 DIG-T (114 PS) oder Vollhybrid e-Power (143 PS)', 'auto-emotion' ),
				__( 'Verbrauch ab ca. 5,0 l/100 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'nissan-modell-qashqai.jpg',
			'name'        => 'Nissan Qashqai',
			'description' => __( 'Nissans meistverkauftes Modell in Europa – geräumiges Kompakt-SUV mit moderner Hybridtechnik.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.3 DIG-T Mild-Hybrid (140–158 PS) oder Vollhybrid e-Power (190 PS)', 'auto-emotion' ),
				__( 'Verbrauch ab ca. 5,3 l/100 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'nissan-modell-xtrail.jpg',
			'name'        => 'Nissan X-Trail',
			'description' => __( 'Das große SUV der Marke, serienmäßig mit Hybridantrieb – auch mit Allrad und dritter Sitzreihe.', 'auto-emotion' ),
			'specs'       => array(
				__( 'Vollhybrid e-Power (204 PS) oder e-4ORCE Allrad-Hybrid (213 PS)', 'auto-emotion' ),
				__( 'Wahlweise mit 5 oder 7 Sitzen', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'nissan-modell-ariya.jpg',
			'name'        => 'Nissan Ariya',
			'description' => __( 'Elektrisches Coupé-SUV mit großzügigem Innenraum und leisem Fahrgefühl.', 'auto-emotion' ),
			'specs'       => array(
				__( 'Vollelektrisch, 63- oder 87-kWh-Batterie', 'auto-emotion' ),
				__( 'WLTP-Reichweite ca. 400–530 km, e-4ORCE Allrad optional', 'auto-emotion' ),
			),
		),
	),
	'seat'   => array(
		array(
			'image'       => 'seat-modell-arona.jpg',
			'name'        => 'Seat Arona',
			'description' => __( 'Kompaktes SUV für die Stadt – sparsam, wendig und mit viel Platz für seine Klasse.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.0 TSI (81–110 PS)', 'auto-emotion' ),
				__( 'Verbrauch ab ca. 5,3 l/100 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'seat-modell-ateca.jpg',
			'name'        => 'Seat Ateca',
			'description' => __( 'Familientaugliches SUV mit großzügigem Kofferraum und optionalem Allradantrieb.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.0–1.5 TSI (110–150 PS), auch mit Allrad', 'auto-emotion' ),
				__( 'Verbrauch ab ca. 6,0 l/100 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'seat-modell-ibiza.jpg',
			'name'        => 'Seat Ibiza',
			'description' => __( 'Der Kleinwagen-Klassiker von Seat – sparsam im Verbrauch und ideal für den Alltag.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.0 MPI/TSI (80–115 PS)', 'auto-emotion' ),
				__( 'Verbrauch ab ca. 5,0 l/100 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'seat-modell-leon.jpg',
			'name'        => 'Seat Leon',
			'description' => __( 'Die Kompaktklasse von Seat – sportlich abgestimmt, wahlweise auch als Plug-in-Hybrid.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.0–2.0 TSI (110–190 PS), auch als e-HYBRID Plug-in', 'auto-emotion' ),
				__( 'e-HYBRID mit zusätzlicher elektrischer Reichweite', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'seat-modell-leon-sportstourer.jpg',
			'name'        => 'Seat Leon Sportstourer',
			'description' => __( 'Der Kombi zum Leon – gleiche Motoren, mehr Platz für Gepäck und Familie.', 'auto-emotion' ),
			'specs'       => array(
				__( 'Gleiche Motoren wie der Seat Leon', 'auto-emotion' ),
				__( 'Deutlich mehr Kofferraumvolumen als die Fließheck-Variante', 'auto-emotion' ),
			),
		),
	),
	'cupra'  => array(
		array(
			'image'       => 'cupra-modell-born.jpg',
			'name'        => 'Cupra Born',
			'description' => __( 'Cupras erstes vollelektrisches Modell – sportlich abgestimmtes Fahrwerk in kompakter Karosserie.', 'auto-emotion' ),
			'specs'       => array(
				__( 'Vollelektrisch, 59- oder 77-kWh-Batterie (204–231 PS)', 'auto-emotion' ),
				__( 'WLTP-Reichweite ca. 420–560 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'cupra-modell-tavascan.jpg',
			'name'        => 'Cupra Tavascan',
			'description' => __( 'Elektrisches Coupé-SUV mit markantem Design und sportlicher Auslegung.', 'auto-emotion' ),
			'specs'       => array(
				__( 'Vollelektrisch, 77-kWh-Batterie (210–250 PS, VZ mit Allrad)', 'auto-emotion' ),
				__( 'WLTP-Reichweite ca. 500–560 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'cupra-modell-terramar.jpg',
			'name'        => 'Cupra Terramar',
			'description' => __( 'Kompaktes SUV von Cupra, auch als Plug-in-Hybrid mit alltagstauglicher elektrischer Reichweite.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.5 TSI (150 PS) oder e-HYBRID Plug-in (204–272 PS)', 'auto-emotion' ),
				__( 'e-HYBRID mit elektrischer Reichweite über 100 km', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'cupra-modell-formentor.jpg',
			'name'        => 'Cupra Formentor',
			'description' => __( 'Das erste eigenständige Cupra-Modell – Coupé-SUV mit sportlichem Anspruch bis zur VZ-Topversion.', 'auto-emotion' ),
			'specs'       => array(
				__( '1.5–2.0 TSI (150–190 PS), VZ bis über 300 PS, auch e-HYBRID', 'auto-emotion' ),
				__( 'Erstes Cupra-Modell ohne direktes Seat-Pendant', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'cupra-modell-leon.jpg',
			'name'        => 'Cupra Leon',
			'description' => __( 'Die sportliche Cupra-Version des Leon, mit eigenständigem Fahrwerks-Tuning.', 'auto-emotion' ),
			'specs'       => array(
				__( 'TSI und e-HYBRID Plug-in bis 245 PS', 'auto-emotion' ),
				__( 'Cupra-spezifisches Fahrwerk- und Bremsen-Setup', 'auto-emotion' ),
			),
		),
		array(
			'image'       => 'cupra-modell-leon-sportstourer.jpg',
			'name'        => 'Cupra Leon Sportstourer',
			'description' => __( 'Der Cupra Leon als Kombi – gleiche Sportlichkeit, mehr Platz für den Alltag.', 'auto-emotion' ),
			'specs'       => array(
				__( 'Gleiche Motoren wie der Cupra Leon', 'auto-emotion' ),
				__( 'Kombivariante mit mehr Laderaum', 'auto-emotion' ),
			),
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
			<details class="model-card">
				<summary class="model-card__summary">
					<figure>
						<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_modell['image'] ); ?>" alt="<?php echo esc_attr( $auto_emotion_modell['name'] . ', offizielles Herstellerfoto' ); ?>" loading="lazy">
						<figcaption>
							<?php echo esc_html( $auto_emotion_modell['name'] ); ?>
							<span class="model-card__toggle" aria-hidden="true"></span>
						</figcaption>
					</figure>
				</summary>
				<div class="model-card__details">
					<?php if ( ! empty( $auto_emotion_modell['description'] ) ) : ?>
						<p><?php echo esc_html( $auto_emotion_modell['description'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $auto_emotion_modell['specs'] ) ) : ?>
						<ul class="model-card__specs">
							<?php foreach ( $auto_emotion_modell['specs'] as $auto_emotion_spec ) : ?>
								<li><?php echo esc_html( $auto_emotion_spec ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<a class="btn btn-outline model-card__cta" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
						<?php esc_html_e( 'Beratung anfragen', 'auto-emotion' ); ?>
						<span class="btn-arrow" aria-hidden="true">&rarr;</span>
					</a>
				</div>
			</details>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php
$auto_emotion_marke_showroom_fotos = array(
	'nissan' => array(
		array(
			'image' => 'showroom-nissan-designlab.jpg',
			'name'  => 'Nissan Design Lab im Showroom',
		),
		array(
			'image' => 'showroom-nissan-evs.jpg',
			'name'  => 'Nissan Elektrofahrzeuge im Showroom',
		),
		array(
			'image' => 'showroom-nissan-logo.jpg',
			'name'  => 'Nissan Markenzeichen im Showroom',
		),
	),
	'cupra'  => array(
		array(
			'image' => 'showroom-cupra-detail.jpg',
			'name'  => 'Cupra Corner im Showroom',
		),
	),
);
$auto_emotion_showroom_fotos       = $auto_emotion_marke_showroom_fotos[ $auto_emotion_term->slug ] ?? array();
?>

<?php if ( $auto_emotion_showroom_fotos ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title"><?php esc_html_e( 'Bei uns vor Ort', 'auto-emotion' ); ?></h2>
	</div>
	<div class="photo-gallery">
		<?php foreach ( $auto_emotion_showroom_fotos as $auto_emotion_showroom_foto ) : ?>
			<figure>
				<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_showroom_foto['image'] ); ?>" alt="<?php echo esc_attr( $auto_emotion_showroom_foto['name'] ); ?>" loading="lazy">
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
