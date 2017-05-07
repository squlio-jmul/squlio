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

			this.addCommas = function(number, decimals, dec_point, thousands_sep) {
				number = (number ? number : 0);
				number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
					prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
					sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
					dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
					s = '',
					toFixedFix = function (n, prec) {
						var k = Math.pow(10, prec);
						return '' + Math.round(n * k) / k;
					};
				// Fix for IE parseFloat(0.55).toFixed(0) = 0;
				s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
				if (s[0].length > 3) {
					s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
				}
				if ((s[1] || '').length < prec) {
					s[1] = s[1] || '';
					s[1] += new Array(prec - s[1].length + 1).join('0');
				}
				return s.join(dec);
			};

			this.ucfirst = function (string) {
				return string.charAt(0).toUpperCase() + string.slice(1);
			};

			this.utcToLocal = function (utc_date_string) {
				var _utc = new Date(utc_date_string);
				var _local = new Date(Date.UTC(
					_utc.getFullYear(),
					_utc.getMonth(),
					_utc.getDate(),
					_utc.getHours(),
					_utc.getMinutes(),
					_utc.getMilliseconds()
				));
				return (((_local.getMonth() + 1) < 10) ? '0' : '' ) + (_local.getMonth() + 1) + '/' +
					((_local.getDate() < 10) ? '0' : '' ) + (_local.getDate()) + '/' +
					_local.getFullYear() + ' ' +
					((_local.getHours() < 10) ? '0' : '' ) + (_local.getHours()) + ':' +
					((_local.getMinutes() < 10) ? '0' : '' ) + (_local.getMinutes());
			};

			this.localToUtc = function (local_date_string) {
				var _local = new Date(local_date_string);
				return (((_local.getUTCMonth() + 1) < 10) ? '0' : '' ) + (_local.getUTCMonth() + 1) + '/' +
					((_local.getUTCDate() < 10) ? '0' : '' ) + (_local.getUTCDate()) + '/' +
					_local.getUTCFullYear() + ' ' +
					((_local.getUTCHours() < 10) ? '0' : '' ) + (_local.getUTCHours()) + ':' +
					((_local.getUTCMinutes() < 10) ? '0' : '' ) + (_local.getUTCMinutes());
			};
		}
	}
);
