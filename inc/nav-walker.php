<?php
/**
 * Walker für das Hauptmenü: rendert Elemente mit Kindern als ausklappbare
 * Gruppe (Accordion) innerhalb des Vollbild-Menü-Overlays, statt als
 * klassisches Hover-Dropdown – passend zum Lamborghini-artigen
 * Vollbild-Navigationsmuster der Seite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Auto_Emotion_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Zuletzt gerenderter Menüpunkt je Tiefe. start_lvl() wird von der
	 * Walker-API direkt nach start_el() des übergeordneten Punkts
	 * aufgerufen, bekommt dessen Daten (URL/Titel) aber nicht
	 * übergeben - hier zwischengespeichert, um im Untermenü einen
	 * "Alle X ansehen"-Link auf die Hauptkategorie voranzustellen. So
	 * wird sofort klar, dass die Hauptkategorie selbst auch eine
	 * eigene, anklickbare Seite ist statt nur ein Aufklapp-Auslöser.
	 */
	private $parent_items = array();

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="sub-menu" data-state="closed">';

		if ( isset( $this->parent_items[ $depth ] ) ) {
			$parent = $this->parent_items[ $depth ];
			$output .= '<li class="menu-item sub-menu__overview">';
			$output .= '<a href="' . esc_url( $parent->url ) . '" class="menu-item__link sub-menu__overview-link">';
			$output .= esc_html(
				sprintf(
					/* translators: %s: Titel des übergeordneten Menüpunkts. */
					__( 'Alle %s ansehen', 'auto-emotion' ),
					$parent->title
				)
			);
			$output .= ' <span aria-hidden="true">&rarr;</span>';
			$output .= '</a></li>';
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$classes      = $has_children ? ' menu-item-has-children' : '';

		if ( $has_children ) {
			$this->parent_items[ $depth ] = $item;
		}

		$output .= '<li class="menu-item' . esc_attr( $classes ) . '">';

		$output .= '<a href="' . esc_url( $item->url ) . '" class="menu-item__link">' . esc_html( $item->title ) . '</a>';

		if ( $has_children ) {
			$output .= '<button type="button" class="submenu-toggle" aria-expanded="false" aria-label="' . esc_attr(
				/* translators: %s: Menu item title. */
				sprintf( __( 'Untermenü %s', 'auto-emotion' ), $item->title )
			) . '"><span class="submenu-toggle-icon" aria-hidden="true"></span></button>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
