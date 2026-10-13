/**
 * Traumauto-Finder: 2-Klick-Quiz, danach ein einziger API-Call ans
 * Backend (inc/traumauto-finder.php), das die KI-Auswahl ausschließlich
 * aus dem echten Fahrzeugbestand trifft. Ergebnis-Karten werden per
 * DOM-APIs (createElement/textContent) gebaut statt per innerHTML-String,
 * damit Titel/Marke/Grund nie als HTML interpretiert werden.
 */
(function () {
	'use strict';

	var root = document.getElementById( 'traumauto-finder' );
	if ( ! root || typeof window.autoEmotionTraumauto === 'undefined' ) {
		return;
	}

	var panels = {
		1: root.querySelector( '[data-panel="1"]' ),
		2: root.querySelector( '[data-panel="2"]' ),
		3: root.querySelector( '[data-panel="3"]' ),
	};
	var dots = root.querySelectorAll( '.traumauto-finder__dot' );
	var loadingEl = root.querySelector( '[data-loading]' );
	var resultsEl = root.querySelector( '[data-results]' );
	var noticeEl = root.querySelector( '[data-notice]' );
	var errorEl = root.querySelector( '[data-error]' );
	var backBtn = root.querySelector( '.traumauto-finder__back' );
	var restartBtn = root.querySelector( '.traumauto-finder__restart' );

	var state = { usage: null, priority: null };

	function showPanel( step ) {
		Object.keys( panels ).forEach( function ( key ) {
			panels[ key ].hidden = Number( key ) !== step;
		} );
		dots.forEach( function ( dot ) {
			dot.classList.toggle( 'is-active', Number( dot.getAttribute( 'data-dot' ) ) <= step );
		} );
	}

	function resetResultState() {
		loadingEl.hidden = false;
		resultsEl.hidden = true;
		resultsEl.innerHTML = '';
		noticeEl.hidden = true;
		noticeEl.textContent = '';
		errorEl.hidden = true;
	}

	function buildResultCard( match ) {
		var card = document.createElement( 'a' );
		card.className = 'traumauto-finder__card';
		card.href = match.link;

		if ( match.bild ) {
			var img = document.createElement( 'img' );
			img.className = 'traumauto-finder__card-image';
			img.src = match.bild;
			img.alt = '';
			img.loading = 'lazy';
			card.appendChild( img );
		}

		var body = document.createElement( 'div' );
		body.className = 'traumauto-finder__card-body';

		if ( match.marke ) {
			var brand = document.createElement( 'span' );
			brand.className = 'traumauto-finder__card-brand';
			brand.textContent = match.marke;
			body.appendChild( brand );
		}

		var title = document.createElement( 'span' );
		title.className = 'traumauto-finder__card-title';
		title.textContent = match.titel;
		body.appendChild( title );

		if ( match.grund ) {
			var reason = document.createElement( 'span' );
			reason.className = 'traumauto-finder__card-reason';
			reason.textContent = match.grund;
			body.appendChild( reason );
		}

		card.appendChild( body );
		return card;
	}

	function runMatch() {
		showPanel( 3 );
		resetResultState();

		fetch( window.autoEmotionTraumauto.endpoint, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify( { usage: state.usage, priority: state.priority } ),
		} )
			.then( function ( res ) {
				if ( ! res.ok ) {
					throw new Error( 'upstream' );
				}
				return res.json();
			} )
			.then( function ( data ) {
				loadingEl.hidden = true;

				if ( data.matches && data.matches.length > 0 ) {
					data.matches.forEach( function ( match ) {
						resultsEl.appendChild( buildResultCard( match ) );
					} );
					resultsEl.hidden = false;
				} else if ( data.notice ) {
					noticeEl.textContent = data.notice;
					noticeEl.hidden = false;
				}
			} )
			.catch( function () {
				loadingEl.hidden = true;
				errorEl.hidden = false;
			} );
	}

	root.addEventListener( 'click', function ( event ) {
		var option = event.target.closest( '.traumauto-finder__option' );
		if ( option ) {
			var group = option.closest( '[data-group]' ).getAttribute( 'data-group' );
			if ( 'usage' === group ) {
				state.usage = option.getAttribute( 'data-value' );
				showPanel( 2 );
			} else if ( 'priority' === group ) {
				state.priority = option.getAttribute( 'data-value' );
				runMatch();
			}
			return;
		}

		if ( event.target.closest( '.traumauto-finder__back' ) ) {
			showPanel( 1 );
			return;
		}

		if ( event.target.closest( '.traumauto-finder__restart' ) ) {
			state = { usage: null, priority: null };
			showPanel( 1 );
		}
	} );
} )();
