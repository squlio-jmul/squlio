define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Screen/ViewStudent/Views/StudentTable',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	StudentTable,
	Q
) {
	'use strict';

	return function ViewStudentController(option) {
		var _me = this;
		var _util = new Util();
		var _studentTable = new StudentTable();

		(function _init() {
			_studentTable.initialize($('.school-admin-content-wrapper'));
		})();
	}
});
