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

	return function AddSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$add_school_form = null;

		SQ.mixin(_me, new Broadcaster(['add_school']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_school_form = $e;
			_$add_school_form.find('#add-school-form').validate({
				rules: {
					'school_name': {
						required: true
					},
					'school_email': {
						email: true,
						required: true
					},
					'phone_1': {
						required: true
					},
					'address_1': {
						required: true
					},
					'zipcode': {
						required: true
					},
					'city': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _account_type = _$add_school_form.find('#account_type').val();
					var _principal_data = {
						username:_$add_school_form.find('#username').val(),
						email: _$add_school_form.find('#email').val(),
						password: _$add_school_form.find('#password').val(),
						first_name: _$add_school_form.find('#first_name').val(),
						last_name: _$add_school_form.find('#last_name').val()
					};
					var _school_admin_data = {
						username: _$add_school_form.find('#school_admin_username').val(),
						email: _$add_school_form.find('#school_admin_email').val(),
						password: _$add_school_form.find('#school_admin_password').val(),
						first_name: _$add_school_form.find('#school_admin_first_name').val(),
						last_name: _$add_school_form.find('#school_admin_last_name').val()
					};
					var _school_data = _util.serializeJSON($(form));
					var _add_all_data = [_account_type, _school_data, _principal_data, _school_admin_data];
					_me.broadcast('add_school', _add_all_data);
				}
			});
		};

		this.displaySuccess = function(success_msg) {
			_$add_school_form.find('#success-container').html(success_msg);
		};
	}
});


