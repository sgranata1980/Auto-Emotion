<?php
/**
 * Gemeinsamer Aufbau der Service-Seiten: Hero, Einstieg, drei Punkte
 * mit Icons, Bild-Text-Block, Handlungsaufforderung, weitere Leistungen.
 *
 * $args['seite']: Eintrag aus auto_emotion_service_seiten().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_seite = $args['seite'];
$auto_emotion_svg   = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"';

if ( empty( $auto_emotion_seite['mail'] ) ) {
	$auto_emotion_cta_text = __( 'Termin anfragen', 'auto-emotion' );
	$auto_emotion_cta_url  = home_url( '/servicetermin-buchen/' );
} else {
	$auto_emotion_cta_text = __( 'Anfrage senden', 'auto-emotion' );
	$auto_emotion_cta_url  = 'mailto:' . auto_emotion_contact( 'email' ) . '?subject=' . rawurlencode( $auto_emotion_seite['mail'] );
}
$auto_emotion_tel = 'tel:' . auto_emotion_contact( 'phone_href' );

echo '</div>';
get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => __( 'Service bei Auto Emotion in Offenbach', 'auto-emotion' ),
		'headline_pre'    => $auto_emotion_seite['pre'],
		'headline_accent' => $auto_emotion_seite['accent'],
		'cta_text'        => $auto_emotion_cta_text,
		'cta_url'         => $auto_emotion_cta_url,
		'cta2_text'       => auto_emotion_contact( 'phone' ),
		'cta2_url'        => $auto_emotion_tel,
		'image'           => AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_seite['hero'] . '?ver=' . AUTO_EMOTION_VERSION,
		'video'           => '',
		'video_webm'      => '',
	)
);
echo '<div class="container">';
?>

<p class="service-lead"><?php echo esc_html( $auto_emotion_seite['lead'] ); ?></p>

<ul class="service-punkte">
	<?php foreach ( $auto_emotion_seite['punkte'] as $auto_emotion_punkt ) : ?>
		<li class="service-punkt">
			<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_punkt[0] ); ?></svg>
			<strong><?php echo esc_html( $auto_emotion_punkt[1] ); ?></strong>
			<span><?php echo esc_html( $auto_emotion_punkt[2] ); ?></span>
		</li>
	<?php endforeach; ?>
</ul>

<?php $auto_emotion_block = $auto_emotion_seite['block']; ?>
<div class="finanz-bloecke">
	<section class="finanz-block" aria-labelledby="service-block">
		<img src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/' . $auto_emotion_block[0] . '?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="<?php echo esc_attr( $auto_emotion_block[1] ); ?>" loading="lazy">
		<div class="finanz-block__text">
			<p class="finanz-block__eyebrow"><?php echo esc_html( $auto_emotion_block[2] ); ?></p>
			<h2 id="service-block"><?php echo esc_html( $auto_emotion_block[3] ); ?></h2>
			<p><?php echo esc_html( $auto_emotion_block[4] ); ?></p>
			<?php if ( ! empty( $auto_emotion_block[5] ) ) : ?>
				<a class="btn btn-outline" href="<?php echo esc_url( $auto_emotion_block[5] ); ?>"><?php echo esc_html( $auto_emotion_block[6] ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
			<?php endif; ?>
		</div>
	</section>
</div>

<?php get_template_part( 'template-parts/seo-text' ); ?>

<section class="service-cta" aria-labelledby="service-cta-titel">
	<div>
		<h2 id="service-cta-titel"><?php esc_html_e( 'Sprechen wir über Ihr Auto.', 'auto-emotion' ); ?></h2>
		<p><?php echo esc_html( sprintf( __( 'Werkstatt geöffnet: %s', 'auto-emotion' ), auto_emotion_contact( 'hours_service' ) ) ); ?></p>
	</div>
	<div class="service-cta__knoepfe">
		<a class="btn btn-giallo" href="<?php echo esc_url( $auto_emotion_cta_url ); ?>"><?php echo esc_html( $auto_emotion_cta_text ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		<a class="btn btn-outline" href="<?php echo esc_attr( $auto_emotion_tel ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
	</div>
</section>

<nav class="service-kacheln service-kacheln--weitere" aria-label="<?php esc_attr_e( 'Weitere Leistungen', 'auto-emotion' ); ?>">
	<?php foreach ( $auto_emotion_seite['weitere'] as $auto_emotion_slug ) : ?>
		<?php $auto_emotion_kachel = auto_emotion_service_kachel( $auto_emotion_slug ); ?>
		<a class="service-kachel" href="<?php echo esc_url( home_url( '/' . $auto_emotion_slug . '/' ) ); ?>">
			<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_kachel[0] ); ?></svg>
			<strong><?php echo esc_html( $auto_emotion_kachel[1] ); ?></strong>
		</a>
	<?php endforeach; ?>
</nav>
