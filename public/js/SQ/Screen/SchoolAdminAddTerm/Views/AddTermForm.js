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

	return function AddTermForm() {

		var _me = this;
		var _util = new Util();
		var _$add_term_form = null;
		var _add_term_data = {};

		SQ.mixin(_me, new Broadcaster(['add_term']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_term_form = $e;
			$e.find('[name="start_date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$e.find('[name="end_date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			_$add_term_form.validate({
				rules: {
					name : {
						required: true,
						remote: {
							url: '/ajax/term/nameNotExist',
							type: 'post',
							data: {school_id: $e.find('[name="school_id"]').val()}
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
					_add_term_data = _util.serializeJSON($(form));
					_me.broadcast('add_term', _add_term_data);
				}
			});
		};
	}
});
