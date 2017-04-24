define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Screen/SchoolAdminAddTeacher/Views/AddTeacherForm',
	'SQ/Module/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	AddTeacherForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAddTeacherController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _teacherModel = new TeacherModel();
		var _addTeacherForm = new AddTeacherForm();
		var _uploadImageForm = new UploadImageForm();
		var _photo_url = null;

		(function _init() {
			_addTeacherForm.initialize($('#add-teacher-form'));
			_addTeacherForm.setListener('add_teacher', _addTeacher);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);
		})();

		function _addTeacher(data) {
			data.photo_url = _photo_url;
			$('body').append(_.template(loadingTemplate));
			_teacherModel.add(data).then(
				function(teacher_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (teacher_id) {
						$.jGrowl('Teacher is added successfully', {header: 'Success'});
						window.location = '/school_admin/edit_teacher/' + teacher_id;
					} else {
						$.jGrowl('Unable to add this teacher', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_teacherModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_photo_url = response.url_path;
						$('body').find('.sq-loading-overlay').remove();
						_uploadImageForm.updateImage(response.url_path);
						$.jGrowl('Teacher avatar is uploaded successfully', {header: 'Success'});
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl(response.error_msg, {header: 'Error'});
					}
				}
			);
		}
	}
});
