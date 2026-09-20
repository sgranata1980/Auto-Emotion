<?php
/**
 * Cookie-Hinweis. Ohne gespeicherte Einwilligung ("ae_consent"-Cookie)
 * werden externe Ressourcen wie Google Fonts nicht geladen (siehe
 * inc/enqueue.php). Erst nach "Alle akzeptieren" werden sie nachgeladen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="cookie-banner" class="cookie-banner" data-state="hidden" role="dialog" aria-label="<?php esc_attr_e( 'Cookie-Einstellungen', 'auto-emotion' ); ?>">
	<p class="cookie-banner__text">
		<?php esc_html_e( 'Wir verwenden technisch notwendige Cookies für den Betrieb dieser Website. Mit Ihrer Einwilligung laden wir zusätzlich Schriftarten von Google Fonts nach – dabei wird Ihre IP-Adresse an Google übertragen.', 'auto-emotion' ); ?>
		<a href="<?php echo esc_url( home_url( '/datenschutz/' ) ); ?>"><?php esc_html_e( 'Mehr in unserer Datenschutzerklärung', 'auto-emotion' ); ?></a>
	</p>
	<div class="cookie-banner__actions">
		<button type="button" class="cookie-banner__button cookie-banner__button--necessary" data-consent="necessary"><?php esc_html_e( 'Nur notwendige', 'auto-emotion' ); ?></button>
		<button type="button" class="cookie-banner__button cookie-banner__button--all" data-consent="all"><?php esc_html_e( 'Alle akzeptieren', 'auto-emotion' ); ?></button>
	</div>
</div>
