'use strict';

if (!Element.prototype.matches) {
	Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
	Element.prototype.closest = function(s) {
		var el = this;

		do {
		if (el.matches(s)) return el;
		el = el.parentElement || el.parentNode;
		} while (el !== null && el.nodeType === 1);
		return null;
	};
}

// from:https://github.com/jserz/js_piece/blob/master/DOM/ChildNode/remove()/remove().md
(function (arr) {
	arr.forEach(function (item) {
		if (item.hasOwnProperty('remove')) {
		return;
		}
		Object.defineProperty(item, 'remove', {
		configurable: true,
		enumerable: true,
		writable: true,
		value: function remove() {
			if (this.parentNode !== null)
			this.parentNode.removeChild(this);
		}
		});
	});
})([Element.prototype, CharacterData.prototype, DocumentType.prototype]);