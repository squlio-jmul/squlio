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

	return function AddStudentForm() {
		var _me = this;
		var _util = new Util();
		var _$add_student_form = null;
		var screenHeight = $(window).height();

		SQ.mixin(_me, new Broadcaster(['add_student']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_student_form = $e;
			var contentHeight = screenHeight - 125;
			_$add_student_form.find('.school-admin-main-content').css('min-height', contentHeight);

			var _allowed_num_student = _$add_student_form.find('.add-student').attr('data-num-students');
			var _current_num_student = _$add_student_form.find('.add-student').attr('data-current-students');
			console.log(_allowed_num_student);
			console.log(_current_num_student);

			_$add_student_form.find('#add-student-form').validate({
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
					'password': {
						required: true
					},
					'last_name': {
						required: true
					}
					'father_username' : {
						required: true,
						remote: {
							url: '/ajax/login/usernameNotExist',
							type: 'post'
						}
					},
					'father_email': {
						required: true,
						remote: {
							url: '/ajax/login/emailNotExist',
					i		type: 'post'
						}
					},
					'father_first_name': {
						required: true
					},
					'father_password': {
						required: true
					},
					'father_last_name': {
						required: true
					},
					'father_phone': {
						required: true
					},
					'mother_username' : {
						required: true,
						remote: {
							url: '/ajax/login/parentUsernameNotExist',
							type: 'post'
						}
					},
					'mother_email': {
						required: true,
						remote: {
							url: '/ajax/login/emailNotExist',
							type: 'post'
						}
					},
					'mother_first_name': {
						required: true
					},
					'mother_password': {
						required: true
					},
					'mother_last_name': {
						required: true
					},
					'mother_phone': {
						required: true
					}
				},
				messages: {
					'username' : {
						remote: 'Username has been taken.'
					},
					'email' : {
						remote: 'Email has been taken.'
					}
					'father_username' : {
						remote: 'Username has been taken.'
					},
					'father_email' : {
						remote: 'Email has been taken.'
					},
					'mother_username' : {
						remote: 'Username has been taken.'
					},
					'mother_email' : {
						remote: 'Email has been taken.'
					}
				},
				submitHandler: function(form) {
					if (_current_num_student >= _allowed_num_student) {
						$.jGrowl('You have exceeded the max number of teachers', {header: 'Error'});
						$(form).trigger('reset');
						console.log('failed');
						return;
					}
					var _status = _$add_student_form.find('#status').val();
					var _gender = _$add_student_form.find('#gender').val();
					var _classroom = _$add_student_form.find('#classroom').val();
					var _student_data = _util.serializeJSON($(form));
					console.log(_status);
					console.log(_gender);
					console.log(_classroom);
					console.log(_student_data);
					console.log('test');
					//_me.broadcast('add_teacher', {status: _status, gender: _gender, teacher: _teacher_data});
					//$.jGrowl('Teacher  successfully added<br /><br /><a href="/school_admin/teacher">Click here to view your teacher</a>', {header: 'Success'});
					//$(form).trigger('reset');
				}
			});
			_$add_student_form.find('#birthday').datepicker({
				changeMonth: true,
				changeYear: true,
			});

		}
	}
});
