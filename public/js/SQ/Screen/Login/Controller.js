define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Login',
	'SQ/Screen/Login/Views/LoginForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	LoginModel,
	LoginForm,
	_,
	loadingTemplate,
	Q
) {
	'use strict';

	return function LoginController(option) {
		var _me = this;
		var _util = new Util();
		var _loginModel = new LoginModel();
		var _loginForm = new LoginForm();

		(function _init() {
			_loginForm.initialize($('#login-form'));
			_loginForm.setListener('verify_login', _verifyLogin);
		})();

		function _verifyLogin(data) {
			_loginForm.clearError();
			$('body').append(_.template(loadingTemplate));
			_loginModel.verifyLogin(data.email, data.password).then(
				function(response) {
					if (response.success) {
						window.location = response.redirect_page;
					} else {
						$('body').find('.sq-loading-overlay').remove();
						_loginForm.displayError('Invalid email and password.');
					}
				}
			);
		}
	}
});
