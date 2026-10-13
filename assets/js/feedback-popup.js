document.addEventListener( 'DOMContentLoaded', function () {
	var popup = document.getElementById( 'feedback-popup' );

	if ( ! popup ) {
		return;
	}

	var STORAGE_KEY = 'ae_feedback_dismissed_until';
	var DELAY_MS = 25000;
	var SNOOZE_DAYS = 30;

	var hasQueryStatus = /[?&]feedback=/.test( window.location.search );

	var isSnoozed = function () {
		try {
			var until = window.localStorage.getItem( STORAGE_KEY );
			return until && Date.now() < parseInt( until, 10 );
		} catch ( e ) {
			return false;
		}
	};

	var snooze = function () {
		try {
			window.localStorage.setItem( STORAGE_KEY, String( Date.now() + SNOOZE_DAYS * 24 * 60 * 60 * 1000 ) );
		} catch ( e ) {
			// Private Browsing o.ä. - Popup erscheint dann beim nächsten Besuch erneut, kein Problem.
		}
	};

	var open = function () {
		popup.setAttribute( 'data-state', 'open' );
	};

	var close = function () {
		popup.setAttribute( 'data-state', 'hidden' );
	};

	var seitenFeld = popup.querySelector( 'input[name="feedback_seite"]' );
	if ( seitenFeld ) {
		seitenFeld.value = window.location.href;
	}

	var closeBtn = popup.querySelector( '.feedback-popup__close' );
	if ( closeBtn ) {
		closeBtn.addEventListener( 'click', function () {
			close();
			snooze();
		} );
	}

	var dismissBtn = popup.querySelector( '.feedback-popup__dismiss' );
	if ( dismissBtn ) {
		dismissBtn.addEventListener( 'click', function () {
			close();
			snooze();
		} );
	}

	if ( hasQueryStatus ) {
		// Formular wurde gerade abgeschickt (Danke-/Fehlermeldung) - Popup sofort zeigen, nicht erneut verzögern.
		open();
		return;
	}

	if ( isSnoozed() ) {
		return;
	}

	window.setTimeout( open, DELAY_MS );
} );
