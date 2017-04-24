define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'jqueryui'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function EditStudentForm() {

		var _me = this;
		var _util = new Util();
		var _$edit_student_form = null;
		var _edit_student_data = {};

		SQ.mixin(_me, new Broadcaster(['edit_student', 'get_classroom']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_student_form = $e;
			$e.find('[name="birthday"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			_$edit_student_form.validate({
				rules: {
					first_name: {
						required: true
					},
					last_name: {
						required: true
					},
					classroom_grade_id: {
						required: true
					},
					classroom_id: {
						required: true
					},
					birthday: {
						required: true
					}
				},
				submitHandler: function(form) {
					_edit_student_data = _util.serializeJSON($(form));
					_edit_student_data.active = _$edit_student_form.find("[name='active']").prop('checked') ? 1 : 0;
					_me.broadcast('edit_student', _edit_student_data);
				}
			});
			_setListeners($e);
		};

		this.populateClassroom = function(classrooms) {
			_$edit_student_form.find('[name="classroom_id"] option').remove();
			_$edit_student_form.find('[name="classroom_id"]').append('<option value=""> - Select Class - </option>');
			$.each(classrooms || [], function(index, c) {
				_$edit_student_form.find('[name="classroom_id"]').append('<option value="' + c.id + '">' + c.name + '</option>');
			});
		};

		function _setListeners($e) {
			$e.find('[name="classroom_grade_id"]').on('change', function() {
				var _$self = $(this);
				var _classroom_grade_id = _$self.val();
				if (_classroom_grade_id) {
					_me.broadcast('get_classroom', _classroom_grade_id);
				}
			});
		}
	}
});
