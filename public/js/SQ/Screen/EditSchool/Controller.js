define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Screen/EditSchool/Views/EditSchoolForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	EditSchoolModel,
	EditSchoolForm,
	Q
) {
	'use strict';

	return function EditSchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _editSchoolModel = new EditSchoolModel();
		var _editSchoolForm = new EditSchoolForm();

		(function _init() {
			_editSchoolForm.initialize($('.admin-main-content'));
			_editSchoolForm.setListener('edit_school', _edit_school);
		})();

		function _edit_school(data) {
			_editSchoolModel.editSchool(data.id, data.name, data.email, data.phone_1, data.address_1, data.zipcode, data.city).then(
				function(response) {
					if (response.success) {
						_editSchoolForm.displaySuccess('Data successfully edited');
					} else {
						_editSchoolForm.displayError('data cannot be inserted');
					}
				}
			);
		};
	}
});
