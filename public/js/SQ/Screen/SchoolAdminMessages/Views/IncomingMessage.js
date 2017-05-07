define(
	[
		'jquery',
		'Global/SQ',
		'SQ/Broadcaster',
		'underscore',
		'text!./template/incomingMessageRows.tmpl',
		'SQ/Util',
		'ThirdParty/dateformat'
	],
	function(
		$,
		SQ,
		Broadcaster,
		_,
		IncomingMessageRowsTemplate,
		Util,
		dateFormat
	) {

		'use_strict';

		return function IncomingMessage() {

			var _me = this;
			var _$incoming_message = null;
			var _util = new Util();

			SQ.mixin(_me, new Broadcaster(['display_incoming_message', 'view_all_incoming', 'send_message']));

			(function _init() {
			})();

			this.initialize = function($e) {
				_$incoming_message = $e;
				_setTableListeners($e);
				_setViewMessageListeners($e);
			};

			this.displayMessage = function(school_admin_teacher_contact) {
				var _created_on = new Date(_util.utcToLocal(school_admin_teacher_contact.created_on.date));
				school_admin_teacher_contact.created_on.date = _created_on.format('mmm d, yyyy h:MM TT');

				_$incoming_message.find('.from').text(school_admin_teacher_contact.teacher.first_name + ' ' + school_admin_teacher_contact.teacher.last_name);
				_$incoming_message.find('.from').attr('data-teacher-id', school_admin_teacher_contact.teacher.id);
				_$incoming_message.find('.date').text(school_admin_teacher_contact.created_on.date);
				_$incoming_message.find('.title').text(school_admin_teacher_contact.title);
				_$incoming_message.find('.content').text(school_admin_teacher_contact.message);
				_$incoming_message.find('#incoming-messages').hide();
				_$incoming_message.find('.sq-view-message-container').fadeIn(500);
			};

			this.populateTable = function(school_admin_teacher_contacts) {
				if (school_admin_teacher_contacts.length) {
					$.each(school_admin_teacher_contacts || [], function(index, satc) {
						var _created_on = new Date(_util.utcToLocal(satc.created_on.date));
						var _now = new Date();
						if (_created_on.getTime() < _now.getTime() - 86400000) {
							satc.created_on.date = _created_on.format('mmm d');
						} else {
							satc.created_on.date = _created_on.format('h:MM TT');
						}
					});
					_$incoming_message.find('#incoming-messages > tbody').empty().append(_.template(IncomingMessageRowsTemplate, {school_admin_teacher_contacts: school_admin_teacher_contacts}));
				}
				_$incoming_message.find('.sq-view-message-container, .sq-reply-message-container').hide();
				_$incoming_message.find('#incoming-messages').fadeIn(500);
				_setTableListeners(_$incoming_message);
			};

			this.sendMessageSuccess = function() {
				_$incoming_message.find('.sq-reply-message-container').hide();
				_$incoming_message.find('.sq-view-message-container').fadeIn(500);
			};

			function _setTableListeners($e) {
				$e.find('.view-message').on('click', function() {
					var _contact_id = $(this).attr('data-contact-id');
					_me.broadcast('display_incoming_message', _contact_id);
				});
			}

			function _setViewMessageListeners($e) {
				$e.find('.reply').on('click', function() {
					var _teacher_id = _$incoming_message.find('.sq-view-message-container').find('.from').attr('data-teacher-id');
					var _teacher_name = _$incoming_message.find('.sq-view-message-container').find('.from').text();
					var _title = _$incoming_message.find('.sq-view-message-container').find('.title').text();

					_$incoming_message.find('.sq-reply-message-container').find('label.error').remove();
					_$incoming_message.find('.sq-reply-message-container').find('.message').val('');
					_$incoming_message.find('.sq-reply-message-container').find('.to').attr('data-teacher-id', _teacher_id);
					_$incoming_message.find('.sq-reply-message-container').find('.to').text(_teacher_name);
					_$incoming_message.find('.sq-reply-message-container').find('.title').text(_title);
					_$incoming_message.find('.sq-view-message-container').hide();
					_$incoming_message.find('.sq-reply-message-container').fadeIn(500);
				});

				$e.find('.back').on('click', function(e) {
					e.preventDefault();
					_me.broadcast('view_all_incoming');
				});

				$e.find('.cancel').on('click', function(e) {
					e.preventDefault();
					_$incoming_message.find('.sq-reply-message-container').hide();
					_$incoming_message.find('.sq-view-message-container').fadeIn(500);
				});

				$e.find('.send').on('click', function() {
					var _message = _$incoming_message.find('.sq-reply-message-container').find('.message').val();
					_$incoming_message.find('.sq-reply-message-container').find('label.error').remove();
					if (_message.length < 30) {
						_$incoming_message.find('.sq-reply-message-container').find('.message').after('<label for="message" class="error">Please enter at least 30 characters.</label>');
						return false;
					}
					var _teacher_id = _$incoming_message.find('.sq-reply-message-container').find('.to').attr('data-teacher-id');
					var _title = _$incoming_message.find('.sq-reply-message-container').find('.title').text();
					_me.broadcast('send_message', {teacher_id: _teacher_id, title: _title, message: _message});
				});
			}
		};
	}
);
