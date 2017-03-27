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

	return function AddAccountTypeForm() {
		var _me = this;
		var _util = new Util();
		var _$add_account_type_form = null;

		SQ.mixin(_me, new Broadcaster(['add_type']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_account_type_form = $e;
			_$add_account_type_form.find('#add-account-type-form').validate({
				rules: {
					'name' : {
						required: true
					},
					'display_name': {
						required: true
					},
					'num_principal': {
						required: true
					},
					'num_school_admin': {
						required: true
					},
					'num_teacher': {
						required: true
					},
					'num_classroom': {
						required: true
					},
					'num_guardian': {
						required: true
					},
					'num_student': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _account_type_data = _util.serializeJSON($(form));
					_me.broadcast('add_type', _account_type_data);
					$(form).trigger('reset');
				}
			});
		};
	}
});
