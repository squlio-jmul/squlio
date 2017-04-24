define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Classroom() {
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
				data.modules.student = data.modules.student || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/classroom/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.classrooms);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(classroom_data) {
				var _deferred = Q.defer();

				var data = {
					classroom_data: classroom_data
				};
				$.ajax({
					url: '/ajax/classroom/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.classroom_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(classroom_id, classroom_data) {
				var _deferred = Q.defer();

				var data = {
					classroom_id: classroom_id,
					classroom_data: classroom_data
				};
				$.ajax({
					url: '/ajax/classroom/update',
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
					url: '/ajax/classroom/upload_image',
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
