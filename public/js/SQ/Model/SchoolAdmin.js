define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {
		'use strict';

		return function Signup(){

			var _me = this;

			(function _init() {}) ();

			this.get = function(filters, fields, order_by, limit, offset, modules){
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
					url: '/ajax/login/get',
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

			this.usernameExist = function(username) {
				var _deferred = Q.defer();

				var data = {username: username};
				$.ajax({
					url: 'ajax/school_admin/usernameExist',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response){
						deferred.resolve(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(username, email, password, first_name, last_name){
				var _deferred = Q.defer();
				var data= {
					username: username,
					email: email,
					password: password,
					first_name: first_name,
					last_name: last_name
				};
				$.ajax({
					url: 'ajax/school_admin/add',
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

			this.successRegister = function(username, password) {
				var _deferred = Q.defer();
				var data = {
					username: username,
					password: password
				};
				$.ajax({
					url:'/ajax/login/verifyLogin',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response){
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR){
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};
		}
	}
);

