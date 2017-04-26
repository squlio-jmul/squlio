define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Term',
	'SQ/Screen/SchoolAdminEditTerm/Views/EditTermForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	TermModel,
	EditTermForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditTermController(options) {
		var _me = this;
		var _util = new Util();
		var _term_id = options.term_id;
		var _termModel = new TermModel();
		var _editTermForm = new EditTermForm();

		(function _init() {
			_editTermForm.initialize($('#edit-term-form'));
			_editTermForm.setListener('edit_term', _editTerm);
		})();

		function _editTerm(data) {
			$('body').append(_.template(loadingTemplate));
			_termModel.update(_term_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Term is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this term', {header: 'Error'});
					}
				}
			);
		}
	}
});
