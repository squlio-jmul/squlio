define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Screen/ViewTeacher/Views/TeacherTable',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	TeacherTable,
	Q
) {
	'use strict';

	return function ViewTeacherController(option) {
		var _me = this;
		var _util = new Util();
		var _teacherTable = new TeacherTable();

		(function _init() {
			_teacherTable.initialize($('.school-admin-content-wrapper'));
		})();
	}
});
