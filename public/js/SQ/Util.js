define(
	['Global/SQ', 'jquery'],
	function(SQ, $) {
		'use strict';

		return function Util() {

			var _init = function() {};
			var _me = this;

			_init();

			// Basic form-to-JSON converter, basic support for name="field[subfield]" form attributes
			this.serializeJSON = function($form) {
				var json = {};

				$.map($form.serializeArray(), function(n, i){
					if (n.name.indexOf('[') > -1) {
						var pieces = n.name.split('[');
						var obj = pieces[0];
						var propertyPieces = pieces[1].split(']');// trim off trailing ]
						var property = propertyPieces[0];
						var value = propertyPieces[1];

						json[obj] = json[obj] ? json[obj] : {};
						if (property) {
							json[obj][property] = n.value;
						} else {
							json[obj] = n.value;
						}
					} else {
						json[n['name']] = n['value'];
					}
				});

				return json;
			};
		}
	}
);
