define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Login',
	'SQ/Screen/Login/Views/LoginForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	LoginModel,
	LoginForm,
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
			_loginModel.verifyLogin(data.username, data.password).then(
				function(response) {
					if (response.success) {
						window.location = response.redirect_page;
					} else {
						_loginForm.displayError('Invalid username and password.');
					}
				}
			);
		}
	}
});
