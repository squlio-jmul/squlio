define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/teachers_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	TeachersTableTemplate
) {
	'use strict';

	return function TeachersTable() {

		var _me = this;
		var _util = new Util();
		var _$teachers_table = null;
		var _teachers_table = null;

		SQ.mixin(_me, new Broadcaster(['open_contact_modal']));

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
				var _classrooms = [];
				$.each(teacher.classroom_teacher || [], function(index, ct) {
					_classrooms.push('<span class="' + ((ct.is_primary) ? 'is-primary':'') + '">' + ct.classroom_name + '</span>');
				});

				_table_data.push(
					[
						'<input type="checkbox" name="check-teacher[]" value="' + teacher.id + '" />',
						teacher.id,
						teacher.first_name,
						teacher.last_name,
						_classrooms.join(', '),
						(teacher.active) ? 'Active' : 'Inactive',
						'<a href="/school_admin/edit_teacher/' + teacher.id + '">Edit</a><a class="contact-teacher" data-teacher-id="' + teacher.id + '" data-teacher-name="' + (teacher.first_name + ' ' + teacher.last_name) + '">Contact</a>'
					]
				);
			});
			_teachers_table.rows.add(_table_data).draw();
			_setRowListeners(_$teachers_table);
		};

		function _setRowListeners($e) {
			$e.find('.contact-teacher').on('click', function(e) {
				e.preventDefault();
				var _$self = $(e.target);
				var _teacher_id = _$self.attr('data-teacher-id');
				var _teacher_name = _$self.attr('data-teacher-name');
				_me.broadcast('open_contact_modal', {teacher_id: _teacher_id, teacher_name: _teacher_name});
			});
		}
	}
});
