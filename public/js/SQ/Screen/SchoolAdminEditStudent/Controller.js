define([
	'jquery',
	'Global/SQ',
	'SQ/Util',
	'SQ/Model/Student',
	'SQ/Model/Classroom',
	'SQ/Model/Login',
	'SQ/Model/Guardian',
	'SQ/Model/GuardianStudent',
	'SQ/Model/Pickup',
	'SQ/Screen/SchoolAdminEditStudent/Views/EditStudentForm',
	'SQ/Screen/SchoolAdminEditStudent/Views/GuardiansTab',
	'SQ/Screen/SchoolAdminEditStudent/Views/PickupsTab',
	'SQ/Module/UploadImageForm',
	'underscore',
	'text!../../Template/loading.tmpl',
	'ThirdParty/q',
	'jgrowl'
], function(
	$,
	SQ,
	Util,
	StudentModel,
	ClassroomModel,
	LoginModel,
	GuardianModel,
	GuardianStudentModel,
	PickupModel,
	EditStudentForm,
	GuardiansTab,
	PickupsTab,
	UploadImageForm,
	_,
	loadingTemplate,
	Q,
	jGrowl
) {
	'use strict';

	return function SchoolAdminEditStudentController(options) {
		var _me = this;
		var _util = new Util();
		var _student_id = options.student_id;
		var _school_id = options.school_id;
		var _selected_guardian_ids = options.selected_guardian_ids;

		var _studentModel = new StudentModel();
		var _classroomModel = new ClassroomModel();
		var _loginModel = new LoginModel();
		var _guardianModel = new GuardianModel();
		var _guardianStudentModel = new GuardianStudentModel();
		var _pickupModel = new PickupModel();

		var _editStudentForm = new EditStudentForm();
		var _uploadImageForm = new UploadImageForm();
		var _guardiansTab = new GuardiansTab();
		var _pickupsTab = new PickupsTab();

		(function _init() {
			_editStudentForm.initialize($('#edit-student-form'));
			_editStudentForm.setListener('get_classroom', _getClassroom);
			_editStudentForm.setListener('edit_student', _editStudent);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

			_guardiansTab.initialize($('#guardians'));
			_guardiansTab.setSelectedGuardianIds(_selected_guardian_ids);
			_guardiansTab.setListener('verify_email', _verifyEmail);
			_guardiansTab.setListener('select_guardian', _selectGuardian);
			_guardiansTab.setListener('add_guardian', _addGuardian);
			_guardiansTab.setListener('remove_guardian', _removeGuardian);

			_pickupsTab.initialize($('#pickups'));
			_pickupsTab.setListener('add_pickup', _addPickup);
			_pickupsTab.setListener('remove_pickup', _removePickup);
			_pickupsTab.setListener('get_pickup', _getPickup);
			_pickupsTab.setListener('edit_pickup', _editPickup);

		})();

		function _getClassroom(classroom_grade_id) {
			$('body').append(_.template(loadingTemplate));
			_classroomModel.get({school: _school_id, classroom_grade: classroom_grade_id, active: 1, deleted: 0}, [], {name: 'asc'}).then(
				function(classrooms) {
					$('body').find('.sq-loading-overlay').remove();
					if (!classrooms) {
						$.jGrowl('Currently there is no class available for this grade', {header: 'Error'});
					}
					_editStudentForm.populateClassroom(classrooms);
				}
			)
		}

		function _editStudent(data) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.update(_student_id, data).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Student is updated successfully', {header: 'Success'});
					} else {
						$.jGrowl('Unable to update this student', {header: 'Error'});
					}
				}
			);
		}

		function _uploadImage(data) {
			$('body').append(_.template(loadingTemplate));
			_studentModel.uploadImage(data).then(
				function(response) {
					if (response.success && response.url_path) {
						_studentModel.update(_student_id, {photo_url: response.url_path}).then(
							function(success) {
								$('body').find('.sq-loading-overlay').remove();
								if (success) {
									_uploadImageForm.updateImage(response.url_path);
									$.jGrowl('Student avatar is uploaded successfully', {header: 'Success'});
								} else {
									$.jGrowl('Unable to upload student avatar', {header: 'Error'});
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

		function _addPickup(data) {
			$('body').append(_.template(loadingTemplate));
			data.student_id = _student_id;
			_pickupModel.add(data).then(
				function(pickup_id) {
					if (pickup_id) {
						_pickupModel.get({id: pickup_id}).then(
							function(pickups) {
								$('body').find('.sq-loading-overlay').remove();
								if (pickups.length) {
									$.jGrowl('Pickup is added successfully', {header: 'Success'});
									pickups[0].type = _util.ucfirst(pickups[0].type);
									_pickupsTab.appendPickup(pickups[0]);
								} else {
									$.jGrowl('Unable to add pickup for this student', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to add pickup for this student', {header: 'Error'});
					}
				}
			);
		}

		function _removePickup(data) {
			$('body').append(_.template(loadingTemplate));
			_pickupModel.delete({id: data.pickup_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Pickup is removed successfully', {header: 'Success'});
						_pickupsTab.removePickup(data.pickup_id);
					} else {
						$.jGrowl('Unable to remove this pickup', {header: 'Error'});
					}
				}
			);
		}

		function _getPickup(data) {
			$('body').append(_.template(loadingTemplate));
			_pickupModel.get({id: data.pickup_id}).then(
				function(pickups) {
					$('body').find('.sq-loading-overlay').remove();
					if (pickups.length) {
						_pickupsTab.populateEdit(pickups[0]);
					} else {
						$.jGrowl('Unable to get this pickup info', {header: 'Error'});
					}
				}
			);
		}

		function _editPickup(data) {
			$('body').append(_.template(loadingTemplate));
			_pickupModel.update(data.pickup_id, data).then(
				function(success) {
					if (success) {
						_pickupModel.get({id: data.pickup_id}).then(
							function(pickups) {
								$('body').find('.sq-loading-overlay').remove();
								if (pickups.length) {
									$.jGrowl('Pickup is updated successfully', {header: 'Success'});
									_pickupsTab.editSuccess(pickups[0]);
								} else {
									$.jGrowl('Unable to get this pickup info', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to update this pickup', {header: 'Error'});
					}
				}
			);
		}

		function _verifyEmail(data) {
			$('body').append(_.template(loadingTemplate));
			_guardianModel.verifyEmail(_student_id, data.email).then(
				function(response) {
					$('body').find('.sq-loading-overlay').remove();
					if (response.email_available) {
						_guardiansTab.displayStep2();
					} else {
						if (response.guardian_exist) {
							_guardiansTab.displayStep1Error('This guardian is already in the list');
						} else if (response.guardian && parseInt(response.guardian.id)) {
							_guardiansTab.displaySimilarGuardian(response.guardian);
						}
					}
				}
			);
		}

		function _selectGuardian(guardian_id) {
			$('body').append(_.template(loadingTemplate));
			_guardianStudentModel.add({guardian_id: guardian_id, student_id: _student_id}).then(
				function(guardian_student_id) {
					if (guardian_student_id) {
						_guardianStudentModel.get({id: guardian_student_id}, {}, {}, null, null, {guardian: true}).then(
							function(guardian_students) {
								$('body').find('.sq-loading-overlay').remove();
								if (guardian_students.length) {
									$.jGrowl('Guardian is added successfully', {header: 'Error'});
									_guardiansTab.appendNewGuardian(guardian_students[0]);
								} else {
									$.jGrowl('Unable to find this guardian', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to add guardian for this student', {header: 'Error'});
					}
				}
			);
		}

		function _addGuardian(data) {
			$('body').append(_.template(loadingTemplate));
			data.school_id = _school_id;
			_guardianModel.add(data).then(
				function(guardian_id) {
					if (guardian_id) {
						_guardianStudentModel.add({guardian_id: guardian_id, student_id: _student_id}).then(
							function(guardian_student_id) {
								if (guardian_student_id) {
									_guardianStudentModel.get({id: guardian_student_id}, {}, {}, null, null, {guardian: true}).then(
										function(guardian_students) {
											$('body').find('.sq-loading-overlay').remove();
											if (guardian_students.length) {
												$.jGrowl('Guardian is added successfully', {header: 'Error'});
												_guardiansTab.appendNewGuardian(guardian_students[0]);
											} else {
												$.jGrowl('Unable to find this guardian', {header: 'Error'});
											}
										}
									);
								} else {
									$('body').find('.sq-loading-overlay').remove();
									$.jGrowl('Unable to add guardian for this student', {header: 'Error'});
								}
							}
						);
					} else {
						$('body').find('.sq-loading-overlay').remove();
						$.jGrowl('Unable to add guardian', {header: 'Error'});
					}
				}
			);
		}

		function _removeGuardian(data) {
			$('body').append(_.template(loadingTemplate));
			_guardianStudentModel.delete({id: data.guardian_student_id}).then(
				function(success) {
					$('body').find('.sq-loading-overlay').remove();
					if (success) {
						$.jGrowl('Guardian is removed successfully', {header: 'Success'});
						_guardiansTab.removeGuardianStudent(data.guardian_student_id);
					} else {
						$.jGrowl('Unable to delete guardian', {header: 'Error'});
					}
				}
			);

		}
	}
});
