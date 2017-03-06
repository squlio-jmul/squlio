define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Admin',
	'SQ/Screen/Dashboard/Views/DashboardForm',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	AdminModel,
	DashboardForm,
	Q
) {
	'use strict';

	return function DashboardController(option) {
		var _me = this;
		var _util = new Util();
		var _adminModel = new AdminModel();
		var _dashboardForm = new DashboardForm();

		(function _init() {
			_dashboardForm.initialize($('.admin-content-wrapper'));
			//_dashboardForm.setLitener('data_amount', _dataAmount);
		})();

		/*function _dataAmount(data) {
			_dashboardForm.clearError();
		}*/
	}
});
