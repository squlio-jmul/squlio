define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Model/Login',
	'SQ/Model/ClassroomTeacher',
	'SQ/Screen/SchoolAdminEditTeacher/Views/EditTeacherForm',
	'SQ/Module/UploadImageForm',
	//'SQ/Screen/SchoolAdminEditTeacher/Views/ChangePasswordForm',
	'SQ/Screen/SchoolAdminEditTeacher/Views/ClassroomsTab',
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
	ClassroomTeacherModel,
	EditTeacherForm,
	UploadImageForm,
	//ChangePasswordForm,
	ClassroomsTab,
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
		var _classrooms = options.classrooms;
		var _selected_classroom_ids = options.selected_classroom_ids;

		var _teacherModel = new TeacherModel();
		var _loginModel = new LoginModel();
		var _classroomTeacherModel = new ClassroomTeacherModel();
		var _editTeacherForm = new EditTeacherForm();
		var _uploadImageForm = new UploadImageForm();
	//	var _changePasswordForm = new ChangePasswordForm();
		var _classroomsTab = new ClassroomsTab(_classrooms, _selected_classroom_ids);

		(function _init() {
			_editTeacherForm.initialize($('#edit-teacher-form'));
			_editTeacherForm.setListener('edit_teacher', _editTeacher);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

			//_changePasswordForm.initialize($('#password'));
			//_changePasswordForm.setListener('change_password', _changePassword);


			_classroomsTab.initialize($('#classrooms'));
			_classroomsTab.setListener('add_classroom', _addClassroom);
			_classroomsTab.setListener('set_primary', _setPrimary);
			_classroomsTab.setListener('remove_classroom', _removeClassroom);
		})();

		function _editTeacher(data) {
			$('body').append(_.template(loadingTemplate));
			_loginModel.update(data.login_id, {email:data.email, password: data.password}).then(
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

		function _addClassroom(data) {
			$('body').append(_.template(loadingTemplate));
			data.teacher_id = _teacher_id;
			_classroomTeacherModel.add(data).then(
				function(classroom_teacher_id) {
					if (classroom_teacher_id) {
						_classroomTeacherModel.get({id: classroom_teacher_id}, [], [], null, null, {teacher: true}).then(
							function(classroom_teachers) {
								$('body').find('.sq-loading-overlay').remove();
								if (classroom_teachers.length) {
									_selected_classroom_ids.push(parseInt(data.classroom_id));
									_classroomsTab.setSelectedClassroomIds(_selected_classroom_ids);
									$.jGrowl('Class is added successfully', {header: 'Success'});
									_classroomsTab.appendClassroom(classroom_teachers[0]);
								} else {
									$.jGrowl('Unable to add this class for this teacher', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to add this class for this teacher', {header: 'Error'});
					}
				}
			);
		}

		function _setPrimary(classroom_teacher_id) {
			$('body').append(_.template(loadingTemplate));
			_classroomTeacherModel.setPrimary(classroom_teacher_id).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Teacher is set as primary in this class successfully', {header: 'Success'});
						_classroomsTab.displayAsPrimary(classroom_teacher_id);
					} else {
						$.jGrowl('Unable to set this teacher as primary', {header: 'Error'});
					}
				}
			);
		}

		function _removeClassroom(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomTeacherModel.delete({id: data.classroom_teacher_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						var _index = _selected_classroom_ids.indexOf(parseInt(data.classroom_id));
						_selected_classroom_ids.splice(_index, 1);
						$.jGrowl('Class is removed successfully', {header: 'Success'});
						_classroomsTab.setSelectedClassroomIds(_selected_classroom_ids);
						_classroomsTab.removeClassroom(data.classroom_teacher_id);
					} else {
						$.jGrowl('Unable to remove this class', {header: 'Error'});
					}
				}
			);
		}



		/*
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
		*/
	}
});
