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

	return function EditAccountTypeForm() {
		var _me = this;
		var _util = new Util();
		var _$edit_account_type_form = null;

		SQ.mixin(_me, new Broadcaster(['edit_type']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_account_type_form = $e;
			_$edit_account_type_form.find('#edit-account-type-form').validate({
				rules: {
					'name': {
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
					console.log(_account_type_data);
					_me.broadcast('edit_type', _account_type_data);
				}
			});
		};
	}
});
