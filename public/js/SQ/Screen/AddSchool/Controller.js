define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Model/Principal',
	'SQ/Model/School_admin',
	'SQ/Screen/AddSchool/Views/AddSchoolForm',
	'ThirdParty/q',
	'jgrowl',
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
	Q,
	jGrowl
) {
	'use strict';

	return function AddSchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _schoolModel = new SchoolModel();
		var _principalModel = new PrincipalModel();
		var _schoolAdminModel = new SchoolAdminModel();
		var _addSchoolForm = new AddSchoolForm();
		var _principal_data = [];
		var _school_admin_data = [];
		var _account_type_data = [];
		var school_id = null;
		var account_type_id = null;
		var num_principal = null;
		var num_school_admin = null;

		(function _init(){
			_addSchoolForm.initialize($('.admin-main-content'));
			_addSchoolForm.setListener('add_school', _add_school);
		})();

		function _add_school(data) {
			_schoolModel.addSchool(data.school.account_type, data.school.school_name, data.school.school_email, data.school.phone_1, data.school.address_1, data.school.zipcode, data.school.city).then(
				function(response) {
					if (response.success && response.school_id) {
						Q.all([_principalModel.addBulk(response.school_id, data.principals), _schoolAdminModel.addBulk(response.school_id, data.school_admins)]).done(
							function(responses) {
								var _principal_success = responses[0];
								var _school_admin_success = responses[1];
								if (_principal_success && _school_admin_success) {
									$.jGrowl('School is added successfully<br /><br /><a href="/admin/school">Click here to view your school</a>', {header: 'Success'});
									window.location.reload();
								} else {
									$.jGrowl('Unable to add school', {header: 'Error'});
								}
							}
						);
					} else {
						$.jGrowl('Unable to add school', {header: 'Error'});
					}
				}
			);
			console.log(data);
			return;
			/*
			var account_type_id = data[0];
			var form = data[1];
			var principal = data[2];
			var school_admin = data[3];
			_schoolModel.addSchool(account_type_id, form.school_name, form.school_email, form.phone_1, form.address_1, form.zipcode, form.city).then(
				function(response) {
					if (response.success) {
						school_id = response.school_id;
						console.log(school_id);
						account_type_id  = response.account_type_id;
						console.log(account_type_id);
						_account_type_data = response.account_type_data[0];
						console.log(_account_type_data);
						num_principal = _account_type_data[0];
						console.log(num_principal);
						num_school_admin = _account_type_data[1];
						console.log(num_school_admin);
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
			*/
		}
	}
});
