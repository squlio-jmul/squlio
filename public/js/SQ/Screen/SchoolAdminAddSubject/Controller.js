define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Subject',
	'SQ/Screen/SchoolAdminAddSubject/Views/AddSubjectForm',
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
	AddSubjectForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAddSubjectController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _subjectModel = new SubjectModel();
		var _addSubjectForm = new AddSubjectForm();
		var _uploadImageForm = new UploadImageForm();
		var _photo_url = null;

		(function _init() {
			_addSubjectForm.initialize($('#add-subject-form'));
			_addSubjectForm.setListener('add_subject', _addSubject);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);
		})();

		function _addSubject(data) {
			data.photo_url = _photo_url;
			$('body').append(_.template(loadingTemplate));
			_subjectModel.add(data).then(
				function(subject_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (subject_id) {
						$.jGrowl('Subject is added successfully', {header: 'Success'});
						window.location = '/school_admin/edit_subject/' + subject_id;
					} else {
						$.jGrowl('Unable to add this subject', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_subjectModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_photo_url = response.url_path;
						$('body').find('.sq-loading-overlay').remove();
						_uploadImageForm.updateImage(response.url_path);
						$.jGrowl('Subject image is uploaded successfully', {header: 'Success'});
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl(response.error_msg, {header: 'Error'});
					}
				}
			);
		}
	}
});
