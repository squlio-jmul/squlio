define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/similar_guardian.tmpl',
	'text!./template/existing_guardian.tmpl',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	SimilarGuardianTemplate,
	ExistingGuardianTemplate,
	jGrowl
) {
	'use strict';

	return function GuardiansTab() {

		var _me = this;
		var _util = new Util();
		var _$guardians_tab = null;
		var _selected_guardian_ids = [];
		var _step_1_data = {};

		SQ.mixin(_me, new Broadcaster(['verify_email', 'select_guardian', 'add_guardian']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$guardians_tab = $e;

			_$guardians_tab.find('#add-guardian-form-step-1').validate({
				rules: {
					email: {
						required: true,
						email: true
					}
				},
				messages: {
					email: 'Please enter a valid email address'
				},
				submitHandler: function(form) {
					_step_1_data = _util.serializeJSON($(form));
					_me.broadcast('verify_email', _step_1_data);
				}
			});

			_$guardians_tab.find('#add-guardian-form-step-2').validate({
				rules: {
					password: {
						required: true
					},
					first_name: {
						required: true
					},
					last_name: {
						required: true
					},
					type: {
						required: true
					},
					phone: {
						required: true,
						number: true
					}
				},
				messages: {
					phone: 'Please enter a valid phone number'
				},
				submitHandler: function(form) {
					var _add_guardian_data = _util.serializeJSON($(form));
					_add_guardian_data.email = _step_1_data.email;
					_add_guardian_data.active = (_add_guardian_data.status == 'active') ? 1 : 0;
					_me.broadcast('add_guardian', _add_guardian_data);
				}
			});

			_setListeners($e);
			_setGuardianListener($e);
		};

		this.setSelectedGuardianIds = function(ids) {
			_selected_guardian_ids = ids;
		};

		this.displayStep2 = function() {
			_$guardians_tab.find('.add-guardian-form-step-1-container').hide();
			_$guardians_tab.find('.add-guardian-form-step-2-container').fadeIn(300);
		};

		this.displayStep1Error = function(error_msg) {
			_$guardians_tab.find('#add-guardian-form-step-1 [name="email"]').siblings('label.error').remove();
			_$guardians_tab.find('#add-guardian-form-step-1 [name="email"]').after('<label class="error" for="email">' + error_msg + '</label>');
		};

		this.displaySimilarGuardian = function(guardian) {
			_$guardians_tab.find('#add-guardian-form-step-1 [name="email"]').after('<label class="error" for="email">This email is taken.</label>');
			guardian.type = _util.ucfirst(guardian.type);
			var _$similar_guardian = $(_.template(SimilarGuardianTemplate, {guardian: guardian}));
			_$guardians_tab.find('.similar-guardian-container').append(_$similar_guardian);

			_$similar_guardian.find('.no-similar-guardian').on('click', function() {
				_$guardians_tab.find('.similar-guardian-container').empty();
			});

			_$similar_guardian.find('.select-guardian').on('click', function() {
				var _guardian_id = $(this).attr('data-guardian-id');
				_me.broadcast('select_guardian', _guardian_id);
			});
		};

		this.appendNewGuardian = function(guardian_student) {
			var _$existing_guardian = $(_.template(ExistingGuardianTemplate, {guardian_student: guardian_student}));
			_$guardians_tab.find('.guardians-list-container').append(_$existing_guardian);
			_setGuardianListener(_$existing_guardian);

			_step_1_data = {};
			_$guardians_tab.find('#add-guardian-form-step-1, #add-guardian-form-step-2').trigger('reset');
			_$guardians_tab.find('#add-guardian-form-step-1 label.error, #add-guardian-form-step-2 label.error').remove();
			_$guardians_tab.find('.similar-guardian-container').empty();
			_$guardians_tab.find('.add-guardian-form-step-1-container').show();
			_$guardians_tab.find('.add-guardian-form-step-2-container').hide();
			_$guardians_tab.find('.add-guardian-form-container, .no-guardian-container').hide();
			_$guardians_tab.find('.add-guardian-container, .guardians-list-container').fadeIn(300);
		};

		this.removeGuardianStudent = function(guardian_student_id) {
			_$guardians_tab.find('.guardians-list-container .existing-guardian-container-' + guardian_student_id).remove();
			if (!_$guardians_tab.find('.guardians-list-container .existing-guardian-container').length) {
				_$guardians_tab.find('.no-guardian-container').fadeIn(300);
			}
		};

		function _setListeners($e) {
			$e.find('.add-guardian').on('click', function() {
				$e.find('.add-guardian-form-container').fadeIn(300);
				$e.find('.add-guardian-container, .guardians-list-container, .no-guardian-container').hide();
			});

			$e.find('.add-guardian-form-step-1-container .cancel').on('click', function(e) {
				e.preventDefault();
				$e.find('.add-guardian-form-container').hide();
				$e.find('.add-guardian-container, .guardians-list-container, .no-guardian-container').fadeIn(300);
				$e.find('#add-guardian-form-step-1 label.error').remove();
				$e.find('#add-guardian-form-step-1').trigger('reset');
			});

			$e.find('.sq-view-password').on('click', function() {
				var _$self = $(this);
				if (_$self.siblings('[name="password"]').attr('type') == 'password') {
					_$self.siblings('[name="password"]').attr('type', 'text');
				} else {
					_$self.siblings('[name="password"]').attr('type', 'password');

				}
			});
		}

		function _setGuardianListener($e) {
			$e.find('.remove-guardian').on('click', function() {
				var _guardian_student_id = $(this).attr('data-guardian-student-id');
				_me.broadcast('remove_guardian', {guardian_student_id: _guardian_student_id});
			});

			$e.find('.edit-guardian').on('click', function() {
				var _guardian_id = $(this).attr('data-guardian-id');
				_me.broadcast('get_guardian', {guardian_id: _guardian_id});
			});

		}
	}
});
