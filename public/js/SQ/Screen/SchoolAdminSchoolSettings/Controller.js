define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/School',
	'SQ/Screen/SchoolAdminSchoolSettings/Views/SettingsForm',
	'SQ/Module/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	SchoolModel,
	SettingsForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminSchoolSettingsController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _schoolModel = new SchoolModel();
		var _settingsForm = new SettingsForm();
		var _uploadImageForm = new UploadImageForm();

		(function _init() {
			_settingsForm.initialize($('#school-settings-form'));
			_settingsForm.setListener('update_school', _updateSchool);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);
		})();

		function _updateSchool(data) {
			$('body').append(_.template(loadingTemplate));
			_schoolModel.update(_school_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('School is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this school', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_schoolModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_schoolModel.update(_school_id, {photo_url: response.url_path}).then(
							function(success) {
								if (success) {
									$('body').find('.sq-loading-overlay').remove();
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Your school image is updated successfully', {header: 'Success'});
								} else {
									$('body').find('.sq-loading-overlay').remove();
									$.jGrowl('Unable to upload your school image', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl(response.error_msg, {header: 'Error'});
					}
				}
			);
		}
	}
});
