define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	//'SQ/Model/School',
	'SQ/Screen/School/Views/SchoolForm',
	'ThirdParty/q',
	'ThirdParty/jquery.dataTables.min'
], function(
	$,
	SQ,
	Util,
	//SchoolModel,
	SchoolForm,
	Q
) {
	'use strict';

	return function SchoolController(option) {
		var _me = this;
		var _util = new Util();
		//var _schoolModel = new SchoolModel();
		var _schoolForm = new SchoolForm();

		(function _init() {
			_schoolForm.initialize($('.admin-content-wrapper'));
		})();

		/*function _displayTable(data) {
			_schoolModel.getSchoolData().then(
				function(response) {
					if (response.success) {
						_schoolForm.displayTable(response.school_data);
					} else {
					}
				}
			);
		};*/
	}
});
