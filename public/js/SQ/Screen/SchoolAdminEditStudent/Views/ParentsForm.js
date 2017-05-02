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

	return function ParentsForm() {

		var _me = this;
		var _util = new Util();
		var _$parents_form = null;
		var _father_data = {};
		var _mother_data = {};

		SQ.mixin(_me, new Broadcaster(['save_father', 'mother_father']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$parents_form = $e;
			_$parents_form.find('#father-form').validate({
				rules: {
					password: {
						required: true
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
							url: '/ajax/login/editEmailNotExist',
							type: 'post',
							data: {login_id: $e.find('#father-form [name="login_id"]').val()}
						}
					},
					phone: {
						required: true,
						number: true
					}
				},
				messages: {
					email: {
						remote: 'Email has been taken'
					}
				},
				submitHandler: function(form) {
					_father_data = _util.serializeJSON($(form));
					_father_data.active = _$parents_form.find("#father-form [name='active']").prop('checked') ? 1 : 0;
					_father_data.type = 'father';
					_me.broadcast('save_father', _father_data);
				}
			});

			_$parents_form.find('#mother-form').validate({
				rules: {
					password: {
						required: true
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
							url: '/ajax/login/editEmailNotExist',
							type: 'post',
							data: {login_id: $e.find('#mother-form [name="login_id"]').val()}
						}
					},
					phone: {
						required: true,
						number: true
					}
				},
				messages: {
					email: {
						remote: 'Email has been taken'
					}
				},
				submitHandler: function(form) {
					_mother_data = _util.serializeJSON($(form));
					_mother_data.active = _$parents_form.find("#mother-form [name='active']").prop('checked') ? 1 : 0;
					_mother_data.type = 'mother';
					_me.broadcast('save_mother', _mother_data);
				}
			});
			_setListeners($e);
		};

		this.setGuardianId = function(parent_type, guardian_id) {
			_$parents_form.find('#' + parent_type + '-form [name="guardian_id"]').val(guardian_id);
		};

		this.setLoginId = function(parent_type, login_id) {
			_$parents_form.find('#' + parent_type + '-form [name="login_id"]').val(login_id);
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
