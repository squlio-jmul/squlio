define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Account_type',
	'SQ/Screen/AddAccountType/Views/AddAccountTypeForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	AddAccountTypeModel,
	AddAccountTypeForm,
	Q
) {
	'use strict';

	return function AddAccountTypeController(option) {
		var _me = this;
		var _util = new Util();
		var _addAccountTypeModel = new AddAccountTypeModel();
		var _addAccountTypeForm = new AddAccountTypeForm();

		(function _init() {
			_addAccountTypeForm.initialize($('.admin-main-content'));
			_addAccountTypeForm.setListener('add_type', _add_type);
		})();

		function _add_type(data) {
			_addAccountTypeModel.addAccountTypeData(data.name, data.display_name, data.num_principal, data.num_school_admin, data.num_teacher, data.num_classroom, data.num_guardian, data.num_student).then(
				function(response) {
					if (response.success) {
						_addAccountTypeForm.displaySuccess('Data successfully inserted');
					} else {
						_addAccountTypeForm.displayError('data cannot be inserted');
					}
				}
			);
		};
	}
});

