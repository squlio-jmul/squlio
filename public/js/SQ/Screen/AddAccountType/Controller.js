define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Account_type',
	'SQ/Screen/AddAccountType/Views/AddAccountTypeForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'jgrowl',
], function(
	$,
	SQ,
	Util,
	AddAccountTypeModel,
	AddAccountTypeForm,
	Q,
	jGrowl
) {
	'use strict';

	return function AddAccountTypeController(option) {
		var _me = this;
		var _util = new Util();
		var _addAccountTypeModel = new AddAccountTypeModel();
		var _addAccountTypeForm = new AddAccountTypeForm();

		(function _init() {
			_addAccountTypeForm.initialize($('.admin-main-content'));
			_addAccountTypeForm.setListener('add_type', _addType);
		})();

		function _addType(data) {
			_addAccountTypeModel.addAccountTypeData(data.name, data.display_name, data.num_principal, data.num_school_admin, data.num_teacher, data.num_classroom, data.num_guardian, data.num_student).then(
				function(response) {
					if (response.success) {
						$.jGrowl('Account type is added successfully<br /><br /><a href="/admin/settings">Click here to view your account type</a>', {header: 'Success'});
					} else {
						$.jGrowl('Unable to add account type', {header: 'Error'});
					}
				}
			);
		};
	}
});

