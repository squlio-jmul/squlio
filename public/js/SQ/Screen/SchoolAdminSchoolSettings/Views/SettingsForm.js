define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function SettingsForm() {

		var _me = this;
		var _util = new Util();
		var _$settings_form = null;

		SQ.mixin(_me, new Broadcaster(['update_school']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$settings_form = $e;
			_$settings_form.validate({
				rules: {
					'name': {
						required: true
					},
					'address_1': {
						required: true
					},
					'city': {
						required: true
					},
					'state': {
						required: true
					},
					'zipcode': {
						required: true,
						number: true
					},
					'email': {
						email: true
					},
					'phone_1': {
						required: true,
						number: true
					},
					'fax': {
						number: true
					},
					'url': {
						url: true
					}
				},
				submitHandler: function(form) {
					var _settings_data = _util.serializeJSON($(form));
					_me.broadcast('update_school', _settings_data);
				}
			});
		};
	}
});
