define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom',
	'SQ/Model/ClassroomTeacher',
	'SQ/Screen/SchoolAdminEditClassroom/Views/EditClassroomForm',
	'SQ/Module/UploadImageForm',
	'SQ/Screen/SchoolAdminEditClassroom/Views/TeachersTab',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomModel,
	ClassroomTeacherModel,
	EditClassroomForm,
	UploadImageForm,
	TeachersTab,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditClassroomController(options) {
		var _me = this;
		var _util = new Util();
		var _classroom_id = options.classroom_id;
		var _teachers = options.teachers;
		var _selected_teacher_ids = options.selected_teacher_ids;
		var _primary_teacher_id = options.primary_teacher_id;

		var _classroomModel = new ClassroomModel();
		var _classroomTeacherModel = new ClassroomTeacherModel();
		var _editClassroomForm = new EditClassroomForm();
		var _uploadImageForm = new UploadImageForm();
		var _teachersTab = new TeachersTab(_teachers, _selected_teacher_ids);

		(function _init() {
			_editClassroomForm.initialize($('#edit-classroom-form'));
			_editClassroomForm.setListener('edit_classroom', _editClassroom);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

			_teachersTab.initialize($('#teachers'));
			_teachersTab.setListener('add_teacher', _addTeacher);
			_teachersTab.setListener('set_primary', _setPrimary);
			_teachersTab.setListener('remove_teacher', _removeTeacher);
		})();

		function _editClassroom(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.update(_classroom_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Classroom is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this classroom', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_classroomModel.update(_classroom_id, {photo_url: response.url_path}).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Classroom avatar is uploaded successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to upload classroom avatar', {header: 'Error'});
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

		function _addTeacher(data) {
			$('body').append(_.template(loadingTemplate));
			data.classroom_id = _classroom_id;
			_classroomTeacherModel.add(data).then(
				function(classroom_teacher_id) {
					if (classroom_teacher_id) {
						_classroomTeacherModel.get({id: classroom_teacher_id}, [], [], null, null, {teacher: true}).then(
							function(classroom_teachers) {
								$('body').find('.sq-loading-overlay').remove();
								if (classroom_teachers.length) {
									_selected_teacher_ids.push(parseInt(data.teacher_id));
									_teachersTab.setSelectedTeacherIds(_selected_teacher_ids);
									$.jGrowl('Teacher is added successfully', {header: 'Success'});
									_teachersTab.appendTeacher(classroom_teachers[0]);
								} else {
									$.jGrowl('Unable to add teacher to this class', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to add teacher to this class', {header: 'Error'});
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
						$.jGrowl('Teacher is set to primary successfully', {header: 'Success'});
						_teachersTab.displayAsPrimary(classroom_teacher_id);
					} else {
						$.jGrowl('Unable to set this teacher as primary', {header: 'Error'});
					}
				}
			);
		}

		function _removeTeacher(classroom_teacher_id) {
			$('body').append(_.template(loadingTemplate));
			_classroomTeacherModel.delete({id: classroom_teacher_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						var _index = _selected_teacher_ids.indexOf(parseInt(classroom_teacher_id));
						_selected_teacher_ids.splice(_index, 1);
						$.jGrowl('Teacher is set to primary successfully', {header: 'Success'});
						_teachersTab.setSelectedTeacherIds(_selected_teacher_ids);
						_teachersTab.removeTeacher(classroom_teacher_id);
					} else {
						$.jGrowl('Unable to set this teacher as primary', {header: 'Error'});
					}
				}
			);
		}

	}
});
