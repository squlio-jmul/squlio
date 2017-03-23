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

	return function EditSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$edit_school_form = null;

		var _allowed_num_principals = 0;
		var _allowed_num_school_admins = 0;

		var _current_account_type = 0;
		var _current_num_principal = 0;
		var _current_num_school_admin = 0;


		SQ.mixin(_me, new Broadcaster(['edit_school', 'delete_principal', 'delete_principal_preview', 'delete_school_admin','delete_school_admin_preview', 'add_principal', 'add_school_admin']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_school_form = $e;
			_current_account_type = _$edit_school_form.find('#account_type').val();
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
					var account_type = _$edit_school_form.find('#account_type').val();
					var _school_data = _util.serializeJSON($(form));
					_me.broadcast('edit_school', {account_type, school: _school_data});
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
					_current_num_principal = parseInt(_$edit_school_form.find('.list-principal').find('.principal').length);
					_allowed_num_principals = parseInt(_$edit_school_form.find('#account_type > option:selected').attr('data-num-principal'));
					console.log(_current_num_principal);
					console.log(_allowed_num_principals);
					if (_current_num_principal >= _allowed_num_principals) {
						$.jGrowl('You have exceeded the max number of principals', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}
					var _principal_data = _util.serializeJSON($(form));
					_me.broadcast('add_principal', _principal_data);
					$(form).trigger('reset');
				}
			});

			_$edit_school_form.find('#edit-school-admin-form').validate({
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
					_current_num_school_admin = parseInt(_$edit_school_form.find('#list-school-admin').find('.school-admin').length);
					_allowed_num_school_admins = parseInt(_$edit_school_form.find('#account_type > option:selected').attr('data-num-school-admin'));

					if (_current_num_school_admin >= _allowed_num_school_admins) {
						$.jGrowl('You have exceeded the max number of school admins', {header: 'Error'});
						$(form).trigger('reset');
						return;
					}
					var _school_admin_data = _util.serializeJSON($(form));
					console.log(_school_admin_data);
					_me.broadcast('add_school_admin', _school_admin_data);
					$(form).trigger('reset');

				}
			});

			_$edit_school_form.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_principal_data = _$self.closest('.principal').find('.principal_login_id').val();
				console.log(_delete_principal_data);
				_me.broadcast('delete_principal', _delete_principal_data);
			});

			_$edit_school_form.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_school_admin_data = _$self.closest('.school-admin').find('#school_admin_login_id').val();
				console.log(_delete_school_admin_data);
				_me.broadcast('delete_school_admin', _delete_school_admin_data);
			});

			_$edit_school_form.find('.edit-principal').on('click', function() {
				_$edit_school_form.find('#update-form-principal').removeClass('hidden');

			});
			_$edit_school_form.find('.edit-school-admin').on('click', function() {
				_$edit_school_form.find('#update-form').removeClass('hidden');
			});

			_setListeners($e);
		};

		this.displayAddSuccessPrincipal = function(principal_data) {
			var login_id = principal_data[0];
			var data = principal_data[1];
			var _$preview_principal = $(_.template(PrincipalTemplate, {principal: data}));
			console.log(data);
			_$edit_school_form.find('.list-principal').append(_$preview_principal);

			_$preview_principal.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_principal_data = [login_id, data.username];
				console.log(_delete_principal_data);
				_me.broadcast('delete_principal_preview', _delete_principal_data);
			});
		}

		this.displayAddSuccessSchoolAdmin = function(school_admin_data) {
			var login_id = school_admin_data[0];
			var data = school_admin_data[1];
			var _$preview_school_admin = $(_.template(SchoolAdminTemplate, {school_admin: data, login_id: login_id}));
			console.log(data);
			console.log(login_id);
			_$edit_school_form.find('#list-school-admin').append(_$preview_school_admin);

			_$preview_school_admin.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_school_admin_data = [login_id, data.username];
				console.log(_delete_school_admin_data);
				_me.broadcast('delete_school_admin_preview', _delete_school_admin_data);
			});
		}

		this.deletePrincipal = function(login_id) {
			console.log(login_id);
			var _login_id = _$edit_school_form.find('li.principal[data-login-id="principal-'+login_id+'"]');
			console.log(_login_id);
			if (_login_id.length > 0){
				_login_id.remove();
			}
		}

		this.deletePrincipalPreview = function(data) {
			var login_id = data[0];
			var username = data[1];
			var _username = _$edit_school_form.find('div[data-username="'+username+'"]');
			console.log(_username);
			if (_username.length > 0){
				_username.remove();
			}
		}

		this.deleteSchoolAdmin = function(login_id) {
			console.log(login_id);
			var _login_id = _$edit_school_form.find('li.school-admin[data-login-id="school-admin-'+login_id+'"]');
			console.log(_login_id);
			if (_login_id.length > 0) {
				_login_id.remove();
			}
		}

		this.deleteSchoolAdminPreview = function(data) {
			var login_id = data[0];
			var username = data[1];
			var _username = _$edit_school_form.find('div[data-username="'+username+'"]');
			console.log(_username);
			if (_username.length > 0) {
				_username.remove();
			}
		}

		// Private function
		function _setListeners($e) {
			$e.find('#edit-school-form').find('#account_type').on('change', function() {
				_current_num_principal = parseInt(_$edit_school_form.find('.list-principal').find('.principal').length);
				_current_num_school_admin = parseInt(_$edit_school_form.find('#list-school-admin').find('.school-admin').length);

				var _new_num_principal = parseInt($(this).find('option:selected').attr('data-num-principal'));
				var _new_num_school_admin = parseInt($(this).find('option:selected').attr('data-num-school-admin'));

				if (_current_num_principal <= _new_num_principal && _current_num_school_admin <= _new_num_school_admin) {
					_current_account_type = $(this).val();
					_allowed_num_principals = _new_num_principal;
					_allowed_num_school_admins = _new_num_school_admin;
				} else {
					$(this).val(_current_account_type);
					$.jGrowl('You cant downgrade the account type cause your principal number and school admin number exceeded the capacity', {header: 'Error'});
				}
			});
		}
	}
});
