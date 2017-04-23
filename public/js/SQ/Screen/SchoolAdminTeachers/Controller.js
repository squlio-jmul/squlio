define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Screen/SchoolAdminTeachers/Views/TeachersTable',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	TeachersTable,
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
		var _teachersTable = new TeachersTable();
		var _school_id = options.school_id;
		var _teacher_limit = parseInt(options.teacher_limit);

		(function _init() {
			_teachersTable.initialize($('#teachers-table-container'));
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
		})();
	}
});
