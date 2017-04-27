define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function SchoolAdminTeacherContact() {
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
				data.modules.school_admin = data.modules.school_admin || false;
				data.modules.teacher = data.modules.teacher || false;

				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/school_admin_teacher_contact/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.school_admin_teacher_contacts);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.add = function(school_admin_teacher_contact_data) {
				var _deferred = Q.defer();

				var data = {
					school_admin_teacher_contact_data: school_admin_teacher_contact_data
				};
				$.ajax({
					url: '/ajax/school_admin_teacher_contact/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response) {
						_deferred.resolve(response.school_admin_teacher_contact_id);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.update = function(school_admin_teacher_contact_id, school_admin_teacher_contact_data) {
				var _deferred = Q.defer();

				var data = {
					school_admin_teacher_contact_id: school_admin_teacher_contact_id,
					school_admin_teacher_contact_data: school_admin_teacher_contact_data
				};
				$.ajax({
					url: '/ajax/school_admin_teacher_contact/update',
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
