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
		var _classroom_limit = parseInt(options.classroom_limit);

		(function _init() {
			_classroomsTable.initialize($('#classrooms-table-container'));
			$('body').append(_.template(loadingTemplate));
			_classroomModel.get({school: _school_id}, {}, {}, null, null, {classroom_grade: true, classroom_teacher: true, student: true}).then(
				function(classrooms) {
					$('body').find('.sq-loading-overlay').remove();
					_classroomsTable.populate(classrooms);
				}
			);

			$('.add-classroom').on('click', function(e) {
				e.preventDefault();
				var _href = $(e.target).attr('href');
				$('body').append(_.template(loadingTemplate));
				_classroomModel.get({school: _school_id}, ['id']).then(
					function(classrooms) {
						if (classrooms.length < _classroom_limit) {
							window.location = _href;
						} else {
							$('body').find('.sq-loading-overlay').remove();
							$.jGrowl('You have exceeded the max number of classrooms for this account.', {header: 'Error'});
						}
					}
				);
			});
		})();
	}
});
