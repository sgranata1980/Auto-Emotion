<?php
/**
 * Template Name: Kontakt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_address = sprintf(
	'%s, %s %s',
	auto_emotion_contact( 'street' ),
	auto_emotion_contact( 'postal_code' ),
	auto_emotion_contact( 'city' )
);
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Kontakt', 'auto-emotion' ); ?></h1>
</div>

<?php while ( have_posts() ) : the_post(); ?>
	<div class="entry-content"><?php the_content(); ?></div>
<?php endwhile; ?>

<div class="contact-grid">
	<div class="contact-grid__item">
		<h2><?php esc_html_e( 'Adresse', 'auto-emotion' ); ?></h2>
		<p>
			<?php echo esc_html( auto_emotion_contact( 'company' ) ); ?><br>
			<?php echo esc_html( auto_emotion_contact( 'street' ) ); ?><br>
			<?php echo esc_html( auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?>
		</p>
		<a class="btn btn-outline" href="https://www.google.com/maps/dir/?api=1&destination=<?php echo rawurlencode( $auto_emotion_address ); ?>" target="_blank" rel="noopener">
			<?php esc_html_e( 'Route planen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</div>

	<div class="contact-grid__item">
		<h2><?php esc_html_e( 'Kontaktdaten', 'auto-emotion' ); ?></h2>
		<p>
			<?php esc_html_e( 'Telefon', 'auto-emotion' ); ?>:
			<a href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?></a><br>
			<?php esc_html_e( 'E-Mail', 'auto-emotion' ); ?>:
			<a href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'email' ) ); ?></a>
		</p>
	</div>

	<div class="contact-grid__item">
		<h2><?php esc_html_e( 'Öffnungszeiten Verkauf', 'auto-emotion' ); ?></h2>
		<p><?php echo esc_html( auto_emotion_contact( 'hours_sales' ) ); ?></p>
	</div>

	<div class="contact-grid__item">
		<h2><?php esc_html_e( 'Öffnungszeiten Werkstatt', 'auto-emotion' ); ?></h2>
		<p><?php echo esc_html( auto_emotion_contact( 'hours_service' ) ); ?></p>
	</div>
</div>

<?php
get_footer();
