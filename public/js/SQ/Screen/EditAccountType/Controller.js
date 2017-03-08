define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Account_type',
	'SQ/Screen/EditAccountType/Views/EditAccountTypeForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	EditAccountTypeModel,
	EditAccountTypeForm,
	Q
) {
	'use strict';

	return function EditAccountTypeController(option) {
		var _me = this;
		var _util = new Util();
		var _editAccountTypeModel = new EditAccountTypeModel();
		var _editAccountTypeForm = new EditAccountTypeForm();

		(function _init() {
			_editAccountTypeForm.initialize($('.admin-main-content'));
			_editAccountTypeForm.setListener('edit_type', _edit_type);
		})();

		function _edit_type(data) {
		};
	}
});
