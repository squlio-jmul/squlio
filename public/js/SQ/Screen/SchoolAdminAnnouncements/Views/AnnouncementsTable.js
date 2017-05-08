define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/announcements_table.tmpl',
	'datatables'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	AnnouncementsTableTemplate
) {
	'use strict';

	return function AnnouncementsTable() {

		var _me = this;
		var _util = new Util();
		var _$announcements_table = null;
		var _announcements_table = null;

		SQ.mixin(_me, new Broadcaster(['view_announcement', 'open_delete_modal']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$announcements_table = $e;
			_$announcements_table.append(_.template(AnnouncementsTableTemplate));
			_announcements_table = _$announcements_table.find('#announcements-table').DataTable({
				bProcessing: true,
				fnDrawCallback: function(oSettings) {
				}
			});
		};

		this.populate = function(announcements) {
			var _table_data = [];
			$.each(announcements || [], function(index, announcement) {
				var _created_on = new Date(_util.utcToLocal(announcement.created_on.date));
				_table_data.push(
					[
						'<input type="checkbox" name="check-announcement[]" value="' + announcement.id + '" />',
						announcement.id,
						announcement.classroom.name,
						announcement.title,
						_created_on.getDate() + '/' + (_created_on.getMonth()+1) + '/' + _created_on.getFullYear(),
						'<a class="view-announcement" data-announcement-id="' + announcement.id + '">View Details</a><a class="delete-announcement" data-announcement-id="' + announcement.id + '">Delete</a>'
					]
				);
			});
			_announcements_table.rows.add(_table_data).draw();
			_setRowListeners(_$announcements_table);
		};

		this.clearTable = function() {
			_announcements_table.clear().draw();
		};

		function _setRowListeners($e) {
			$e.find('.view-announcement').on('click', function(e) {
				e.preventDefault();
				var _$self = $(e.target);
				var _announcement_id = _$self.attr('data-announcement-id');
				_me.broadcast('view_announcement', _announcement_id);
			});
			$e.find('.delete-announcement').on('click', function(e) {
				e.preventDefault();
				var _$self = $(e.target);
				var _announcement_id = _$self.attr('data-announcement-id');
				_me.broadcast('open_delete_modal', _announcement_id);
			});

		}
	}
});
