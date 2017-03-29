define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {
		'use strict';

		return function Classroom_grade() {
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
					url: '/ajax/classroom_grade/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.account_types);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.addClassroomGrade= function(school_id, name,  display_name) {
				var _deferred = Q.defer();
				var data= {
					school_id: school_id,
					name: name,
					display_name: display_name,
				};
				$.ajax({
					url: '/ajax/classroom_grade/add',
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

			/*this.editType = function(id, name, display_name, num_principal, num_school_admin, num_teacher, num_classroom, num_guardian, num_student) {
				var _deferred = Q.defer();
				var data = {
					id: id,
					name: name,
					display_name: display_name,
					num_principal: num_principal,
					num_school_admin: num_school_admin,
					num_teacher: num_teacher,
					num_classroom: num_classroom,
					num_guardian: num_guardian,
					num_student: num_student
				};
				$.ajax({
					url: '/ajax/account_type/update',
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
			};*/
		}
	}
);
