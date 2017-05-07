define(
	[
		'jquery',
		'Global/SQ',
		'SQ/Screen/SchoolAdminMessages/Views/IncomingMessage',
		'SQ/Screen/SchoolAdminMessages/Views/OutgoingMessage',
		'SQ/Model/SchoolAdminTeacherContact',
		'underscore',
		'text!../../Template/loading.tmpl',
		'SQ/Util',
		'ThirdParty/jquery.jgrowl.min'
	],
	function(
		$,
		SQ,
		IncomingMessage,
		OutgoingMessage,
		SchoolAdminTeacherContactModel,
		_,
		loadingTemplate,
		Util,
		jGrowl
	) {
		'use strict';

		return function SchoolAdminMessages(options) {

			var _me = this;
			var _incomingMessage = new IncomingMessage();
			var _outgoingMessage = new OutgoingMessage();
			var _schoolAdminTeacherContactModel = new SchoolAdminTeacherContactModel();
			var _school_admin_id = options.school_admin_id;

			var _coUtil = new Util();

			(function _init() {
				_incomingMessage.initialize($('#incoming'));
				_incomingMessage.setListener('display_incoming_message', _displayIncomingMessage);
				_incomingMessage.setListener('view_all_incoming', _repopulateIncoming);
				_incomingMessage.setListener('send_message', _sendMessage);

				_outgoingMessage.initialize($('#outgoing'));
				_outgoingMessage.setListener('display_outgoing_message', _displayOutgoingMessage);
				_outgoingMessage.setListener('view_all_outgoing', _repopulateOutgoing);

				_repopulateIncoming();

				$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
					var _$target = $(e.target);
					if (_$target.text() == 'Outgoing Messages') {
						_repopulateOutgoing();
					} else {
						_repopulateIncoming();
					}
				})
			})(options);

			function _displayIncomingMessage(contact_id) {
				$('body').append(_.template(loadingTemplate));
				_schoolAdminTeacherContactModel.get({id: contact_id}, {}, {}, null, null, {teacher: true}).then(
					function(school_admin_teacher_contacts) {
						if (school_admin_teacher_contacts.length) {
							var _school_admin_teacher_contact = school_admin_teacher_contacts[0];
							_schoolAdminTeacherContactModel.update(contact_id, {message_read: 1}).then(
								function(success) {
									$('body').find('.sq-loading-overlay').remove();
									if (success) {
										var _num_new_messages = parseInt($('.sq-badge.num-messages').text());
										if (!_school_admin_teacher_contact.message_read) {
											_num_new_messages -= 1;
										}
										if (_num_new_messages) {
											$('.num-messages').text(_num_new_messages);
										} else {
											$('.num-messages').hide();
										}
										_incomingMessage.displayMessage(_school_admin_teacher_contact);
									} else {
										$.jGrowl('Unable to view this message.', {header: 'Error'});
									}
								}
							);
						} else {
							$('body').find('.sq-loading-overlay').remove();
							$.jGrowl('Unable to view this message.', {header: 'Error'});
						}
					}
				);
			}

			function _repopulateIncoming() {
				$('body').append(_.template(loadingTemplate));
				_schoolAdminTeacherContactModel.get({school_admin: _school_admin_id, direction: 'teacher_to_school_admin'}, {}, {created_on: 'desc'}, null, null, {teacher: true}).then(
					function(school_admin_teacher_contacts) {
						$('body').find('.sq-loading-overlay').remove();
						_incomingMessage.populateTable(school_admin_teacher_contacts);
					}
				);
			}

			function _displayOutgoingMessage(contact_id) {
				$('body').append(_.template(loadingTemplate));
				_schoolAdminTeacherContactModel.get({id: contact_id}, {}, {}, null, null, {teacher: true}).then(
					function(school_admin_teacher_contacts) {
						$('body').find('.sq-loading-overlay').remove();
						if (school_admin_teacher_contacts.length) {
							var _school_admin_teacher_contact = school_admin_teacher_contacts[0];
							_outgoingMessage.displayMessage(_school_admin_teacher_contact);
						} else {
							$.jGrowl('Unable to view this message.', {header: 'Error'});
						}
					}
				);
			}

			function _repopulateOutgoing() {
				$('body').append(_.template(loadingTemplate));
				_schoolAdminTeacherContactModel.get({school_admin: _school_admin_id, direction: 'school_admin_to_teacher'}, {}, {created_on: 'desc'}, null, null, {teacher: true}).then(
					function(school_admin_teacher_contacts) {
						$('body').find('.sq-loading-overlay').remove();
						_outgoingMessage.populateTable(school_admin_teacher_contacts);
					}
				);
			}

			function _sendMessage(data) {
				$('body').append(_.template(loadingTemplate));
				var _add_data = {
					school_admin_id: _school_admin_id,
					teacher_id: data.teacher_id,
					direction: 'school_admin_to_teacher',
					title: data.title,
					message: data.message
				};
				_schoolAdminTeacherContactModel.add(_add_data).then(
					function(school_admin_teacher_contact_id){
						$('body').find('.sq-loading-overlay').remove();
						if (school_admin_teacher_contact_id) {
							$.jGrowl('Your message has been sent.', {header: 'Success'});
							_incomingMessage.sendMessageSuccess();
						} else {
							$.jGrowl('Unable to contact this teacher.', {header: 'Error'});
						}
					}
				);
			}
		};
	}
);
