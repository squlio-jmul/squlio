define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function SignupForm() {
		var _me = this;
		var _util = new Util();
		var _$signup_form = null;

		SQ.mixin(_me, new Broadcaster(['add']));

		(function _init() {
		}) ();

		this.initialize = function($e) {
			_$signup_form = $e;
			_$signup_form.validate({
				rules: {
					'username' : {
						required: true
					},
					'email': {
						email: true,
						required: true
					},
					'password': {
						required: true,
						minlength: 5
					},
					'first_name': {
						required: true
					},
					'last_name': {
						required: true
					}
				},
				messages: {
					'email' : {
						email: $.validator.format('Your email be in correct format')
					},
					'password': {
						minlength: $.validator.format('Min 5 character')
					}
				},
				submitHandler: function(form) {
					var _signup_data = _util.serializeJSON($(form));
					_me.broadcast('add', _signup_data);
				}
			});
		}
		this.clearError = function() {
			_$signup_form.find('.error-container').empty();
		};

		this.displayError = function(error_msg) {
			_$signup_form.find('.error-container').text(error_msg);
		};
	}
});
