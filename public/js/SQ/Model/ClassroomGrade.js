define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function ClassroomGrade() {
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

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/classroom_grade/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.classroom_grades);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(classroom_grade_data) {
				var _deferred = Q.defer();

				var data = {
					classroom_grade_data: classroom_grade_data
				};
				$.ajax({
					url: '/ajax/classroom_grade/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.classroom_grade_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(classroom_grade_id, classroom_grade_data) {
				var _deferred = Q.defer();

				var data = {
					classroom_grade_id: classroom_grade_id,
					classroom_grade_data: classroom_grade_data
				};
				$.ajax({
					url: '/ajax/classroom_grade/update',
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
					url: '/ajax/classroom_grade/delete',
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
