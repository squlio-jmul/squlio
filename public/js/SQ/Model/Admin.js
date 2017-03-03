define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Admin() {

			var _me = this;

			(function _init() {})();

			this.get = function(filters, fields, order_by, limit, offset, modules){
				var data = {};
				data.filsters = filters || {};
				data.fields = fields || [];
				data.order_by = order_by || {};
				data.limit = limit || null;
				data.offset = offset || null;
				data.modules = modules || {};
				data.modules.all = data.modules.all || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/admin/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.admins);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			}

			this.verifyLogin = function(email, password) {
				var _deferred = Q.defer();

				var data = {
					email: email,
					password: password
				};
				$.ajax({
					url: 'ajax/admin/verifyLogin',
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
		}
	}
);

