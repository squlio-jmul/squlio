define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom',
	'SQ/Model/ClassroomTeacher',
	'SQ/Model/Schedule',
	'SQ/Model/Student',
	'SQ/Model/SchoolAdminTeacherContact',
	'SQ/Screen/SchoolAdminEditClassroom/Views/EditClassroomForm',
	'SQ/Module/UploadImageForm',
	'SQ/Screen/SchoolAdminEditClassroom/Views/TeachersTab',
	'SQ/Screen/SchoolAdminEditClassroom/Views/StudentsTab',
	'SQ/Screen/SchoolAdminEditClassroom/Views/ScheduleTab',
	'SQ/Screen/SchoolAdminEditClassroom/Views/ContactFormModal',
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
	ScheduleModel,
	StudentModel,
	SchoolAdminTeacherContactModel,
	EditClassroomForm,
	UploadImageForm,
	TeachersTab,
	StudentsTab,
	ScheduleTab,
	ContactFormModal,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditClassroomController(options) {
		var _me = this;
		var _util = new Util();
		var _school_admin_id = options.school_admin_id;
		var _classroom_id = options.classroom_id;
		var _teachers = options.teachers;
		var _selected_teacher_ids = options.selected_teacher_ids;
		var _primary_teacher_id = options.primary_teacher_id;
		var _selected_student_ids = options.selected_student_ids;
		var _contact_teacher_id = null;

		var _classroomModel = new ClassroomModel();
		var _classroomTeacherModel = new ClassroomTeacherModel();
		var _scheduleModel = new ScheduleModel();
		var _studentModel = new StudentModel();
		var _schoolAdminTeacherContactModel = new SchoolAdminTeacherContactModel();

		var _editClassroomForm = new EditClassroomForm();
		var _uploadImageForm = new UploadImageForm();
		var _teachersTab = new TeachersTab(_teachers, _selected_teacher_ids);
		var _studentsTab = new StudentsTab(_selected_student_ids);
		var _scheduleTab = new ScheduleTab();
		var _contactFormModal = new ContactFormModal();

		(function _init() {
			_editClassroomForm.initialize($('#edit-classroom-form'));
			_editClassroomForm.setListener('edit_classroom', _editClassroom);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

			_teachersTab.initialize($('#teachers'));
			_teachersTab.setListener('add_teacher', _addTeacher);
			_teachersTab.setListener('set_primary', _setPrimary);
			_teachersTab.setListener('remove_teacher', _removeTeacher);
			_teachersTab.setListener('contact_teacher', _openContactModal);

			_scheduleTab.initialize($('#schedule'));
			_scheduleTab.setListener('add_schedule', _addSchedule);
			_scheduleTab.setListener('delete_schedule', _deleteSchedule);

			$('a[href="#schedule"]').on('shown.bs.tab', function (e) {
				if (options.has_term && options.has_subject) {
					_scheduleTab.viewTable();
					_repopulateScheduleTable();
				}
			})

			_studentsTab.initialize($('#students'));
			_studentsTab.setListener('add_student', _addStudent);
			_studentsTab.setListener('remove_student', _removeStudent);

			$('a[href="#students"]').on('shown.bs.tab', function (e) {
				if (options.has_student) {
					_studentsTab.viewTable();
					_repopulateStudentTable();
				}
			})

			_contactFormModal.initialize($('#sq-contact-modal'));
			_contactFormModal.setListener('send_message', _sendMessage);
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

		function _removeTeacher(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomTeacherModel.delete({id: data.classroom_teacher_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						var _index = _selected_teacher_ids.indexOf(parseInt(data.teacher_id));
						_selected_teacher_ids.splice(_index, 1);
						$.jGrowl('Teacher is removed successfully', {header: 'Success'});
						_teachersTab.setSelectedTeacherIds(_selected_teacher_ids);
						_teachersTab.removeTeacher(data.classroom_teacher_id);
					} else {
						$.jGrowl('Unable to remove this teacher', {header: 'Error'});
					}
				}
			);
		}

		function _addSchedule(data) {
			$('body').append(_.template(loadingTemplate));
			_scheduleModel.add(data).then(
				function(schedule_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (schedule_id) {
						$.jGrowl('Schedule is added successfully', {header: 'Success'});
						_scheduleTab.viewTable();
						_repopulateScheduleTable();
					} else {
						$.jGrowl('Unable to add schedule', {header: 'Error'});
					}
				}
			);
		}

		function _repopulateScheduleTable() {
			$('body').append(_.template(loadingTemplate));
			_scheduleTab.clearTable();
			_scheduleModel.get({classroom: _classroom_id}, {}, {date: 'asc'}, null, null, {term: true, subject: true}).then(
				function(schedules) {
					$('body').find('.sq-loading-overlay').remove();
					_scheduleTab.populate(schedules);
				}
			);
		}

		function _deleteSchedule(schedule_id) {
			$('body').append(_.template(loadingTemplate));
			_scheduleModel.delete({id: schedule_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Schedule is deleted successfully', {header: 'Success'});
						_repopulateScheduleTable();
					} else {
						$.jGrowl('Unable to delete schedule', {header: 'Error'});
					}
				}
			);
		}

		function _repopulateStudentTable() {
			$('body').append(_.template(loadingTemplate));
			_studentsTab.clearTable();
			_studentModel.get({classroom: _classroom_id, active: 1, deleted: 0}, {}, {first_name: 'asc', last_name: 'asc'}).then(
				function(students) {
					$('body').find('.sq-loading-overlay').remove();
					_studentsTab.populate(students);
				}
			);
		}

		function _addStudent(student_id) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.update(student_id, {classroom_id: _classroom_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						_selected_student_ids.push(parseInt(student_id));
						_studentsTab.setSelectedStudentIds(_selected_student_ids);

						$.jGrowl('Student is added successfully', {header: 'Success'});
						_studentsTab.viewTable();
						_repopulateStudentTable();
					} else {
						$.jGrowl('Unable to add student', {header: 'Error'});
					}
				}
			);
		}

		function _removeStudent(student_id) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.update(student_id, {classroom_id: null}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						var _index = _selected_student_ids.indexOf(parseInt(student_id));
						_selected_student_ids.splice(_index, 1);
						$.jGrowl('Student is removed successfully', {header: 'Success'});
						_studentsTab.setSelectedStudentIds(_selected_student_ids);
						_repopulateStudentTable();
					} else {
						$.jGrowl('Unable to remove this student', {header: 'Error'});
					}
				}
			);
		}

		function _openContactModal(data) {
			_contactFormModal.setTitle('Contact ' + data.teacher_name);
			_contact_teacher_id = data.teacher_id;
			_contactFormModal.show();
		}

		function _sendMessage(data) {
			$('body').append(_.template(loadingTemplate));
			var _add_data = {
				school_admin_id: _school_admin_id,
				teacher_id: _contact_teacher_id,
				direction: 'school_admin_to_teacher',
				title: data.title,
				message: data.message
			};
			_schoolAdminTeacherContactModel.add(_add_data).then(
				function(school_admin_teacher_contact_id){
					$('body').find('.sq-loading-overlay').remove();
					if (school_admin_teacher_contact_id) {
						$.jGrowl('Your message has been sent.', {header: 'Success'});
						_contactFormModal.hide();
					} else {
						$.jGrowl('Unable to contact this host.', {header: 'Error'});
					}
				}
			);
		}

	}
});
