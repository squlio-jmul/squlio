define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Schedule() {
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
				data.modules.school = data.modules.school || false;
				data.modules.term = data.modules.term || false;
				data.modules.classroom = data.modules.classroom || false;
				data.modules.subject = data.modules.subject || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/schedule/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.schedules);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(schedule_data) {
				var _deferred = Q.defer();

				var data = {
					schedule_data: schedule_data
				};
				$.ajax({
					url: '/ajax/schedule/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.schedule_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(schedule_id, schedule_data) {
				var _deferred = Q.defer();

				var data = {
					schedule_id: schedule_id,
					schedule_data: schedule_data
				};
				$.ajax({
					url: '/ajax/schedule/update',
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

			this.delete = function(filters) {
				var data = {};
				data.filters = filters || {};

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/schedule/delete',
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

		}
	}
);
