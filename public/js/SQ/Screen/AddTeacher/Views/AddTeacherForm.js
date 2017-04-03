define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui',
	'jgrowl'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	jGrowl
) {
	'use strict';

	return function AddTeacherForm() {
		var _me = this;
		var _util = new Util();
		var _$add_teacher_form = null;
		var screenHeight = $(window).height();

		SQ.mixin(_me, new Broadcaster(['add_teacher']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_teacher_form = $e;
			var contentHeight = screenHeight - 125;
			_$add_teacher_form.find('.school-admin-main-content').css('min-height', contentHeight);

			var _allowed_num_teacher = _$add_teacher_form.find('.add-teacher').attr('data-num-teacher');
			var _current_num_teacher = _$add_teacher_form.find('.add-teacher').attr('data-current-teachers');

			_$add_teacher_form.find('#add-teacher-form').validate({
				rules: {
					'username' : {
						required: true,
						remote: {
							url: '/ajax/login/usernameNotExist',
							type: 'post'
						}
					},
					'email': {
						required: true,
						remote: {
							url: '/ajax/login/emailNotExist',
							type: 'post'
						}
					},
					'first_name': {
						required: true
					},
					'phone': {
						required: true
					},
					'password': {
						required: true
					},
					'last_name': {
						required: true
					},
					'address': {
						required: true
					},
				},
				messages: {
					'username' : {
						remote: 'Username has been taken.'
					},
					'email' : {
						remote: 'Email has been taken.'
					}
				},
				submitHandler: function(form) {
					if (_current_num_teacher <= _allowed_num_teacher) {
						$.jGrowl('You have exceeded the max number of teachers', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}
					var _status = _$add_teacher_form.find('#status').val();
					var _gender = _$add_teacher_form.find('#gender').val();
					var _teacher_data = _util.serializeJSON($(form));
					_me.broadcast('add_teacher', {status: _status, gender: _gender, teacher: _teacher_data});
					$.jGrowl('Teacher  successfully added<br /><br /><a href="/school_admin/teacher">Click here to view your teacher</a>', {header: 'Success'});
					$(form).trigger('reset');
				}
			});
			_$add_teacher_form.find('#birthday').datepicker({
				changeMonth: true,
				changeYear: true,
			});
		}
	}
});
