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

	return function AdminForm() {
		var _me = this;
		var _util = new Util();
		var _$admin_form = null;

		SQ.mixin(_me, new Broadcaster(['verify_login']));

		(function _init() {
		}) ();

		this.initialize = function($e) {
			_$admin_form = $e;
			_$admin_form.validate({
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
			_$admin_form.find("a.forget-password").click(function(){
				_$admin_form.find("#admin-form").removeClass("form-active");
				_$admin_form.find("#admin-forget-password").addClass("form-active");
			});
			_$admin_form.find("a.login-link").click(function(){
				_$admin_form.find("#admin-forget-password").removeClass("form-active");
				_$admin_form.find("#admin-form").addClass("form-active");
			});
		};

		this.clearError = function() {
			_$admin_form.find('.error-container').empty();
		};

		this.displayError = function(error_msg) {
			_$admin_form.find('.error-container').empty();
		};
	}
});
