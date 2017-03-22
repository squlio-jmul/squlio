define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Model/Principal',
	'SQ/Model/School_admin',
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
	SchoolAdminModel,
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
		var _schoolAdminModel = new SchoolAdminModel();
		var _editSchoolForm = new EditSchoolForm();

		(function _init() {
			_editSchoolForm.initialize($('.admin-main-content'));
			_editSchoolForm.setListener('edit_school', _edit_school);
			_editSchoolForm.setListener('delete_principal', _delete_principal);
			_editSchoolForm.setListener('delete_school_admin', _delete_school_admin);
		})();

		function _edit_school(data) {
			console.log(data.account_type);
			_schoolModel.editSchool(data.account_type, data.school.id, data.school.name, data.school.email, data.school.phone_1, data.school.address_1,
				data.school.zipcode, data.school.city).then(
				function(response) {
					$.jGrowl('School is update successfully<br /><br /><a href="/admin/school">Click here to view your school</a>', {header: 'Success'});

					if (response.success && response.school_id) {
						Q.all([_principalModel.addBulk(response.school_id, data.principals), _schoolAdminModel.addBulk(response.school_id, data.school_admins)]).done(
							function(response) {
								var _principal_success = response[0];
								var _school_admin_success = response[1];
								if (_principal_success && _school_admin_success) {

									$.jGrowl('School is update successfully<br /><br /><a href="/admin/school">Click here to view your school</a>', {header: 'Success'});
								} else if (_principal_success) {
									$.jGrowl('School is update successfully<br /><br /><a href="/admin/school">Click here to view your school</a>', {header: 'Success'});
								} else if (_school_admin_success) {
									$.jGrowl('School is update successfully<br /><br /><a href="/admin/school">Click here to view your school</a>', {header: 'Success'});
								} else {
									$.jGrowl('Unable to update school', {header: 'Error'});
								}

							}
						);
					} else {
						$.jGrowl('Unable to update school', {header: 'Error'});
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
						$.jGrowl('Principal success deleted', {header: 'Success'});
					} else {
						$.jGrowl('Principal can not deleted', {header: 'Error'});
					}
				}
			);
		}

		function _delete_school_admin(login_id) {
			console.log(login_id);
			_schoolAdminModel.deleteSchoolAdmin(login_id).then(
				function(response) {
					if (response.success) {
						console.log('success');
						$.jGrowl('School admin success deleted', {header: 'Success'});
					} else {
						$.jGrowl('School admin can not deleted', {header: 'Error'});
					}
				}
			);
		}
	}
});
