<?php
/**
 * Beitragsübersicht: kompakter Kopf, neuester Beitrag groß, übrige als Karten.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rote Zeile über dem Titel: Datum und im Titel genannte Marke.
 */
function auto_emotion_blog_meta() {
	$marke = '';
	foreach ( array( 'Seat', 'Cupra', 'Nissan' ) as $name ) {
		if ( false !== stripos( get_the_title(), $name ) ) {
			$marke = $name;
			break;
		}
	}
	?>
	<p class="blog-meta">
		<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd. M Y' ) ); ?></time>
		<?php if ( $marke ) : ?>
			<span class="blog-meta__linie" aria-hidden="true"></span>
			<span><?php echo esc_html( $marke ); ?></span>
		<?php endif; ?>
	</p>
	<?php
}

echo '</div>';
?>
<header class="blog-kopf">
	<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/cupra-bild-full-raval.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="" fetchpriority="high">
	<div class="blog-kopf__titel">
		<h1><?php esc_html_e( 'Blog', 'auto-emotion' ); ?></h1>
		<p><?php esc_html_e( 'Modelle und Angebote von Seat, Cupra und Nissan aus unserem Autohaus in Offenbach.', 'auto-emotion' ); ?></p>
	</div>
</header>
<div class="container">

<?php if ( have_posts() ) : ?>
	<?php $auto_emotion_blog_nummer = 0; ?>
	<div class="blog-liste">
		<?php
		while ( have_posts() ) :
			the_post();
			$auto_emotion_blog_gross = 0 === $auto_emotion_blog_nummer && ! is_paged();
			++$auto_emotion_blog_nummer;
			?>
			<article <?php post_class( $auto_emotion_blog_gross ? 'blog-karte blog-karte--gross' : 'blog-karte' ); ?>>
				<a class="blog-karte__bild" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'alt' => '' ) ); ?>
					<?php endif; ?>
				</a>
				<div class="blog-karte__text">
					<?php auto_emotion_blog_meta(); ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php if ( $auto_emotion_blog_gross ) : ?>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34, ' …' ) ); ?></p>
						<a class="blog-karte__mehr" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Weiterlesen', 'auto-emotion' ); ?><span class="screen-reader-text">: <?php the_title(); ?></span></a>
					<?php endif; ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
	<?php the_posts_pagination(); ?>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
