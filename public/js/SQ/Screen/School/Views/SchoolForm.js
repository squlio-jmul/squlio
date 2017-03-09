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

	return function SchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$school_form = null;
		var screenHeight = $(window).height();

		(function _init() {
		})();

		this.initialize = function($e) {
			_$school_form = $e;
			var contentHeight = screenHeight - 125;
			_$school_form.find('.admin-main-content').css('min-height', contentHeight);
			_$school_form.find('.btn.btn-primary').click(function(){
				window.location.replace("addSchool");
			});
		};
	}
});
