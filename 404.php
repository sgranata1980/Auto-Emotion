<?php
/**
 * Template for 404 error page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Seite nicht gefunden', 'auto-emotion' ); ?></h1>
	</header>
	<div class="page-content">
		<p><?php esc_html_e( 'Die gesuchte Seite konnte nicht gefunden werden.', 'auto-emotion' ); ?></p>
	</div>
</section>

<?php
get_footer();
