define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Term',
	'SQ/Screen/SchoolAdminTerms/Views/TermsTable',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TermModel,
	TermsTable,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminTermsController(options) {
		var _me = this;
		var _util = new Util();
		var _termModel = new TermModel();
		var _termsTable = new TermsTable();
		var _school_id = options.school_id;

		(function _init() {
			_termsTable.initialize($('#terms-table-container'));
			$('body').append(_.template(loadingTemplate));
			_termModel.get({school: _school_id}, [], {name: 'asc'}).then(
				function(terms) {
					$('body').find('.sq-loading-overlay').remove();
					_termsTable.populate(terms);
				}
			);
		})();
	}
});
