define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Model/Principal',
	'SQ/Model/School_admin',
	'SQ/Screen/AddSchool/Views/AddSchoolForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	SchoolModel,
	PrincipalModel,
	SchoolAdminModel,
	AddSchoolForm,
	Q
) {
	'use strict';

	return function AddSchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _schoolModel = new SchoolModel();
		var _principalModel = new PrincipalModel();
		var _schoolAdminModel = new SchoolAdminModel();
		var _addSchoolForm = new AddSchoolForm();

		(function _init(){
			_addSchoolForm.initialize($('.admin-main-content'));
			_addSchoolForm.setListener('add_school', _add_school);
			_addSchoolForm.setListener('add_principal', _add_principal);
			_addSchoolForm.setListener('add_school_admin', _add_school_admin);
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

		function _add_principal(data) {
			var school_id  = data[0];
			var form = data[1];
			_principalModel.addPrincipal(school_id, form.username, form.email, form.password, form.first_name, form.last_name).then(
				function(response) {
					if (response.success) {
						_addSchoolForm.displaySuccessPrincipal('Data successfully inserted');
					} else {
					}
				}
			);
		};

		function _add_school_admin(data) {
			var school_id = data[0];
			var form = data[1];
			_schoolAdminModel.addSchoolAdmin(school_id, form.username, form.email, form.password, form.first_name, form.last_name).then(
				function(response) {
					if (response.success) {
						_addSchoolForm.displaySuccessSchoolAdmin('Data successfully inserted');
					} else {
					}
				}
			);
		};
	}
});
