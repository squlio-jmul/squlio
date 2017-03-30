define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom_grade',
	'SQ/Screen/EditClassroomGrade/Views/EditClassroomGradeForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomGradeModel,
	EditClassroomGradeForm,
	Q,
	jGrowl
) {
	'use strict';

	return function EditClassroomGradeController(option) {
		var _me = this;
		var _util = new Util();
		var _classroomGradeModel = new ClassroomGradeModel();
		var _editClassroomGradeForm = new EditClassroomGradeForm();

		(function _init() {
			_editClassroomGradeForm.initialize($('.admin-content-wrapper'));
			_editClassroomGradeForm.setListener('edit_classroom_grade', _editClassroomGrade);
			_editClassroomGradeForm.setListener('delete_classroom_grade', _deleteClassroomGrade);
		})();

		function _editClassroomGrade(data) {
			_classroomGradeModel.editClassroomGrade(data.id, data.name, data.display_name).then(
				function(response) {
					if (response.success) {
						$.jGrowl('Classroom grade successfull updated<br /><br /><a href="/admin/classroomGrade">Click here to view your classroom grade</a>', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update classroom grade', {header: 'Error'});
					}
				}
			);
		};

		function _deleteClassroomGrade(classroom_grade_id) {
			_classroomGradeModel.deleteClassroomGrade(classroom_grade_id).then(
				function(response) {
					if (response) {
						$.jGrowl('Classroom grade successfully deleted<br /><br /><a href="/admin/classroomGrade">Click here to view your classroom grade</a>', {header: 'Success'});
					} else {
					}
				}
			);
		};
	}
});
