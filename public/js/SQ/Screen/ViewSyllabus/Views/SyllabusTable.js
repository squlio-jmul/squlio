define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.dataTables.min'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function SyllabusTable() {
		var _me = this;
		var _util = new Util();
		var _$syllabus_table = null;
		var _combine = null;

		SQ.mixin(_me, new Broadcaster(['classroom_dropdown', 'term_dropdown']));
		(function _init(){
		}) ();

		this.initialize = function($e) {
			_$syllabus_table = $e;
			_$syllabus_table.find('#classroom').on('change', function() {
				var _classroom_id = $(this).val();
				_me.broadcast('classroom_dropdown', _classroom_id);
			});

			_$syllabus_table.find('#term').on('change', function(){
				var _term_id = $(this).val();
				var _classroom_id = _$syllabus_table.find('#classroom').val();
				_combine = [_classroom_id, _term_id];
				console.log(_combine);
				_me.broadcast('term_dropdown', _combine);
			});
		};

		this.clearError = function(){
			_$syllabus_table.find('.error-container').empty();
		};

		this.displayError = function() {
			_$syllabus_table.find('.error-container').text(error_msg);
		};

		this.displayTable = function(syllabus_data) {
			var _table = null;
			if (!_table){
				_table = _$syllabus_table.find('#table').DataTable({
					destroy:true,
					'data':syllabus_data,
					columns: [
						{ title: "Id"},
						{ title: "School id"},
						{ title: "Term id"},
						{ title: "Classroom id"},
						{ title: "Classroom subject id"},
						{ title: "Title"},
						{ title: "Description"},
						{ title: "Created on"},
						{ title: "Last updated"}
					]
				});
			}
		};
	}
});

