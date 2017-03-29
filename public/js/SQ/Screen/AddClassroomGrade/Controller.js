define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom_grade',
	'SQ/Screen/AddClassroomGrade/Views/AddClassroomGradeForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'jgrowl',
], function(
	$,
	SQ,
	Util,
	ClassroomGradeModel,
	AddClassroomGradeForm,
	Q,
	jGrowl
) {
	'use strict';

	return function AddAccountTypeController(option) {
		var _me = this;
		var _util = new Util();
		var _classroomGradeModel = new ClassroomGradeModel();
		var _addClassroomGradeForm = new AddClassroomGradeForm();

		(function _init() {
			_addClassroomGradeForm.initialize($('.admin-content-wrapper'));
			_addClassroomGradeForm.setListener('add_classroom_grade', _addClassroomGrade);
		})();

		function _addClassroomGrade(data) {
			_classroomGradeModel.addClassroomGrade(data.school_id, data.classroom_grade.name, data.classroom_grade.display_name).then(
				function(response) {
					if (response.success) {
						console.log('success');
						$.jGrowl('Classroom Grade is added successfully<br /><br /><a href="/admin/classroomGrade">Click here to view your Classroom grade</a>', {header: 'Success'});
					} else {
						$.jGrowl('Unable to add classroom grade', {header: 'Error'});
					}
				}
			);
		};
	}
});
