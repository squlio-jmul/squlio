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

	return function EditClassroomGradeForm() {

		var _me = this;
		var _util = new Util();
		var _$edit_classroom_grade_form = null;
		var _edit_classroom_grade_data = {};

		SQ.mixin(_me, new Broadcaster(['edit_classroom_grade']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_classroom_grade_form = $e;
			_$edit_classroom_grade_form.validate({
				rules: {
					name : {
						required: true,
						remote: {
							url: '/ajax/classroom_grade/editNameNotExist',
							type: 'post',
							data: {school_id: $e.find('[name="school_id"]').val(), classroom_grade_id: $e.find('[name="classroom_grade_id"]').val()}
						}
					}
				},
				messages: {
					name: {
						remote: 'This name has been taken'
					}
				},
				submitHandler: function(form) {
					_edit_classroom_grade_data = _util.serializeJSON($(form));
					_me.broadcast('edit_classroom_grade', _edit_classroom_grade_data);
				}
			});
		};
	}
});
