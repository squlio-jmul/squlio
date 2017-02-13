define(
	['Global/SQ'],
	function(SQ) {
		'use strict';

		return function Broadcaster(registeredEvents) {

			var _registeredEvents = [];
			var _listeners = {};

			var _init = function(registeredEvents) {
				_registeredEvents = registeredEvents || [];
			};

			this.broadcast = function(eventToBroadcast, data) {
				for (var i in _listeners) {
					if (eventToBroadcast === i) {
						_listeners[i].forEach(function(j) {
							if (typeof data !== 'undefined') {
								j.apply(this, [data, eventToBroadcast]);
							} else {
								j.apply(this, [null, eventToBroadcast]);
							}
						});
					}
				}
			};

			this.setListener = function(event, callback) {
				var _isEventSet = false;

				for (var i in _listeners) {
					if (event === i) {
						_listeners[i].push(callback);
						_isEventSet = true;
					}
				}

				if (!_isEventSet) {
					_listeners[event] = [callback];
				}
			};

			_init(registeredEvents);
		};
	}
);
