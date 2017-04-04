define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.dataTables.min'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function StudentTable() {
		var _me = this;
		var _util = new Util();
		var _$student_table = null;
		var screenHeight = $(window).height();
		var _table = null;

		(function _init() {
		})();

		this.initialize = function($e) {
			_$student_table = $e;
			var contentHeight = screenHeight - 125;
			_$student_table.find('.school-admin-main-content').css('min-height', contentHeight);
			_$student_table.find('.btn.btn-primary').click(function(){
				window.location.replace("addStudent");
			});
		}

	}
});