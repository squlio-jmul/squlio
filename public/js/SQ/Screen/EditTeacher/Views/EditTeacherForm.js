define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function EditTeacherForm() {
		var _me = this;
		var _util = new Util();
		var _$edit_teacher_form = null;
		var screenHeight = $(window).height();

		SQ.mixin(_me, new Broadcaster(['edit_teacher', 'delete_teacher']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_teacher_form = $e;
			var contentHeight = screenHeight - 125;
			_$edit_teacher_form.find('.school-admin-main-content').css('min-height', contentHeight);
			_$edit_teacher_form.find('#edit-teacher-form').validate({
				rules: {
					'username' : {
						required: true,
						remote: {
							url: '/ajax/login/editUsernameNotExist',
							type: 'post',
							data: {
								login_id: function() {
									return $('.login_id').val();
								}
							}
						}
					},
					'email': {
						required: true,
						remote: {
							url: '/ajax/login/editEmailNotExist',
							type: 'post',
							data: {
								login_id: function() {
									return $('.login_id').val();
								}
							}
						}
					},
					'first_name': {
						required: true
					},
					'phone': {
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
					var _gender = _$edit_teacher_form.find('#gender').val();
					var _teacher_data = _util.serializeJSON($(form));
					_me.broadcast('edit_teacher', {gender: _gender, teacher: _teacher_data});
					$(form).trigger('reset');
				}
			});
			_$edit_teacher_form.find('#birthday').datepicker({
				changeMonth: true,
				changeYear: true,
			});

			_$edit_teacher_form.find('.delete-btn').on('click', function() {
				var _login_id = _$edit_teacher_form.find('.login_id').val();
				_me.broadcast('delete_teacher', _login_id);
				_$edit_teacher_form.find('#edit-teacher-form').trigger('reset');
			});
		}
	}
});
