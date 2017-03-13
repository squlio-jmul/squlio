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

	return function SchoolForm() {
		var _me = this;
		var _util = new Util();
		var _$school_form = null;
		var screenHeight = $(window).height();
		var table = null;

		(function _init() {
		})();

		this.initialize = function($e) {
			_$school_form = $e;
			var contentHeight = screenHeight - 125;
			_$school_form.find('.admin-main-content').css('min-height', contentHeight);
			_$school_form.find('.btn.btn-primary').click(function(){
				window.location.replace("addSchool");
			});
			/*_$school_form.find('#table').DataTable({
				'data': school_data,
				columnds: [
					{ title: "ID"},
					{ title: "Name"},
					{ title: "Principle"},
					{ title: "Admins"},
					{ title: "Students"},
					{ title: "Classroom"},
					{ title: "Status"}
				]
			});*/
		};
	}
});
