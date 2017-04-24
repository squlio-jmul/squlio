define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Guardian() {
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
				data.modules.login = data.modules.login || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/guardian/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.guardians);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(guardian_data) {
				var _deferred = Q.defer();

				var data = {
					guardian_data: guardian_data
				};
				$.ajax({
					url: '/ajax/guardian/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.guardian_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(guardian_id, guardian_data) {
				var _deferred = Q.defer();

				var data = {
					guardian_id: guardian_id,
					guardian_data: guardian_data
				};
				$.ajax({
					url: '/ajax/guardian/update',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.success);
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
