define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Model/SchoolAdminTeacherContact',
	'SQ/Screen/SchoolAdminTeachers/Views/TeachersTable',
	'SQ/Screen/SchoolAdminTeachers/Views/ContactFormModal',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	SchoolAdminTeacherContactModel,
	TeachersTable,
	ContactFormModal,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminTeachersController(options) {
		var _me = this;
		var _util = new Util();
		var _teacherModel = new TeacherModel();
		var _schoolAdminTeacherContactModel = new SchoolAdminTeacherContactModel();
		var _teachersTable = new TeachersTable();
		var _contactFormModal = new ContactFormModal();
		var _school_id = options.school_id;
		var _teacher_limit = parseInt(options.teacher_limit);
		var _school_admin_id = options.school_admin_id;
		var _contact_teacher_id = null;

		(function _init() {
			_teachersTable.initialize($('#teachers-table-container'));
			_teachersTable.setListener('open_contact_modal', _openContactModal);

			$('body').append(_.template(loadingTemplate));
			_teacherModel.get({school: _school_id}, [], [], null, null, {classroom_teacher: true}).then(
				function(teachers) {
					$('body').find('.sq-loading-overlay').remove();
					_teachersTable.populate(teachers);
				}
			);

			$('.add-teacher').on('click', function(e) {
				e.preventDefault();
				var _href = $(e.target).attr('href');
				$('body').append(_.template(loadingTemplate));
				_teacherModel.get({school: _school_id}, ['id']).then(
					function(teachers) {
						if (teachers.length < _teacher_limit) {
							window.location = _href;
						} else {
							$('body').find('.sq-loading-overlay').remove();
							$.jGrowl('You have exceeded the max number of teachers for this account.', {header: 'Error'});
						}
					}
				);
			});

			_contactFormModal.initialize($('#sq-contact-modal'));
			_contactFormModal.setListener('send_message', _sendMessage);
		})();

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
