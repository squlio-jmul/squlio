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
					url: '/ajax/school/get',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.schools);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.addSchool = function(account_type_id, school_name, school_email, phone_1, address_1, zipcode, city) {
				var _deferred = Q.defer();
				var data = {
					account_type_id: account_type_id,
					school_name: school_name,
					school_email: school_email,
					phone_1:  phone_1,
					address_1: address_1,
					zipcode: zipcode,
					city: city
				};
				$.ajax({
					url: '/ajax/school/add',
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
		}
	}
);
