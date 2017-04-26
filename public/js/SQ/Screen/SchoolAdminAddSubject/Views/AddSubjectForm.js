define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'ThirdParty/jquery.validate',
	'ThirdParty/jquery.validate.additional-methods'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {
	'use strict';

	return function AddSubjectForm() {

		var _me = this;
		var _util = new Util();
		var _$add_subject_form = null;
		var _add_subject_data = {};

		SQ.mixin(_me, new Broadcaster(['add_subject']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$add_subject_form = $e;
			_$add_subject_form.validate({
				rules: {
					title: {
						required: true
					},
					classroom_grade_id: {
						required: true
					},
					description: {
						required: true
					},
					url: {
						pattern: /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/
					},
					video_url: {
						pattern: /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/
					}
				},
				messages: {
					url: 'Please enter a valid URL',
					video_url: 'Please enter a valid URL'
				},
				submitHandler: function(form) {
					_add_subject_data = _util.serializeJSON($(form));
					_me.broadcast('add_subject', _add_subject_data);
				}
			});
		};
	}
});
