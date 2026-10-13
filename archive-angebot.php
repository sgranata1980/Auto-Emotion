<?php
/**
 * Archive template for the "Angebot" post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_marke_filter = isset( $_GET['marke'] ) ? sanitize_title( wp_unslash( $_GET['marke'] ) ) : '';
$auto_emotion_marke_term   = $auto_emotion_marke_filter ? get_term_by( 'slug', $auto_emotion_marke_filter, 'marke' ) : false;

$auto_emotion_active_filter_names = array();
if ( $auto_emotion_marke_term ) {
	$auto_emotion_active_filter_names[] = $auto_emotion_marke_term->name;
}
foreach ( array( 'karosserie', 'antrieb' ) as $auto_emotion_tax ) {
	$auto_emotion_slugs = isset( $_GET[ $auto_emotion_tax ] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET[ $auto_emotion_tax ] ) ) : array();
	foreach ( $auto_emotion_slugs as $auto_emotion_slug ) {
		$auto_emotion_term = get_term_by( 'slug', $auto_emotion_slug, $auto_emotion_tax );
		if ( $auto_emotion_term ) {
			$auto_emotion_active_filter_names[] = $auto_emotion_term->name;
		}
	}
}
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Angebote', 'auto-emotion' ); ?></h1>
</div>

<?php get_template_part( 'template-parts/vehicle-filter' ); ?>

<?php if ( $auto_emotion_active_filter_names ) : ?>
	<p class="archive-filter-notice">
		<?php echo esc_html( sprintf( __( 'Gefiltert nach: %s', 'auto-emotion' ), implode( ', ', $auto_emotion_active_filter_names ) ) ); ?>
	</p>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<div class="story-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="product-tile">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
				<?php endif; ?>
				<h2 class="product-tile__caption"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry-content"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	</div>

	<?php the_posts_pagination(); ?>
<?php elseif ( $auto_emotion_active_filter_names ) : ?>
	<div class="no-results">
		<p>
			<?php echo esc_html( sprintf( __( 'Aktuell kein gelistetes Fahrzeug mit dieser Auswahl (%s). Sag uns, wonach du suchst – wir sagen dir, was möglich ist.', 'auto-emotion' ), implode( ', ', $auto_emotion_active_filter_names ) ) ); ?>
		</p>
		<a class="btn btn-giallo" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>

<?php
get_footer();
