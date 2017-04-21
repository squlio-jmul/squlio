define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom',
	'SQ/Screen/SchoolAdminEditClassroom/Views/EditClassroomForm',
	'SQ/Screen/SchoolAdminEditClassroom/Views/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomModel,
	EditClassroomForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditClassroomController(options) {
		var _me = this;
		var _util = new Util();
		var _classroom_id = options.classroom_id;
		var _classroomModel = new ClassroomModel();
		var _editClassroomForm = new EditClassroomForm();
		var _uploadImageForm = new UploadImageForm();

		(function _init() {
			_editClassroomForm.initialize($('#edit-classroom-form'));
			_editClassroomForm.setListener('edit_classroom', _editClassroom);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

		})();

		function _editClassroom(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.update(_classroom_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Classroom is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this classroom', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_classroomModel.update(_classroom_id, {photo_url: response.url_path}).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Classroom avatar is uploaded successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to upload classroom avatar', {header: 'Error'});
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
