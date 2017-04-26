define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/ClassroomGrade',
	'SQ/Screen/SchoolAdminClassroomGrades/Views/ClassroomGradesTable',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomGradeModel,
	ClassroomGradesTable,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminClassroomGradesController(options) {
		var _me = this;
		var _util = new Util();
		var _classroomGradeModel = new ClassroomGradeModel();
		var _classroomGradesTable = new ClassroomGradesTable();
		var _school_id = options.school_id;

		(function _init() {
			_classroomGradesTable.initialize($('#classroom-grades-table-container'));
			$('body').append(_.template(loadingTemplate));
			_classroomGradeModel.get({school: _school_id}, [], {name: 'asc'}).then(
				function(classroom_grades) {
					$('body').find('.sq-loading-overlay').remove();
					_classroomGradesTable.populate(classroom_grades);
				}
			);
		})();
	}
});
