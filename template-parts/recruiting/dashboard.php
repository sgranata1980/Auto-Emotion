<?php
/**
 * Dashboard-Ansicht des Mitarbeiterbereichs: Übersicht aller Suchprofile.
 * Erwartet: $auto_emotion_profiles (array<WP_Post>)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_status_labels = array(
	'aktiv'    => __( 'Aktiv', 'auto-emotion' ),
	'pausiert' => __( 'Pausiert', 'auto-emotion' ),
	'besetzt'  => __( 'Besetzt', 'auto-emotion' ),
);

$auto_emotion_aktive_anzahl = 0;
foreach ( $auto_emotion_profiles as $auto_emotion_zaehl_profil ) {
	$auto_emotion_zaehl_status = get_post_meta( $auto_emotion_zaehl_profil->ID, '_suchprofil_status', true );
	if ( ! $auto_emotion_zaehl_status || 'aktiv' === $auto_emotion_zaehl_status ) {
		++$auto_emotion_aktive_anzahl;
	}
}

auto_emotion_staff_shell_start( __( 'Suchprofile', 'auto-emotion' ), 'dashboard' );
?>

<h1><?php esc_html_e( 'Suchprofile', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Interne Übersicht offener Positionen. Für jedes Suchprofil generiert das System fertige Such-Links – es werden keine Bewerber-Daten gespeichert, nur eure eigenen Such-Kriterien.', 'auto-emotion' ); ?>
</p>

<div class="ae-kpis">
	<div class="ae-kpi">
		<div class="ae-kpi__icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 19.5V4.5C4 3.67 4.67 3 5.5 3H18a1 1 0 0 1 1 1v15" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M6.5 3v18M6.5 17H19a2 2 0 0 1 2 2v1H6.5" stroke="currentColor" stroke-width="1.6" fill="none"/></svg></div>
		<div class="ae-kpi__value"><?php echo esc_html( count( $auto_emotion_profiles ) ); ?></div>
		<div class="ae-kpi__label"><?php esc_html_e( 'Suchprofile gesamt', 'auto-emotion' ); ?></div>
	</div>
	<div class="ae-kpi">
		<div class="ae-kpi__icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.6"/><path d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8" stroke="currentColor" stroke-width="1.6"/></svg></div>
		<div class="ae-kpi__value"><?php echo esc_html( $auto_emotion_aktive_anzahl ); ?></div>
		<div class="ae-kpi__label"><?php esc_html_e( 'Aktiv gesucht', 'auto-emotion' ); ?></div>
	</div>
</div>

<div class="ae-toolbar">
	<span></span>
	<a class="ae-btn" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/neu/' ) ); ?>"><?php esc_html_e( '+ Neues Suchprofil', 'auto-emotion' ); ?></a>
</div>

<?php if ( empty( $auto_emotion_profiles ) ) : ?>
	<p class="ae-empty"><?php esc_html_e( 'Noch keine Suchprofile angelegt.', 'auto-emotion' ); ?></p>
<?php else : ?>
	<ul class="ae-list">
		<?php foreach ( $auto_emotion_profiles as $auto_emotion_profile ) : ?>
			<?php
			$auto_emotion_status     = get_post_meta( $auto_emotion_profile->ID, '_suchprofil_status', true );
			$auto_emotion_status     = $auto_emotion_status ? $auto_emotion_status : 'aktiv';
			$auto_emotion_standort   = get_post_meta( $auto_emotion_profile->ID, '_suchprofil_standort', true );
			$auto_emotion_art        = get_post_meta( $auto_emotion_profile->ID, '_suchprofil_anstellungsart', true );
			$auto_emotion_links      = auto_emotion_suchprofil_links( $auto_emotion_profile->ID );
			$auto_emotion_edit_url   = home_url( '/mitarbeiter/recruiting/' . $auto_emotion_profile->ID . '/' );
			$auto_emotion_bewerbungen_anzahl = function_exists( 'auto_emotion_bewerbungen_fuer_position' ) ? count( auto_emotion_bewerbungen_fuer_position( $auto_emotion_profile->post_title ) ) : 0;
			?>
			<li>
				<div class="ae-list__main">
					<p class="ae-list__title">
						<a href="<?php echo esc_url( $auto_emotion_edit_url ); ?>"><?php echo esc_html( $auto_emotion_profile->post_title ); ?></a>
						<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_status ); ?>">
							<?php echo esc_html( isset( $auto_emotion_status_labels[ $auto_emotion_status ] ) ? $auto_emotion_status_labels[ $auto_emotion_status ] : $auto_emotion_status ); ?>
						</span>
					</p>
					<p class="ae-list__meta">
						<?php echo esc_html( trim( implode( ' · ', array_filter( array( $auto_emotion_standort, $auto_emotion_art ) ) ) ) ); ?>
						·
						<a href="<?php echo esc_url( add_query_arg( 'position', rawurlencode( $auto_emotion_profile->post_title ), home_url( '/mitarbeiter/bewerbungen/' ) ) ); ?>">
							<?php echo esc_html( sprintf( _n( '%d Bewerbung', '%d Bewerbungen', $auto_emotion_bewerbungen_anzahl, 'auto-emotion' ), $auto_emotion_bewerbungen_anzahl ) ); ?>
						</a>
					</p>
				</div>
				<div class="ae-list__links">
					<?php foreach ( $auto_emotion_links as $auto_emotion_link ) : ?>
						<a href="<?php echo esc_url( $auto_emotion_link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $auto_emotion_link['label'] ); ?> ↗</a>
						<?php if ( ! empty( $auto_emotion_link['hinweis'] ) ) : ?>
							<span class="ae-list__hinweis"><?php echo esc_html( $auto_emotion_link['hinweis'] ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<div class="ae-list__actions">
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' . $auto_emotion_profile->ID . '/anzeige/' ) ); ?>"><?php esc_html_e( 'Anzeige', 'auto-emotion' ); ?></a>
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' . $auto_emotion_profile->ID . '/kandidaten/' ) ); ?>"><?php esc_html_e( 'Kandidaten', 'auto-emotion' ); ?></a>
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( $auto_emotion_edit_url ); ?>"><?php esc_html_e( 'Bearbeiten', 'auto-emotion' ); ?></a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
