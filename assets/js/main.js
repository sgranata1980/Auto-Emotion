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
});
