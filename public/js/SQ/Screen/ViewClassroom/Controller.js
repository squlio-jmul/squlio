define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Screen/ViewClassroom/Views/ClassroomTable',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	ClassroomTable,
	Q
) {
	'use strict';

	return function ViewClassroomController(option) {
		var _me = this;
		var _util = new Util();
		var _classroomTable = new ClassroomTable();

		(function _init() {
			_classroomTable.initialize($('.school-admin-content-wrapper'));
		})();
	}
});
