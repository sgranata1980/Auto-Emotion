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
	// Teilen: natives Menü, wo vorhanden, sonst Link kopieren.
	document.querySelectorAll( '.model-card__teilen' ).forEach( function ( knopf ) {
		knopf.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			event.stopPropagation();

			var karte = knopf.closest( '.model-card' );
			var url   = location.href.split( '#' )[ 0 ] + '#' + karte.id;

			if ( navigator.share ) {
				navigator.share( { title: knopf.getAttribute( 'data-titel' ), url: url } ).catch( function () {} );
				return;
			}

			var melden = function ( text ) {
				knopf.setAttribute( 'data-kopiert', text );
				setTimeout( function () {
					knopf.removeAttribute( 'data-kopiert' );
				}, 2000 );
			};

			if ( navigator.clipboard ) {
				navigator.clipboard.writeText( url ).then(
					function () { melden( 'Link kopiert' ); },
					function () { window.prompt( 'Link kopieren:', url ); }
				);
			} else {
				window.prompt( 'Link kopieren:', url );
			}
		} );
	} );

	// Geteilter Link öffnet die passende Kachel.
	if ( location.hash.indexOf( '#modell-' ) === 0 ) {
		var geteilt = document.getElementById( location.hash.slice( 1 ) );
		if ( geteilt && geteilt.tagName === 'DETAILS' ) {
			geteilt.open = true;
		}
	}
} )();
