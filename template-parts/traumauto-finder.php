<?php
/**
 * Traumauto-Finder (Startseite): 2-Klick-Quiz, am Ende schlägt die KI
 * passende Fahrzeuge NUR aus dem echten, aktuellen Angebot-Bestand vor
 * (siehe inc/traumauto-finder.php - nichts wird erfunden).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_tf_usage    = auto_emotion_traumauto_usage_labels();
$auto_emotion_tf_priority = auto_emotion_traumauto_priority_labels();
?>
<section id="traumauto-finder" class="traumauto-finder" aria-labelledby="traumauto-finder-heading">
	<div class="traumauto-finder__header">
		<span class="traumauto-finder__badge">
			<span class="ai-badge" title="<?php esc_attr_e( 'KI-generierte Inhalte', 'auto-emotion' ); ?>">
				<?php auto_emotion_ai_badge_icon( 16 ); ?>
			</span>
			<?php esc_html_e( 'KI-gestützter Fahrzeug-Finder', 'auto-emotion' ); ?>
		</span>
		<h2 id="traumauto-finder-heading" class="traumauto-finder__title"><?php esc_html_e( 'Finden Sie Ihr Traumauto', 'auto-emotion' ); ?></h2>
		<p class="traumauto-finder__lede"><?php esc_html_e( 'Zwei Klicks, dann schlagen wir Ihnen passende Fahrzeuge aus unserem aktuellen Bestand vor – unverbindlich, egal ob Kauf, Finanzierung, Leasing oder gebraucht.', 'auto-emotion' ); ?></p>
	</div>

	<div class="traumauto-finder__progress" aria-hidden="true">
		<span class="traumauto-finder__dot is-active" data-dot="1"></span>
		<span class="traumauto-finder__dot" data-dot="2"></span>
		<span class="traumauto-finder__dot" data-dot="3"></span>
	</div>

	<div class="traumauto-finder__panel" data-panel="1">
		<p class="traumauto-finder__question"><?php esc_html_e( 'Wofür suchen Sie ein Fahrzeug?', 'auto-emotion' ); ?></p>
		<div class="traumauto-finder__options" data-group="usage">
			<?php foreach ( $auto_emotion_tf_usage as $auto_emotion_tf_key => $auto_emotion_tf_label ) : ?>
				<button type="button" class="traumauto-finder__option" data-value="<?php echo esc_attr( $auto_emotion_tf_key ); ?>"><?php echo esc_html( $auto_emotion_tf_label ); ?></button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="traumauto-finder__panel" data-panel="2" hidden>
		<p class="traumauto-finder__question"><?php esc_html_e( 'Worauf legen Sie Wert?', 'auto-emotion' ); ?></p>
		<div class="traumauto-finder__options" data-group="priority">
			<?php foreach ( $auto_emotion_tf_priority as $auto_emotion_tf_key => $auto_emotion_tf_label ) : ?>
				<button type="button" class="traumauto-finder__option" data-value="<?php echo esc_attr( $auto_emotion_tf_key ); ?>"><?php echo esc_html( $auto_emotion_tf_label ); ?></button>
			<?php endforeach; ?>
		</div>
		<button type="button" class="traumauto-finder__back"><?php esc_html_e( '← Zurück', 'auto-emotion' ); ?></button>
	</div>

	<div class="traumauto-finder__panel" data-panel="3" hidden>
		<div class="traumauto-finder__loading" data-loading>
			<span class="traumauto-finder__spinner" aria-hidden="true"></span>
			<?php esc_html_e( 'Wir suchen die passenden Fahrzeuge für Sie …', 'auto-emotion' ); ?>
		</div>
		<div class="traumauto-finder__results" data-results hidden></div>
		<p class="traumauto-finder__notice" data-notice hidden></p>
		<p class="traumauto-finder__error" data-error hidden>
			<?php esc_html_e( 'Der Fahrzeug-Finder ist gerade nicht erreichbar. Rufen Sie uns gerne direkt an:', 'auto-emotion' ); ?>
			<a href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?></a>
		</p>
		<button type="button" class="btn btn-outline traumauto-finder__restart"><?php esc_html_e( 'Neu starten', 'auto-emotion' ); ?></button>
	</div>
</section>
