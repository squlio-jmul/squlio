define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Login',
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
		}) ();

		function _verifyLogin(data) {
		}
	}
});
