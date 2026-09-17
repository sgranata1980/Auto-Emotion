<?php
/**
 * Footer template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer id="colophon" class="site-footer">
	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-widgets">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php endif; ?>

	<nav id="footer-navigation" class="footer-navigation">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'menu_id'        => 'footer-menu',
			)
		);
		?>
	</nav>

	<div class="site-info">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
