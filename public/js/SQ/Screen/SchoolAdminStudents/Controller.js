define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Student',
	'SQ/Screen/SchoolAdminStudents/Views/StudentsTable',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	StudentModel,
	StudentsTable,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminStudentsController(options) {
		var _me = this;
		var _util = new Util();
		var _studentModel = new StudentModel();
		var _studentsTable = new StudentsTable();
		var _school_id = options.school_id;
		var _student_limit = parseInt(options.student_limit);

		(function _init() {
			_studentsTable.initialize($('#students-table-container'));
			$('body').append(_.template(loadingTemplate));
			_studentModel.get({school: _school_id}, [], [], null, null, {classroom_grade: true, classroom: true}).then(
				function(students) {
					$('body').find('.sq-loading-overlay').remove();
					_studentsTable.populate(students);
				}
			);

			$('.add-student').on('click', function(e) {
				e.preventDefault();
				var _href = $(e.target).attr('href');
				$('body').append(_.template(loadingTemplate));
				_studentModel.get({school: _school_id}, ['id']).then(
					function(students) {
						if (students.length < _student_limit) {
							window.location = _href;
						} else {
							$('body').find('.sq-loading-overlay').remove();
							$.jGrowl('You have exceeded the max number of students for this account.', {header: 'Error'});
						}
					}
				);
			});
		})();
	}
});
