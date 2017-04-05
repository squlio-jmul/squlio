define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	//'SQ/Model/Student',
	'SQ/Screen/AddStudent/Views/AddStudentForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui',
	'jgrowl',
], function(
	$,
	SQ,
	Util,
	//StudentModel,
	AddStudentForm,
	Q,
	jgrowl
) {
	'use strict';

	return function AddStudentController(option) {
		var _me = this;
		var _util = new Util();
		//var _studentModel = new StudentModel();
		var _addStudentForm = new AddStudentForm();

		(function _init() {
			_addStudentForm.initialize($('.school-admin-content-wrapper'));
			_addStudentForm.setListener('add_student', _addStudent);
		})();

		function _addStudent(data) {
			/*_studentModel.addStudent(data.status, data.gender, data.teacher.school_id, data.teacher.username, data.teacher.email, data.teacher.password, data.teacher.first_name, data.teacher.last_name, data.teacher.phone, data.teacher.address, data.teacher.birthday).then(
				function(response) {
					if (response.success) {
						window.location.reload();
					} else {
						$.jGrowl('Unable to add student', {header: 'Error'});
					}
				}
			);*/
		}
	}
});
