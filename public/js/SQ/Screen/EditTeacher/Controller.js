define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Teacher',
	'SQ/Screen/EditTeacher/Views/EditTeacherForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui',
	'jgrowl',
], function(
	$,
	SQ,
	Util,
	TeacherModel,
	EditTeacherForm,
	Q,
	jgrowl
) {
	'use strict';

	return function AddTeacherController(option) {
		var _me = this;
		var _util = new Util();
		var _teacherModel = new TeacherModel();
		var _editTeacherForm = new EditTeacherForm();

		(function _init() {
			_editTeacherForm.initialize($('.school-admin-content-wrapper'));
			_editTeacherForm.setListener('edit_teacher', _editTeacher);
		})();

		function _editTeacher(data) {
			console.log(data);
			_teacherModel.editTeacher(data.gender, data.teacher.login_id, data.teacher.id, data.teacher.school_id, data.teacher.username, data.teacher.email, data.teacher.password, data.teacher.first_name, data.teacher.last_name, data.teacher.phone, data.teacher.address, data.teacher.birthday).then(
				function(response) {
					if (response.success) {
						$.jGrowl('Teacher  successfully updated<br /><br /><a href="/school_admin/teacher">Click here to view your teacher</a>', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update teacher', {header: 'Error'});
					}
				}
			);
		}
	}
});
