define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/classrooms_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	ClassroomsTableTemplate
) {
	'use strict';

	return function ClassroomsTable() {

		var _me = this;
		var _util = new Util();
		var _$classrooms_table = null;
		var _classrooms_table = null;

		SQ.mixin(_me, new Broadcaster());

		(function _init() {
		})();

		this.initialize = function($e) {
			_$classrooms_table = $e;
			_$classrooms_table.append(_.template(ClassroomsTableTemplate));
			_classrooms_table = _$classrooms_table.find('#classrooms-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(classrooms) {
			var _table_data = [];
			$.each(classrooms || [], function(index, classroom) {
				var _teachers = [];
				$.each(classroom.classroom_teacher || [], function(index, ct) {
					_teachers.push('<span class="' + ((ct.is_primary) ? 'is-primary':'') + '">' + ct.teacher_first_name + ' ' + ct.teacher_last_name + '</span>');
				});
				_table_data.push(
					[
						'<input type="checkbox" name="check-classroom[]" value="' + classroom.id + '" />',
						classroom.id,
						classroom.name,
						classroom.classroom_grade.name,
						_teachers.join(', '),
						_util.addCommas(classroom.student.length),
						(classroom.active) ? 'Active' : 'Inactive',
						'<a href="/school_admin/edit_classroom/' + classroom.id + '">Edit</a>'
					]
				);
			});
			_classrooms_table.rows.add(_table_data).draw();
		};
	}
});
