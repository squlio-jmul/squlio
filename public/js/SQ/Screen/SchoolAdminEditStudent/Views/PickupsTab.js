define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util',
	'underscore',
	'text!./template/add_pickup.tmpl',
	'text!./template/existing_pickup.tmpl',
	'text!./template/edit_pickup.tmpl',
	'jgrowl',
	'ThirdParty/jquery.validate'
], function(
	$,
	SQ,
	Broadcaster,
	Util,
	_,
	AddPickupTemplate,
	ExistingPickupTemplate,
	EditPickupTemplate,
	jGrowl
) {
	'use strict';

	return function PickupsTab() {

		var _me = this;
		var _util = new Util();
		var _$pickups_tab = null;
		var _add_pickup_form_opened = false;

		SQ.mixin(_me, new Broadcaster(['add_pickup', 'remove_pickup', 'edit_pickup']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$pickups_tab = $e;
			_setListeners($e);
			_setPickupListener($e);
		};

		this.appendPickup = function(pickup) {
			var _$existing_pickup_template = $(_.template(ExistingPickupTemplate, {pickup: pickup}));
			_$pickups_tab.find('.pickups-list-container').find('.add-pickup-form-container').remove();
			_$pickups_tab.find('.pickups-list-container').append(_$existing_pickup_template);
			_$pickups_tab.find('.no-pickup-container').hide();
			_add_pickup_form_opened = false;
			_setPickupListener(_$existing_pickup_template);
		};

		this.populateEdit = function(pickup) {
			var _$edit_pickup_template = $(_.template(EditPickupTemplate, {pickup: pickup}));
			_$pickups_tab.find('.pickups-list-container').find('.existing-pickup-container-' + pickup.id).hide();
			_$pickups_tab.find('.pickups-list-container .existing-pickup-container-' + pickup.id).after(_$edit_pickup_template);
			_add_pickup_form_opened = true;

			_$edit_pickup_template.find('.cancel').on('click', function(e) {
				e.preventDefault();
				var _$self = $(e.target);
				var _pickup_id = _$self.closest('.edit-pickup-form-container').attr('data-pickup-id');
				_$self.closest('.edit-pickup-form-container').remove();
				_$pickups_tab.find('.pickups-list-container').find('.existing-pickup-container-' + _pickup_id).fadeIn(300);
				_add_pickup_form_opened = false;
			});

			_$edit_pickup_template.find('.edit-pickup-form').validate({
				rules: {
					type: {
						required: true
					},
					first_name: {
						required: true
					},
					last_name: {
						required: true
					},
					phone: {
						required: true,
						number: true
					}
				},
				messages: {
					phone: 'Please enter a valid phone number.'
				},
				submitHandler: function(form) {
					var _edit_pickup_data = _util.serializeJSON($(form));
					_me.broadcast('edit_pickup', _edit_pickup_data);
				}
			});
		};

		this.editSuccess = function(pickup) {
			_$pickups_tab.find('.pickups-list-container .edit-pickup-form-container').remove();
			_$pickups_tab.find('.pickups-list-container').find('.existing-pickup-container-' + pickup.id + ' .pickup-type').text(_util.ucfirst(pickup.type));
			_$pickups_tab.find('.pickups-list-container').find('.existing-pickup-container-' + pickup.id + ' .pickup-name').text(pickup.first_name + ' ' + pickup.last_name);
			_$pickups_tab.find('.pickups-list-container').find('.existing-pickup-container-' + pickup.id + ' .pickup-phone').text(pickup.phone);
			_$pickups_tab.find('.pickups-list-container').find('.existing-pickup-container-' + pickup.id).fadeIn(300);
			_add_pickup_form_opened = false;
		};

		this.removePickup = function(pickup_id) {
			_$pickups_tab.find('.existing-pickup-container-' + pickup_id).remove();
			if (!_$pickups_tab.find('.existing-pickup-container').length) {
				_$pickups_tab.find('.no-pickup-container').fadeIn(300);
			}
		};

		function _setListeners($e) {
			$e.find('.add-pickup').on('click', function() {
				if (_add_pickup_form_opened) {
					return false;
				}
				var _$add_pickup_template = $(_.template(AddPickupTemplate, {}));

				_add_pickup_form_opened = true;
				$e.find('.pickups-list-container').append(_$add_pickup_template);
				$e.find('.no-pickup-container').hide();

				_$add_pickup_template.find('.cancel').on('click', function(e) {
					e.preventDefault();
					$(e.target).closest('.add-pickup-form-container').remove();
					if (!_$pickups_tab.find('.existing-pickup-container').length) {
						_$pickups_tab.find('.no-pickup-container').fadeIn(300);
					}
					_add_pickup_form_opened = false;
				});

				_$add_pickup_template.find('.add-pickup-form').validate({
					rules: {
						type: {
							required: true
						},
						first_name: {
							required: true
						},
						last_name: {
							required: true
						},
						phone: {
							required: true,
							number: true
						}
					},
					messages: {
						phone: 'Please enter a valid phone number.'
					},
					submitHandler: function(form) {
						var _add_pickup_data = _util.serializeJSON($(form));
						_me.broadcast('add_pickup', _add_pickup_data);
					}
				});
			});
		}

		function _setPickupListener($e) {
			$e.find('.remove-pickup').on('click', function() {
				var _pickup_id = $(this).attr('data-pickup-id');
				_me.broadcast('remove_pickup', {pickup_id: _pickup_id});
			});

			$e.find('.edit-pickup').on('click', function() {
				if (_add_pickup_form_opened) {
					return false;
				}

				var _pickup_id = $(this).attr('data-pickup-id');
				_me.broadcast('get_pickup', {pickup_id: _pickup_id});
			});

		}
	}
});
