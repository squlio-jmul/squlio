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

		return function ChangePasswordForm() {

			var _me = this;
			var _$change_password_form = null;
			var _sqUtil = new Util();

			SQ.mixin(_me, new Broadcaster(['change_password']));

			(function _init() {
			})();

			this.initialize = function($e) {
				_$change_password_form = $e;
				$e.find('.sq-change-password-form').validate({
					rules: {
						old_password: {
							required: true,
							remote: {
								url: '/ajax/login/passwordMatch',
								type: 'post',
								data: {login_id: $e.find('[name="login_id"]').val()}
							}
						},
						password: {
							required: true,
							minlength: 5
						},
						password_confirm: {
							required: true,
							minlength: 5,
							equalTo: ".sq-change-password-form [name=password]",
						}
					},
					messages: {
						old_password: {
							remote: "Password not match"
						},
					},
					submitHandler: function(form, event) {
						event.preventDefault();
						var _change_password_data = _sqUtil.serializeJSON($(form));
						_me.broadcast('change_password', _change_password_data);
					}
				});
			};

			this.reset = function() {
				_$change_password_form.find('.sq-change-password-form').trigger('reset');
			};
		};
	}
);
