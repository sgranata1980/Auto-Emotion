<?php
/**
 * Footer template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( ! is_front_page() ) : ?>
</div>
<?php endif; ?>
</main>

<footer id="colophon" class="site-footer">
	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-widgets">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php endif; ?>

	<div class="footer-contact">
		<p>
			<?php echo esc_html( auto_emotion_contact( 'street' ) . ', ' . auto_emotion_contact( 'postal_code' ) . ' ' . auto_emotion_contact( 'city' ) ); ?><br>
			<a href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?></a>
			·
			<a href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>"><?php echo esc_html( auto_emotion_contact( 'email' ) ); ?></a>
		</p>
	</div>

	<nav id="footer-navigation" class="footer-navigation">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'menu_id'        => 'footer-menu',
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>

	<p class="footer-legal-note">
		<?php esc_html_e( 'Finanzierung & Leasing: Für Ihr neues Seat, Cupra oder Nissan Fahrzeug arbeiten wir nicht mit einer einzigen festen Hausbank, sondern mit unabhängigen Finanzierungspartnern zusammen – Sie haben die freie Bankwahl und sind an keinen bestimmten Anbieter gebunden. Zusätzlich profitieren Sie von aktuellen Werksangeboten der Hersteller, die wir für Sie im Blick behalten. Repräsentatives Beispiel im Sinne des § 17 PAngV (Stand: 21.09.2026, gültig bis 30.09.2026 bei allen teilnehmenden Cupra-Partnern, nicht kombinierbar mit anderen Sonderaktionen): Cupra Born 140 kW/58 kWh, Fahrzeugpreis 39.990 €. PrivatLeasing-Angebot der SEAT Leasing, Zweigniederlassung der Volkswagen Leasing GmbH, Gifhorner Straße 57, 38112 Braunschweig. Laufzeit 48 Monate, jährliche Fahrleistung 10.000 km, Anzahlung 3.000 €, monatliche Rate 309 €, zzgl. Überführungs- und Zulassungskosten. Bei einer Mehrkilometerleistung von über 2.500 km wird die vereinbarte Ausgleichszahlung fällig, bei Minderkilometern erfolgt eine Erstattung bis maximal 10.000 km. Bonität vorausgesetzt. Verbrauchern steht ein Widerrufsrecht gemäß § 495 BGB zu. Alle Preise verstehen sich inklusive der aktuell geltenden Mehrwertsteuer. Für andere Modelle, Marken, Laufzeiten oder Kilometerpakete erstellen wir Ihnen gerne ein individuelles Angebot – sprechen Sie uns einfach an.', 'auto-emotion' ); ?>
	</p>
	<p class="footer-legal-note footer-legal-note--mini">
		<?php esc_html_e( 'Alle Angaben ohne Gewähr. Modell-, Preis- und Konditionsänderungen durch den Hersteller vorbehalten. Es gilt der zum Zeitpunkt der Bestellung aktuelle, tatsächlich gültige Stand der Herstellerangebote – maßgeblich ist stets die schriftliche Bestätigung durch Auto Emotion GmbH & Co. KG.', 'auto-emotion' ); ?>
	</p>

	<div class="site-info">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
	</div>
</footer>

<?php get_template_part( 'template-parts/chat-widget' ); ?>
<?php get_template_part( 'template-parts/cookie-banner' ); ?>

<?php wp_footer(); ?>
</body>
</html>
