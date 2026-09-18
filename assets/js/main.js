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

	// Hauptmenü: Untermenüs innerhalb des Overlays einzeln auf-/zuklappen.
	document.querySelectorAll('.submenu-toggle').forEach(function (toggle) {
		var submenu = toggle.closest('.menu-item').querySelector('.sub-menu');
		if (!submenu) {
			return;
		}
		toggle.addEventListener('click', function () {
			var isOpen = submenu.getAttribute('data-state') === 'open';
			submenu.setAttribute('data-state', isOpen ? 'closed' : 'open');
			toggle.setAttribute('aria-expanded', String(!isOpen));
		});
	});

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
