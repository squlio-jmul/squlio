define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Account_type',
	'SQ/Screen/EditAccountType/Views/EditAccountTypeForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	EditAccountTypeModel,
	EditAccountTypeForm,
	Q,
	jGrowl
) {
	'use strict';

	return function EditAccountTypeController(option) {
		var _me = this;
		var _util = new Util();
		var _editAccountTypeModel = new EditAccountTypeModel();
		var _editAccountTypeForm = new EditAccountTypeForm();

		(function _init() {
			_editAccountTypeForm.initialize($('.admin-main-content'));
			_editAccountTypeForm.setListener('edit_type', _editType);
		})();

		function _editType(data) {
			console.log(data.num_guardian);
			_editAccountTypeModel.editType(data.id, data.name, data.display_name, data.num_principal, data.num_school_admin, data.num_teacher, data.num_classroom, data.num_guardian, data.num_student).then(
				function(response) {
					if (response.success) {
						$.jGrowl('Account type successfull updated<br /><br /><a href="/admin/settings">Click here to view your school</a>', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update account type', {header: 'Error'});
					}
				}
			);
		};
	}
});
