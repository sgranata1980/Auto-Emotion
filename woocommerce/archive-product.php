<?php
/**
 * Shop-Archiv, nach Produktkategorien gruppiert (statt einer einzigen
 * undifferenzierten Liste aller Produkte) – Theme-Override von
 * WooCommerce templates/archive-product.php.
 *
 * @package WooCommerce\Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php woocommerce_page_title(); ?></h1>
</div>

<?php do_action( 'woocommerce_archive_description' ); ?>

<?php
$auto_emotion_shop_categories = get_terms(
	array(
		'taxonomy'     => 'product_cat',
		'hide_empty'   => true,
		'parent'       => 0,
		'orderby'      => 'name',
	)
);

if ( ! empty( $auto_emotion_shop_categories ) && ! is_wp_error( $auto_emotion_shop_categories ) ) :
	foreach ( $auto_emotion_shop_categories as $auto_emotion_shop_category ) :
		$auto_emotion_cat_query = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $auto_emotion_shop_category->term_id,
					),
				),
			)
		);

		if ( ! $auto_emotion_cat_query->have_posts() ) {
			continue;
		}
		?>
		<div class="section-heading">
			<h2 class="section-heading__title"><?php echo esc_html( $auto_emotion_shop_category->name ); ?></h2>
			<?php if ( $auto_emotion_shop_category->description ) : ?>
				<p class="section-heading__hint"><?php echo esc_html( $auto_emotion_shop_category->description ); ?></p>
			<?php endif; ?>
		</div>

		<ul class="products">
			<?php
			while ( $auto_emotion_cat_query->have_posts() ) :
				$auto_emotion_cat_query->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			?>
		</ul>
		<?php
		wp_reset_postdata();
	endforeach;
else :
	wc_get_template( 'loop/no-products-found.php' );
endif;
?>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
