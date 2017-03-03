define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery-ui'
], function(
		$,
		SQ,
		Broadcaster,
		Util
) {
	//'use strict';

	return function SyllabusForm() {
		var _me = this;
		var _util = new Util();
		var _$syllabus_form = null;

		SQ.mixin(_me, new Broadcaster(['add_syllabus']));

		(function _init() {
		}) ();

		this.initialize = function($e) {
			_$syllabus_form = $e;
			_$syllabus_form.validate({
				rules: {
					'title' : {
						required: true
					},
					'description': {
						required: true
					},
					'date': {
						required: true
					}
				},
				submitHandler: function(form){
					var term = _$syllabus_form.find('#term').val();
					var classroom = _$syllabus_form.find('#classroom').val();
					var classroom_subject = _$syllabus_form.find('#classroom_subject').val();
					var _syllabus_data_form = _util.serializeJSON($(form));
					console.log(term);
					console.log(classroom);
					console.log(classroom_subject);
					var _syllabus_data = [term, classroom, classroom_subject, _syllabus_data_form];
					console.log(_syllabus_data);
					_me.broadcast('add_syllabus', _syllabus_data);
				}
			});

			_$syllabus_form.find('#term').change(function(){
				var _term_id = $(this).val();
				if (_term_id == 1){
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						changeYear: true,
						yearRange: '2017: 2018',
						minDate: new Date(2017, 01 -1, 01),
						maxDate: new Date(2017, 06 -1, 01)
					});
				} else if (_term_id == 2) {
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						//destroy: true,
						changeMonth: true,
						changeYear: true,
						yearRange: '2017:2018',
						minDate: new Date(2017, 06 -1, 01),
						maxDate: new Date(2017, 12 -1, 31)
					});
				} else if (_term_id == 3) {
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						changeYear: true,
						yearRange: '2017: 2018',
						minDate: new Date(2018, 01 -1, 01),
						maxDate: new Date(2018, 06 -1, 01)
					});
				} else if (_term_id == 4) {
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						changeYear: true,
						yearRange: '2018:2019',
						minDate: new Date(2018, 06 -1, 01),
						maxDate: new Date(2018, 12 -1, 31)
					});
				} else if (_term_id == 6){
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						changeYear: true,
						yearRange: '2019:2020',
						minDate: new Date(2019, 01 -1, 01),
						maxDate: new Date(2019, 06 -1, 01)
					});
				} else if (_term_id == 19){
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						changeYear: true,
						yearRange: '2019:2020',
						minDate: new Date(2019, 06 -1, 01),
						maxDate: new Date(2019, 12 -1, 31)
					});
				} else if (_term_id == 20){
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						chageYear: true,
						yearRange: '2020:2021',
						minDate: new Date(2020, 01 -1, 01),
						maxDate: new Date(2020, 06 -1, 01)
					});
				} else if (_term_id ==21){
					$('#date').datepicker("destroy");
					$('#date').datepicker({
						changeMonth: true,
						changeYear: true,
						yearRange: '2020:2021',
						minDate: new Date(2020, 06 -1, 01),
						maxDate: new Date(2020, 12 -1, 31)
					});
				}
			});
		};

		this.displaySuccess = function(success_msg){
			_$syllabus_form.find('#success-container').html(success_msg);
		};

		this.clearError = function() {
			_$syllabus_form.find('.error-container').empty();
		};

		this.displayError = function(error_msg) {
			_$syllabus_form.find('.error-container').text(error_msg);
		};
	}
});
