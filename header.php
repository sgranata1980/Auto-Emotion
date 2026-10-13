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

<div class="utility-bar">
	<p class="utility-bar__address">
		<?php echo esc_html( auto_emotion_contact( 'company' ) . ' · ' . auto_emotion_contact( 'street' ) . ', ' . auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?>
	</p>
	<div class="utility-bar__info">
		<a class="utility-bar__item" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 21s-7-6.1-7-11.5A7 7 0 0 1 19 9.5C19 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
			<?php esc_html_e( 'Kontaktdaten', 'auto-emotion' ); ?>
		</a>
		<a class="utility-bar__item" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M5 4h3.5l1.5 4.5-2.3 1.7a12.5 12.5 0 0 0 6.1 6.1l1.7-2.3L19 15.5V19a1 1 0 0 1-1 1C10.5 20 4 13.5 4 6a1 1 0 0 1 1-1Z"/></svg>
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
		</a>
		<span class="utility-bar__item utility-bar__status">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>
			<?php echo auto_emotion_is_open_now() ? esc_html__( 'Geöffnet', 'auto-emotion' ) : esc_html__( 'Geschlossen', 'auto-emotion' ); ?>
		</span>
	</div>
</div>

<header id="masthead" class="site-header">
	<button type="button" class="nav-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'auto-emotion' ); ?>">
		<span class="nav-toggle-icon"></span>
		<span class="nav-toggle-label"><?php esc_html_e( 'Menu', 'auto-emotion' ); ?></span>
	</button>

	<div class="site-branding">
		<?php
		$auto_emotion_logo_tag = is_front_page() ? 'h1' : 'p';
		?>
		<<?php echo $auto_emotion_logo_tag; ?> class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span class="site-logo-wrap">
				<img
					class="site-logo"
					src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/logo-icon-white.png' ); ?>"
					alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
					width="35"
					height="37"
				>
				</span>
			</a>
		</<?php echo $auto_emotion_logo_tag; ?>>
	</div>

	<div class="header-actions">
		<button type="button" class="search-toggle" aria-controls="header-search" aria-expanded="false" aria-label="<?php esc_attr_e( 'Suche öffnen', 'auto-emotion' ); ?>">
			<svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.25"/><line x1="12.6" y1="12.6" x2="17" y2="17" stroke="currentColor" stroke-width="1.25"/></svg>
		</button>
	</div>

	<nav id="site-navigation" class="main-navigation" data-state="closed">
		<?php auto_emotion_render_primary_menu(); ?>
		<button type="button" class="main-navigation__ai-trigger">
			<?php esc_html_e( 'AI-Assistent', 'auto-emotion' ); ?>
		</button>
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
