define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/classroom_grades_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	ClassroomGradesTableTemplate
) {
	'use strict';

	return function ClassroomGradesTable() {

		var _me = this;
		var _util = new Util();
		var _$classroom_grades_table = null;
		var _classroom_grades_table = null;

		SQ.mixin(_me, new Broadcaster());

		(function _init() {
		})();

		this.initialize = function($e) {
			_$classroom_grades_table = $e;
			_$classroom_grades_table.append(_.template(ClassroomGradesTableTemplate));
			_classroom_grades_table = _$classroom_grades_table.find('#classroom-grades-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(classroom_grades) {
			var _table_data = [];
			$.each(classroom_grades || [], function(index, classroom_grade) {
				_table_data.push(
					[
						'<input type="checkbox" name="check-classroom-grade[]" value="' + classroom_grade.id + '" />',
						classroom_grade.id,
						classroom_grade.name,
						'<a href="/school_admin/edit_classroom_grade/' + classroom_grade.id + '">Edit</a>'
					]
				);
			});
			_classroom_grades_table.rows.add(_table_data).draw();
		};
	}
});
