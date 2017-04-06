define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui',
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
		var screenHeight = $(window).height();

		SQ.mixin(_me, new Broadcaster(['edit_classroom_grade', 'delete_classroom_grade']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$edit_classroom_grade_form = $e;
			var contentHeight = screenHeight - 125;
			_$edit_classroom_grade_form.find('.admin-main-content').css('min-height', contentHeight);

			var _classroom_amount = _$edit_classroom_grade_form.find('#edit-classroom-grade-form').attr('data-classroom-amount');
			console.log(_classroom_amount);
			_$edit_classroom_grade_form.find('#edit-classroom-grade-form').validate({
				rules: {
					'name': {
						required: true
					},
					'display_name': {
						required: true
					}
				},
				submitHandler: function(form) {
					var _classroom_grade_data = _util.serializeJSON($(form));
					_me.broadcast('edit_classroom_grade', _classroom_grade_data);
				}
			});

			_$edit_classroom_grade_form.find('.delete').on('click', function() {
				var _classroom_grade_id = _$edit_classroom_grade_form.find('.classroom_grade_id').val();
				if (_classroom_amount >= 1) {
					_$edit_classroom_grade_form.find('#dialog-confirm').dialog({
						resizable: false,
						height: 'auto',
						width: 400,
						modal: true,
						buttons: {
							"Close": function() {
								//_me.broadcast('delete_classroom_grade', _classroom_grade_id);
								$(this).dialog('close');
							},
							Cancel: function() {
								$(this).dialog('close');
							}
						}
					});
				} else {
					//_me.broadcast('delete_classroom_grade', _classroom_grade_id);
				}
			});
		};
	}
});
