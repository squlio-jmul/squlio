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

	return function AddClassroomGradeForm() {

		var _me = this;
		var _util = new Util();
		var _$add_classroom_grade_form = null;
		var _add_classroom_grade_data = {};

		SQ.mixin(_me, new Broadcaster(['add_classroom_grade']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_classroom_grade_form = $e;
			_$add_classroom_grade_form.validate({
				rules: {
					name : {
						required: true,
						remote: {
							url: '/ajax/classroom_grade/nameNotExist',
							type: 'post',
							data: {school_id: $e.find('[name="school_id"]').val()}
						}
					}
				},
				messages: {
					name: {
						remote: 'Grade name has been taken.'
					}
				},
				submitHandler: function(form) {
					_add_classroom_grade_data = _util.serializeJSON($(form));
					_me.broadcast('add_classroom_grade', _add_classroom_grade_data);
				}
			});
		};
	}
});
