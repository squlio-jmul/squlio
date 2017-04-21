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

	return function AddClassroomForm() {

		var _me = this;
		var _util = new Util();
		var _$add_classroom_form = null;
		var _add_classroom_data = {};

		SQ.mixin(_me, new Broadcaster(['add_classroom']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_classroom_form = $e;
			_$add_classroom_form.validate({
				rules: {
					name: {
						required: true,
						remote: {
							url: '/ajax/classroom/nameNotExist',
							type: 'post',
							data: {school_id: $e.find('[name="school_id"]').val()}
						}
					},
					classroom_grade_id: {
						required: true
					}
				},
				messages: {
					name: {
						remote: 'This name has been taken'
					}
				},
				submitHandler: function(form) {
					_add_classroom_data = _util.serializeJSON($(form));
					_add_classroom_data.active = _$add_classroom_form.find("[name='active']").prop('checked') ? 1 : 0;
					_me.broadcast('add_classroom', _add_classroom_data);
				}
			});
		};
	}
});
