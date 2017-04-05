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

			var _allowed_num_student = _$add_student_form.find('.add-student-container').attr('data-num-student');
			var _current_num_student = _$add_student_form.find('.add-student-container').attr('data-current-students');
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
				},
				messages: {
					'username' : {
						remote: 'Username has been taken.'
					},
					'email' : {
						remote: 'Email has been taken.'
					}
				},
			});

			_$add_student_form.find('#add-father-form').validate({
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
					'password' : {
						required: true
					},
					'first_name' : {
						required: true
					},
					'last_name' : {
						required: true
					}
				},
				messages: {
					'username' : {
						remote: 'Username has been taken.'
					},
					'email' : {
						remote: 'Email has been taken.'
					},
				}
			});

			_$add_student_form.find('#add-mother-form').validate({
				rules : {
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
					'password' : {
						required: true
					},
					'first_name' : {
						required: true
					},
					'last_name' : {
						required: true
					}
				},
				messages: {
					'username' : {
						remote: 'Username has been taken.'
					},
					'email' : {
						remote: 'Email has been taken.'
					},
				}
			});

			_$add_student_form.find('#student-status').validate({
				submitHandler: function(form) {
					if (_current_num_student >= _allowed_num_student) {
						$.jGrowl('You have exceeded the max number of students', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}
					var _status = _$add_student_form.find('#status').val();
					var _gender = _$add_student_form.find('#gender').val();
					var _classroom = _$add_student_form.find('#classroom').val();
					var _student_data = _util.serializeJSON($(_$add_student_form.find('#add-student-form')));
					var _father_data = _util.serializeJSON($(_$add_student_form.find('#add-father-form')));
					var _mother_data = _util.serializeJSON($(_$add_student_form.find('#add-mother-form')));
					console.log(_status);
					console.log(_gender);
					console.log(_classroom);
					console.log(_student_data);
					console.log(_father_data);
					console.log(_mother_data);
				//	_me.broadcast('add_student', {status: _status, gender: _gender, classroom: _classroom, student: _student_data});
				//	$.jGrowl('Student  successfully added<br /><br /><a href="/school_admin/student">Click here to view your student</a>', {header: 'Success'});
					$(form).trigger('reset');
				}

			});

			_$add_student_form.find('.reset-btn').on('click', function() {
				_$add_student_form.find('#add-student-form').trigger('reset');
				_$add_student_form.find('#add-father-form').trigger('reset');
				_$add_student_form.find('#add-mother-form').trigger('reset');
			});
			_$add_student_form.find('#birthday').datepicker({
				changeMonth: true,
				changeYear: true,
			});
		}
	}
});
