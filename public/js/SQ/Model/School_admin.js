define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {
		'use strict';

		return function School_admin() {
			var _me = this;

			(function _init() {})();

			this.get = function(filters, fields, order_by, limit, offset, modules) {
				var data = {};
				data.filters = filters || {};
				data.fields = fields || [];
				data.order_by = order_by || {};
				data.limit = limit || null;
				data.offset = offset || null;
				data.modules = modules || {};
				data.modules.all = data.modules.all || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/school_admin/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.school_admins);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.verifyLogin = function(email, password) {
				var _deferred = Q.defer();

				var data = {
					email: email,
					password: password
				};
				$.ajax({
					url: 'ajax/login/verifyLoginSchoolAdmin',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.addSchoolAdmin = function(school_id, username, email, password, first_name, last_name) {
				var _deferred = Q.defer();
				var data = {
					school_id: school_id,
					username: username,
					email: email,
					password: password,
					first_name: first_name,
					last_name: last_name
				};
				$.ajax({
					url: '/ajax/school_admin/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.addBulk = function(school_id, school_admins) {
			   var _deferred = Q.defer();
				var data = {
					school_id: school_id,
					school_admins: school_admins
				};
				$.ajax({
					url: '/ajax/school_admin/addBulk',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.success);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.deleteSchoolAdmin = function(login_id) {
				var _deferred = Q.defer();
				var data = {
					login_id: login_id
				};
				$.ajax({
					url: '/ajax/school_admin/delete',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(school_admin_id, school_admin_data) {
				var _deferred = Q.defer();
				var data = {
					school_admin_id: school_admin_id,
					school_admin_data: school_admin_data
				};
				$.ajax({
					url: '/ajax/school_admin/update',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;

			};
		}
	}
);
