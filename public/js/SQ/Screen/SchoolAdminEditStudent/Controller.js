define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Student',
	'SQ/Model/Classroom',
	'SQ/Model/Login',
	'SQ/Screen/SchoolAdminEditStudent/Views/EditStudentForm',
	'SQ/Module/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	StudentModel,
	ClassroomModel,
	LoginModel,
	EditStudentForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditStudentController(options) {
		var _me = this;
		var _util = new Util();
		var _student_id = options.student_id;
		var _school_id = options.school_id;
		var _studentModel = new StudentModel();
		var _classroomModel = new ClassroomModel();
		var _loginModel = new LoginModel();
		var _editStudentForm = new EditStudentForm();
		var _uploadImageForm = new UploadImageForm();

		(function _init() {
			_editStudentForm.initialize($('#edit-student-form'));
			_editStudentForm.setListener('get_classroom', _getClassroom);
			_editStudentForm.setListener('edit_student', _editStudent);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);
		})();

		function _getClassroom(classroom_grade_id) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.get({school: _school_id, classroom_grade: classroom_grade_id, active: 1, deleted: 0}, [], {name: 'asc'}).then(
				function(classrooms) {
					$('body').find('.sq-loading-overlay').remove();
					if (!classrooms) {
						$.jGrowl('Currently there is no class available for this grade', {header: 'Error'});
					}
					_editStudentForm.populateClassroom(classrooms);
				}
			)
		}

		function _editStudent(data) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.update(_student_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Student is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this student', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_studentModel.update(_student_id, {photo_url: response.url_path}).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Student avatar is uploaded successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to upload student avatar', {header: 'Error'});
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
	}
});
