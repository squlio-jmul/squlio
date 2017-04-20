define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'text!./template/teachers_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	TeachersTableTemplate
) {
	'use strict';

	return function TeachersTable() {

		var _me = this;
		var _util = new Util();
		var _$teachers_table = null;
		var _teachers_table = null;

		SQ.mixin(_me, new Broadcaster(['add_teacher']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$teachers_table = $e;
			_$teachers_table.append(_.template(TeachersTableTemplate));
			_teachers_table = _$teachers_table.find('#teachers-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(teachers) {
			var _table_data = [];
			$.each(teachers || [], function(index, teacher) {
				_table_data.push(
					[
						'<input type="checkbox" name="check-teacher[]" value="' + teacher.id + '" />',
						teacher.id,
						teacher.first_name,
						teacher.last_name,
						'',
						(teacher.active) ? 'Active' : 'Inactive',
						'<a href="/school_admin/edit_teacher/' + teacher.id + '">Edit</a>'
					]
				);
			});
			_teachers_table.rows.add(_table_data).draw();
		};
	}
});
