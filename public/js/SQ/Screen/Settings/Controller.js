define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Admin',
	'SQ/Screen/Settings/Views/SettingsForm',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	AdminModel,
	SettingsForm,
	Q
) {
	'use strict';

	return function SettingsController(option) {
		var _me = this;
		var _util = new Util();
		var _adminModel = new AdminModel();
		var _settingsForm = new SettingsForm();

		(function _init() {
			_settingsForm.initialize($('.admin-content-wrapper'));
		})();
	}
});
