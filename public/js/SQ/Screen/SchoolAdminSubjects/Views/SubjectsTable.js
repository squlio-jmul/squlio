define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/subjects_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	SubjectsTableTemplate
) {
	'use strict';

	return function SubjectsTable() {

		var _me = this;
		var _util = new Util();
		var _$subjects_table = null;
		var _subjects_table = null;

		SQ.mixin(_me, new Broadcaster());

		(function _init() {
		})();

		this.initialize = function($e) {
			_$subjects_table = $e;
			_$subjects_table.append(_.template(SubjectsTableTemplate));
			_subjects_table = _$subjects_table.find('#subjects-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(subjects) {
			var _table_data = [];
			$.each(subjects || [], function(index, subject) {
				_table_data.push(
					[
						'<input type="checkbox" name="check-subject[]" value="' + subject.id + '" />',
						subject.id,
						subject.title,
						subject.classroom_grade.name,
						'<a href="/school_admin/edit_subject/' + subject.id + '">Edit</a>'
					]
				);
			});
			_subjects_table.rows.add(_table_data).draw();
		};
	}
});
