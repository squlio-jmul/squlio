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

	return function EditTeacherForm() {

		var _me = this;
		var _util = new Util();
		var _$edit_teacher_form = null;
		var _edit_teacher_data = {};

		SQ.mixin(_me, new Broadcaster(['edit_teacher']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_teacher_form = $e;
			$e.find('[name="birthday"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			_$edit_teacher_form.validate({
				rules: {
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
							url: '/ajax/login/editEmailNotExist',
							type: 'post',
							data: {login_id: $e.find('[name="login_id"]').val()}
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
					email: {
						remote: 'Email has been taken'
					}
				},
				submitHandler: function(form) {
					_edit_teacher_data = _util.serializeJSON($(form));
					_edit_teacher_data.active = _$edit_teacher_form.find("[name='active']").prop('checked') ? 1 : 0;
					_me.broadcast('edit_teacher', _edit_teacher_data);
				}
			});
			_setListeners($e);
		};

		function _setListeners($e) {
			$e.find('.sq-view-password').on('click', function() {
				var _$self = $(this);
				if (_$self.siblings('[name="password"]').attr('type') == 'password') {
					_$self.siblings('[name="password"]').attr('type', 'text');
				} else {
					_$self.siblings('[name="password"]').attr('type', 'password');

				}
			});
		}
	}
});
