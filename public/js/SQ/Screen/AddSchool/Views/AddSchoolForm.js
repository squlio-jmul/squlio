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

	return function AddSchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$add_school_form = null;

		SQ.mixin(_me, new Broadcaster(['add_school']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_school_form = $e;
			_$add_school_form.find('#add-school-form').validate({
				rules: {
					'school_name': {
						required: true
					},
					'school_email': {
						email: true,
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
				messages: {
					'school_email': {
						email: $.validator.format('Your email must be in correct format')
					}
				},
				submitHanlder: function(form) {
					var _add_school_data = _util.serializeJSON($(form));
					_me.broadcast('add_school', _add_school_data);
				}
			});
		};
		this.displaySuccess = function(error_msg) {
			_$add_school_form.find('input[type="text"],textarea').val('');
			_$add_school_form.find('#success-container').html(success_msg);
		};
	}
});


