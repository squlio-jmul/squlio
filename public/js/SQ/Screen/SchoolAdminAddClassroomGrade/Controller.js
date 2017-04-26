define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/ClassroomGrade',
	'SQ/Screen/SchoolAdminAddClassroomGrade/Views/AddClassroomGradeForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomGradeModel,
	AddClassroomGradeForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAddClassroomGradeController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _classroomGradeModel = new ClassroomGradeModel();
		var _addClassroomGradeForm = new AddClassroomGradeForm();

		(function _init() {
			_addClassroomGradeForm.initialize($('#add-classroom-grade-form'));
			_addClassroomGradeForm.setListener('add_classroom_grade', _addClassroomGrade);
		})();

		function _addClassroomGrade(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomGradeModel.add(data).then(
				function(classroom_grade_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (classroom_grade_id) {
						$.jGrowl('Classroom grade is added successfully', {header: 'Success'});
						window.location = '/school_admin/edit_classroom_grade/' + classroom_grade_id;
					} else {
						$.jGrowl('Unable to add this classroom grade', {header: 'Error'});
					}
				}
			);
		}
	}
});
