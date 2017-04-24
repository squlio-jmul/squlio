define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function GuardianStudent() {
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
				data.modules.guardian = data.modules.guardian || false;
				data.modules.student = data.modules.student || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/guardian_student/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.guardian_students);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(guardian_student_data) {
				var _deferred = Q.defer();

				var data = {
					guardian_student_data: guardian_student_data
				};
				$.ajax({
					url: '/ajax/guardian_student/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.guardian_student_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(guardian_student_id, guardian_student_data) {
				var _deferred = Q.defer();

				var data = {
					guardian_student_id: guardian_student_id,
					guardian_student_data: guardian_student_data
				};
				$.ajax({
					url: '/ajax/guardian_student/update',
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
					url: '/ajax/guardian_student/delete',
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
