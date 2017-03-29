define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Screen/ClassroomGrade/Views/ClassroomGradeTable',
	'ThirdParty/q',
	'ThirdParty/jquery.dataTables.min'
], function(
	$,
	SQ,
	Util,
	ClassroomGradeTable,
	Q
) {
	'use strict';

	return function SchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _classroomGradeTable = new ClassroomGradeTable();

		(function _init() {
			_classroomGradeTable.initialize($('.admin-content-wrapper'));
		})();
	}
});
