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
		var _step_2_data = {};

		SQ.mixin(_me, new Broadcaster(['verify_email', 'select_guardian']));

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

			_$guardians_tab.find('#add-guardian-form-step-1, #add-guardian-form-step-2').trigger('reset');
			_$guardians_tab.find('#add-guardian-form-step-1 label.error, #add-guardian-form-step-2 label.error').remove();
			_$guardians_tab.find('.similar-guardian-container').empty();
			_$guardians_tab.find('.add-guardian-form-step-1-container').show();
			_$guardians_tab.find('.add-guardian-form-step-2-container').hide();
			_$guardians_tab.find('.add-guardian-form-container').hide();
			_$guardians_tab.find('.add-guardian-container, .guardians-list-container').fadeIn(300);
		};

		this.displayPickExistingGuardian = function(guardians) {
			_$guardians_tab.find('#pick-existing-guardian-form [name="guardian_id"] option').remove();
			_$guardians_tab.find('#pick-existing-guardian-form [name="guardian_id"]').append('<option value=""> - Select Guardian - </option>');
			$.each(guardians || [], function(index, guardian) {
				_$guardians_tab.find('#pick-existing-guardian-form [name="guardian_id"]').append('<option value="' + guardian.id + '">' + guardian.first_name + ' ' + guardian.last_name + '</option>');
			});
			_$guardians_tab.find('.add-guardian-option-container').hide();
			_$guardians_tab.find('.pick-existing-guardian-form-container').fadeIn(300);
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
		}

		function _setGuardianListener($e) {
			$e.find('.remove-guardian').on('click', function() {
				var _guardian_id = $(this).attr('data-guardian-id');
				_me.broadcast('remove_guardian', {guardian_id: _guardian_id});
			});

			$e.find('.edit-guardian').on('click', function() {
				var _guardian_id = $(this).attr('data-guardian-id');
				_me.broadcast('get_guardian', {guardian_id: _guardian_id});
			});

		}
	}
});
