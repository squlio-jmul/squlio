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

	return function AddTeacherForm() {

		var _me = this;
		var _util = new Util();
		var _$add_teacher_form = null;
		var _add_teacher_data = {};

		SQ.mixin(_me, new Broadcaster(['add_teacher']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_teacher_form = $e;
			$e.find('[name="birthday"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			_$add_teacher_form.validate({
				rules: {
					username : {
						required: true,
						remote: {
							url: '/ajax/login/usernameNotExist',
							type: 'post'
						}
					},
					password: {
						required: true,
						minlength: 5
					},
					first_name: {
						required: true
					},
					last_name: {
						required: true
					},
					email: {
						required: true,
						email: true,
						remote: {
							url: '/ajax/login/emailNotExist',
							type: 'post'
						}
					},
					address: {
						required: true
					},
					city: {
						required: true
					},
					state: {
						required: true
					},
					zipcode: {
						required: true,
						number: true
					},
					phone: {
						required: true,
						number: true
					},
					birthday: {
						required: true
					}
				},
				messages: {
					username: {
						remote: 'Username has been taken'
					},
					email: {
						remote: 'Email has been taken'
					}
				},
				submitHandler: function(form) {
					_add_teacher_data = _util.serializeJSON($(form));
					_add_teacher_data.active = _$add_teacher_form.find("[name='active']").prop('checked') ? true : false;
					_me.broadcast('add_teacher', _add_teacher_data);
				}
			});
		};
	}
});
