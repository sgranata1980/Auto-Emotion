<?php
/**
 * Papierkorb: gelöschte Suchprofile und Bewerbungen, wiederherstellbar.
 * Erwartet: $auto_emotion_papierkorb_items (array<WP_Post>)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

auto_emotion_staff_shell_start( __( 'Papierkorb', 'auto-emotion' ), 'papierkorb' );
?>

<h1><?php esc_html_e( 'Papierkorb', 'auto-emotion' ); ?></h1>
<p class="ae-intro">
	<?php esc_html_e( 'Gelöschte Suchprofile, Bewerbungen, Kontakte und Nachrichten bleiben hier 30 Tage wiederherstellbar, bevor WordPress sie automatisch endgültig entfernt (inkl. hochgeladener Dateien).', 'auto-emotion' ); ?>
</p>

<?php if ( empty( $auto_emotion_papierkorb_items ) ) : ?>
	<p class="ae-empty"><?php esc_html_e( 'Der Papierkorb ist leer.', 'auto-emotion' ); ?></p>
<?php else : ?>
	<ul class="ae-list">
		<?php foreach ( $auto_emotion_papierkorb_items as $auto_emotion_item ) : ?>
			<?php
			$auto_emotion_typ_labels = array(
				'suchprofil' => __( 'Suchprofil', 'auto-emotion' ),
				'bewerbung'  => __( 'Bewerbung', 'auto-emotion' ),
				'kontakt'    => __( 'Kontakt', 'auto-emotion' ),
				'nachricht'  => __( 'Nachricht', 'auto-emotion' ),
			);
			$auto_emotion_typ_label  = isset( $auto_emotion_typ_labels[ $auto_emotion_item->post_type ] ) ? $auto_emotion_typ_labels[ $auto_emotion_item->post_type ] : $auto_emotion_item->post_type;
			$auto_emotion_titel     = 'bewerbung' === $auto_emotion_item->post_type ? get_post_meta( $auto_emotion_item->ID, '_bewerbung_name', true ) : $auto_emotion_item->post_title;
			?>
			<li>
				<div class="ae-list__main">
					<p class="ae-list__title">
						<?php echo esc_html( $auto_emotion_titel ? $auto_emotion_titel : $auto_emotion_item->post_title ); ?>
						<span class="ae-status ae-status--pausiert"><?php echo esc_html( $auto_emotion_typ_label ); ?></span>
					</p>
					<p class="ae-list__meta">
						<?php echo esc_html( sprintf( __( 'Gelöscht am %s', 'auto-emotion' ), get_the_modified_date( 'd.m.Y H:i', $auto_emotion_item ) ) ); ?>
					</p>
				</div>
				<div class="ae-list__actions">
					<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_papierkorb_wiederherstellen&ae_post_id=' . $auto_emotion_item->ID ), 'auto_emotion_papierkorb_wiederherstellen_' . $auto_emotion_item->ID ) ); ?>"><?php esc_html_e( 'Wiederherstellen', 'auto-emotion' ); ?></a>
					<a class="ae-btn ae-btn--danger" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_papierkorb_endgueltig_loeschen&ae_post_id=' . $auto_emotion_item->ID ), 'auto_emotion_papierkorb_loeschen_' . $auto_emotion_item->ID ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Endgültig löschen? Das kann nicht rückgängig gemacht werden.', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'Endgültig löschen', 'auto-emotion' ); ?></a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php auto_emotion_staff_shell_end(); ?>
