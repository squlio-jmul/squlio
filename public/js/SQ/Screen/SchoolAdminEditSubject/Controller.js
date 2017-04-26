define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Subject',
	'SQ/Screen/SchoolAdminEditSubject/Views/EditSubjectForm',
	'SQ/Module/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	SubjectModel,
	EditSubjectForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditSubjectController(options) {
		var _me = this;
		var _util = new Util();
		var _subject_id = options.subject_id;

		var _subjectModel = new SubjectModel();
		var _editSubjectForm = new EditSubjectForm();
		var _uploadImageForm = new UploadImageForm();

		(function _init() {
			_editSubjectForm.initialize($('#edit-subject-form'));
			_editSubjectForm.setListener('edit_subject', _editSubject);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);
		})();

		function _editSubject(data) {
			$('body').append(_.template(loadingTemplate));
			_subjectModel.update(_subject_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Subject is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this subject', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_subjectModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_subjectModel.update(_subject_id, {photo_url: response.url_path}).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Subject image is uploaded successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to upload subject image', {header: 'Error'});
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
