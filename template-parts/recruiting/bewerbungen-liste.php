<?php
/**
 * Übersicht aller gespeicherten Bewerbungen im Mitarbeiterbereich –
 * Listen- oder Kanban-Board-Ansicht (?view=board).
 * Erwartet: $auto_emotion_bewerbungen, $auto_emotion_filter_status,
 * $auto_emotion_filter_suche, $auto_emotion_filter_tag,
 * $auto_emotion_filter_talentpool, $auto_emotion_alle_tags,
 * $auto_emotion_view, $auto_emotion_alle_bewerbungen
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_status_labels = auto_emotion_bewerbung_status_labels();

auto_emotion_staff_shell_start( __( 'Bewerbungen', 'auto-emotion' ), 'bewerbungen' );
?>

<h1><?php esc_html_e( 'Bewerbungen', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Eingehende Bewerbungen aus den Karriere-Formularen. Unterlagen sind nur hier, geschützt, einsehbar und lassen sich an Kollegen weiterleiten – nie über eine öffentliche URL.', 'auto-emotion' ); ?>
</p>

<?php if ( ! empty( $auto_emotion_filter_position ) ) : ?>
	<p class="ae-notice" style="background:var(--ae-accent-soft); border-color:var(--ae-accent); color:var(--ae-accent);">
		<?php echo esc_html( sprintf( __( 'Gefiltert nach Position: %s', 'auto-emotion' ), $auto_emotion_filter_position ) ); ?>
		· <a href="<?php echo esc_url( remove_query_arg( 'position' ) ); ?>" style="text-decoration:underline;"><?php esc_html_e( 'Filter entfernen', 'auto-emotion' ); ?></a>
	</p>
<?php endif; ?>

<div class="ae-toolbar">
	<div class="ae-status-tabs">
		<a href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>" class="<?php echo empty( $auto_emotion_filter_status ) ? 'is-active' : ''; ?>"><?php esc_html_e( 'Alle', 'auto-emotion' ); ?></a>
		<?php foreach ( $auto_emotion_status_labels as $auto_emotion_status_key => $auto_emotion_status_label ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'status', $auto_emotion_status_key, home_url( '/mitarbeiter/bewerbungen/' ) ) ); ?>" class="<?php echo $auto_emotion_filter_status === $auto_emotion_status_key ? 'is-active' : ''; ?>"><?php echo esc_html( $auto_emotion_status_label ); ?></a>
		<?php endforeach; ?>
	</div>
	<div class="ae-status-tabs">
		<a href="<?php echo esc_url( remove_query_arg( 'view' ) ); ?>" class="<?php echo 'liste' === $auto_emotion_view ? 'is-active' : ''; ?>"><?php esc_html_e( 'Liste', 'auto-emotion' ); ?></a>
		<a href="<?php echo esc_url( add_query_arg( 'view', 'board' ) ); ?>" class="<?php echo 'board' === $auto_emotion_view ? 'is-active' : ''; ?>"><?php esc_html_e( 'Board', 'auto-emotion' ); ?></a>
	</div>
	<div class="ae-status-tabs">
		<a href="<?php echo esc_url( $auto_emotion_filter_talentpool ? remove_query_arg( 'talentpool' ) : add_query_arg( 'talentpool', '1' ) ); ?>" class="<?php echo $auto_emotion_filter_talentpool ? 'is-active' : ''; ?>">★ <?php esc_html_e( 'Talent-Pool', 'auto-emotion' ); ?></a>
	</div>
	<form method="get" action="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' ) ); ?>" class="ae-suche">
		<?php if ( $auto_emotion_filter_status ) : ?>
			<input type="hidden" name="status" value="<?php echo esc_attr( $auto_emotion_filter_status ); ?>">
		<?php endif; ?>
		<?php if ( 'board' === $auto_emotion_view ) : ?>
			<input type="hidden" name="view" value="board">
		<?php endif; ?>
		<?php if ( $auto_emotion_filter_talentpool ) : ?>
			<input type="hidden" name="talentpool" value="1">
		<?php endif; ?>
		<input type="search" name="suche" value="<?php echo esc_attr( $auto_emotion_filter_suche ); ?>" placeholder="<?php esc_attr_e( 'Suche: Name, Position, Notiz, Tag …', 'auto-emotion' ); ?>">
		<button type="submit" class="ae-btn ae-btn--ghost"><?php esc_html_e( 'Suchen', 'auto-emotion' ); ?></button>
	</form>
</div>

<?php if ( $auto_emotion_filter_suche ) : ?>
	<p class="ae-notice" style="background:var(--ae-accent-soft); border-color:var(--ae-accent); color:var(--ae-accent);">
		<?php echo esc_html( sprintf( __( 'Suche: "%s"', 'auto-emotion' ), $auto_emotion_filter_suche ) ); ?>
		· <a href="<?php echo esc_url( remove_query_arg( 'suche' ) ); ?>" style="text-decoration:underline;"><?php esc_html_e( 'Suche zurücksetzen', 'auto-emotion' ); ?></a>
	</p>
<?php endif; ?>

<?php if ( ! empty( $auto_emotion_alle_tags ) ) : ?>
	<div class="ae-status-tabs" style="margin-bottom:20px;">
		<a href="<?php echo esc_url( remove_query_arg( 'tag' ) ); ?>" class="<?php echo empty( $auto_emotion_filter_tag ) ? 'is-active' : ''; ?>"><?php esc_html_e( 'Alle Tags', 'auto-emotion' ); ?></a>
		<?php foreach ( $auto_emotion_alle_tags as $auto_emotion_tag_option ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'tag', rawurlencode( $auto_emotion_tag_option ) ) ); ?>" class="<?php echo $auto_emotion_filter_tag === $auto_emotion_tag_option ? 'is-active' : ''; ?>">#<?php echo esc_html( $auto_emotion_tag_option ); ?></a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if ( 'board' === $auto_emotion_view ) : ?>

	<div class="ae-board">
		<?php foreach ( $auto_emotion_status_labels as $auto_emotion_status_key => $auto_emotion_status_label ) : ?>
			<?php
			$auto_emotion_spalte = array_filter(
				$auto_emotion_alle_bewerbungen,
				function ( $auto_emotion_b ) use ( $auto_emotion_status_key ) {
					$s = get_post_meta( $auto_emotion_b->ID, '_bewerbung_status', true );
					return ( $s ? $s : 'neu' ) === $auto_emotion_status_key;
				}
			);
			?>
			<div class="ae-board__column">
				<div class="ae-board__column-title">
					<span><?php echo esc_html( $auto_emotion_status_label ); ?></span>
					<span><?php echo esc_html( count( $auto_emotion_spalte ) ); ?></span>
				</div>
				<?php foreach ( $auto_emotion_spalte as $auto_emotion_karte ) : ?>
					<?php
					$auto_emotion_bewertung_val = (int) get_post_meta( $auto_emotion_karte->ID, '_bewerbung_bewertung', true );
					$auto_emotion_karte_name    = get_post_meta( $auto_emotion_karte->ID, '_bewerbung_name', true );
					$auto_emotion_karte_tags    = auto_emotion_bewerbung_tags( $auto_emotion_karte->ID );
					?>
					<a class="ae-board__card" href="<?php echo esc_url( home_url( '/mitarbeiter/bewerbungen/' . $auto_emotion_karte->ID . '/' ) ); ?>">
						<div style="display:flex; align-items:center; gap:8px;">
							<span class="ae-avatar ae-avatar--sm" style="background:<?php echo esc_attr( auto_emotion_avatar_farbe( $auto_emotion_karte_name ) ); ?>;"><?php echo esc_html( auto_emotion_initialen( $auto_emotion_karte_name ) ); ?></span>
							<div class="ae-board__card-title"><?php echo esc_html( $auto_emotion_karte_name ); ?></div>
						</div>
						<div class="ae-board__card-meta"><?php echo esc_html( get_post_meta( $auto_emotion_karte->ID, '_bewerbung_position', true ) ); ?></div>
						<?php if ( $auto_emotion_bewertung_val > 0 ) : ?>
							<div class="ae-sterne"><?php echo esc_html( str_repeat( '★', $auto_emotion_bewertung_val ) . str_repeat( '☆', 5 - $auto_emotion_bewertung_val ) ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $auto_emotion_karte_tags ) ) : ?>
							<div style="margin-top:6px;">
								<?php foreach ( $auto_emotion_karte_tags as $auto_emotion_karte_tag ) : ?>
									<span class="ae-tag">#<?php echo esc_html( $auto_emotion_karte_tag ); ?></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</div>

<?php elseif ( empty( $auto_emotion_bewerbungen ) ) : ?>

	<p class="ae-empty"><?php esc_html_e( 'Noch keine Bewerbungen eingegangen.', 'auto-emotion' ); ?></p>

<?php else : ?>

	<ul class="ae-list">
		<?php foreach ( $auto_emotion_bewerbungen as $auto_emotion_bewerbung ) : ?>
			<?php
			$auto_emotion_position      = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_position', true );
			$auto_emotion_telefon       = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_telefon', true );
			$auto_emotion_dateien       = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_dateien', true );
			$auto_emotion_detail_url    = home_url( '/mitarbeiter/bewerbungen/' . $auto_emotion_bewerbung->ID . '/' );
			$auto_emotion_status_val    = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_status', true );
			$auto_emotion_status_val    = $auto_emotion_status_val ? $auto_emotion_status_val : 'neu';
			$auto_emotion_bewertung_val  = (int) get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_bewertung', true );
			$auto_emotion_termin_val     = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_termin', true );
			$auto_emotion_termin_zukunft = $auto_emotion_termin_val && strtotime( $auto_emotion_termin_val ) >= current_time( 'timestamp' ); // phpcs:ignore -- Vergleich zweier lokaler Pseudo-Unix-Zeiten, siehe recruiting-bewerbungen.php.
			$auto_emotion_name_val       = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_name', true );
			$auto_emotion_tags_val       = auto_emotion_bewerbung_tags( $auto_emotion_bewerbung->ID );
			$auto_emotion_talentpool_val = auto_emotion_bewerbung_im_talentpool( $auto_emotion_bewerbung->ID );
			$auto_emotion_dubletten_val  = get_post_meta( $auto_emotion_bewerbung->ID, '_bewerbung_dubletten', true );
			?>
			<li>
				<span class="ae-avatar" style="background:<?php echo esc_attr( auto_emotion_avatar_farbe( $auto_emotion_name_val ) ); ?>;"><?php echo esc_html( auto_emotion_initialen( $auto_emotion_name_val ) ); ?></span>
				<div class="ae-list__main">
					<p class="ae-list__title">
						<a href="<?php echo esc_url( $auto_emotion_detail_url ); ?>"><?php echo esc_html( $auto_emotion_name_val ); ?></a>
						<span class="ae-status ae-status--<?php echo esc_attr( $auto_emotion_status_val ); ?>"><?php echo esc_html( isset( $auto_emotion_status_labels[ $auto_emotion_status_val ] ) ? $auto_emotion_status_labels[ $auto_emotion_status_val ] : $auto_emotion_status_val ); ?></span>
						<?php if ( $auto_emotion_talentpool_val ) : ?>
							<span class="ae-tag" title="<?php esc_attr_e( 'Im Talent-Pool', 'auto-emotion' ); ?>">★ <?php esc_html_e( 'Talent-Pool', 'auto-emotion' ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $auto_emotion_dubletten_val ) ) : ?>
							<span class="ae-status ae-status--interview" title="<?php esc_attr_e( 'Mögliche Dublette – bitte prüfen', 'auto-emotion' ); ?>"><?php esc_html_e( 'Mögliche Dublette', 'auto-emotion' ); ?></span>
						<?php endif; ?>
						<?php if ( $auto_emotion_bewertung_val > 0 ) : ?>
							<span class="ae-sterne" aria-label="<?php echo esc_attr( $auto_emotion_bewertung_val . ' von 5 Sternen' ); ?>"><?php echo esc_html( str_repeat( '★', $auto_emotion_bewertung_val ) . str_repeat( '☆', 5 - $auto_emotion_bewertung_val ) ); ?></span>
						<?php endif; ?>
						<?php foreach ( $auto_emotion_tags_val as $auto_emotion_tag_val ) : ?>
							<span class="ae-tag">#<?php echo esc_html( $auto_emotion_tag_val ); ?></span>
						<?php endforeach; ?>
					</p>
					<p class="ae-list__meta">
						<?php echo esc_html( trim( implode( ' · ', array_filter( array( $auto_emotion_position, $auto_emotion_telefon, get_the_date( 'd.m.Y', $auto_emotion_bewerbung ) ) ) ) ) ); ?>
						<?php if ( ! empty( $auto_emotion_dateien ) ) : ?>
							· <?php echo esc_html( sprintf( _n( '%d Datei', '%d Dateien', count( $auto_emotion_dateien ), 'auto-emotion' ), count( $auto_emotion_dateien ) ) ); ?>
						<?php endif; ?>
						<?php if ( $auto_emotion_termin_zukunft ) : ?>
							· <?php echo esc_html( sprintf( __( 'Termin %s Uhr', 'auto-emotion' ), mysql2date( 'd.m.Y H:i', $auto_emotion_termin_val ) ) ); ?>
						<?php endif; ?>
					</p>
				</div>
				<div class="ae-list__actions">
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( $auto_emotion_detail_url ); ?>"><?php esc_html_e( 'Ansehen', 'auto-emotion' ); ?></a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
