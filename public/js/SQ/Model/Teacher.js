define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function School() {
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

			/*
			this.addTeacher = function(status, gender, school_id, username, email, password, first_name, last_name, phone, address, birthday) {
				var _deferred = Q.defer();
				var data = {
					status: status,
					gender: gender,
					school_id: school_id,
					username: username,
					email: email,
					password: password,
					first_name: first_name,
					last_name: last_name,
					phone: phone,
					address: address,
					birthday: birthday
				};
				$.ajax({
					url: '/ajax/teacher/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.editTeacher = function(gender, login_id, id, school_id, username, email, password, first_name, last_name, phone, address, birthday) {
				var _deferred = Q.defer();
				var data = {
					gender: gender,
					login_id: login_id,
					id: id,
					school_id: school_id,
					username: username,
					email: email,
					password: password,
					first_name: first_name,
					last_name: last_name,
					phone: phone,
					address: address,
					birthday: birthday
				};
				$.ajax({
					url: '/ajax/teacher/update',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.deleteTeacher = function(login_id) {
				var _deferred = Q.defer();
				var data = {
					login_id: login_id
				};
				$.ajax({
					url: '/ajax/teacher/delete',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.getTeacherData = function(school_id) {
				var _deferred = Q.defer();

				var data = {school_id: school_id};
				$.ajax({
					url: '/ajax/teacher/displayTable',
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
			}
			*/

		}
	}
);
