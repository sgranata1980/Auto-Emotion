<?php
/**
 * Dashboard-Startseite: echte Kennzahlen + Pipeline-Trichter +
 * neueste Bewerbungen. Angelehnt an gängige Recruiting-Dashboards
 * (Indeed, StepStone) – aber ausschließlich mit echten eigenen Daten,
 * keine erfundenen Kennzahlen wie Antwortquote/Conversion.
 *
 * Erwartet: auto_emotion_suchprofile_gesamt, auto_emotion_suchprofile_aktiv,
 * auto_emotion_bewerbungen_gesamt, auto_emotion_bewerbungen_woche,
 * auto_emotion_status_verteilung, auto_emotion_status_labels,
 * auto_emotion_neueste_bewerbungen
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

auto_emotion_staff_shell_start( __( 'Übersicht', 'auto-emotion' ), 'uebersicht' );

$auto_emotion_status_max = max( 1, max( $auto_emotion_status_verteilung ) );
?>

<h1><?php esc_html_e( 'Übersicht', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Aktueller Stand von Suchprofilen und Bewerbungen – alles echte Zahlen aus diesem System.', 'auto-emotion' ); ?>
</p>

<div class="ae-kpis">
	<div class="ae-kpi">
		<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_suchprofile_gesamt ); ?></div>
		<div class="ae-kpi__label"><?php esc_html_e( 'Suchprofile gesamt', 'auto-emotion' ); ?></div>
	</div>
	<div class="ae-kpi">
		<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_suchprofile_aktiv ); ?></div>
		<div class="ae-kpi__label"><?php esc_html_e( 'Aktiv gesucht', 'auto-emotion' ); ?></div>
	</div>
	<div class="ae-kpi">
		<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_bewerbungen_gesamt ); ?></div>
		<div class="ae-kpi__label"><?php esc_html_e( 'Bewerbungen gesamt', 'auto-emotion' ); ?></div>
	</div>
	<div class="ae-kpi">
		<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_bewerbungen_woche ); ?></div>
		<div class="ae-kpi__label"><?php esc_html_e( 'Neu diese Woche', 'auto-emotion' ); ?></div>
	</div>
</div>

<div class="ae-card">
	<h2><?php esc_html_e( 'Bewerbungs-Pipeline', 'auto-emotion' ); ?></h2>
	<div class="ae-funnel">
		<?php foreach ( $auto_emotion_status_labels as $auto_emotion_status_key => $auto_emotion_status_label ) : ?>
			<?php $auto_emotion_anzahl = isset( $auto_emotion_status_verteilung[ $auto_emotion_status_key ] ) ? $auto_emotion_status_verteilung[ $auto_emotion_status_key ] : 0; ?>
			<a class="ae-funnel__step" href="<?php echo esc_url( add_query_arg( 'status', $auto_emotion_status_key, home_url( '/mitarbeiter/bewerbungen/' ) ) ); ?>">
				<div class="ae-funnel__bar" style="height: <?php echo esc_attr( max( 6, round( ( $auto_emotion_anzahl / $auto_emotion_status_max ) * 64 ) ) ); ?>px;"></div>
				<div class="ae-funnel__value"><?php echo esc_html( $auto_emotion_anzahl ); ?></div>
				<div class="ae-funnel__label"><?php echo esc_html( $auto_emotion_status_label ); ?></div>
			</a>
		<?php endforeach; ?>
	</div>
</div>

<div class="ae-card">
	<h2><?php esc_html_e( 'Neueste Bewerbungen', 'auto-emotion' ); ?></h2>
	<?php if ( empty( $auto_emotion_neueste_bewerbungen ) ) : ?>
		<p class="ae-list__meta" style="margin:0;"><?php esc_html_e( 'Noch keine Bewerbungen eingegangen.', 'auto-emotion' ); ?></p>
	<?php else : ?>
		<ul class="ae-list" style="box-shadow:none; border:none;">
			<?php foreach ( $auto_emotion_neueste_bewerbungen as $auto_emotion_b ) : ?>
				<?php
				$auto_emotion_b_status = get_post_meta( $auto_emotion_b->ID, '_bewerbung_status', true );
				$auto_emotion_b_status = $auto_emotion_b_status ? $auto_emotion_b_status : 'neu';
				?>
				<li style="padding-left:0; padding-right:0;">
					<div class="ae-list__main">
						<p class="ae-list__title">
							<a href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' . $auto_emotion_b->ID . '/' ) ); ?>"><?php echo esc_html( get_post_meta( $auto_emotion_b->ID, '_bewerbung_name', true ) ); ?></a>
							<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_b_status ); ?>"><?php echo esc_html( isset( $auto_emotion_status_labels[ $auto_emotion_b_status ] ) ? $auto_emotion_status_labels[ $auto_emotion_b_status ] : $auto_emotion_b_status ); ?></span>
						</p>
						<p class="ae-list__meta">
							<?php echo esc_html( get_post_meta( $auto_emotion_b->ID, '_bewerbung_position', true ) ); ?> · <?php echo esc_html( get_the_date( 'd.m.Y', $auto_emotion_b ) ); ?>
						</p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>

<?php auto_emotion_staff_shell_end(); ?>
