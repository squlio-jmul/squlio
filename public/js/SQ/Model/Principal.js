define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {
		'use strict';

		return function Principal() {
			var _me = this;

			(function _init() {})();

			this.get = function(filtes, fields, order_by, limit, offset, modules) {
				var data= {};
				data.filters = filters || {};
				data.fields = fields || [];
				data.order_by = order_by || {};
				data.limit = limit || null;
				data.offset = offset || null;
				data.modules = modules || {};
				data.modules.all = data.modules.all || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/principal/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.principals);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.addPrincipal = function(school_id, username, email, password, first_name, last_name) {
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
					url: '/ajax/principal/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response.success);
					}
				});
				return _deferred.promise;
			};

			this.addBulk = function(school_id, principals) {
			   var _deferred = Q.defer();
				var data = {
					school_id: school_id,
					principals: principals
				};
				$.ajax({
					url: '/ajax/principal/addBulk',
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

			this.updatePrincipal = function(school_id, login_id, principal_id, username, password, email, first_name, last_name) {
				var _deferred = Q.defer();
				var data = {
					school_id: school_id,
					login_id: login_id,
					principal_id: principal_id,
					username: username,
					password: password,
					email: email,
					first_name: first_name,
					last_name: last_name
				};
				$.ajax({
					url: '/ajax/principal/update',
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
			}

			this.deletePrincipal = function(login_id) {
				var _deferred = Q.defer();
				var data = {
					login_id: login_id
				};
				$.ajax({
					url: '/ajax/principal/delete',
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
