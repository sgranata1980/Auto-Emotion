<?php
/**
 * Template Name: Elektro & Hybrid
 *
 * Förderzahlen mit Datum/Quelle versehen (ändern sich häufig) statt
 * als feste Zusage zu formulieren. Keine erfundene "Extras von uns"-
 * Zusage (z.B. Lade-Guthaben) ohne Bestätigung durch den Kunden.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_elektro_faq = array(
	array(
		'q' => __( 'Bekomme ich beim Kauf eines Elektroautos noch eine staatliche Förderung?', 'auto-emotion' ),
		'a' => __( 'Seit Januar 2026 gibt es wieder eine bundesweite Kaufprämie für Neuzulassungen – je nach Fahrzeugtyp und Haushaltseinkommen zwischen 1.500 € und 6.000 €. Ob und in welcher Höhe sie für Sie gilt, hängt von Ihrer individuellen Situation ab, aktuelle Details erfragen Sie am besten direkt bei uns.', 'auto-emotion' ),
	),
	array(
		'q' => __( 'Was ist die THG-Quote und bringt sie mir etwas?', 'auto-emotion' ),
		'a' => __( 'Halter eines reinen Elektroautos können die eingesparten CO₂-Emissionen über die sogenannte THG-Quote jährlich an Unternehmen verkaufen, die dafür eine Prämie zahlen. Die Höhe schwankt je nach Anbieter.', 'auto-emotion' ),
	),
	array(
		'q' => __( 'Ist ein Elektro- oder ein Hybridfahrzeug die richtige Wahl für mich?', 'auto-emotion' ),
		'a' => __( 'Das hängt von Fahrprofil, Lademöglichkeit und Budget ab. Wir beraten Sie gerne unverbindlich zu allen Elektro- und Hybridmodellen von Seat, Cupra und Nissan.', 'auto-emotion' ),
	),
);
auto_emotion_register_faq_schema( $auto_emotion_elektro_faq );

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Elektro & Hybrid', 'auto-emotion' ); ?></h1>
</div>

<div class="entry-content">
	<p><?php esc_html_e( 'Elektro- und Hybridfahrzeuge von Seat, Cupra und Nissan gehören fest zu unserem Modellprogramm – vom CUPRA Born und Tavascan über den Seat Leon e-HYBRID bis zum Nissan X-Trail e-POWER und Nissan Leaf.', 'auto-emotion' ); ?></p>
	<ul>
		<li><a href="<?php echo esc_url( home_url( '/marke/seat/' ) ); ?>"><?php esc_html_e( 'Seat-Modelle bei Auto Emotion', 'auto-emotion' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/marke/cupra/' ) ); ?>"><?php esc_html_e( 'Cupra-Modelle bei Auto Emotion', 'auto-emotion' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/marke/nissan/' ) ); ?>"><?php esc_html_e( 'Nissan-Modelle bei Auto Emotion', 'auto-emotion' ); ?></a></li>
	</ul>
	<p><?php esc_html_e( 'In unserer Werkstatt sind speziell für Hochvoltfahrzeuge geschulte Mitarbeiter im Einsatz.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Staatliche Förderung', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Seit Januar 2026 gilt in Deutschland wieder eine soziale Kaufprämie für neu zugelassene Elektroautos und bestimmte Plug-in-Hybride bzw. Fahrzeuge mit Range Extender: 3.000 € Basisförderung für rein elektrische Fahrzeuge, mindestens 1.500 € für Plug-in-Hybride/Range-Extender. Haushalte mit bis zu zwei Kindern und einem zu versteuernden Jahreseinkommen bis 45.000 € können bis zu 6.000 € erhalten, die allgemeine Einkommensgrenze liegt bei 80.000 € (mit Kindern 90.000 €).', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Zusätzlich lässt sich über die sogenannte THG-Quote die CO₂-Einsparung eines reinen Elektroautos jährlich an quotenpflichtige Unternehmen verkaufen – die Prämie dafür liegt je nach Anbieter aktuell ungefähr zwischen 100 € und 370 € pro Jahr.', 'auto-emotion' ); ?></p>
	<p class="model-card__disclaimer"><?php esc_html_e( 'Stand: Oktober 2026, Angaben ohne Gewähr nach öffentlich zugänglichen Quellen. Fördersätze, Einkommensgrenzen und Fristen ändern sich regelmäßig und hängen von Ihrer individuellen Situation ab – wir prüfen das gerne gemeinsam mit Ihnen, ersetzen aber keine steuerliche oder rechtliche Beratung.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Kurze Geschichte des Elektroautos', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Elektroautos sind keine Erfindung der letzten Jahre: Schon 1881 stellte der Franzose Gustave Trouvé in Paris ein elektrisch angetriebenes Dreirad vor, 1888 baute der deutsche Maschinenfabrikant Andreas Flocken das erste deutsche Elektroauto. Um 1900 waren in vielen Städten sogar mehr Fahrzeuge mit Elektro- als mit Verbrennungsantrieb unterwegs – leiser, einfacher zu bedienen, ohne Kurbelstart.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Auch der Hybridantrieb ist über hundert Jahre alt: Ferdinand Porsche präsentierte 1900 auf der Weltausstellung in Paris ein Fahrzeug, bei dem ein Verbrennungsmotor einen Generator für Elektromotoren in den Radnaben antrieb. Mit besseren, günstigeren Verbrennungsmotoren und der Erfindung des elektrischen Anlassers verschwand die Elektromobilität dann für Jahrzehnte fast vollständig von der Bildfläche – bis steigende Reichweiten, Batteriekosten und Umweltauflagen sie in den letzten rund 15 Jahren zurückgebracht haben.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Wie geht es weiter?', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Seat, Cupra und Nissan bauen ihre Elektro- und Hybridmodelle kontinuierlich aus – Reichweiten steigen, Ladezeiten sinken, und mit dem Preisverfall bei Batterien rücken E-Autos auch preislich näher an vergleichbare Verbrenner heran. Wie schnell sich das entwickelt und wie die Förderlandschaft sich weiter verändert, lässt sich seriös nicht auf Jahre hinaus vorhersagen – wir halten Sie dazu gerne auf dem Laufenden, wenn Sie sich aktuell mit einem Kauf beschäftigen.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Häufige Fragen', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<?php foreach ( $auto_emotion_elektro_faq as $auto_emotion_faq_item ) : ?>
		<h3><?php echo esc_html( $auto_emotion_faq_item['q'] ); ?></h3>
		<p><?php echo esc_html( $auto_emotion_faq_item['a'] ); ?></p>
	<?php endforeach; ?>
</div>

<div class="entry-content">
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Elektro & Hybrid-Anfrage' ); ?>">
			<?php esc_html_e( 'Anfrage senden', 'auto-emotion' ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
		<a class="btn btn-outline" href="tel:<?php echo esc_attr( auto_emotion_contact( 'phone_href' ) ); ?>">
			<?php echo esc_html( auto_emotion_contact( 'phone' ) ); ?>
			<span class="btn-arrow" aria-hidden="true">&rarr;</span>
		</a>
	</p>
</div>

<?php
get_footer();
