define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/add_teacher.tmpl',
	'text!./template/new_teacher.tmpl',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	AddTeacherTemplate,
	NewTeacherTemplate,
	jGrowl
) {
	'use strict';

	return function TeachersTab(teachers, selected_teacher_ids) {

		var _me = this;
		var _util = new Util();
		var _$teachers_tab = null;
		var _teachers = teachers;
		var _selected_teacher_ids = selected_teacher_ids;
		var _add_teacher_form_opened = false;

		SQ.mixin(_me, new Broadcaster(['add_teacher', 'delete_teacher', 'set_primary_teacher']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$teachers_tab = $e;
			_setListeners($e);
		};

		this.setSelectedTeacherIds = function(selected_teacher_ids) {
			_selected_teacher_ids = selected_teacher_ids;
		};

		this.appendNewTeacher = function(classroom_teacher) {
			var _$new_teacher_template = $(_.template(NewTeacherTemplate, {classroom_teacher: classroom_teacher}));
			_$teachers_tab.find('.teachers-list-container').find('.add-teacher-to-class-container').remove();
			_$teachers_tab.find('.teachers-list-container').append(_$new_teacher_template);
			_$teachers_tab.find('.no-teacher-container').hide();
			_add_teacher_form_opened = false;
		};

		function _setListeners($e) {
			$e.find('.add-teacher').on('click', function() {
				if (!_teachers.length) {
					$.jGrowl('Currently you do not have any teacher in the school. Click <a href="/school_admin/add_teacher">here</a> to add one.', {header: 'Error'});
					return false;
				}
				if (_add_teacher_form_opened) {
					return false;
				}
				if (_selected_teacher_ids.length == _teachers.length) {
					$.jGrowl('All teachers have been added to this class.', {header: 'Error'});
					return false;
				}
				var _$add_teacher_template = $(_.template(AddTeacherTemplate, {teachers: _teachers, selected_teacher_ids: _selected_teacher_ids}));
				_add_teacher_form_opened = true;
				$e.find('.teachers-list-container').append(_$add_teacher_template);
				$e.find('.no-teacher-container').hide();

				_$add_teacher_template.find('.cancel').on('click', function(e) {
					e.preventDefault();
					$(e.target).closest('.add-teacher-to-class-container').remove();
					if (!_selected_teacher_ids.length) {
						_$teachers_tab.find('.no-teacher-container').fadeIn(300);
					}
					_add_teacher_form_opened = false;
				});

				_$add_teacher_template.find('.add-teacher-form').validate({
					rules: {
						teacher_id: {
							required: true
						}
					},
					submitHandler: function(form) {
						var _add_teacher_data = _util.serializeJSON($(form));
						_add_teacher_data.is_primary = _$add_teacher_template.find("[name='is_primary']").val() == 'y' ? 1 : 0;
						_me.broadcast('add_teacher', _add_teacher_data);
					}
				});
			});
		}
	}
});
