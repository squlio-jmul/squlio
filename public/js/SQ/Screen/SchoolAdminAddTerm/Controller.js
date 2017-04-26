define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Term',
	'SQ/Screen/SchoolAdminAddTerm/Views/AddTermForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TermModel,
	AddTermForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAddTermController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _termModel = new TermModel();
		var _addTermForm = new AddTermForm();

		(function _init() {
			_addTermForm.initialize($('#add-term-form'));
			_addTermForm.setListener('add_term', _addTerm);
		})();

		function _addTerm(data) {
			$('body').append(_.template(loadingTemplate));
			_termModel.add(data).then(
				function(term_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (term_id) {
						$.jGrowl('Term is added successfully', {header: 'Success'});
						window.location = '/school_admin/edit_term/' + term_id;
					} else {
						$.jGrowl('Unable to add this term', {header: 'Error'});
					}
				}
			);
		}
	}
});
