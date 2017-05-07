define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Announcement',
	'SQ/Screen/SchoolAdminAnnouncements/Views/AnnouncementsTable',
	'SQ/Screen/SchoolAdminAnnouncements/Views/AddAnnouncementForm',
	'SQ/Screen/SchoolAdminAnnouncements/Views/ViewDetailModal',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	AnnouncementModel,
	AnnouncementsTable,
	AddAnnouncementForm,
	ViewDetailModal,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAnnouncementsController(options) {
		var _me = this;
		var _util = new Util();
		var _announcementModel = new AnnouncementModel();
		var _announcementsTable = new AnnouncementsTable();
		var _addAnnouncementForm = new AddAnnouncementForm();
		var _viewDetailModal = new ViewDetailModal();
		var _school_id = options.school_id;

		(function _init() {
			_announcementsTable.initialize($('#announcements-table-container'));
			_announcementsTable.setListener('view_announcement', _viewAnnouncement);
			_announcementsTable.setListener('delete_announcement', _deleteAnnouncement);

			$('body').append(_.template(loadingTemplate));
			_announcementModel.get({school: _school_id}, [], {created_on: 'desc'}, null, null, {classroom: true}).then(
				function(announcements) {
					$('body').find('.sq-loading-overlay').remove();
					_announcementsTable.populate(announcements);
				}
			);

			_addAnnouncementForm.initialize($('#sq-school-admin-add-announcement-container'));
			_addAnnouncementForm.setListener('view_table', _viewTable);
			_addAnnouncementForm.setListener('add_announcement', _addAnnouncement);

			_viewDetailModal.initialize($('#sq-view-modal'));

			$('.add-announcement').on('click', function() {
				$('.header, #announcements-table-container').hide();
				_addAnnouncementForm.show();
			});
		})();

		function _viewTable() {
			$('.header, #announcements-table-container').fadeIn(300);
		}

		function _addAnnouncement(data) {
			$('body').append(_.template(loadingTemplate));
			data.school_id = _school_id;
			_announcementModel.addBulk(data).then(
				function(success) {
					if (success) {
						_announcementModel.get({school: _school_id}, [], {created_on: 'desc'}, null, null, {classroom: true}).then(
							function(announcements) {
								$('body').find('.sq-loading-overlay').remove();
								$.jGrowl('Announcement is added successfully', {header: 'Success'});
								$('.announcements-count').text(_util.addCommas(announcements.length) + ' Announcement' + ((announcements.length > 1) ? 's':''));
								_addAnnouncementForm.hide();
								_viewTable();
								_announcementsTable.clearTable();
								_announcementsTable.populate(announcements);
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to add announcement', {header: 'Error'});
					}
				}
			);
		}

		function _viewAnnouncement(announcement_id) {
			$('body').append(_.template(loadingTemplate));
			_announcementModel.get({id: announcement_id}, [], {}, null, null, {classroom: true}).then(
				function(announcements) {
					$('body').find('.sq-loading-overlay').remove();
					if (announcements.length) {
						_viewDetailModal.setModalTitle('Announcement for ' + announcements[0].classroom.name);
						_viewDetailModal.setContent(announcements[0]);
						_viewDetailModal.show();
					} else {
						$.jGrowl('Unable to get announcement detail', {header: 'Error'});
					}
				}
			);
		}

		function _deleteAnnouncement(announcement_id) {
			$('body').append(_.template(loadingTemplate));
			_announcementModel.delete({id: announcement_id}).then(
				function(success) {
					if (success) {
						_announcementModel.get({school: _school_id}, [], {created_on: 'desc'}, null, null, {classroom: true}).then(
							function(announcements) {
								$('body').find('.sq-loading-overlay').remove();
								$.jGrowl('Announcement is deleted successfully', {header: 'Success'});
								$('.announcements-count').text(_util.addCommas(announcements.length) + ' Announcement' + ((announcements.length > 1) ? 's':''));
								_addAnnouncementForm.hide();
								_viewTable();
								_announcementsTable.clearTable();
								_announcementsTable.populate(announcements);
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to delete announcement', {header: 'Error'});
					}
				}
			);
		}

	}
});
