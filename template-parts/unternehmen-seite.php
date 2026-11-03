<?php
/**
 * Gemeinsamer Aufbau der Unternehmensseiten. Jeder Abschnitt erscheint
 * nur, wenn er in auto_emotion_unternehmen_seiten() eingetragen ist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_seite = auto_emotion_unternehmen_seiten()[ get_post_field( 'post_name' ) ];
$auto_emotion_svg   = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"';
$auto_emotion_bild  = static function ( $datei ) {
	return AUTO_EMOTION_URI . '/assets/images/' . $datei . '?ver=' . AUTO_EMOTION_VERSION;
};

if ( ! empty( $auto_emotion_seite['faq'] ) ) {
	$auto_emotion_faq_schema = array();
	foreach ( $auto_emotion_seite['faq'] as $auto_emotion_frage ) {
		$auto_emotion_faq_schema[] = array(
			'q' => $auto_emotion_frage[0],
			'a' => $auto_emotion_frage[1],
		);
	}
	auto_emotion_register_faq_schema( $auto_emotion_faq_schema );
}

get_header();

echo '</div>';
get_template_part(
	'template-parts/hero',
	null,
	array(
		'eyebrow'         => $auto_emotion_seite['eyebrow'],
		'headline_pre'    => $auto_emotion_seite['pre'],
		'headline_accent' => $auto_emotion_seite['accent'],
		'cta_text'        => $auto_emotion_seite['cta1'][0],
		'cta_url'         => $auto_emotion_seite['cta1'][1],
		'cta2_text'       => $auto_emotion_seite['cta2'][0] ?? '',
		'cta2_url'        => $auto_emotion_seite['cta2'][1] ?? '',
		'image'           => $auto_emotion_bild( $auto_emotion_seite['hero'] ),
		'video'           => '',
		'video_webm'      => '',
	)
);
echo '<div class="container">';
?>

<?php if ( ! empty( $auto_emotion_seite['lead'] ) ) : ?>
	<p class="service-lead"><?php echo esc_html( $auto_emotion_seite['lead'] ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['fakten'] ) ) : ?>
	<dl class="firma-fakten">
		<?php foreach ( $auto_emotion_seite['fakten'] as $auto_emotion_fakt ) : ?>
			<div>
				<dt><?php echo esc_html( $auto_emotion_fakt[1] ); ?></dt>
				<dd><?php echo esc_html( $auto_emotion_fakt[0] ); ?></dd>
			</div>
		<?php endforeach; ?>
	</dl>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['punkte'] ) ) : ?>
	<ul class="service-punkte">
		<?php foreach ( $auto_emotion_seite['punkte'] as $auto_emotion_punkt ) : ?>
			<li class="service-punkt">
				<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_punkt[0] ); ?></svg>
				<strong><?php echo esc_html( $auto_emotion_punkt[1] ); ?></strong>
				<span><?php echo esc_html( $auto_emotion_punkt[2] ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['zeitleiste'] ) ) : ?>
	<ol class="zeitleiste" id="zeitleiste">
		<?php foreach ( $auto_emotion_seite['zeitleiste'] as $auto_emotion_eintrag ) : ?>
			<li>
				<span class="zeitleiste__datum"><?php echo esc_html( $auto_emotion_eintrag[0] ); ?></span>
				<div>
					<h2><?php echo esc_html( $auto_emotion_eintrag[1] ); ?></h2>
					<?php if ( $auto_emotion_eintrag[2] ) : ?>
						<p><?php echo esc_html( $auto_emotion_eintrag[2] ); ?></p>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['kontakt'] ) ) : ?>
	<ul class="kontakt-karten">
		<li>
			<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'ort' ); ?></svg>
			<strong><?php esc_html_e( 'Adresse', 'auto-emotion' ); ?></strong>
			<span><?php echo esc_html( auto_emotion_contact( 'company' ) ); ?><br><?php echo esc_html( auto_emotion_contact( 'street' ) ); ?><br><?php echo esc_html( auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?></span>
		</li>
		<li>
			<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'telefon' ); ?></svg>
			<strong><?php esc_html_e( 'Telefon und E-Mail', 'auto-emotion' ); ?></strong>
			<span><a href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?></a><br><a href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'email' ) ); ?></a></span>
		</li>
		<li>
			<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'uhr' ); ?></svg>
			<strong><?php esc_html_e( 'Öffnungszeiten Verkauf', 'auto-emotion' ); ?></strong>
			<span><?php echo esc_html( auto_emotion_contact( 'hours_sales' ) ); ?></span>
		</li>
		<li>
			<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'werkzeug' ); ?></svg>
			<strong><?php esc_html_e( 'Öffnungszeiten Werkstatt', 'auto-emotion' ); ?></strong>
			<span><?php echo esc_html( auto_emotion_contact( 'hours_service' ) ); ?></span>
		</li>
	</ul>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['team'] ) ) : ?>
	<div id="team">
		<?php foreach ( $auto_emotion_seite['team'] as $auto_emotion_gruppe => $auto_emotion_personen ) : ?>
			<section class="team-gruppe">
				<h2><?php echo esc_html( $auto_emotion_gruppe ); ?></h2>
				<ul class="team-karten">
					<?php foreach ( $auto_emotion_personen as $auto_emotion_person ) : ?>
						<li class="team-karte">
							<strong><?php echo esc_html( $auto_emotion_person[0] ); ?></strong>
							<span class="team-karte__rolle"><?php echo esc_html( $auto_emotion_person[1] ); ?></span>
							<a href="tel:<?php echo esc_attr( $auto_emotion_person[3] ); ?>"><svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'telefon' ); ?></svg><?php echo esc_html( $auto_emotion_person[2] ); ?></a>
							<a href="mailto:<?php echo esc_attr( $auto_emotion_person[4] ); ?>"><svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( 'mail' ); ?></svg><?php echo esc_html( $auto_emotion_person[4] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['faq'] ) ) : ?>
	<div class="faq-liste">
		<?php foreach ( $auto_emotion_seite['faq'] as $auto_emotion_nummer => $auto_emotion_frage ) : ?>
			<details <?php echo 0 === $auto_emotion_nummer ? 'open' : ''; ?>>
				<summary><?php echo esc_html( $auto_emotion_frage[0] ); ?></summary>
				<p><?php echo esc_html( $auto_emotion_frage[1] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['stellen'] ) ) : ?>
	<ul class="stellen-karten" id="stellen">
		<?php foreach ( auto_emotion_stellen() as $auto_emotion_stelle ) : ?>
			<li>
				<a class="stellen-karte" href="<?php echo esc_url( home_url( '/' . $auto_emotion_stelle[4] . '/' ) ); ?>">
					<img src="<?php echo esc_url( $auto_emotion_bild( $auto_emotion_stelle[0] ) ); ?>" alt="" loading="lazy">
					<span class="stellen-karte__text">
						<span class="stellen-karte__umfang"><?php echo esc_html( $auto_emotion_stelle[1] ); ?></span>
						<strong><?php echo esc_html( $auto_emotion_stelle[2] ); ?></strong>
						<span><?php echo esc_html( $auto_emotion_stelle[3] ); ?></span>
						<span class="stellen-karte__link"><?php esc_html_e( 'Zur Stelle', 'auto-emotion' ); ?> <span aria-hidden="true">&rarr;</span></span>
					</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['schritte'] ) ) : ?>
	<section class="firma-abschnitt">
		<h2><?php echo esc_html( $auto_emotion_seite['schritte'][0] ); ?></h2>
		<ul class="service-punkte">
			<?php foreach ( $auto_emotion_seite['schritte'][1] as $auto_emotion_punkt ) : ?>
				<li class="service-punkt">
					<svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_punkt[0] ); ?></svg>
					<strong><?php echo esc_html( $auto_emotion_punkt[1] ); ?></strong>
					<span><?php echo esc_html( $auto_emotion_punkt[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['bloecke'] ) ) : ?>
	<div class="finanz-bloecke">
		<?php foreach ( $auto_emotion_seite['bloecke'] as $auto_emotion_block ) : ?>
			<section class="finanz-block">
				<img src="<?php echo esc_url( $auto_emotion_bild( $auto_emotion_block[0] ) ); ?>" alt="<?php echo esc_attr( $auto_emotion_block[1] ); ?>" loading="lazy">
				<div class="finanz-block__text">
					<p class="finanz-block__eyebrow"><?php echo esc_html( $auto_emotion_block[2] ); ?></p>
					<h2><?php echo esc_html( $auto_emotion_block[3] ); ?></h2>
					<p><?php echo esc_html( $auto_emotion_block[4] ); ?></p>
					<?php if ( ! empty( $auto_emotion_block[5] ) ) : ?>
						<a class="btn btn-outline" href="<?php echo esc_url( $auto_emotion_block[5] ); ?>"><?php echo esc_html( $auto_emotion_block[6] ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
					<?php endif; ?>
				</div>
			</section>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['galerie'] ) ) : ?>
	<section class="firma-abschnitt" id="galerie">
		<h2><?php echo esc_html( $auto_emotion_seite['galerie']['titel'] ); ?></h2>
		<div class="firma-galerie">
			<?php foreach ( $auto_emotion_seite['galerie']['bilder'] as $auto_emotion_foto ) : ?>
				<figure>
					<img src="<?php echo esc_url( $auto_emotion_bild( $auto_emotion_foto[0] ) ); ?>" alt="<?php echo esc_attr( $auto_emotion_foto[1] ); ?>" loading="lazy">
					<figcaption><?php echo esc_html( $auto_emotion_foto[1] ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['text'] ) ) : ?>
	<section class="firma-abschnitt firma-text">
		<h2><?php echo esc_html( $auto_emotion_seite['text'][0] ); ?></h2>
		<p><?php echo esc_html( $auto_emotion_seite['text'][1] ); ?></p>
		<p><?php echo esc_html( $auto_emotion_seite['text'][2] ); ?></p>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/seo-text' ); ?>

<?php if ( ! empty( $auto_emotion_seite['notiz'] ) ) : ?>
	<p class="firma-notiz"><?php echo esc_html( $auto_emotion_seite['notiz'] ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['cta'] ) ) : ?>
	<section class="service-cta">
		<div>
			<h2><?php echo esc_html( $auto_emotion_seite['cta'][0] ); ?></h2>
			<p><?php echo esc_html( $auto_emotion_seite['cta'][1] ); ?></p>
		</div>
		<div class="service-cta__knoepfe">
			<a class="btn btn-giallo" href="<?php echo esc_url( $auto_emotion_seite['cta'][2][1] ); ?>"><?php echo esc_html( $auto_emotion_seite['cta'][2][0] ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
			<a class="btn btn-outline" href="<?php echo esc_url( $auto_emotion_seite['cta'][3][1] ); ?>"><?php echo esc_html( $auto_emotion_seite['cta'][3][0] ); ?> <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_seite['weitere'] ) ) : ?>
	<nav class="termin-bilder" aria-label="<?php esc_attr_e( 'Weitere Seiten', 'auto-emotion' ); ?>">
		<?php foreach ( $auto_emotion_seite['weitere'] as $auto_emotion_slug ) : ?>
			<?php $auto_emotion_kachel = auto_emotion_unternehmen_kachel( $auto_emotion_slug ); ?>
			<a class="termin-bild" href="<?php echo esc_url( home_url( '/' . $auto_emotion_slug . '/' ) ); ?>">
				<img src="<?php echo esc_url( $auto_emotion_bild( $auto_emotion_kachel[0] ) ); ?>" alt="" loading="lazy">
				<span><svg <?php echo $auto_emotion_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Attribute. ?>><?php auto_emotion_service_icon( $auto_emotion_kachel[1] ); ?></svg><?php echo esc_html( $auto_emotion_kachel[2] ); ?> <span aria-hidden="true">&rarr;</span></span>
			</a>
		<?php endforeach; ?>
	</nav>
<?php endif; ?>

<?php
get_footer();
