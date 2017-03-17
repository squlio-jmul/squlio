define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function EditSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$edit_school_form = null;

		SQ.mixin(_me, new Broadcaster(['edit_school']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_school_form = $e;
			_$edit_school_form.find('#edit-school-form').validate({
				rules: {
					'name': {
						required: true
					},
					'email': {
						required: true
					},
					'phone_1': {
						required: true
					},
					'address_1': {
						required: true
					},
					'zipcode': {
						required: true
					},
					'city': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _school_data = _util.serializeJSON($(form));
					_me.broadcast('edit_school', _school_data);
				}
			});
		};

		this.displaySuccess = function(success_msg) {
			_$edit_account_type_form.find('input[type="text"],textarea').val('');
			_$edit_account_type_form.find('#success-container').html(success_msg);
		};
	}
});
