define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/principal.tmpl',
	'text!./template/school_admin.tmpl',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	PrincipalTemplate,
	SchoolAdminTemplate,
	jGrowl
) {
	'use strict';

	return function AddSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$add_school_form = null;

		var _principals = [];
		var _school_admins = [];

		var _allowed_num_principals = 0;
		var _allowed_num_school_admins = 0;

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
					var _school_data = _util.serializeJSON($(form));
					_$add_school_form.find('#add-school-form').find('.error-container').text('');
					if (_principals.length < 1 || _school_admins.length < 1) {
						_$add_school_form.find('#add-school-form').find('.error-container').text('You need to enter at least 1 principal and 1 school admin.');
						return false;
					}
					_me.broadcast('add_school', {school: _school_data, principals: _principals, school_admins: _school_admins});
				}
			});

			_$add_school_form.find('#add-principal-form').validate({
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
					if (_principals.length >= _allowed_num_principals) {
						$.jGrowl('You have exceeded the max number of principals', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}
					var _principal_data = _util.serializeJSON($(form));
					_principals.push(_principal_data);
					$(form).trigger('reset');
					var _$preview_principal = $(_.template(PrincipalTemplate, {principal: _principal_data}));
					_$add_school_form.find('#preview-principal-container').append(_$preview_principal);

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

			_$add_school_form.find('#add-school-admin-form').validate({
				rules: {
					'username': {
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
					'username': {
						remote: 'Username has been taken'
					},
					'email': {
						remote: 'Email has been taken'
					}
				},
				submitHandler: function(form) {
					if (_school_admins.length >= _allowed_num_school_admins) {
						$.jGrowl('You have exceeded the max number of school admins', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}
					var _school_admin_data = _util.serializeJSON($(form));
					_school_admins.push(_school_admin_data);
					$(form).trigger('reset');
					var _$preview_school_admin = $(_.template(SchoolAdminTemplate, {school_admin: _school_admin_data}));
					_$add_school_form.find('#preview-school-admin-container').append(_$preview_school_admin);

					_$preview_school_admin.find('.delete').on('click', function() {
						var _$self = $(this);
						$.each(_school_admins || [], function(index, school_admin) {
							var _username = _$self.siblings('.username').text();
							if (school_admin.username == _username) {
								_school_admins.splice(index, 1);
								_$self.closest('.school-admin-container').remove();
								return;
							}
						});
					});
				}
			});

			_setListeners($e);
		};

		this.displaySuccess = function(success_msg) {
			_$add_school_form.find('#success-container').html(success_msg);
		};

		this.displaySuccessPrincipal = function(success_msg) {
			_$add_school_form.find('#success-container-principal').html(success_msg);
		};

		this.displaySuccessSchoolAdmin = function(success_msg) {
			_$add_school_form.find('#success-container-school-admin').html(success_msg);
		};

		this.displayError = function(error_msg) {
			_$add_school_form.find('.error-container').text(error_msg);
		};

		this.displayLimitPrincipal = function(error_msg) {
			_$add_school_form.find('#limit-container-principal').html(error_msg);
		};

		this.displayLimitSchoolAdmin = function(error_msg) {
			_$add_school_form.find('#limit-container-school-admin').html(error_msg);
		};

		// Private function
		function _setListeners($e) {
			$e.find('#add-school-form').find('#account_type').on('change', function() {
				if ($(this).val()) {
					_allowed_num_principals = parseInt($(this).find('option:selected').attr('data-num-principal'));
					_allowed_num_school_admins = parseInt($(this).find('option:selected').attr('data-num-school-admin'));
					_$add_school_form.find('#add-principal-form').removeClass('hidden');
					_$add_school_form.find('#add-school-admin-form').removeClass('hidden');
				} else {
					_allowed_num_principals = 0;
					_allowed_num_school_admins = 0;
					_$add_school_form.find('#add-principal-form').hide();
					_$add_school_form.find('#add-school-admin-form').hide();
				}
			});
		}
	}
});


