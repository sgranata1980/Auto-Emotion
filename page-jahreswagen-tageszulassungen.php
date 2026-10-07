<?php
/**
 * Template Name: Jahreswagen / Tageszulassungen
 *
 * Hintergrund zu Jahreswagen/Tageszulassungen recherchiert (allgemeines
 * Branchenwissen, u.a. wie Zulassungsziele/Margenstaffeln das Konzept
 * entstehen lassen) - bewusst ohne Auto-Emotion-spezifische Erfindungen
 * zu konkreten Modellen, Rabatten oder Stückzahlen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$auto_emotion_jahreswagen_faq = array(
	array(
		'q' => __( 'Was ist der Unterschied zwischen Jahreswagen und Tageszulassung?', 'auto-emotion' ),
		'a' => __( 'Eine Tageszulassung ist ein fabrikneues Fahrzeug, das für einen oder wenige Tage auf das Autohaus zugelassen und danach sofort weiterverkauft wird – de jure ein Gebrauchtwagen, de facto aber ungefahren. Ein Jahreswagen ist tatsächlich rund ein Jahr genutzt worden, meist mit 10.000 bis 20.000 Kilometern Laufleistung, klassischerweise aus einem Werksangehörigen-Programm.', 'auto-emotion' ),
	),
	array(
		'q' => __( 'Bekomme ich auf Jahreswagen und Tageszulassungen noch Herstellergarantie?', 'auto-emotion' ),
		'a' => __( 'In der Regel ja, da die Herstellergarantie ab Erstzulassung läuft und bei Fahrzeugen mit wenigen Monaten oder einem Jahr Nutzung meist noch zum größten Teil erhalten ist. Den genauen Garantiestand zu einem konkreten Fahrzeug nennen wir Ihnen gerne.', 'auto-emotion' ),
	),
);

auto_emotion_register_faq_schema( $auto_emotion_jahreswagen_faq );

get_header();
?>

<div class="section-heading">
	<h1 class="section-heading__title"><?php esc_html_e( 'Jahreswagen / Tageszulassungen', 'auto-emotion' ); ?></h1>
</div>

<img class="content-header-image" src="<?php echo esc_url( AUTO_EMOTION_URI . '/assets/images/showroom-formentor-born.jpg?ver=' . AUTO_EMOTION_VERSION ); ?>" alt="Fahrzeuge im Showroom von Auto Emotion" loading="lazy">

<div class="entry-content">
	<p><?php esc_html_e( 'Jahreswagen und Tageszulassungen verbinden den günstigeren Preis eines Gebrauchtwagens mit dem Zustand eines Neuwagens – minimale Laufleistung, aktuelle Ausstattung, meist noch volle Herstellergarantie.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Verfügbarkeit und Ausstattung wechseln laufend. Sprechen Sie uns an, wir sagen Ihnen gerne, welche Jahreswagen und Tageszulassungen von Seat, Cupra und Nissan aktuell bei uns verfügbar sind.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Wie ist das Konzept entstanden?', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Hersteller geben Autohäusern Zulassungsziele und Stückzahl-Boni vor: Je mehr Fahrzeuge ein Händler in einem bestimmten Zeitraum zulässt, desto höher fällt sein Bonus vom Hersteller aus. Eine Tageszulassung – das Autohaus meldet ein fabrikneues Fahrzeug kurz auf sich selbst an und direkt wieder ab – zählt dabei bereits als Verkauf. So entstehen Fahrzeuge, die rechtlich als gebraucht gelten, in Wirklichkeit aber nie bewegt wurden. Einen Teil des dadurch ausgelösten Bonus geben Händler als Preisvorteil an Kundinnen und Kunden weiter.', 'auto-emotion' ); ?></p>
	<p><?php esc_html_e( 'Jahreswagen haben einen anderen Ursprung: Viele Hersteller lassen Mitarbeitende Neuwagen vergünstigt least oder kaufen, verbunden mit einer Mindesthaltezeit von meist rund einem Jahr. Danach kommen diese Fahrzeuge zurück in den Handel – echt genutzt, aber mit überschaubarer Laufleistung und meist sehr gepflegt.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Was bringt mir das als Käufer?', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<p><?php esc_html_e( 'Der Preisvorteil gegenüber einem echten Neuwagen kann je nach Marke und Modell spürbar ausfallen, gerade bei Tageszulassungen mit praktisch null Kilometern. Dafür verzichten Sie auf die freie Konfiguration eines Neuwagens – Ausstattung, Farbe und Motorisierung stehen bereits fest. Wer sich mit dem verfügbaren Fahrzeug anfreunden kann, bekommt ein de facto neues Auto zu einem günstigeren Preis.', 'auto-emotion' ); ?></p>
</div>

<div class="section-heading">
	<h2 class="section-heading__title"><?php esc_html_e( 'Häufige Fragen', 'auto-emotion' ); ?></h2>
</div>
<div class="entry-content">
	<?php foreach ( $auto_emotion_jahreswagen_faq as $auto_emotion_faq_item ) : ?>
		<h3><?php echo esc_html( $auto_emotion_faq_item['q'] ); ?></h3>
		<p><?php echo esc_html( $auto_emotion_faq_item['a'] ); ?></p>
	<?php endforeach; ?>
</div>

<div class="entry-content">
	<p>
		<a class="btn btn-giallo" href="mailto:<?php echo esc_attr( auto_emotion_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( 'Jahreswagen-Anfrage' ); ?>">
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
