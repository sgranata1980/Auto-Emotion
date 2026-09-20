<?php
/**
 * Footer template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( ! is_front_page() ) : ?>
</div>
<?php endif; ?>
</main>

<footer id="colophon" class="site-footer">
	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-widgets">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php endif; ?>

	<div class="footer-contact">
		<p>
			<?php echo esc_html( auto_emotion_contact( 'street' ) . ', ' . auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?><br>
			<a href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?></a>
			·
			<a href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'email' ) ); ?></a>
		</p>
	</div>

	<nav id="footer-navigation" class="footer-navigation">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'menu_id'        => 'footer-menu',
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>

	<p class="footer-legal-note">
		<?php esc_html_e( 'Finanzierung & Leasing: Wir arbeiten mit unabhängigen Finanzierungspartnern statt einer festen Hausbank – Sie haben die freie Bankwahl, keine Bindung an einen bestimmten Anbieter. Ihr individuelles Angebot erstellen wir persönlich.', 'auto-emotion' ); ?>
	</p>

	<div class="site-info">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
	</div>
</footer>

<?php get_template_part( 'template-parts/chat-widget' ); ?>
<?php get_template_part( 'template-parts/cookie-banner' ); ?>

<?php wp_footer(); ?>
</body>
</html>
