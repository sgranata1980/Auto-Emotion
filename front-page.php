<?php
/**
 * Template for the site front page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero' );

$auto_emotion_blog_page_id = (int) get_option( 'page_for_posts' );
$auto_emotion_blog_url     = $auto_emotion_blog_page_id ? get_permalink( $auto_emotion_blog_page_id ) : home_url( '/' );

$auto_emotion_latest = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
?>

<?php if ( $auto_emotion_latest->have_posts() ) : ?>
	<div class="section-heading">
		<h2 class="section-heading__title"><?php esc_html_e( 'Neuigkeiten', 'auto-emotion' ); ?></h2>
		<a class="btn btn-ghost" href="<?php echo esc_url( $auto_emotion_blog_url ); ?>">
			<?php esc_html_e( 'Alle ansehen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>

	<div class="story-grid">
		<?php while ( $auto_emotion_latest->have_posts() ) : $auto_emotion_latest->the_post(); ?>
			<article class="story-grid__item">
				<span class="story-grid__date"><?php echo esc_html( get_the_date() ); ?></span>
				<h3 class="story-grid__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large' ); ?>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php
get_footer();
