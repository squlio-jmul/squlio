define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/principal.tmpl',
	//'text!./template/school_admin.tmpl',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	PrincipalTemplate,
//	SchoolAdminTemplate,
	jGrowl
) {
	'use strict';

	return function EditSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$edit_school_form = null;

		var _principals = [];
	//	var _school_admins = [];

	//	var _allowed_num_principals = 0;
	//	var _allowed_num_school_admins = 0;


		SQ.mixin(_me, new Broadcaster(['edit_school', 'delete_principal']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_school_form = $e;
			_$edit_school_form.find('#edit-school-form').validate({
				rules: {
					'name': {
						required: true
					},
					'email': {
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
					var _account_type_data = _$edit_school_form.find('#account_type').val();
					var _school_data_form = _util.serializeJSON($(form));
					console.log(_account_type_data);
					var _school_data = [_account_type_data, _school_data_form];
					_me.broadcast('edit_school', _school_data);
				}
			});
			_$edit_school_form.find('#edit-principal-form').validate({
				rules: {
					'username': {
						required: true,
						remote: {
							url: '/ajax/login/usernameNotExist',
							type: 'post'
						}
					},
					'email': {
						email: true,
						required: true,
						remote: {
							url: '/ajax/login/emailNotExist',
							type: 'post'
						}
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
				messages: {
					'username' : {
						remote: 'Username has been taken.'
					},
					'email' : {
						remote: 'Email has been taken.'
					}
				},
				submitHandler: function(form) {
					/*if (_principals.length >= _allowed_num_principals) {
						$.jGrowl('You have exceeded the max number of principals', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}*/
					var _principal_data = _util.serializeJSON($(form));
					_principals.push(_principal_data);
					console.log(_principals);
					$(form).trigger('reset');
					var _$preview_principal = $(_.template(PrincipalTemplate, {principal: _principal_data}));
					_$edit_school_form.find('#list-principal').append(_$preview_principal);

					_$preview_principal.find('.delete').on('click', function() {
						var _$self = $(this);
						$.each(_principals || [], function(index, principal) {
							var _username = _$self.siblings('.username').text();
							if (principal.username == _username) {
								_principals.splice(index, 1);
								_$self.closest('.principal-container').remove();
								return;
							}
						});
					});
					return;
				}
			});
			_$edit_school_form.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_principal_data = _$edit_school_form.find('#principal_login_id').val();
				console.log(_delete_principal_data);
				_me.broadcast('delete_principal', _delete_principal_data);
				//var _username = _$self.siblings('.username').text();
				_$self.closest('.principal').remove();
			});
		};
	}
});
