<?php
/**
 * Längere Abschnitte und sichtbare Fragen aus auto_emotion_seo_seiten().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_seo = auto_emotion_seo_eintrag();

if ( empty( $auto_emotion_seo['abschnitte'] ) && empty( $auto_emotion_seo['fragen'] ) ) {
	return;
}
?>

<div class="seo-text">
	<?php foreach ( $auto_emotion_seo['abschnitte'] ?? array() as $auto_emotion_abschnitt ) : ?>
		<section>
			<h2><?php echo esc_html( $auto_emotion_abschnitt[0] ); ?></h2>
			<?php foreach ( $auto_emotion_abschnitt[1] as $auto_emotion_absatz ) : ?>
				<p><?php echo wp_kses_post( $auto_emotion_absatz ); ?></p>
			<?php endforeach; ?>
		</section>
	<?php endforeach; ?>

	<?php if ( ! empty( $auto_emotion_seo['fragen'] ) ) : ?>
		<section>
			<h2><?php esc_html_e( 'Häufige Fragen', 'auto-emotion' ); ?></h2>
			<div class="faq-liste">
				<?php foreach ( $auto_emotion_seo['fragen'] as $auto_emotion_frage ) : ?>
					<details>
						<summary><?php echo esc_html( $auto_emotion_frage[0] ); ?></summary>
						<p><?php echo esc_html( $auto_emotion_frage[1] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
</div>
