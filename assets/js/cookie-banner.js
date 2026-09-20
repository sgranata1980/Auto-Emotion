(function () {
	function getCookie(name) {
		var match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
		return match ? decodeURIComponent(match[1]) : null;
	}

	function setCookie(name, value, days) {
		var date = new Date();
		date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
		document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + date.toUTCString() + ';path=/;SameSite=Lax';
	}

	document.addEventListener('DOMContentLoaded', function () {
		var banner = document.getElementById('cookie-banner');
		if (!banner) {
			return;
		}

		if (getCookie('ae_consent')) {
			return;
		}

		banner.setAttribute('data-state', 'visible');

		var buttons = banner.querySelectorAll('[data-consent]');
		for (var i = 0; i < buttons.length; i++) {
			buttons[i].addEventListener('click', function (event) {
				var consent = event.currentTarget.getAttribute('data-consent');
				setCookie('ae_consent', consent, 180);
				banner.setAttribute('data-state', 'hidden');
				if (consent === 'all') {
					window.location.reload();
				}
			});
		}
	});
})();
