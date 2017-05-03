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

	return function EditClassroomForm() {

		var _me = this;
		var _util = new Util();
		var _$edit_classroom_form = null;
		var _edit_classroom_data = {};

		SQ.mixin(_me, new Broadcaster(['edit_classroom']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_classroom_form = $e;
			_$edit_classroom_form.validate({
				rules: {
					name : {
						required: true,
						remote: {
							url: '/ajax/classroom/editNameNotExist',
							type: 'post',
							data: {
								school_id: $e.find('[name="school_id"]').val(),
								classroom_id: $e.find('[name="classroom_id"]').val()
							}
						}
					}
				},
				messages: {
					name: {
						remote: 'This name has been taken'
					}
				},
				submitHandler: function(form) {
					_edit_classroom_data = _util.serializeJSON($(form));
					_edit_classroom_data.active = _$edit_classroom_form.find("[name='active']").prop('checked') ? 1 : 0;
					_me.broadcast('edit_classroom', _edit_classroom_data);
				}
			});
		};
	}
});
