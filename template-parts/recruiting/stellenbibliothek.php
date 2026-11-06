<?php
/**
 * Stellenbibliothek: Übersicht der Autohaus-Berufsvorlagen, nach
 * Kategorie filterbar.
 * Erwartet: $auto_emotion_vorlagen (array<WP_Post>), $auto_emotion_filter_kategorie (string)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_kategorien = auto_emotion_stellenbibliothek_kategorien();

auto_emotion_staff_shell_start( __( 'Stellenbibliothek', 'auto-emotion' ), 'stellenbibliothek' );
?>

<h1><?php esc_html_e( 'Stellenbibliothek', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Fertige Aufgaben- und Anforderungsprofile für typische Autohaus-Berufe – als Startpunkt für ein neues Suchprofil. Texte sind allgemeine Vorlagen und lassen sich hier jederzeit anpassen.', 'auto-emotion' ); ?>
</p>

<div class="ae-toolbar">
	<div class="ae-status-tabs">
		<a href="<?php echo esc_url( home_url( '/mitarbeiter/stellenbibliothek/' ) ); ?>" class="<?php echo empty( $auto_emotion_filter_kategorie ) ? 'is-active' : ''; ?>"><?php esc_html_e( 'Alle', 'auto-emotion' ); ?></a>
		<?php foreach ( $auto_emotion_kategorien as $auto_emotion_kat_key => $auto_emotion_kat_label ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'kategorie', $auto_emotion_kat_key, home_url( '/mitarbeiter/stellenbibliothek/' ) ) ); ?>" class="<?php echo $auto_emotion_filter_kategorie === $auto_emotion_kat_key ? 'is-active' : ''; ?>"><?php echo esc_html( $auto_emotion_kat_label ); ?></a>
		<?php endforeach; ?>
	</div>
	<a class="ae-btn" style="width:auto;" href="<?php echo esc_url( home_url( '/mitarbeiter/stellenbibliothek/neu/' ) ); ?>"><?php esc_html_e( '+ Eigene Vorlage', 'auto-emotion' ); ?></a>
</div>

<?php if ( empty( $auto_emotion_vorlagen ) ) : ?>
	<p class="ae-empty"><?php esc_html_e( 'Keine Vorlagen in dieser Kategorie.', 'auto-emotion' ); ?></p>
<?php else : ?>
	<ul class="ae-list">
		<?php foreach ( $auto_emotion_vorlagen as $auto_emotion_v ) : ?>
			<?php $auto_emotion_v_kategorie = get_post_meta( $auto_emotion_v->ID, '_vorlage_kategorie', true ); ?>
			<li>
				<div class="ae-list__main">
					<p class="ae-list__title">
						<a href="<?php echo esc_url( home_url( '/mitarbeiter/stellenbibliothek/' . $auto_emotion_v->ID . '/' ) ); ?>"><?php echo esc_html( $auto_emotion_v->post_title ); ?></a>
					</p>
					<p class="ae-list__meta">
						<?php echo esc_html( isset( $auto_emotion_kategorien[ $auto_emotion_v_kategorie ] ) ? $auto_emotion_kategorien[ $auto_emotion_v_kategorie ] : '' ); ?>
					</p>
				</div>
				<div class="ae-list__actions">
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( home_url( '/mitarbeiter/stellenbibliothek/' . $auto_emotion_v->ID . '/' ) ); ?>"><?php esc_html_e( 'Ansehen', 'auto-emotion' ); ?></a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
