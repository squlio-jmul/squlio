define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom_grade',
	'SQ/Screen/ClassroomGrade/Views/ClassroomGradeTable',
	'ThirdParty/q',
	'ThirdParty/jquery.dataTables.min',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomGradeModel,
	ClassroomGradeTable,
	Q,
	jGrowl
) {
	'use strict';

	return function ClassroomGradeController(option) {
		var _me = this;
		var _util = new Util();
		var _classroomGradeModel = new ClassroomGradeModel();
		var _classroomGradeTable = new ClassroomGradeTable();

		(function _init() {
			_classroomGradeTable.initialize($('.admin-content-wrapper'));
			_classroomGradeTable.setListener('school_id', _displayTable);
		})();

		function _displayTable(data) {
			_classroomGradeModel.getClassroomGradeData(data).then(
				function(response) {
					if (response.success) {
						_classroomGradeTable.displayTable(response.classroom_grade_data);
					} else {
						$.jGrowl('No data available', {header: 'Error'});
					}
				}
			);
		}
	}
});
