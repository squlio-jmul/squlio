define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function ClassroomTeacher() {
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
				data.modules.classroom = data.modules.classroom || false;
				data.modules.teacher = data.modules.teacher || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/classroom_teacher/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.classroom_teachers);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(classroom_teacher_data) {
				var _deferred = Q.defer();

				var data = {
					classroom_teacher_data: classroom_teacher_data
				};
				$.ajax({
					url: '/ajax/classroom_teacher/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.classroom_teacher_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(classroom_teacher_id, classroom_teacher_data) {
				var _deferred = Q.defer();

				var data = {
					classroom_teacher_id: classroom_teacher_id,
					classroom_teacher_data: classroom_teacher_data
				};
				$.ajax({
					url: '/ajax/classroom_teacher/update',
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
