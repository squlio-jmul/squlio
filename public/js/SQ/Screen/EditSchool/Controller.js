define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Model/Principal',
	'SQ/Screen/EditSchool/Views/EditSchoolForm',
	'ThirdParty/q',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	SchoolModel,
	PrincipalModel,
	EditSchoolForm,
	Q,
	jGrowl
) {
	'use strict';

	return function EditSchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _schoolModel = new SchoolModel();
		var _principalModel = new PrincipalModel();
		var _editSchoolForm = new EditSchoolForm();

		(function _init() {
			_editSchoolForm.initialize($('.admin-main-content'));
			_editSchoolForm.setListener('edit_school', _edit_school);
			_editSchoolForm.setListener('delete_principal', _delete_principal);
		})();

		function _edit_school(data) {
			var account_type = data[0];
			var school = data[1];
			console.log(school);
			_schoolModel.editSchool(account_type, school.id, school.name, school.email, school.phone_1, school.address_1, school.zipcode, school.city).then(
				function(response) {
					if (response.success) {
						$.jGrowl('School is update successfully<br /><br /><a href="/admin/school">Click here to view your school</a>', {header: 'Success'});
					} else {
						$.jGrowl('Unable to add school', {header: 'Error'});

					}
				}
			);
		};

		function _delete_principal(login_id) {
			console.log(login_id);
			_principalModel.deletePrincipal(login_id).then(
				function(response) {
					if (response.success) {
						console.log('success');
					} else {
						console.log('failed');
					}
				}
			);
		}
	}
});
