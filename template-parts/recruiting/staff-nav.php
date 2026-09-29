<?php
/**
 * Gemeinsame Kopfleiste für alle /mitarbeiter/-Seiten.
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ae-staff__bar">
	<div class="ae-staff__nav">
		<a class="ae-staff__brand" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' ) ); ?>"><?php esc_html_e( 'Suchprofile', 'auto-emotion' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>"><?php esc_html_e( 'Bewerbungen', 'auto-emotion' ); ?></a>
	</div>
	<a class="ae-staff__logout" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_recruiting_logout' ), 'auto_emotion_recruiting_logout' ) ); ?>"><?php esc_html_e( 'Abmelden', 'auto-emotion' ); ?></a>
</div>
