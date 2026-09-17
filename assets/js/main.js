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
});
