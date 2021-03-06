define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Student',
	'SQ/Model/Classroom',
	'SQ/Screen/SchoolAdminAddStudent/Views/AddStudentForm',
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
	AddStudentForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAddStudentController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _studentModel = new StudentModel();
		var _classroomModel = new ClassroomModel();
		var _addStudentForm = new AddStudentForm();
		var _uploadImageForm = new UploadImageForm();
		var _photo_url = null;

		(function _init() {
			_addStudentForm.initialize($('#add-student-form'));
			_addStudentForm.setListener('get_classroom', _getClassroom);
			_addStudentForm.setListener('add_student', _addStudent);

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
					_addStudentForm.populateClassroom(classrooms);
				}
			)
		}

		function _addStudent(data) {
			data.photo_url = _photo_url;
			data.deleted = 0;
			$('body').append(_.template(loadingTemplate));
			_studentModel.add(data).then(
				function(student_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (student_id) {
						$.jGrowl('Student is added successfully', {header: 'Success'});
						window.location = '/school_admin/edit_student/' + student_id;
					} else {
						$.jGrowl('Unable to add this student', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_photo_url = response.url_path;
						$('body').find('.sq-loading-overlay').remove();
						_uploadImageForm.updateImage(response.url_path);
						$.jGrowl('Student avatar is uploaded successfully', {header: 'Success'});
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl(response.error_msg, {header: 'Error'});
					}
				}
			);
		}
	}
});
