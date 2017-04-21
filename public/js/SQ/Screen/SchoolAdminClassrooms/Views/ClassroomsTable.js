define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'text!./template/classrooms_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	ClassroomsTableTemplate
) {
	'use strict';

	return function ClassroomsTable() {

		var _me = this;
		var _util = new Util();
		var _$classrooms_table = null;
		var _classrooms_table = null;

		SQ.mixin(_me, new Broadcaster(['add_classroom']));

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
				_table_data.push(
					[
						'<input type="checkbox" name="check-classroom[]" value="' + classroom.id + '" />',
						classroom.id,
						classroom.name,
						classroom.classroom_grade.display_name,
						'',
						'',
						(classroom.active) ? 'Active' : 'Inactive',
						'<a href="/school_admin/edit_classroom/' + classroom.id + '">Edit</a>'
					]
				);
			});
			_classrooms_table.rows.add(_table_data).draw();
		};
	}
});
