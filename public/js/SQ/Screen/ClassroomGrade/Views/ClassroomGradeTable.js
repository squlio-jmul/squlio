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

	return function ClassroomGradeTable() {
		var _me = this;
		var _util = new Util();
		var _$classroom_grade_table = null;
		var screenHeight = $(window).height();
		var _table = null;

		SQ.mixin(_me, new Broadcaster(['school_id']));
		(function _init() {
		})();

		this.initialize = function($e) {
			_$classroom_grade_table = $e;
			var contentHeight = screenHeight - 125;
			_$classroom_grade_table.find('.admin-main-content').css('min-height', contentHeight);
			_$classroom_grade_table.find('.btn.btn-primary').click(function(){
				window.location.replace("addClassroomGrade");
			});

			_$classroom_grade_table.find('#school').on('change', function(){
				var _school_id = $(this).val();
				_me.broadcast('school_id', _school_id);
			});
		}

		this.displayTable = function(classroom_grade_data) {
			if (!_table){
				_table = _$classroom_grade_table.find('#table').DataTable({
					'data': classroom_grade_data,
					columns: [
						{ data: 'id'},
						{ data: 'school_name'},
						{ data: 'display_name'},
						{ data: 'action'}
					],
					'columnDefs': [{
						'targets': 3,
						'data': 'action',
						'render': function ( data, type, full, meta) {
							return '<a href="/admin/editClassroomGrade?id='+data+'">Edit</a>';
						}
					} ]
				});
			} else {
				_table.clear();
				_table.rows.add(classroom_grade_data);
				_table.draw();
			}
		}
	}
});
