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

	return function SettingsForm() {
		var _me = this;
		var _util = new Util();
		var _$settings_form = null;
		var screenHeight =  $(window).height();

		//SQ.mixin(_me, new Braodcaster(['data_amount']);

		(function _init() {
		})();

		this.initialize = function($e) {
			_$settings_form = $e;
			var contentHeight = screenHeight - 125;
			_$settings_form.find('.admin-main-content').css('min-height', contentHeight);
			_$settings_form.find('.btn.btn-primary').click(function(){
				window.location.replace("addType");
			});
		};
	}
});
