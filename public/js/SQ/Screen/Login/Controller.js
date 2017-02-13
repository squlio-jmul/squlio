define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Login',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	LoginModel,
	Q
) {
	'use strict';

	return function LoginController(option) {
		var _me = this;
		var _util = new Util();
		var _loginModel = new LoginModel();

		(function _init() {
			$('#login-form').validate({
				rules: {
					'username': {
						required: true,
						remote: {
							url: '/ajax/school_admin/usernameExist',
							type: 'post'
						}
					},
					'password': {
						required: true
					}
				},
				messages: {
					'username': {
						remote: $.validator.format('Unable to find this username.')
					}
				},
				submitHandler: function(form) {
					var _login_data = _util.serializeJSON($(form));
					_doLogin(_login_data);
				}
			});
		})();

		function _doLogin(data) {
			$('.error-container').empty();
			_loginModel.verifyLogin(data.username, data.password).then(
				function(response) {
					if (response.success) {
						window.location = response.redirect_page;
					} else {
						$('.error-container').text('Invalid username and password');
					}
				}
			);
		}
	}
});
