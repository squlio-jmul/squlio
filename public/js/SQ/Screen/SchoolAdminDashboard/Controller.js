define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Screen/SchoolAdminDashboard/Views/DashboardPage',
	'ThirdParty/q'
], function(
	$,
	SQ,
	Util,
	DashboardPage,
	Q
) {
	'use strict';

	return function SchoolAdminDashboardController(option) {
		var _me = this;
		var _util = new Util();
		var _dashboardPage = new DashboardPage();

		(function _init() {
			_dashboardPage.initialize($('.school-admin-content-wrapper'));
		})();
	}
});
