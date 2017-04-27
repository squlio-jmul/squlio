define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/students_table.tmpl',
	'jgrowl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	StudentsTableTemplate,
	jGrowl
) {
	'use strict';

	return function StudentsTab(selected_student_ids) {

		var _me = this;
		var _util = new Util();
		var _$students_tab = null;
		var _students_table = null;
		var _selected_student_ids = selected_student_ids;

		var _add_student_data = {};

		SQ.mixin(_me, new Broadcaster(['add_student', 'remove_student']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$students_tab = $e;
			_$students_tab.find('#student-table-container').append(_.template(StudentsTableTemplate));
			_students_table = _$students_tab.find('#student-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});

			_$students_tab.find('#add-student-form').validate({
				rules: {
					student_id: {
						required: true
					}
				},
				submitHandler: function(form) {
					_add_student_data = _util.serializeJSON($(form));
					_me.broadcast('add_student', _add_student_data.student_id);
				}
			});

			_setListeners($e);
		};

		this.setSelectedStudentIds = function(selected_student_ids) {
			_selected_student_ids = selected_student_ids;
			_$students_tab.find('[name="student_id"] option').removeClass('sq-hidden');
			$.each(_$students_tab.find('[name="student_id"] option') || [], function() {
				var _student_id = parseInt($(this).attr('value'));
				if (_student_id && _selected_student_ids.indexOf(_student_id) >= 0) {
					$(this).addClass('sq-hidden');
				}
			});
		};

		this.populate = function(students) {
			var _table_data = [];
			$.each(students || [], function(index, student) {
				_table_data.push(
					[
						'<input type="checkbox" name="check-student[]" value="' + student.id + '" />',
						'<a href="/school_admin/edit_student/' + student.id + '" target="_blank">' + student.id + '</a>',
						student.first_name,
						student.last_name,
						_util.ucfirst(student.gender),
						'<button class="button remove-student" data-student-id="' + student.id + '">Remove</button>'
					]
				);
			});
			_students_table.rows.add(_table_data).draw();
			_setTableListeners(_$students_tab.find('#student-table'));
		};

		this.viewTable = function() {
			_$students_tab.find('#add-student-container').hide();
			_$students_tab.find('.header, #student-table-container').fadeIn(300);
		};

		this.clearTable = function() {
			_students_table.clear().draw();
		};

		function _setListeners($e) {
			$e.find('.add-student').on('click', function() {
				if (($e.find('[name="student_id"] option').length - 1) == _selected_student_ids.length) {
					$.jGrowl('No more available student.<br /><a href="/school_admin/add_student">Click here to add new student</a>', {header: 'Error'});
					return false;
				}
				$e.find('.header, #student-table-container').hide();
				$e.find('#add-student-form').trigger('reset');
				$e.find('#add-student-container').fadeIn(300);
			});

			$e.find('.cancel').on('click', function(e) {
				e.preventDefault();
				$e.find('#add-student-container').hide();
				$e.find('.header, #student-table-container').fadeIn(300);
			});
		}

		function _setTableListeners($e) {
			$e.find('.remove-student').on('click', function() {
				var _student_id = $(this).attr('data-student-id');
				_me.broadcast('remove_student', _student_id);
			});
		}
	}
});
