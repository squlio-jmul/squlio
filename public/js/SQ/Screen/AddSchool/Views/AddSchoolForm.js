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

	return function AddSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$add_school_form = null;

		SQ.mixin(_me, new Broadcaster(['add_school', 'add_principal']));

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
					var _add_school_form = _util.serializeJSON($(form));
					var _add_school_data = [_account_type, _add_school_form];
					_me.broadcast('add_school', _add_school_data);
				}
			});
			_$add_school_form.find('#add-principal-form').validate({
				rules: {
					'username': {
						required: true
					},
					'email': {
						required: true,
						email: true
					},
					'password': {
						required: true
					},
					'first_name': {
						required: true
					},
					'last_name': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _school = _$add_school_form.find('#school').val();
					var _principal_data_form = _util.serializeJSON($(form));
					var _principal_data = [_school, _principal_data_form];
					_me.broadcast('add_principal', _principal_data);
				}
			});
			_$add_school_form.find('#add-school-admin-form').validate({
				rules: {
					'username': {
						required: true
					},
					'email': {
						required: true,
						email: true
					},
					'password': {
						required: true
					},
					'first_name': {
						required: true
					},
					'last_name': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _school = _$add_school_form.find('#school').val();
					var _school_admin_data_form = _util.serializeJSON($(form));
					var _school_admin_data = [_school, _school_admin_data_form];
					_me.broadcast('add_school_admin', _school_admin_data);
				}
			});
		};

		this.displaySuccess = function(success_msg) {
			_$add_school_form.find('input[type="text"],textarea').val('');
			_$add_school_form.find('#success-container').html(success_msg);
		};

		this.displaySuccessPrincipal = function(success_msg) {
			_$add_school_form.find('input[type="text"],textarea').val('');
			_$add_school_form.find('#success-container-principal').html(success_msg);
		};
	}
});


