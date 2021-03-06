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
				data.modules.account_type = data.modules.account_type || false;

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

			this.update = function(school_id, school_data) {
				var _deferred = Q.defer();

				var data = {
					school_id: school_id,
					school_data: school_data
				};
				$.ajax({
					url: '/ajax/school/update',
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
					url: '/ajax/school/upload_image',
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
					url: '/ajax/school/addSchool',
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

			this.getSchoolData = function() {
				var _deferred = Q.defer();
				$.ajax({
					url: '/ajax/school/displayTable',
					dataType: 'json',
					success: function(response) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.editSchool = function(account_type, id, name, email, phone_1, address_1, zipcode, city) {
				var _deferred = Q.defer();
				var data = {
					account_type: account_type_id,
					id: id,
					name: name,
					email: email,
					phone_1: phone_1,
					address_1: address_1,
					zipcode: zipcode,
					city: city
				};
				$.ajax({
					url: '/ajax/school/update',
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
