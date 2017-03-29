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
		var screenHeight = $(window).height();


		SQ.mixin(_me, new Broadcaster(['add_classroom_grade']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_classroom_grade_form = $e;
			var contentHeight = screenHeight - 125;
			_$add_classroom_grade_form.find('.admin-main-content').css('min-height', contentHeight);

			_$add_classroom_grade_form.find('#add-classroom-grade-form').validate({
				rules: {
					'name' : {
						required: true
					},
					'display_name': {
						required: true
					}
				},
				submitHandler: function(form) {
					var school_id = _$add_classroom_grade_form.find('#school').val();
					var _classroom_grade_data = _util.serializeJSON($(form));
					_me.broadcast('add_classroom_grade', {school_id: school_id, classroom_grade:_classroom_grade_data});
					$(form).trigger('reset');
				}
			});
		};
	}
});
