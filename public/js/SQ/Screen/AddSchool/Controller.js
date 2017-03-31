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
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	SchoolModel,
	PrincipalModel,
	SchoolAdminModel,
	AddSchoolForm,
	Q,
	jgrowl
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
			_addSchoolForm.setListener('add_school', _addSchool);
		})();

		function _addSchool(data) {
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
			return;
		}
	}
});
