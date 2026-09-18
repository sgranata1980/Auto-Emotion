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

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="sub-menu" data-state="closed">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$classes      = $has_children ? ' menu-item-has-children' : '';

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
