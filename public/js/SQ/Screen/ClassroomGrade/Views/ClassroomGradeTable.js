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

	return function SchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$school_form = null;
		var screenHeight = $(window).height();
		var table = null;

		(function _init() {
		})();

		this.initialize = function($e) {
			_$school_form = $e;
			var contentHeight = screenHeight - 125;
			_$school_form.find('.admin-main-content').css('min-height', contentHeight);
			_$school_form.find('.btn.btn-primary').click(function(){
				window.location.replace("addClassroomGrade");
			});
			/*if (!table){

				table = _$school_form.find('#table').DataTable({
					'ajax': '/ajax/school/displayTable',
					'columns': [
						{ 'data': 'id' },
						{ 'data': 'name' },
						{ 'data': 'num_principal' },
						{ 'data': 'num_school_admin' },
						{ 'data': 'num_teacher'},
						{ 'data': 'num_student' },
						{ 'data': 'num_classroom' },
						{ 'data': 'status' }
					],
					'columnDefs': [ {
						'targets': 8,
						'data': 'action',
						'render': function ( data, type, full, meta ) {
							return '<a href="/admin/editSchool?id='+data+'">Edit</a>';
						}
					} ]
				});

			};*/
		}
	}
});
