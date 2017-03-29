define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function DashboardForm() {
		var _me = this;
		var _util = new Util();
		var _$dashboard_page = null;
		var screenHeight = $(window).height();

		(function _init() {
		})();

		this.initialize = function($e) {
			_$dashboard_page = $e;
			var contentHeight = screenHeight - 125;
			_$dashboard_page.find('.school-admin-main-content').css('min-height', contentHeight);
		};
	}
});
