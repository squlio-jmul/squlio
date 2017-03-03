define(
	['jquery', 'Global/SQ', 'ThirdParty/q'],
	function($, SQ, Q) {

		'use strict';

		return function Syllabus() {

			var _me = this;

			(function _init() {}) ();

			this.get = function(filters, fields, order_by, limit, offset, modules){
				var data = {};
				data.filters = filters ||{};
				data.fields = fields || [];
				data.order_by = order_by || {};
				data.limit = limit || null;
				data.offset = offset || null;
				data.modules = modules || {};
				data.modules.all = data.modules.all || false;

				var _deferred = Q.defer();
				$.ajax({
					url: 'ajax/login/get',
					type: 'post',
					dataType: 'json',
					data:data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response.syllabuses);
					},
					error: function(response, textStatus, jqXHR) {
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};

			this.getClassroomData = function(classroom_id, term_id = null){

				var _deferred = Q.defer();

				var data = {classroom_id: classroom_id, term_id: term_id};
				$.ajax({
					url: 'ajax/syllabus/displayTable',
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
			};

			this.addSyllabus = function(term_id, classroom_id, classroom_subject_id, title, description, date){
				var _deferred = Q.defer();
				var data = {
					term_id: term_id,
					classroom_id: classroom_id,
					classroom_subject_id: classroom_subject_id,
					title:  title,
					description: description,
					date: date
				};
				$.ajax({
					url: 'ajax/syllabus/add',
					type: 'post',
					dataType: 'json',
					data: data,
					success: function(response, textStatus, jqXHR) {
						_deferred.resolve(response);
					},
					error: function(response, textStatus, jqXHR){
						_deferred.reject(response);
					}
				});
				return _deferred.promise;
			};
		}
	}
);

