document.addEventListener('DOMContentLoaded', function () {
	var widget = document.querySelector('.chat-widget');
	if (!widget || typeof autoEmotionChat === 'undefined') {
		return;
	}

	var toggle = widget.querySelector('.chat-widget__toggle');
	var panel = widget.querySelector('.chat-widget__panel');
	var closeBtn = widget.querySelector('.chat-widget__close');
	var form = widget.querySelector('#chat-widget-form');
	var input = widget.querySelector('#chat-widget-input');
	var messages = widget.querySelector('#chat-widget-messages');
	var history = [];
	var isSending = false;

	function setOpen(isOpen) {
		widget.setAttribute('data-state', isOpen ? 'open' : 'closed');
		panel.setAttribute('data-state', isOpen ? 'open' : 'closed');
		toggle.setAttribute('aria-expanded', String(isOpen));
		if (isOpen) {
			input.focus();
		}
	}

	toggle.addEventListener('click', function () {
		var isOpen = widget.getAttribute('data-state') === 'open';
		setOpen(!isOpen);
	});

	closeBtn.addEventListener('click', function () {
		setOpen(false);
	});

	function addMessage(text, who) {
		var el = document.createElement('div');
		el.className = 'chat-widget__message chat-widget__message--' + who;
		el.textContent = text;
		messages.appendChild(el);
		messages.scrollTop = messages.scrollHeight;
		return el;
	}

	form.addEventListener('submit', function (event) {
		event.preventDefault();

		var text = input.value.trim();
		if (!text || isSending) {
			return;
		}

		addMessage(text, 'user');
		input.value = '';
		isSending = true;

		var pending = addMessage('…', 'bot');

		fetch(autoEmotionChat.endpoint, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ message: text, history: history }),
		})
			.then(function (response) {
				return response.json().then(function (data) {
					return { ok: response.ok, data: data };
				});
			})
			.then(function (result) {
				if (result.ok && result.data && result.data.reply) {
					pending.textContent = result.data.reply;
					history.push({ role: 'user', content: text });
					history.push({ role: 'assistant', content: result.data.reply });
				} else {
					pending.textContent = 'Da ist leider etwas schiefgelaufen. Bitte ruf uns direkt an.';
				}
			})
			.catch(function () {
				pending.textContent = 'Da ist leider etwas schiefgelaufen. Bitte ruf uns direkt an.';
			})
			.finally(function () {
				isSending = false;
				messages.scrollTop = messages.scrollHeight;
			});
	});
});
