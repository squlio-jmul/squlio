define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'jqueryui'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function AddAnnouncementForm() {

		var _me = this;
		var _util = new Util();
		var _$add_announcement_form = null;
		var _add_announcement_data = {};

		SQ.mixin(_me, new Broadcaster(['add_announcement', 'view_table']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_announcement_form = $e;
			$e.find('[name="start_date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$e.find('[name="end_date"]').datepicker({
				dateFormat: 'yy-mm-dd'
			});

			_$add_announcement_form.find('#add-announcement-form').validate({
				rules: {
					classroom_ids: {
						required: true
					},
					title: {
						required: true,
						maxlength: 120
					},
					content: {
						required: true,
						minlength: 30
					},
					start_date: {
						required: true
					},
					end_date: {
						required: true
					}
				},
				submitHandler: function(form) {
					_add_announcement_data = _util.serializeJSON($(form));
					var _classroom_ids = [];
					_$add_announcement_form.find('[name="classroom_ids"] option:selected').each(function() {
						_classroom_ids.push($(this).val());
					});
					_add_announcement_data.classroom_ids = _classroom_ids;
					_me.broadcast('add_announcement', _add_announcement_data);
				}
			});

			_setListeners($e);
		};

		this.show =  function() {
			_$add_announcement_form.fadeIn(300);
		};

		this.hide =  function() {
			_$add_announcement_form.find('#add-announcement-form').trigger('reset');
			_$add_announcement_form.find('label.error').remove();
			_$add_announcement_form.hide();
		};


		function _setListeners($e) {
			$e.find('.cancel').on('click', function(e) {
				e.preventDefault();
				_me.hide();
				_me.broadcast('view_table');
			});
		}
	}
});
