define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/terms_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	TermsTableTemplate
) {
	'use strict';

	return function TermsTable() {

		var _me = this;
		var _util = new Util();
		var _$terms_table = null;
		var _terms_table = null;

		SQ.mixin(_me, new Broadcaster());

		(function _init() {
		})();

		this.initialize = function($e) {
			_$terms_table = $e;
			_$terms_table.append(_.template(TermsTableTemplate));
			_terms_table = _$terms_table.find('#terms-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(terms) {
			var _table_data = [];
			$.each(terms || [], function(index, term) {
				var _start_date = new Date(term.start_date.date);
				var _end_date = new Date(term.end_date.date);
				_table_data.push(
					[
						'<input type="checkbox" name="check-term[]" value="' + term.id + '" />',
						term.id,
						term.name,
						_start_date.getDate() + '/' + (_start_date.getMonth()+1) + '/' + _start_date.getFullYear(),
						_end_date.getDate() + '/' + (_end_date.getMonth()+1) + '/' + _end_date.getFullYear(),
						'<a href="/school_admin/edit_term/' + term.id + '">Edit</a>'
					]
				);
			});
			_terms_table.rows.add(_table_data).draw();
		};
	}
});
