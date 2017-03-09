define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Screen/School/Views/SchoolForm',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	SchoolForm,
	Q
) {
	'use strict';

	return function SchoolController(option) {
		var _me = this;
		var _util = new Util();
		var _schoolForm = new SchoolForm();

		(function _init() {
			_schoolForm.initialize($('.admin-content-wrapper'));
		})();
	}
});
