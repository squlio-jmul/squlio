define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/ClassroomGrade',
	'SQ/Screen/SchoolAdminEditClassroomGrade/Views/EditClassroomGradeForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomGradeModel,
	EditClassroomGradeForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditClassroomGradeController(options) {
		var _me = this;
		var _util = new Util();
		var _classroom_grade_id = options.classroom_grade_id;
		var _classroomGradeModel = new ClassroomGradeModel();
		var _editClassroomGradeForm = new EditClassroomGradeForm();

		(function _init() {
			_editClassroomGradeForm.initialize($('#edit-classroom-grade-form'));
			_editClassroomGradeForm.setListener('edit_classroom_grade', _editClassroomGrade);
		})();

		function _editClassroomGrade(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomGradeModel.update(_classroom_grade_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Classroom grade is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this classroom grade', {header: 'Error'});
					}
				}
			);
		}
	}
});
