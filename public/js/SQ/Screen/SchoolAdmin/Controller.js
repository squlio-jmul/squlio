define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School_admin',
	'SQ/Screen/SchoolAdmin/Views/SchoolAdminForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	SchoolAdminModel,
	SchoolAdminForm,
	Q
) {
	'use strict';

	return function SchoolAdminController(option) {
		var _me = this;
		var _util = new Util();
		var _schoolAdminModel = new SchoolAdminModel();
		var _schoolAdminForm = new SchoolAdminForm();

		(function _init() {
			_schoolAdminForm.initialize($('#school-admin-container'));
			_schoolAdminForm.setListener('verify_login', _verifyLogin);
		})();

		function _verifyLogin(data) {
			_schoolAdminForm.clearError();
			_schoolAdminModel.verifyLogin(data.email, data.password).then(
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
