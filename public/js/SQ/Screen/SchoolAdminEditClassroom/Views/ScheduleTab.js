define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/schedule_table.tmpl',
	'datatables',
	'jqueryui'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	ScheduleTableTemplate
) {
	'use strict';

	return function ScheduleTab() {

		var _me = this;
		var _util = new Util();
		var _$schedule_tab = null;
		var _schedule_table = null;
		var _add_schedule_data = {};

		SQ.mixin(_me, new Broadcaster(['add_schedule']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$schedule_tab = $e;
			$e.find('#add-schedule-form [name="date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});

			_$schedule_tab.find('#schedule-table-container').append(_.template(ScheduleTableTemplate));
			_schedule_table = _$schedule_tab.find('#schedule-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});

			_$schedule_tab.find('#add-schedule-form').validate({
				rules: {
					term_id: {
						required: true
					},
					subject_id: {
						required: true
					},
					date: {
						required: true,
						remote: {
							url: '/ajax/schedule/dateNotExist',
							type: 'post',
							data: {classroom_id: $e.find('[name="classroom_id"]').val()}
						}
					}
				},
				messages: {
					date: {
						remote: 'There is already a schedule exists on this date'
					}
				},
				submitHandler: function(form) {
					_add_schedule_data = _util.serializeJSON($(form));
					_me.broadcast('add_schedule', _add_schedule_data);
				}
			});

			_setListeners($e);
		};

		this.populate = function(schedules) {
			var _table_data = [];
			$.each(schedules || [], function(index, schedule) {
				var _date = new Date(schedule.date.date);
				_table_data.push(
					[
						'<input type="checkbox" name="check-schedule[]" value="' + schedule.id + '" />',
						schedule.id,
						schedule.term.name,
						schedule.subject.title,
						_date.getDate() + '/' + (_date.getMonth()+1) + '/' + _date.getFullYear(),
						'<button class="button delete-schedule" data-schedule-id="' + schedule.id + '">Delete</button>'
					]
				);
			});
			_schedule_table.rows.add(_table_data).draw();
		};

		this.viewTable = function() {
			_$schedule_tab.find('#add-schedule-container').hide();
			_$schedule_tab.find('.header, #schedule-table-container').fadeIn(300);
		};

		this.clearTable = function() {
			_schedule_table.clear().draw();
		};

		function _setListeners($e) {
			$e.find('.add-schedule').on('click', function() {
				$e.find('.header, #schedule-table-container').hide();
				$e.find('#add-schedule-form').trigger('reset');
				$e.find('#add-schedule-container').fadeIn(300);
			});

			$e.find('.cancel').on('click', function(e) {
				e.preventDefault();
				$e.find('#add-schedule-container').hide();
				$e.find('.header, #schedule-table-container').fadeIn(300);
			});

			$e.find('[name="term_id"]').on('change', function() {
				var _$self = $(this);
				$e.find('[name="date"]').val('');
				if ($(this).val()) {
					var _$selected_option = _$self.find('option:selected');
					var _start_date = _$selected_option.attr('data-start-date');
					var _end_date = _$selected_option.attr('data-end-date');
					$e.find('#add-schedule-form [name="date"]').datepicker('option', 'minDate', _start_date);
					$e.find('#add-schedule-form [name="date"]').datepicker('option', 'maxDate', _end_date);
				}
			});
		}
	}
});
