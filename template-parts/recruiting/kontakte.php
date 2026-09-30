<?php
/**
 * Adressbuch-Übersicht.
 * Erwartet: $auto_emotion_kontakte (array<WP_Post>)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

auto_emotion_staff_shell_start( __( 'Adressbuch', 'auto-emotion' ), 'kontakte' );
?>

<h1><?php esc_html_e( 'Adressbuch', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Interne Kontakte rund ums Recruiting – z. B. Ansprechpartner bei Jobportalen, Personalvermittlern oder der Arbeitsagentur.', 'auto-emotion' ); ?>
</p>

<div class="ae-toolbar">
	<span></span>
	<a class="ae-btn" href="<?php echo esc_url( home_url( '/mitarbeiter/kontakte/neu/' ) ); ?>"><?php esc_html_e( '+ Neuer Kontakt', 'auto-emotion' ); ?></a>
</div>

<?php if ( empty( $auto_emotion_kontakte ) ) : ?>
	<p class="ae-empty"><?php esc_html_e( 'Noch keine Kontakte angelegt.', 'auto-emotion' ); ?></p>
<?php else : ?>
	<ul class="ae-list">
		<?php foreach ( $auto_emotion_kontakte as $auto_emotion_kontakt ) : ?>
			<?php
			$auto_emotion_firma   = get_post_meta( $auto_emotion_kontakt->ID, '_kontakt_firma', true );
			$auto_emotion_rolle   = get_post_meta( $auto_emotion_kontakt->ID, '_kontakt_rolle', true );
			$auto_emotion_telefon = get_post_meta( $auto_emotion_kontakt->ID, '_kontakt_telefon', true );
			$auto_emotion_email   = get_post_meta( $auto_emotion_kontakt->ID, '_kontakt_email', true );
			$auto_emotion_edit    = home_url( '/mitarbeiter/kontakte/' . $auto_emotion_kontakt->ID . '/' );
			?>
			<li>
				<div class="ae-list__main">
					<p class="ae-list__title">
						<a href="<?php echo esc_url( $auto_emotion_edit ); ?>"><?php echo esc_html( $auto_emotion_kontakt->post_title ); ?></a>
					</p>
					<p class="ae-list__meta">
						<?php echo esc_html( trim( implode( ' · ', array_filter( array( $auto_emotion_rolle, $auto_emotion_firma ) ) ) ) ); ?>
					</p>
				</div>
				<div class="ae-list__links">
					<?php if ( $auto_emotion_telefon ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $auto_emotion_telefon ) ); ?>"><?php echo esc_html( $auto_emotion_telefon ); ?></a>
					<?php endif; ?>
					<?php if ( $auto_emotion_email ) : ?>
						<a href="mailto:<?php echo esc_attr( $auto_emotion_email ); ?>"><?php echo esc_html( $auto_emotion_email ); ?></a>
					<?php endif; ?>
				</div>
				<div class="ae-list__actions">
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( $auto_emotion_edit ); ?>"><?php esc_html_e( 'Bearbeiten', 'auto-emotion' ); ?></a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
