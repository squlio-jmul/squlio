define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Announcement() {
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
				data.modules.classroom = data.modules.classroom || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/announcement/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.announcements);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(announcement_data) {
				var _deferred = Q.defer();

				var data = {
					announcement_data: announcement_data
				};
				$.ajax({
					url: '/ajax/announcement/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.announcement_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(announcement_id, announcement_data) {
				var _deferred = Q.defer();

				var data = {
					announcement_id: announcement_id,
					announcement_data: announcement_data
				};
				$.ajax({
					url: '/ajax/announcement/update',
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
					url: '/ajax/announcement/delete',
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

			this.addBulk = function(announcement_data) {
				var _deferred = Q.defer();

				var data = {
					announcement_data: announcement_data
				};
				$.ajax({
					url: '/ajax/announcement/addBulk',
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
