define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Classroom',
	'SQ/Screen/SchoolAdminAddClassroom/Views/AddClassroomForm',
	'SQ/Screen/SchoolAdminAddClassroom/Views/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	ClassroomModel,
	AddClassroomForm,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminAddClassroomController(options) {
		var _me = this;
		var _util = new Util();
		var _school_id = options.school_id;
		var _classroomModel = new ClassroomModel();
		var _addClassroomForm = new AddClassroomForm();
		var _uploadImageForm = new UploadImageForm();
		var _photo_url = null;

		(function _init() {
			_addClassroomForm.initialize($('#add-classroom-form'));
			_addClassroomForm.setListener('add_classroom', _addClassroom);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);
		})();

		function _addClassroom(data) {
			data.photo_url = _photo_url;
			data.deleted = 0;
			$('body').append(_.template(loadingTemplate));
			_classroomModel.add(data).then(
				function(classroom_id) {
					$('body').find('.sq-loading-overlay').remove();
					if (classroom_id) {
						$.jGrowl('Classroom is added successfully', {header: 'Success'});
						window.location = '/school_admin/edit_classroom/' + classroom_id;
					} else {
						$.jGrowl('Unable to add this classroom', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_photo_url = response.url_path;
						$('body').find('.sq-loading-overlay').remove();
						_uploadImageForm.updateImage(response.url_path);
						$.jGrowl('Classroom avatar is uploaded successfully', {header: 'Success'});
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl(response.error_msg, {header: 'Error'});
					}
				}
			);
		}
	}
});
