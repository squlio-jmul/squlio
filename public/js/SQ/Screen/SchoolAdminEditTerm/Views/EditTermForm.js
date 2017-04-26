define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'jqueryui'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function EditTermForm() {

		var _me = this;
		var _util = new Util();
		var _$edit_term_form = null;
		var _edit_term_data = {};

		SQ.mixin(_me, new Broadcaster(['edit_term']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_term_form = $e;
			$e.find('[name="start_date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$e.find('[name="end_date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			_$edit_term_form.validate({
				rules: {
					name : {
						required: true,
						remote: {
							url: '/ajax/term/editNameNotExist',
							type: 'post',
							data: {school_id: $e.find('[name="school_id"]').val(), term_id: $e.find('[name="term_id"]').val()}
						}
					},
					start_date: {
						required: true
					},
					end_date: {
						required: true
					}
				},
				messages: {
					name: {
						remote: 'Name has been taken'
					}
				},
				submitHandler: function(form) {
					_edit_term_data = _util.serializeJSON($(form));
					_me.broadcast('edit_term', _edit_term_data);
				}
			});
		};
	}
});
