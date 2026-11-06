document.addEventListener('DOMContentLoaded', function () {
	function bindToggle(buttonSelector, panelSelector) {
		var button = document.querySelector(buttonSelector);
		var panel = document.querySelector(panelSelector);

		if (!button || !panel) {
			return;
		}

		button.addEventListener('click', function () {
			var isOpen = panel.getAttribute('data-state') === 'open';
			panel.setAttribute('data-state', isOpen ? 'closed' : 'open');
			button.setAttribute('aria-expanded', String(!isOpen));
		});
	}

	bindToggle('.nav-toggle', '#site-navigation');
	bindToggle('.search-toggle', '#header-search');

	// "AI-Assistent" im Hauptmenü und jeder weitere Button mit der Klasse
	// .js-open-chat (z.B. die Quick-Action-Kachel auf der Neuwagen-Seite)
	// verlinken auf keine eigene Seite, sondern öffnen direkt das
	// bestehende Chat-Widget (Emo). querySelectorAll statt querySelector,
	// damit mehrere solcher Buttons auf einer Seite funktionieren.
	var aiChatTriggers = document.querySelectorAll( '.main-navigation__ai-trigger, .js-open-chat' );
	var chatToggle = document.querySelector( '.chat-widget__toggle' );
	if ( aiChatTriggers.length && chatToggle ) {
		aiChatTriggers.forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function () {
				var nav = document.getElementById( 'site-navigation' );
				var navToggleBtn = document.querySelector( '.nav-toggle' );
				if ( nav && nav.getAttribute( 'data-state' ) === 'open' ) {
					nav.setAttribute( 'data-state', 'closed' );
					if ( navToggleBtn ) {
						navToggleBtn.setAttribute( 'aria-expanded', 'false' );
					}
				}
				chatToggle.click();
			} );
		} );
	}

	// Hauptmenü: Untermenüs innerhalb des Overlays auf-/zuklappen - immer
	// nur eines gleichzeitig offen (wie Tabs), statt mehrere Panels
	// übereinander stehen zu lassen. Ohne das ließ sich z.B. "Fahrzeuge"
	// UND "Marken" gleichzeitig aufklappen, was als unübersichtliche
	// Textwand wirkte statt eines klaren, nachvollziehbaren Panels.
	var allToggles = Array.prototype.slice.call( document.querySelectorAll( '.submenu-toggle' ) );
	var togglePairs = allToggles.map( function ( toggle ) {
		return { toggle: toggle, submenu: toggle.closest( '.menu-item' ).querySelector( '.sub-menu' ) };
	} ).filter( function ( pair ) {
		return !! pair.submenu;
	} );

	togglePairs.forEach( function ( pair ) {
		pair.toggle.addEventListener( 'click', function () {
			var isOpen = pair.submenu.getAttribute( 'data-state' ) === 'open';

			togglePairs.forEach( function ( other ) {
				if ( other === pair ) {
					return;
				}
				other.submenu.setAttribute( 'data-state', 'closed' );
				other.toggle.setAttribute( 'aria-expanded', 'false' );
			} );

			pair.submenu.setAttribute( 'data-state', isOpen ? 'closed' : 'open' );
			pair.toggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
		} );
	} );

	/**
	 * Das geöffnete Untermenü-Panel hängt (siehe CSS) bewusst per
	 * position:fixed unter der Topbar, damit es unabhängig vom
	 * auslösenden Menüpunkt die volle Breite bekommt. Scrollt man die
	 * Seite dabei weiter - besonders auf Unterseiten, wo der Header
	 * selbst NICHT fixiert ist und mit wegscrollt -, blieb das Panel
	 * bisher freischwebend an seiner alten Position stehen, ohne noch
	 * zur Topbar zu gehören. Schließt sich daher automatisch beim
	 * Scrollen, wie bei den meisten Mega-Menüs üblich.
	 */
	var closeAllSubmenus = function () {
		togglePairs.forEach( function ( pair ) {
			pair.submenu.setAttribute( 'data-state', 'closed' );
			pair.toggle.setAttribute( 'aria-expanded', 'false' );
		} );
	};

	if ( togglePairs.length ) {
		window.addEventListener( 'scroll', function () {
			var hasOpenSubmenu = togglePairs.some( function ( pair ) {
				return pair.submenu.getAttribute( 'data-state' ) === 'open';
			} );
			if ( hasOpenSubmenu ) {
				closeAllSubmenus();
			}
		}, { passive: true } );
	}

	// Header: transparenter Verlauf über dem Hero, fest sobald gescrollt wird.
	var header = document.querySelector('.site-header');
	if (header && document.body.classList.contains('has-transparent-header')) {
		var threshold = 40;

		var updateHeaderState = function () {
			if (window.scrollY > threshold) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		};

		updateHeaderState();
		window.addEventListener('scroll', updateHeaderState, { passive: true });
	}

	// Fahrzeug-Filter (Angebote-Archiv): Auswahl einer Kachel filtert
	// sofort, ohne dass extra auf "Filtern" geklickt werden muss - für
	// ein unmittelbareres, direkteres Gefühl statt eines zusätzlichen
	// Zwischenschritts. Der Button bleibt als Fallback bestehen, falls
	// JavaScript nicht verfügbar ist.
	var vehicleFilterForm = document.querySelector( '.vehicle-filter__form' );
	if ( vehicleFilterForm ) {
		vehicleFilterForm.addEventListener( 'change', function ( event ) {
			if ( event.target && ( event.target.type === 'checkbox' || event.target.type === 'radio' ) ) {
				vehicleFilterForm.submit();
			}
		} );
	}

	// Model Showcase: Dots wechseln die sichtbare Marken-Slide.
	var showcase = document.querySelector('.model-showcase');
	if (showcase) {
		var slides = showcase.querySelectorAll('.model-showcase__slide');
		var dots = showcase.querySelectorAll('.model-showcase__dot');

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				var target = dot.getAttribute('data-slide-target');

				slides.forEach(function (slide) {
					slide.hidden = slide.getAttribute('data-slide') !== target;
				});
				dots.forEach(function (d) {
					d.setAttribute('aria-current', String(d === dot));
				});
			});
		});
	}
});
