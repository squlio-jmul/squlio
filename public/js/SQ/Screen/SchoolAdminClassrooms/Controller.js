define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom',
	'SQ/Screen/SchoolAdminClassrooms/Views/ClassroomsTable',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomModel,
	ClassroomsTable,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminClassroomsController(options) {
		var _me = this;
		var _util = new Util();
		var _classroomModel = new ClassroomModel();
		var _classroomsTable = new ClassroomsTable();
		var _school_id = options.school_id;

		(function _init() {
			_classroomsTable.initialize($('#classrooms-table-container'));
			$('body').append(_.template(loadingTemplate));
			_classroomModel.get({school: _school_id}, {}, {}, null, null, {classroom_grade: true}).then(
				function(classrooms) {
					$('body').find('.sq-loading-overlay').remove();
					_classroomsTable.populate(classrooms);
				}
			);
		})();
	}
});
