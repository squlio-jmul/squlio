define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Screen/ViewTeacher/Views/TeacherTable',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	TeacherTable,
	Q
) {
	'use strict';

	return function ViewTeacherController(option) {
		var _me = this;
		var _util = new Util();
		var _teacherModel = new TeacherModel();
		var _teacherTable = new TeacherTable();

		(function _init() {
			_teacherTable.initialize($('.school-admin-content-wrapper'));
			_teacherTable.setListener('school_id', _displayTable);

		})();

		function _displayTable(data) {
			_teacherModel.getTeacherData(data).then(
				function (response) {
					if (response.success) {
						_teacherTable.displayTable(response.teacher_data);
					} else {
					}
				}
			);
		}
	}
});
