define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Teacher() {
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
				data.modules.school = data.modules.school || false;
				data.modules.classroom_teacher = data.modules.classroom_teacher || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/teacher/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.teachers);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(teacher_data) {
				var _deferred = Q.defer();

				var data = {
					teacher_data: teacher_data
				};
				$.ajax({
					url: '/ajax/teacher/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.teacher_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(teacher_id, teacher_data) {
				var _deferred = Q.defer();

				var data = {
					teacher_id: teacher_id,
					teacher_data: teacher_data
				};
				$.ajax({
					url: '/ajax/teacher/update',
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

			this.uploadImage = function(data){
				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/teacher/upload_image',
					type: 'post',
					data: data,
					contentType: false,
					cache: false,
					processData: false,
					success: function(response, textStatus, jqXHR) {
						response = JSON.parse(response);
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						response = JSON.parse(response);
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};
		}
	}
);
