define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Syllabus',
	'SQ/Screen/ViewSyllabus/Views/SyllabusTable',
	'ThirdParty/q',
	'ThirdParty/jquery.dataTables.min',
], function(
	$,
	SQ,
	Util,
	SyllabusModel,
	SyllabusTable,
	Q
) {
	'use strict';

	return function ViewSyllabusController(option) {
		var _me = this;
		var _util = new Util();
		var _syllabusModel = new SyllabusModel();
		var _syllabusTable = new SyllabusTable();


		(function _init() {
			_syllabusTable.initialize($('#viewsyllabus-container'));
			_syllabusTable.setListener('classroom_dropdown',  _displayTable);
			_syllabusTable.setListener('term_dropdown', _displayTable);
		}) ();

		function _displayTable(data) {

			console.log(data);
			var classroom_id = data[0];
			var term_id = data[1];
			_syllabusTable.clearError();
			_syllabusModel.getClassroomData(classroom_id, term_id).then(
				function(response) {
					if (response.success) {
						console.log(response.syllabus_data);
						console.log('test');
						_syllabusTable.displayTable(response.syllabus_data, response.classroom_id, response.term_id);
					} else {
						_syllabusTable.displayError('Table can not be displayed');
					}
				}
			);
		};
	}
});
