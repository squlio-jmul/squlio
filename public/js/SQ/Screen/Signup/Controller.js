define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/SchoolAdmin',
	'SQ/Screen/Signup/Views/SignupForm',
	'ThirdParty/q',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Util,
	SchoolAdminModel,
	SignupForm,
	Q
) {
	'use strict'

	return function SignupController(option){
		var _me = this;
		var _util = new Util();
		var _schoolAdminModel = new SchoolAdminModel();
		var _signupForm = new SignupForm();

		(function _init() {
			_signupForm.initialize($('#signup-form'));
			_signupForm.setListener('add', _add);
		}) ();

		function _add(data){
			_signupForm.clearError();
			_schoolAdminModel.add(data.username, data.email, data.password, data.first_name, data.last_name).then(
				function(response) {
					if (response.success) {
						console.log('add success');
						_schoolAdminModel.successRegister(data.username, data.password).then(
							function(response) {
								if (response.success) {
									console.log('add success');
									window.location = response.redirect_page;
								} else {
									_signupForm.displayError('data cannot be inserted');
								}
							}
						);
					} else {
						console.log('add failed');
					}
				}
			);
		}
	}
});

