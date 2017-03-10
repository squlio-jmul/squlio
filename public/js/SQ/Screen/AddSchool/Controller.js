define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Screen/AddSchool/Views/AddSchoolForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	SchoolModel,
	AddSchoolForm,
	Q
) {
	'use strict';

	return function AddSchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _schoolModel = new SchoolModel();
		var _addSchoolForm = new AddSchoolForm();

		(function _init(){
			_addSchoolForm.initialize($('#add-school-form'));
			_addSchoolForm.setListener('add_school', _add_school);
		})();

		function _add_school(data) {
			var account_type_id = data[0];
			var form = data[1];
			_schoolModel.addSchool(account_type_id, form.school_name, form.school_email, form.phone_1, form.address_1, form.zipcode, form.city).then(
				function(response) {
					if (response.success) {
						_addSchoolForm.displaySuccess('Data successfully inserted');
					} else {
					}
				}
			);
		};
	}
});
