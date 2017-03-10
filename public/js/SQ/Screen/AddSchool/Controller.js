define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	//'SQ/Model/School',
	'SQ/Screen/AddSchool/Views/AddSchoolForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
//	SchoolModel,
	AddSchoolForm,
	Q
) {
	'use strict';

	return function AddSchoolController(option) {
		var _me = this;
		var _util = new Util();
	//	var _schoolModel = new SchoolModel();
		var _addSchoolForm = new AddSchoolForm();

		(function _init(){
			_addSchoolForm.initialize($('.admin-main-content'));
			_addSchoolForm.setListener('add_school', _add_school);
		})();

		function _add_school(data) {
		};
	}
});
