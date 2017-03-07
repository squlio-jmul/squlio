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
		var screenwidth =  $(window).height();

		//SQ.mixin(_me, new Braodcaster(['data_amount']);

		(function _init() {
		})();

		this.initialize = function($e) {
			_$settings_form = $e;
			_$settings_form.find('.admin-content').css('min-height', screenwidth);
		};
	}
});
