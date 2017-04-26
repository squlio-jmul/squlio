define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/students_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	studentsTableTemplate
) {
	'use strict';

	return function studentsTable() {

		var _me = this;
		var _util = new Util();
		var _$students_table = null;
		var _students_table = null;

		SQ.mixin(_me, new Broadcaster(['add_student']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$students_table = $e;
			_$students_table.append(_.template(studentsTableTemplate));
			_students_table = _$students_table.find('#students-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(students) {
			var _table_data = [];
			$.each(students || [], function(index, student) {
				_table_data.push(
					[
						'<input type="checkbox" name="check-student[]" value="' + student.id + '" />',
						student.id,
						student.first_name,
						student.last_name,
						student.classroom_grade.name,
						student.classroom.name,
						(student.active) ? 'Active' : 'Inactive',
						'<a href="/school_admin/edit_student/' + student.id + '">Edit</a>'
					]
				);
			});
			_students_table.rows.add(_table_data).draw();
		};
	}
});
