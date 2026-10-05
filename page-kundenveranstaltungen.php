<?php
/**
 * Template Name: Kundenveranstaltungen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Kundenveranstaltungen', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Viele unserer Kunden begleiten uns seit Jahren, einige seit der Gründung 2001. Als inhabergeführtes Familienunternehmen ist uns dieser persönliche Kontakt über den reinen Fahrzeugkauf hinaus wichtig – entsprechend laden wir zu Anlässen wie Modellpremieren oder Jubiläen auch gezielt Kunden zu uns ein.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Konkrete Termine kündigen wir rechtzeitig an, unter anderem über unsere Social-Media-Kanäle. Wenn Sie nichts verpassen möchten, hinterlassen Sie uns gerne Ihre Kontaktdaten.', 'auto-emotion' ); ?></p>
	<p>
		<a class="btn btn-giallo" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
			<?php esc_html_e( 'Kontakt aufnehmen', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<?php $auto_emotion_instagram_url = auto_emotion_contact( 'instagram' ); ?>
		<?php if ( $auto_emotion_instagram_url ) : ?>
			<a class="btn btn-outline" href="<?php echo esc_url( $auto_emotion_instagram_url ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'Auf Instagram folgen', 'auto-emotion' ); ?>
				<span class="btn-arrow" aria-hidden="true">&rarr;</span>
			</a>
		<?php endif; ?>
	</p>
</div>

<?php
get_footer();
