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


		SQ.mixin(_me, new Broadcaster(['edit_school', 'delete_principal', 'delete_principal_preview', 'delete_school_admin','delete_school_admin_preview',
			'add_principal', 'add_school_admin', 'update_principal', 'update_school_admin']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_school_form = $e;
			_current_account_type = _$edit_school_form.find('#account_type').val();
			_$edit_school_form.find('.principal').removeClass('hidden');
			_$edit_school_form.find('.school-admin').removeClass('hidden');

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

			_$edit_school_form.find('#add-principal-form').validate({
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

			_$edit_school_form.find('#add-school-admin-form').validate({
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
					_me.broadcast('add_school_admin', _school_admin_data);
					$(form).trigger('reset');

				}
			});

			_$edit_school_form.find('#update-form-principal').validate({
				rules: {
					'username': {
						required: true,
						remote: {
							url: '/ajax/login/editUsernameNotExist',
							type: 'post',
							data: {
								login_id: function() {
									return $('.login_id').val();
								}
							}
						}
					},
					'email': {
						required: true,
						remote: {
							url: '/ajax/login/editEmailNotExist',
							type: 'post',
							data: {
								login_id: function() {
									return $('.login_id').val();
								}
							}
						}
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
					var _update_principal_data = _util.serializeJSON($(form));
					_me.broadcast('update_principal', _update_principal_data);
					$(form).trigger('reset');
				}
			});

			_$edit_school_form.find('#update-form-school-admin').validate({
				rules: {
					'username': {
						required: true,
						remote: {
							url: '/ajax/login/editUsernameNotExist',
							type: 'post',
							data: {
								login_id: function() {
									return $('#login_id').val();
								}
							}
						}
					},
					'email': {
						required: true,
						remote: {
							url: '/ajax/login/editEmailNotExist',
							type: 'post',
							data: {
								login_id: function() {
									return $('#login_id').val();
								}
							}
						}
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
					var _update_school_admin_data = _util.serializeJSON($(form));
					_me.broadcast('update_school_admin', _update_school_admin_data);
					$(form).trigger('reset');
				}
			});

			_$edit_school_form.find('.delete-principal').on('click', function() {
				var _$self = $(this);
				var _delete_principal_data = _$self.closest('.popup-principal').attr('data-login-id');
				_me.broadcast('delete_principal', _delete_principal_data);
			});

			_$edit_school_form.find('.delete-school-admin').on('click', function() {
				var _$self = $(this);
				var _delete_school_admin_data = _$self.closest('.popup-school-admin').attr('data-login-id');
				_me.broadcast('delete_school_admin', _delete_school_admin_data);
			});

			_$edit_school_form.find('.edit-principal').on('click', function() {
				var _$self= $(this);
				var login_id = _$self.closest('.principal').find('.principal_login_id').val();
				var principal_id = _$self.closest('.principal').find('.principal_id').val();
				var username = _$self.closest('.principal').find('.username').text();
				var email = _$self.closest('.principal').find('.email').text();
				var first_name = _$self.closest('.principal').find('.first_name').text();
				var last_name = _$self.closest('.principal').find('.last_name').text();

				_$edit_school_form.find('#update-form-principal input[name="login_id"]').val(login_id);
				_$edit_school_form.find('#update-form-principal input[name="principal_id"]').val(principal_id);
				_$edit_school_form.find('#update-form-principal input[name="username"]').val(username);
				_$edit_school_form.find('#update-form-principal input[name="email"]').val(email);
				_$edit_school_form.find('#update-form-principal input[name="first_name"]').val(first_name);
				_$edit_school_form.find('#update-form-principal input[name="last_name"]').val(last_name);
				_$edit_school_form.find('#update-form-principal').removeClass('hidden');
				_$edit_school_form.find('.principal').addClass('hidden');

			});
			_$edit_school_form.find('.edit-school-admin').on('click', function() {
				var _$self= $(this);
				var login_id = _$self.closest('.school-admin').find('.school_admin_login_id').val();
				var school_admin_id = _$self.closest('.school-admin').find('.school_admin_id').val();
				var username = _$self.closest('.school-admin').find('.username').text();
				var email = _$self.closest('.school-admin').find('.email').text();
				var first_name = _$self.closest('.school-admin').find('.first_name').text();
				var last_name = _$self.closest('.school-admin').find('.last_name').text();
				_$edit_school_form.find('#update-form-school-admin input[name="login_id"]').val(login_id);
				_$edit_school_form.find('#update-form-school-admin input[name="school_admin_id"]').val(school_admin_id);
				_$edit_school_form.find('#update-form-school-admin input[name="username"]').val(username);
				_$edit_school_form.find('#update-form-school-admin input[name="email"]').val(email);
				_$edit_school_form.find('#update-form-school-admin input[name="first_name"]').val(first_name);
				_$edit_school_form.find('#update-form-school-admin input[name="last_name"]').val(last_name);
				_$edit_school_form.find('#update-form-school-admin').removeClass('hidden');
				_$edit_school_form.find('.school-admin').addClass('hidden');
			});

			_$edit_school_form.find('.cancel-principal').on('click', function() {
				_$edit_school_form.find('#update-form-principal').addClass('hidden');
				_$edit_school_form.find('.principal').removeClass('hidden');
			});

			_$edit_school_form.find('.cancel-school-admin').on('click', function() {
				_$edit_school_form.find('#update-form-school-admin').addClass('hidden');
				_$edit_school_form.find('.school-admin').removeClass('hidden');
			});
			_setListeners($e);
		};

		this.displayAddSuccessPrincipal = function(principal_data) {
			var login_id = principal_data[0];
			var data = principal_data[1];
			var principal_id = principal_data[2];
			data.principal_id = principal_id;
			data.login_id = login_id;
			var _$preview_principal = $(_.template(PrincipalTemplate, {principal: data}));
			_$edit_school_form.find('.list-principal-data').append(_$preview_principal);

			_$preview_principal.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_principal_data = [login_id, data.username];
				_me.broadcast('delete_principal_preview', _delete_principal_data);
			});

			_$preview_principal.find('.edit').on('click', function() {
				var username = _$preview_principal.find('.username').text();
				var email = _$preview_principal.find('.email').text();
				var first_name = _$preview_principal.find('.first_name').text();
				var last_name = _$preview_principal.find('.last_name').text();
				_$edit_school_form.find('#update-form-principal input[name="login_id"]').val(login_id);
				_$edit_school_form.find('#update-form-principal input[name="principal_id"]').val(principal_id);
				_$edit_school_form.find('#update-form-principal input[name="username"]').val(username);
				_$edit_school_form.find('#update-form-principal input[name="email"]').val(email);
				_$edit_school_form.find('#update-form-principal input[name="first_name"]').val(first_name);
				_$edit_school_form.find('#update-form-principal input[name="last_name"]').val(last_name);
				_$edit_school_form.find('#update-form-principal').removeClass('hidden');
			});
		}

		this.displayAddSuccessSchoolAdmin = function(school_admin_data) {
			var login_id = school_admin_data[0];
			var data = school_admin_data[1];
			var school_admin_id = school_admin_data[2];
			data.school_admin_id = school_admin_id;
			data.login_id = login_id;
			var _$preview_school_admin = $(_.template(SchoolAdminTemplate, {school_admin: data}));
			_$edit_school_form.find('.list-school-admin-data').append(_$preview_school_admin);

			_$preview_school_admin.find('.delete').on('click', function() {
				var _$self = $(this);
				var _delete_school_admin_data = [login_id, data.username];
				_me.broadcast('delete_school_admin_preview', _delete_school_admin_data);
			});

			_$preview_school_admin.find('.edit').on('click', function() {
				var username = _$preview_school_admin.find('.username').text();
				var email = _$preview_school_admin.find('.email').text();
				var first_name = _$preview_school_admin.find('.first_name').text();
				var last_name = _$preview_school_admin.find('.last_name').text();
				_$edit_school_form.find('#update-form-school-admin input[name="login_id"]').val(login_id);
				_$edit_school_form.find('#update-form-school-admin input[name="school_admin_id"]').val(school_admin_id);
				_$edit_school_form.find('#update-form-school-admin input[name="username"]').val(username);
				_$edit_school_form.find('#update-form-school-admin input[name="email"]').val(email);
				_$edit_school_form.find('#update-form-school-admin input[name="first_name"]').val(first_name);
				_$edit_school_form.find('#update-form-school-admin input[name="last_name"]').val(last_name);
				_$edit_school_form.find('#update-form-school-admin').removeClass('hidden');

			});
		}

		this.displayEditPrincipalSuccess = function(data) {
			var login_id = data.login_id;
			_$edit_school_form.find('#update-form-principal').addClass('hidden');
			_$edit_school_form.find('.principal').removeClass('hidden');
			var _login_id = _$edit_school_form.find('li.principal[data-login-id="principal-'+login_id+'"]');
			if (_login_id.length > 0) {
				_login_id.find('p.username').replaceWith('<p class="username">'+data.username+'</p>');
				_login_id.find('p.email').replaceWith('<p class="email">'+data.email+'</p>');
				_login_id.find('p.first_name').replaceWith('<p class="first_name">'+data.first_name+'</p>');
				_login_id.find('p.last_name').replaceWith('<p class="last_name">'+data.last_name+'</p>');
			}
			$.jGrowl('Principal successfully updated', {header: 'Success'});
		}

		this.displayEditSchoolAdminSuccess = function(data) {
			var login_id = data.login_id;
			_$edit_school_form.find('#update-form-school-admin').addClass('hidden');
			_$edit_school_form.find('.school-admin').removeClass('hidden');
			var _login_id = _$edit_school_form.find('li.school-admin[data-login-id="school-admin-'+login_id+'"]');
			if (_login_id.length > 0) {
				_login_id.find('p.username').replaceWith('<p class="username">'+data.username+'</p>');
				_login_id.find('p.email').replaceWith('<p class="email">'+data.email+'</p>');
				_login_id.find('p.first_name').replaceWith('<p class="first_name">'+data.first_name+'</p>');
				_login_id.find('p.last_name').replaceWith('<p class="last_name">'+data.last_name+'</p>');
			}
		}

		this.displayEditPrincipalPreviewSuccess = function(data) {
			var principal_id = data.principal_id;
			var new_principal = $(_.template(PrincipalTemplate, {principal: data}));
			var old_principal = _$edit_school_form.find('.principal-container[data-id="'+principal_id+'"]');
			if (_old_principal.length > 0) {
				old_principal.html(new_principal);
			}
		}

		this.displayEditSchoolAdminPreviewSuccess = function(data) {
			var school_admin_id = data.school_admin_id;
			var old_school_admin = _$edit_school_form.find('.school-admin-container[data-id="'+school_admin_id+'"]');
			console.log(old_school_admin);
			if (_old_school_admin.length > 0) {
				old_principal.html(new_principal);
			}
		}

		this.deletePrincipal = function(login_id) {
			var _login_id = _$edit_school_form.find('li.principal[data-login-id="principal-'+login_id+'"]');
			if (_login_id.length > 0){
				_login_id.remove();
			}
		}

		this.deletePrincipalPreview = function(data) {
			var login_id = data[0];
			var username = data[1];
			var _username = _$edit_school_form.find('.principal[data-username="'+username+'"]');
			if (_username.length > 0){
				_username.remove();
			}
		}

		this.deleteSchoolAdmin = function(login_id) {
			var _login_id = _$edit_school_form.find('li.school-admin[data-login-id="school-admin-'+login_id+'"]');
			if (_login_id.length > 0) {
				_login_id.remove();
			}
		}

		this.deleteSchoolAdminPreview = function(data) {
			var login_id = data[0];
			var username = data[1];
			var _username = _$edit_school_form.find('.school-admin[data-username="'+username+'"]');
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
