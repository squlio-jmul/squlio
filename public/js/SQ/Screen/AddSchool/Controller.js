define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Model/Principal',
	'SQ/Model/School_admin',
	'SQ/Screen/AddSchool/Views/AddSchoolForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui'
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
		var school_id = null;
		var _principal_data = [];
		var _school_admin_data = [];

		(function _init(){
			_addSchoolForm.initialize($('.admin-main-content'));
			_addSchoolForm.setListener('add_school', _add_school);
			_addSchoolForm.setListener('add_principal', _add_principal);
			_addSchoolForm.setListener('add_school_admin', _add_school_admin);
		})();

		function _add_school(data) {
			var account_type_id = data[0];
			var form = data[1];
			var principal = data[2];
			var school_admin = data[3];
			console.log(account_type_id);
			console.log(form);
			console.log(principal);
			_schoolModel.addSchool(account_type_id, form.school_name, form.school_email, form.phone_1, form.address_1, form.zipcode, form.city).then(
				function(response) {
					if (response.school_id) {
						school_id = response.school_id;
						console.log(school_id);
						Q.all([_principalModel.addPrincipal(school_id, principal.username, principal.email, principal.password, principal.first_name,
							principal.last_name), _schoolAdminModel.addSchoolAdmin(school_id, school_admin.username, school_admin.email, school_admin.password, 
							school_admin.first_name, school_admin.last_name)]).done (
								function(response) {
									console.log('success');
									_addSchoolForm.displaySuccess('Data successfully inserted');
								}
							);
					} else {
						_addSchoolForm.displayError('Fail to insert data');
					}
				}
			);
		}

		function _add_principal(data) {
			_principal_data.push(data);
			var _get_school_id = school_id;
			var principal = _principal_data[0];
			console.log(principal);
			console.log(_get_school_id);
			_principalModel.addPrincipal(_get_school_id, principal.username, principal.email, principal.password, principal.first_name, principal.last_name).then(
				function(response) {
					if (response.success) {
						console.log('add new principal data success');
						_addSchoolForm.displaySuccessPrincipal('New principal data successfully added');
						_principal_data.pop(data);
					} else {
					}
				}
			);
		}

		function _add_school_admin(data) {
			_school_admin_data.push(data);
			var _get_school_id = school_id;
			var school_admin = _school_admin_data[0];
			console.log(school_admin);
			console.log(_get_school_id);
			_schoolAdminModel.addSchoolAdmin(_get_school_id, school_admin.username, school_admin.email, school_admin.password, school_admin.first_name, 
				school_admin.last_name).then(
				function(response) {
					if (response.success) {
						console.log('add new school admin data success');
						_addSchoolForm.displaySuccessSchoolAdmin('New school admin data successfully added');
						_school_admin_data.pop(data);
					} else {
					}
				}
			);
		}
	}
});
