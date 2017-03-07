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
		var _$dashboard_form = null;
		var screenHeight = $(window).height();

		//SQ.mixin(_me, new Braodcaster(['data_amount']);

		(function _init() {
		})();

		this.initialize = function($e) {
			_$dashboard_form = $e;
			var contentHeight = screenHeight - 125;
			_$dashboard_form.find('.admin-main-content').css('min-height', contentHeight);
		};
	}
});
