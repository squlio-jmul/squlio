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

	return function LoginForm() {

		var _me = this;
		var _util = new Util();
		var _$login_form = null;

		SQ.mixin(_me, new Broadcaster(['verify_login']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$login_form = $e;
			_$login_form.validate({
				rules: {
					'email': {
						required: true
					},
					'password': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _login_data = _util.serializeJSON($(form));
					_me.broadcast('verify_login', _login_data);
				}
			});
		};

		this.clearError = function() {
			_$login_form.find('.error-container').empty();
		};

		this.displayError = function(error_msg) {
			_$login_form.find('.error-container').text(error_msg);
		};
	}
});
