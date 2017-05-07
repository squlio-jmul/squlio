define(
	[
		'jquery',
		'Global/SQ',
		'SQ/Broadcaster',
		'underscore',
		'text!./template/outgoingMessageRows.tmpl',
		'SQ/Util',
		'ThirdParty/dateformat'
	],
	function(
		$,
		SQ,
		Broadcaster,
		_,
		OutgoingMessageRowsTemplate,
		Util,
		dateFormat
	) {

		'use_strict';

		return function OutgoingMessage() {

			var _me = this;
			var _$outgoing_message = null;
			var _util = new Util();

			SQ.mixin(_me, new Broadcaster(['display_outgoing_message', 'view_all_outgoing']));

			(function _init() {
			})();

			this.initialize = function($e) {
				_$outgoing_message = $e;
				_setTableListeners($e);
				_setViewMessageListeners($e);
			};

			this.displayMessage = function(school_admin_teacher_contact) {
				var _created_on = new Date(_util.utcToLocal(school_admin_teacher_contact.created_on.date));
				school_admin_teacher_contact.created_on.date = _created_on.format('mmm d, yyyy h:MM TT');

				_$outgoing_message.find('.to').text(school_admin_teacher_contact.teacher.first_name + ' ' + school_admin_teacher_contact.teacher.last_name);
				_$outgoing_message.find('.date').text(school_admin_teacher_contact.created_on.date);
				_$outgoing_message.find('.title').text(school_admin_teacher_contact.title);
				_$outgoing_message.find('.content').text(school_admin_teacher_contact.message);
				_$outgoing_message.find('#outgoing-messages').hide();
				_$outgoing_message.find('.sq-view-message-container').fadeIn(500);
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
					_$outgoing_message.find('#outgoing-messages > tbody').empty().append(_.template(OutgoingMessageRowsTemplate, {school_admin_teacher_contacts: school_admin_teacher_contacts}));
				}
				_$outgoing_message.find('.sq-view-message-container').hide();
				_$outgoing_message.find('#outgoing-messages').fadeIn(500);
				_setTableListeners(_$outgoing_message);
			};

			function _setTableListeners($e) {
				$e.find('.view-message').on('click', function() {
					var _contact_id = $(this).attr('data-contact-id');
					_me.broadcast('display_outgoing_message', _contact_id);
				});
			}

			function _setViewMessageListeners($e) {
				$e.find('.back').on('click', function(e) {
					e.preventDefault();
					_me.broadcast('view_all_outgoing');
				});
			}
		};
	}
);
