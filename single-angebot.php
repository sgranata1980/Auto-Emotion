<?php
/**
 * Single template for the "Angebot" post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$auto_emotion_probefahrt_status = isset( $_GET['probefahrt'] ) ? sanitize_text_field( wp_unslash( $_GET['probefahrt'] ) ) : '';
?>

<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class(); ?>>
		<header class="entry-header">
			<?php
			$auto_emotion_marken = get_the_terms( get_the_ID(), 'marke' );
			if ( $auto_emotion_marken && ! is_wp_error( $auto_emotion_marken ) ) :
				?>
				<span class="story-grid__date"><?php echo esc_html( $auto_emotion_marken[0]->name ); ?></span>
			<?php endif; ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>

		<?php if ( get_post_meta( get_the_ID(), '_auto_emotion_ist_elektro', true ) ) : ?>
			<div class="funding-notice">
				<p>
					<?php esc_html_e( 'Berechtigt für die staatliche E-Auto-Förderung von bis zu 6.000 € – einkommensabhängig, Antrag über die BAFA.', 'auto-emotion' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Fragen Sie uns außerdem nach Finanzierungs- und Leasingmöglichkeiten für dieses Fahrzeug.', 'auto-emotion' ); ?>
				</p>
			</div>
		<?php endif; ?>

		<div class="entry-actions">
			<a class="btn btn-giallo" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
				<?php esc_html_e( 'Jetzt anfragen', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
			<a class="btn btn-outline" href="#probefahrt">
				<?php esc_html_e( 'Probefahrt anfragen', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>

		<div id="probefahrt" class="section-heading">
			<h2 class="section-heading__title"><?php esc_html_e( 'Probefahrt anfragen', 'auto-emotion' ); ?></h2>
		</div>

		<?php if ( 'ok' === $auto_emotion_probefahrt_status ) : ?>
			<div class="application-notice application-notice--success">
				<?php esc_html_e( 'Danke! Wir melden uns, um einen Termin abzustimmen.', 'auto-emotion' ); ?>
			</div>
		<?php elseif ( 'fehler' === $auto_emotion_probefahrt_status ) : ?>
			<div class="application-notice application-notice--error">
				<?php esc_html_e( 'Bitte Name und Telefonnummer angeben und erneut senden.', 'auto-emotion' ); ?>
			</div>
		<?php endif; ?>

		<form class="application-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="auto_emotion_probefahrt">
			<input type="hidden" name="probefahrt_fahrzeug" value="<?php the_title_attribute(); ?>">
			<?php wp_nonce_field( 'auto_emotion_probefahrt', 'auto_emotion_probefahrt_nonce' ); ?>

			<p class="application-form__honeypot" aria-hidden="true">
				<label for="auto_emotion_website"><?php esc_html_e( 'Website (bitte freilassen)', 'auto-emotion' ); ?></label>
				<input type="text" id="auto_emotion_website" name="auto_emotion_website" tabindex="-1" autocomplete="off">
			</p>

			<div class="application-form__field">
				<label for="probefahrt_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
				<input type="text" id="probefahrt_name" name="probefahrt_name" required>
			</div>

			<div class="application-form__field">
				<label for="probefahrt_telefon"><?php esc_html_e( 'Telefon', 'auto-emotion' ); ?></label>
				<input type="tel" id="probefahrt_telefon" name="probefahrt_telefon" required>
			</div>

			<div class="application-form__field">
				<label for="probefahrt_termin"><?php esc_html_e( 'Wunschtermin (optional)', 'auto-emotion' ); ?></label>
				<input type="text" id="probefahrt_termin" name="probefahrt_termin" placeholder="<?php esc_attr_e( 'z. B. Samstagvormittag', 'auto-emotion' ); ?>">
			</div>

			<div class="application-form__field">
				<label for="probefahrt_nachricht"><?php esc_html_e( 'Nachricht (optional)', 'auto-emotion' ); ?></label>
				<textarea id="probefahrt_nachricht" name="probefahrt_nachricht" rows="4"></textarea>
			</div>

			<label class="application-form__consent">
				<input type="checkbox" name="probefahrt_dsgvo" value="1" required>
				<?php esc_html_e( 'Ich stimme zu, dass meine Angaben zur Bearbeitung dieser Anfrage gespeichert werden. Jederzeit widerrufbar.', 'auto-emotion' ); ?>
			</label>

			<button type="submit" class="btn btn-giallo application-form__submit">
				<?php esc_html_e( 'Probefahrt anfragen', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</button>
		</form>
	</article>
<?php endwhile; ?>

<?php
get_footer();
