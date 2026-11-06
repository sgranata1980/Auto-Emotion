/**
 * Unverbindlicher Finanzierungs-Vorabrechner.
 *
 * Reine Beispielrechnung auf Basis eines recherchierten Richtzinses
 * (Verivox-Verbraucheratlas, Marktdurchschnitt Anfang 2026). Ersetzt
 * kein individuelles Finanzierungsangebot – siehe Disclaimer im
 * Markup. Rein clientseitig, keine Übertragung an den Server.
 */
( function () {
	'use strict';

	function formatEuro( value ) {
		return value.toLocaleString( 'de-DE', {
			style: 'currency',
			currency: 'EUR',
			maximumFractionDigits: 0,
		} );
	}

	function berechneMonatsrate( kreditbetrag, effektiverJahreszinsProzent, laufzeitMonate ) {
		if ( kreditbetrag <= 0 || laufzeitMonate <= 0 ) {
			return 0;
		}
		var jahreszins = effektiverJahreszinsProzent / 100;
		var monatszins = Math.pow( 1 + jahreszins, 1 / 12 ) - 1;
		if ( monatszins === 0 ) {
			return kreditbetrag / laufzeitMonate;
		}
		var faktor = Math.pow( 1 + monatszins, laufzeitMonate );
		return ( kreditbetrag * monatszins * faktor ) / ( faktor - 1 );
	}

	function init() {
		var form = document.querySelector( '[data-finanzierungsrechner]' );
		if ( ! form ) {
			return;
		}

		var preisInput = form.querySelector( '[data-fr-preis]' );
		var anzahlungInput = form.querySelector( '[data-fr-anzahlung]' );
		var laufzeitInput = form.querySelector( '[data-fr-laufzeit]' );
		var zinsInput = form.querySelector( '[data-fr-zins]' );
		var ergebnisRate = form.querySelector( '[data-fr-ergebnis-rate]' );
		var ergebnisGesamt = form.querySelector( '[data-fr-ergebnis-gesamt]' );
		var ergebnisKredit = form.querySelector( '[data-fr-ergebnis-kredit]' );

		function berechnen() {
			var preis = parseFloat( preisInput.value ) || 0;
			var anzahlung = parseFloat( anzahlungInput.value ) || 0;
			var laufzeit = parseInt( laufzeitInput.value, 10 ) || 0;
			var zins = parseFloat( zinsInput.value ) || 0;

			if ( anzahlung > preis ) {
				anzahlung = preis;
				anzahlungInput.value = preis;
			}

			var kreditbetrag = Math.max( preis - anzahlung, 0 );
			var monatsrate = berechneMonatsrate( kreditbetrag, zins, laufzeit );
			var gesamtbetrag = monatsrate * laufzeit + anzahlung;

			ergebnisKredit.textContent = formatEuro( kreditbetrag );
			ergebnisRate.textContent = formatEuro( monatsrate ) + ' / Monat';
			ergebnisGesamt.textContent = formatEuro( gesamtbetrag );
		}

		form.addEventListener( 'input', berechnen );
		berechnen();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
