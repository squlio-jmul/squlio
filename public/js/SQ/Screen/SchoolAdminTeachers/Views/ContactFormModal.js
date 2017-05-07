define(
	[
		'jquery',
		'Global/SQ',
		'SQ/Broadcaster',
		'SQ/Util',
		'ThirdParty/jquery.validate'
	],
	function(
		$,
		SQ,
		Broadcaster,
		Util
	) {

		'use_strict';

		return function ContactFormModal() {

			var _me = this;
			var _$contact_form_modal = null;
			var _util = new Util();

			SQ.mixin(_me, new Broadcaster(['send_message']));

			(function _init() {
			})();

			this.initialize = function($e) {
				_$contact_form_modal = $e;
				$e.find('.sq-contact-form').validate({
					rules: {
						title: {
							required: true,
							maxlength: 255
						},
						message: {
							required: true,
							minlength: 30
						}
					},
					submitHandler: function(form, event) {
						event.preventDefault();
						var _contact_data = _util.serializeJSON($(form));
						_me.broadcast('send_message', _contact_data);
					}
				});
				_$contact_form_modal.on('hidden.bs.modal', function () {
					_$contact_form_modal.find('label.error').remove();
					_$contact_form_modal.find('.sq-contact-form').trigger('reset');
				})
			};

			this.show = function() {
				_$contact_form_modal.modal('show');
			};

			this.hide = function() {
				_$contact_form_modal.modal('hide');
			};

			this.setTitle = function(title) {
				_$contact_form_modal.find('.modal-title').text(title);
			};
		};
	}
);
