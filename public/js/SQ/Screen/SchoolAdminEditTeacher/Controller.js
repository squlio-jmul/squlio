define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Model/Login',
	'SQ/Screen/SchoolAdminEditTeacher/Views/EditTeacherForm',
	'SQ/Module/UploadImageForm',
	'SQ/Screen/SchoolAdminEditTeacher/Views/ChangePasswordForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	LoginModel,
	EditTeacherForm,
	UploadImageForm,
	ChangePasswordForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditTeacherController(options) {
		var _me = this;
		var _util = new Util();
		var _teacher_id = options.teacher_id;
		var _teacherModel = new TeacherModel();
		var _loginModel = new LoginModel();
		var _editTeacherForm = new EditTeacherForm();
		var _uploadImageForm = new UploadImageForm();
		var _changePasswordForm = new ChangePasswordForm();

		(function _init() {
			_editTeacherForm.initialize($('#edit-teacher-form'));
			_editTeacherForm.setListener('edit_teacher', _editTeacher);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

			_changePasswordForm.initialize($('#password'));
			_changePasswordForm.setListener('change_password', _changePassword);
		})();

		function _editTeacher(data) {
			$('body').append(_.template(loadingTemplate));
			_loginModel.update(data.login_id, {username: data.username, email:data.email}).then(
				function(success) {
					if (success) {
						_teacherModel.update(_teacher_id, data).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									$.jGrowl('Teacher is updated successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to update this teacher', {header: 'Error'});
								}
							}
						);
					} else {
						$.jGrowl('Unable to update this teacher', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_teacherModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_teacherModel.update(_teacher_id, {photo_url: response.url_path}).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Teacher avatar is uploaded successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to upload teacher avatar', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl(response.error_msg, {header: 'Error'});
					}
				}
			);
		}


		function _changePassword(data){
			$('body').append(_.template(loadingTemplate));
			_loginModel.update(data.login_id, {password: data.password}).then(
				function(success){
					$('body').find('.sq-loading-overlay').remove();
					$.jGrowl('Your password has been updated.', {header: 'Success'});
					_changePasswordForm.reset();
				}
			);
		}
	}
});
