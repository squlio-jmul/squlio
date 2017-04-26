define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Subject() {
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
				data.modules.classroom_grade = data.modules.classroom_grade || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/subject/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.subjects);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(subject_data) {
				var _deferred = Q.defer();

				var data = {
					subject_data: subject_data
				};
				$.ajax({
					url: '/ajax/subject/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.subject_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(subject_id, subject_data) {
				var _deferred = Q.defer();

				var data = {
					subject_id: subject_id,
					subject_data: subject_data
				};
				$.ajax({
					url: '/ajax/subject/update',
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
					url: '/ajax/subject/delete',
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
