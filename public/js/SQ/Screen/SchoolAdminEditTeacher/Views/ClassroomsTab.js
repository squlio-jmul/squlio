define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/add_classroom.tmpl',
	'text!./template/existing_classroom.tmpl',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	AddClassroomTemplate,
	ExistingClassroomTemplate,
	jGrowl
) {
	'use strict';

	return function ClassroomsTab(classrooms, selected_classroom_ids) {

		var _me = this;
		var _util = new Util();
		var _$classrooms_tab = null;
		var _classrooms = classrooms;
		var _selected_classroom_ids = selected_classroom_ids;
		var _add_classroom_form_opened = false;

		SQ.mixin(_me, new Broadcaster(['add_classroom', 'remove_classroom', 'set_primary']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$classrooms_tab = $e;
			_setListeners($e);
			_setClassroomListener($e);
		};

		this.setSelectedClassroomIds = function(selected_classroom_ids) {
			_selected_classroom_ids = selected_classroom_ids;
		};

		this.appendClassroom = function(classroom_teacher) {
			var _$existing_classroom_template = $(_.template(ExistingClassroomTemplate, {classroom_teacher: classroom_teacher}));
			_$classrooms_tab.find('.classrooms-list-container').find('.add-teacher-to-class-container').remove();
			_$classrooms_tab.find('.classrooms-list-container').append(_$existing_classroom_template);
			_$classrooms_tab.find('.no-classroom-container').hide();
			_add_classroom_form_opened = false;
			_setClassroomListener(_$existing_classroom_template);
		};

		this.displayAsPrimary = function(classroom_teacher_id) {
			_$classrooms_tab.find('.set-primary-' + classroom_teacher_id).hide();
			_$classrooms_tab.find('.is-primary-' + classroom_teacher_id).show();
		};

		this.removeClassroom = function(classroom_teacher_id) {
			_$classrooms_tab.find('.existing-classroom-container-' + classroom_teacher_id).remove();
		};

		function _setListeners($e) {
			$e.find('.add-classroom').on('click', function() {
				if (!_classrooms.length) {
					$.jGrowl('Currently you do not have any classroom in the school. Click <a href="/school_admin/add_classroom">here</a> to add one.', {header: 'Error'});
					return false;
				}
				if (_add_classroom_form_opened) {
					return false;
				}
				if (_selected_classroom_ids.length == _classrooms.length) {
					$.jGrowl('No more available classroom.<br /><a href="/school_admin/add_classroom">Click here to add new classroom</a>', {header: 'Error'});
					return false;
				}
				var _$add_classroom_template = $(_.template(AddClassroomTemplate, {classrooms: _classrooms, selected_classroom_ids: _selected_classroom_ids}));
				_add_classroom_form_opened = true;
				$e.find('.classrooms-list-container').append(_$add_classroom_template);
				$e.find('.no-classroom-container').hide();

				_$add_classroom_template.find('.cancel').on('click', function(e) {
					e.preventDefault();
					$(e.target).closest('.add-teacher-to-class-container').remove();
					if (!_selected_classroom_ids.length) {
						_$classrooms_tab.find('.no-classroom-container').fadeIn(300);
					}
					_add_classroom_form_opened = false;
				});

				_$add_classroom_template.find('.add-classroom-form').validate({
					rules: {
						classroom_id: {
							required: true
						}
					},
					submitHandler: function(form) {
						var _add_classroom_data = _util.serializeJSON($(form));
						_add_classroom_data.is_primary = _$add_classroom_template.find("[name='is_primary']").val() == 'y' ? 1 : 0;
						_me.broadcast('add_classroom', _add_classroom_data);
					}
				});
			});
		}

		function _setClassroomListener($e) {
			$e.find('.set-primary').on('click', function() {
				var _classroom_teacher_id = $(this).attr('data-classroom-teacher-id');
				_me.broadcast('set_primary', _classroom_teacher_id);
			});

			$e.find('.remove-classroom').on('click', function() {
				var _classroom_teacher_id = $(this).attr('data-classroom-teacher-id');
				var _classroom_id = $(this).attr('data-classroom-id');

				_me.broadcast('remove_classroom', {classroom_teacher_id: _classroom_teacher_id, classroom_id: _classroom_id});
			});
		}
	}
});
