<?php
/**
 * Header template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( is_front_page() ? array( 'has-transparent-header' ) : array() ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Zum Inhalt springen', 'auto-emotion' ); ?></a>

<header id="masthead" class="site-header">
	<button type="button" class="nav-toggle" aria-controls="site-navigation" aria-expanded="false">
		<span class="nav-toggle-icon"></span>
		<?php esc_html_e( 'Menu', 'auto-emotion' ); ?>
	</button>

	<div class="site-branding">
		<?php
		$auto_emotion_logo_tag = is_front_page() ? 'h1' : 'p';
		?>
		<<?php echo $auto_emotion_logo_tag; ?> class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img
					class="site-logo"
					src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/logo-icon-white.png' ); ?>"
					alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
					width="35"
					height="37"
				>
			</a>
		</<?php echo $auto_emotion_logo_tag; ?>>
	</div>

	<div class="header-actions">
		<button type="button" class="search-toggle" aria-controls="header-search" aria-expanded="false" aria-label="<?php esc_attr_e( 'Suche öffnen', 'auto-emotion' ); ?>">
			<svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.25"/><line x1="12.6" y1="12.6" x2="17" y2="17" stroke="currentColor" stroke-width="1.25"/></svg>
		</button>
	</div>

	<nav id="site-navigation" class="main-navigation" data-state="closed">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
			)
		);
		?>
	</nav>

	<form role="search" method="get" class="header-search" id="header-search" data-state="closed" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="header-search-input"><?php esc_html_e( 'Suche nach:', 'auto-emotion' ); ?></label>
		<input type="search" id="header-search-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Suchen…', 'auto-emotion' ); ?>">
	</form>
</header>

<main id="primary" class="site-main">
<?php if ( ! is_front_page() ) : ?>
<div class="container">
<?php endif; ?>
