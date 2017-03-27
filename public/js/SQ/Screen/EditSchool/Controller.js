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
			_editSchoolForm.setListener('edit_school', _editSchool);
			_editSchoolForm.setListener('delete_principal', _deletePrincipal);
			_editSchoolForm.setListener('delete_principal_preview', _deletePrincipalPreview);
			_editSchoolForm.setListener('delete_school_admin_preview', _deleteSchoolAdminPreview);
			_editSchoolForm.setListener('delete_school_admin', _deleteSchoolAdmin);
			_editSchoolForm.setListener('add_principal', _addPrincipal);
			_editSchoolForm.setListener('add_school_admin', _addSchoolAdmin);
			_editSchoolForm.setListener('update_principal', _updatePrincipal);
			_editSchoolForm.setListener('update_school_admin', _updateSchoolAdmin);
		})();

		function _editSchool(data) {
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

		function _addPrincipal(data) {
			console.log(data);
			_principalModel.addPrincipal(data.school_id, data.username, data.email, data.password, data.first_name, data.last_name).then(
				function (response) {
					if (response.success) {
						var principal_data = [response.login_id, data, response.principal_id];
						console.log(principal_data);
						_editSchoolForm.displayAddSuccessPrincipal(principal_data);
						$.jGrowl('Principal successfully added', {header: 'Success'});
					} else {
						$.jGrowl('Principal could not be added', {header: 'Error'});
					}
				}
			);
		}

		function _addSchoolAdmin(data) {
			console.log(data);
			_schoolAdminModel.addSchoolAdmin(data.school_id, data.username, data.email, data.password, data.first_name, data.last_name).then(
				function (response) {
					if (response.success) {
						var school_admin_data = [response.login_id, data, response.school_admin_id];
						_editSchoolForm.displayAddSuccessSchoolAdmin(school_admin_data);
						$.jGrowl('School admin successfully added', {header: 'Success'});
					} else {
						$.jGrowl('School Admin could not be added', {header: 'Error'});
					}
				}
			);
		}

		function _updatePrincipal(data) {
			console.log(data);
			_principalModel.updatePrincipal(data.school_id, data.login_id, data.principal_id, data.username, data.email, data.first_name, data.last_name).then(
					function (response) {
					if (response) {
						console.log(data);
						console.log(data.login_id);
						_editSchoolForm.displayEditPrincipalSuccess(data);
						_editSchoolForm.displayEditPrincipalPreviewSuccess(data);
						$.jGrowl('Principal successfully updated', {header: 'Success'});
					} else {
						$.jGrowl('Principal could not be update', {header: 'Error'});
					}
				}
			);
		}

		function _updateSchoolAdmin(data) {
			console.log(data);
			_schoolAdminModel.updateSchoolAdmin(data.school_id, data.login_id, data.school_admin_id, data.username, data.email, data.first_name, data.last_name).then(
					function (response) {
					if (response) {
						console.log(data);
						console.log(data.login_id);
						_editSchoolForm.displayEditSchoolAdminSuccess(data);
						_editSchoolForm.displayEditSchoolAdminPreviewSuccess(data);
						$.jGrowl('School admin successfully updated', {header: 'Success'});
					} else {
						$.jGrowl('School admin could not be update', {header: 'Error'});
					}
				}
			);
		}


		function _deletePrincipal(login_id) {
			console.log(login_id);
			_principalModel.deletePrincipal(login_id).then(
				function(response) {
					if (response.success) {
						console.log('success');
						_editSchoolForm.deletePrincipal(login_id);
						$.jGrowl('Principal success deleted', {header: 'Success'});
					} else {
						$.jGrowl('Principal can not deleted', {header: 'Error'});
					}
				}
			);
		};

		function _deletePrincipalPreview(data) {
			console.log(data);
			var login_id = data[0];
			var username = data[1];
			_principalModel.deletePrincipal(login_id).then(
				function(response) {
					if(response.success) {
						console.log('success');
						_editSchoolForm.deletePrincipalPreview(data);
						$.jGrowl('Principal success deleted', {header: 'Success'});
					} else {
						$.jGrowl('Principal can not deleted', {header: 'Error'});
					}
				}
			);
		};

		function _deleteSchoolAdmin(login_id) {
			console.log(login_id);
			_schoolAdminModel.deleteSchoolAdmin(login_id).then(
				function(response) {
					if (response.success) {
						console.log('success');
						_editSchoolForm.deleteSchoolAdmin(login_id);
						$.jGrowl('School admin success deleted', {header: 'Success'});
					} else {
						$.jGrowl('School admin can not deleted', {header: 'Error'});
					}
				}
			);
		};

		function _deleteSchoolAdminPreview(data) {
			console.log(data);
			var login_id = data[0];
			var username = data[1];
			_schoolAdminModel.deleteSchoolAdmin(login_id).then(
				function(response) {
					if (response.success) {
						console.log('success');
						_editSchoolForm.deleteSchoolAdminPreview(data);
						$.jGrowl('School admin success deleted', {header: 'Success'});
					} else {
						$.jGrowl('School admin can not deleted', {header: 'Error'});
					}
				}
			);
		};
	}
});
