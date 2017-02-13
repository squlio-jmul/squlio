define(['jquery'], function($) {

	SQ = window.SQ || (function() {
		function namespace(str) {
			var object = this;
			var levels = str.split(".");

			for(var i = 0, l = levels.length; i < l; i++) {
				if(typeof object[levels[i]] == "undefined") {
					object[levels[i]] = {};
				}
				object = object[levels[i]];
			}

			return object;
		}

		return {
			namespace: namespace
		};
	})();

	SQ.mixin = function(a, b) {
		for (var i in b) {
			if (b.hasOwnProperty(i)) {
				a[i] = b[i];
			}
		}

		return a;
	};

	SQ.log = function(msg) {
		if (typeof console !== 'undefined' && console.log && SQ.debug) {
			console.log(msg);
		}
	};

	return SQ;
});
