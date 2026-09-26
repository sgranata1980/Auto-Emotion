/**
 * Modell-Konfigurator (Marken-Archiv): reine Anzeige-Logik, keine
 * Preisberechnung – fasst die Auswahl in einer Live-Zusammenfassung
 * zusammen und übergibt sie als Nachricht an den Anfrage-Button.
 */
( function () {
	'use strict';

	function updateSummary( configurator ) {
		var model      = configurator.getAttribute( 'data-model' );
		var colorInput = configurator.querySelector( 'input[type="radio"]:checked' );
		var color      = colorInput ? colorInput.value : '';
		var selects    = configurator.querySelectorAll( 'select' );
		var parts      = [ model ];

		if ( color ) {
			parts.push( color );
		}

		selects.forEach( function ( select ) {
			if ( select.value ) {
				parts.push( select.value );
			}
		} );

		var summaryEl = configurator.querySelector( '.configurator__summary-text' );
		if ( summaryEl ) {
			summaryEl.textContent = parts.join( ', ' );
		}

		var cta = configurator.querySelector( '.configurator__cta' );
		if ( cta && cta.dataset.hrefBase ) {
			var message = 'Hallo, ich interessiere mich für folgende Konfiguration:\n\n' + parts.join( '\n' );
			cta.setAttribute( 'href', cta.dataset.hrefBase + '&body=' + encodeURIComponent( message ) );
		}
	}

	function init() {
		var configurators = document.querySelectorAll( '.configurator' );
		configurators.forEach( function ( configurator ) {
			configurator.addEventListener( 'change', function () {
				updateSummary( configurator );
			} );
			updateSummary( configurator );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
