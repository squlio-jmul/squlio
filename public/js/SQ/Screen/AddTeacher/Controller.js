define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Screen/AddTeacher/Views/AddTeacherForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui',
	'jgrowl',
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	AddTeacherForm,
	Q,
	jgrowl
) {
	'use strict';

	return function AddTeacherController(option) {
		var _me = this;
		var _util = new Util();
		var _teacherModel = new TeacherModel();
		var _addTeacherForm = new AddTeacherForm();

		(function _init() {
			_addTeacherForm.initialize($('.school-admin-content-wrapper'));
			_addTeacherForm.setListener('add_teacher', _addTeacher);
		})();

		function _addTeacher(data) {
			_teacherModel.addTeacher(data.status, data.gender, data.teacher.school_id, data.teacher.username, data.teacher.email, data.teacher.password, data.teacher.first_name, data.teacher.last_name, data.teacher.phone, data.teacher.address, data.teacher.birthday).then(
				function(response) {
					if (response.success) {
						window.location.reload();
					} else {
						$.jGrowl('Unable to add teacher', {header: 'Error'});
					}
				}
			);
		}
	}
});
