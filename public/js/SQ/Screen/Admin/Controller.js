define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Admin',
	'SQ/Screen/Admin/Views/AdminForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	AdminModel,
	AdminForm,
	Q
) {
	'use strict';

	return function AdminController(option) {
		var _me = this;
		var _util = new Util();
		var _adminModel = new AdminModel();
		var _adminForm = new AdminForm();

		(function _init() {
			_adminForm.initialize($('#admin-container'));
			_adminForm.setListener('verify_login', _verifyLogin);
		})();

		function _verifyLogin(data) {
			_adminForm.clearError();
			_adminModel.verifyLogin(data.email, data.password).then(
				function(response) {
					if (response.success) {
						window.location = response.redirect_page;
					} else {
						_adminForm.displayError('Ivalid email and password.');
					}
				}
			);
		}
	}
});
