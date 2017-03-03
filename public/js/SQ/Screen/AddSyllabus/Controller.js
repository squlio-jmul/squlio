define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Syllabus',
	'SQ/Screen/AddSyllabus/Views/SyllabusForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui'
], function(
	$,
	SQ,
	Util,
	SyllabusModel,
	SyllabusForm,
	Q
) {
	'use strict';

	return function AddSyllabusController(option){
		var _me = this;
		var _util = new Util();
		var _syllabusModel = new SyllabusModel();
		var _syllabusForm = new SyllabusForm();

		(function _init(){
			_syllabusForm.initialize($('#addsyllabus-form'));
			_syllabusForm.setListener('add_syllabus', _add_syllabus);
		}) ();

		function _add_syllabus(data){
			console.log(data);
			var term_id = data[0];
			var classroom_id = data[1];
			var classroom_subject_id = data[2];
			var form = data[3];
			_syllabusModel.addSyllabus(term_id, classroom_id, classroom_subject_id, form.title, form.description, form.date).then(
				function(response){
					if (response.success){
						console.log('add success');
						_syllabusForm.displaySuccess('Data successfully inserted');
					} else {
						_syllabusForm.displayError('data cannot be inserted');
					}
				}
			);
		};
	}
});
