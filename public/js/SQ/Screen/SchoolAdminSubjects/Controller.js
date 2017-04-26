define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Subject',
	'SQ/Screen/SchoolAdminSubjects/Views/SubjectsTable',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	SubjectModel,
	SubjectsTable,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminSubjectsController(options) {
		var _me = this;
		var _util = new Util();
		var _subjectModel = new SubjectModel();
		var _subjectsTable = new SubjectsTable();
		var _school_id = options.school_id;

		(function _init() {
			_subjectsTable.initialize($('#subjects-table-container'));
			$('body').append(_.template(loadingTemplate));
			_subjectModel.get({school: _school_id}, {}, {}, null, null, {classroom_grade: true}).then(
				function(subjects) {
					$('body').find('.sq-loading-overlay').remove();
					_subjectsTable.populate(subjects);
				}
			);
		})();
	}
});
