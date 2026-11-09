<?php
/**
 * Template part shown when no content is found.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nichts gefunden', 'auto-emotion' ); ?></h1>
	</header>
	<div class="page-content">
		<p><?php esc_html_e( 'Es konnten keine passenden Inhalte gefunden werden.', 'auto-emotion' ); ?></p>
	</div>
</section>
