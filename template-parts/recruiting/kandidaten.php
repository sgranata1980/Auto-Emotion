<?php
/**
 * Manuelle Kandidatenliste eines Suchprofils.
 * Erwartet: $auto_emotion_form_post (WP_Post)
 *
 * @package Auto Emotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_post_id  = $auto_emotion_form_post->ID;
$auto_emotion_kandidaten = auto_emotion_get_kandidaten( $auto_emotion_post_id );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?php esc_html_e( 'Kandidatenliste', 'auto-emotion' ); ?> – <?php echo esc_html( $auto_emotion_form_post->post_title ); ?> – <?php bloginfo( 'name' ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/tokens.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/css/recruiting-backend.css?ver=' . AUTO_EMOTION_VERSION ); ?>">
</head>
<body class="ae-staff">
	<?php get_template_part( 'template-parts/recruiting/staff-nav' ); ?>

	<main class="ae-staff-main">
		<a class="ae-back-link" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' . $auto_emotion_post_id . '/' ) ); ?>">← <?php echo esc_html( $auto_emotion_form_post->post_title ); ?></a>

		<h1><?php esc_html_e( 'Kandidatenliste', 'auto-emotion' ); ?></h1>
		<p class="ae-staff-main__intro">
			<?php esc_html_e( 'Tragt hier von Hand Kandidaten ein, die ihr über die Such-Links gefunden habt – Name und Profil-Link genügen. Kein automatisches Sammeln von Profildaten, das würde gegen die Nutzungsbedingungen von LinkedIn & Co. verstoßen.', 'auto-emotion' ); ?>
		</p>

		<div class="ae-staff-toolbar">
			<span></span>
			<?php if ( ! empty( $auto_emotion_kandidaten ) ) : ?>
				<a class="ae-btn ae-btn--ghost" href="<?php echo esc_url( home_url( '/mitarbeiter/recruiting/' . $auto_emotion_post_id . '/kandidaten/export/' ) ); ?>"><?php esc_html_e( 'Als CSV exportieren', 'auto-emotion' ); ?></a>
			<?php endif; ?>
		</div>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ae-form-grid">
			<input type="hidden" name="action" value="auto_emotion_kandidat_save">
			<input type="hidden" name="ae_suchprofil_id" value="<?php echo esc_attr( $auto_emotion_post_id ); ?>">
			<?php wp_nonce_field( 'auto_emotion_kandidat_save_' . $auto_emotion_post_id, 'auto_emotion_kandidat_save_nonce' ); ?>

			<div class="ae-field">
				<label for="ae_kandidat_name"><?php esc_html_e( 'Name', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_kandidat_name" name="ae_kandidat_name" required>
			</div>
			<div class="ae-field">
				<label for="ae_kandidat_profil"><?php esc_html_e( 'Profil-Link (LinkedIn/Xing)', 'auto-emotion' ); ?></label>
				<input type="url" id="ae_kandidat_profil" name="ae_kandidat_profil" placeholder="https://www.linkedin.com/in/...">
			</div>
			<div class="ae-field ae-field--full">
				<label for="ae_kandidat_notiz"><?php esc_html_e( 'Notiz (optional)', 'auto-emotion' ); ?></label>
				<input type="text" id="ae_kandidat_notiz" name="ae_kandidat_notiz">
			</div>
			<div class="ae-field ae-field--full">
				<button type="submit" class="ae-btn" style="width:auto;"><?php esc_html_e( '+ Kandidat hinzufügen', 'auto-emotion' ); ?></button>
			</div>
		</form>

		<?php if ( empty( $auto_emotion_kandidaten ) ) : ?>
			<p class="ae-empty"><?php esc_html_e( 'Noch keine Kandidaten eingetragen.', 'auto-emotion' ); ?></p>
		<?php else : ?>
			<table class="ae-kandidaten-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Name', 'auto-emotion' ); ?></th>
						<th><?php esc_html_e( 'Profil', 'auto-emotion' ); ?></th>
						<th><?php esc_html_e( 'Notiz', 'auto-emotion' ); ?></th>
						<th><?php esc_html_e( 'Hinzugefügt', 'auto-emotion' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $auto_emotion_kandidaten as $auto_emotion_kandidat ) : ?>
						<tr>
							<td><?php echo esc_html( $auto_emotion_kandidat['name'] ); ?></td>
							<td>
								<?php if ( ! empty( $auto_emotion_kandidat['profil_url'] ) ) : ?>
									<a href="<?php echo esc_url( $auto_emotion_kandidat['profil_url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Profil ansehen', 'auto-emotion' ); ?> ↗</a>
								<?php endif; ?>
							</td>
							<td><?php echo esc_html( $auto_emotion_kandidat['notiz'] ); ?></td>
							<td><?php echo esc_html( $auto_emotion_kandidat['hinzugefuegt_am'] ); ?></td>
							<td>
								<a class="ae-remove" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=auto_emotion_kandidat_delete&ae_suchprofil_id=' . $auto_emotion_post_id . '&ae_kandidat_id=' . $auto_emotion_kandidat['id'] ), 'auto_emotion_kandidat_delete_' . $auto_emotion_post_id . '_' . $auto_emotion_kandidat['id'] ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Kandidat wirklich entfernen?', 'auto-emotion' ) ); ?>');"><?php esc_html_e( 'Entfernen', 'auto-emotion' ); ?></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</main>
</body>
</html>
