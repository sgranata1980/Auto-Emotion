<?php
/**
 * Instagram-Beiträge über das Plugin „Smash Balloon Social Photo Feed“.
 * Ohne aktives Plugin bleibt der Abschnitt einfach unsichtbar.
 */

if ( ! defined( 'ABSPATH' ) || ! shortcode_exists( 'instagram-feed' ) ) {
	return;
}
?>
<section class="firma-abschnitt instagram-bereich">
	<h2><?php esc_html_e( 'Auto Emotion auf Instagram', 'auto-emotion' ); ?></h2>
	<?php echo do_shortcode( '[instagram-feed]' ); ?>
</section>
