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

	return function SchoolAdminForm() {
		var _me = this;
		var _util = new Util();
		var _$school_admin_form = null;

		SQ.mixin(_me, new Broadcaster(['verify_login']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$school_admin_form = $e;
			_$school_admin_form.find('#school-admin-form').validate({
				rules: {
					'email': {
						required: true,
						remote: {
							url: '/ajax/login/emailExist',
							type: 'post'
						}
					},
					'password': {
						required: true
					}
				},
				messages: {
					'email': {
						remote: $.validator.format('Unable to find this email.')
					}
				},
				submitHandler: function(form) {
					var _login_data = _util.serializeJSON($(form));
					_me.broadcast('verify_login', _login_data);
				}
			});
			_$school_admin_form.find('#school-admin-forget-password').validate({
				rules: {
					'email': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _email = _util.serializeJSON($(form));
					_me.broadcast('verify_login', _email);
				}
			});
			_$school_admin_form.find("a.forget-password").click(function(){
				_$school_admin_form.find("#school-admin-form").removeClass("form-active");
				_$school_admin_form.find("#school-admin-forget-password").addClass("form-active");
			});
			_$school_admin_form.find("a.login-link").click(function(){
				_$school_admin_form.find("#school-admin-forget-password").removeClass("form-active");
				_$school_admin_form.find("#school-admin-form").addClass("form-active");
			});
		};

		this.clearError = function() {
			_$school_admin_form.find('.error-container').empty();
		};

		this.displayError = function(error_msg) {
			_$school_admin_form.find('.error-container').text(error_msg);
		};
	}
});
