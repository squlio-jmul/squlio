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

	return function TeacherTable() {
		var _me = this;
		var _util = new Util();
		var _$teacher_table = null;
		var screenHeight = $(window).height();
		var _table = null;

		SQ.mixin(_me, new Broadcaster(['school_id']));
		(function _init() {
		})();

		this.initialize = function($e) {
			_$teacher_table = $e;
			var contentHeight = screenHeight - 125;
			_$teacher_table.find('.school-admin-main-content').css('min-height', contentHeight);
			_$teacher_table.find('.btn.btn-primary').click(function(){
				window.location.replace("addClassroomGrade");
			});

			_$teacher_table.find('#school').on('change', function(){
				var _school_id = $(this).val();
				_me.broadcast('school_id', _school_id);
			});

		}

		this.displayTable = function(teacher_data) {
			if (!_table){
				_table = _$teacher_table.find('#table').DataTable({
					'data': teacher_data,
					columns: [
						{ data: 'id'},
						{ data: 'name'},
						{ data: 'class'},
						{ data: 'status'}
					],
					'columnDefs': [{
						'targets': 1,
						'data': 'name',
						'render': function ( data, type, row, meta) {
							return '<a href="/school_admin/editTeacher?id='+row.id+'">'+data+'</a>';
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
