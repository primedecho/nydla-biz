/**
 * NYDLA.biz — chrome + external links open in a new tab.
 */
(function () {
	'use strict';

	/* Mobile nav */
	(function initNav() {
		var toggle = document.querySelector('[data-biz-nav-toggle]');
		var nav = document.querySelector('[data-biz-nav]');
		if (!toggle || !nav) {
			return;
		}

		function setOpen(open) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			nav.classList.toggle('is-open', open);
		}

		toggle.addEventListener('click', function () {
			setOpen(toggle.getAttribute('aria-expanded') !== 'true');
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				setOpen(false);
			}
		});

		nav.addEventListener('click', function (event) {
			if (event.target.closest('a') && window.matchMedia('(max-width: 860px)').matches) {
				setOpen(false);
			}
		});
	})();

	/* External links → new tab (catch-all for content / late HTML) */
	(function blankExternals() {
		var host = window.location.hostname.replace(/^www\./i, '').toLowerCase();

		function isExternal(href) {
			if (!href || href.charAt(0) === '#') {
				return false;
			}
			if (/^(mailto:|tel:|sms:)/i.test(href)) {
				return true;
			}
			try {
				var url = new URL(href, window.location.origin);
				var h = url.hostname.replace(/^www\./i, '').toLowerCase();
				return h && h !== host;
			} catch (e) {
				return false;
			}
		}

		function apply(root) {
			(root || document).querySelectorAll('a[href]').forEach(function (a) {
				if (!isExternal(a.getAttribute('href'))) {
					return;
				}
				a.setAttribute('target', '_blank');
				var rel = (a.getAttribute('rel') || '').toLowerCase();
				if (rel.indexOf('noopener') === -1) {
					a.setAttribute('rel', (rel ? rel + ' ' : '') + 'noopener noreferrer');
				}
			});
		}

		apply(document);

		if (typeof MutationObserver !== 'undefined') {
			var obs = new MutationObserver(function (mutations) {
				mutations.forEach(function (m) {
					m.addedNodes.forEach(function (node) {
						if (node.nodeType !== 1) {
							return;
						}
						if (node.matches && node.matches('a[href]')) {
							apply(node.parentNode || document);
						} else if (node.querySelectorAll) {
							apply(node);
						}
					});
				});
			});
			obs.observe(document.documentElement, { childList: true, subtree: true });
		}
	})();
})();
