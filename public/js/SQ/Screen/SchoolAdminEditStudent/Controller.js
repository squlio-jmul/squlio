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
	'SQ/Screen/SchoolAdminEditStudent/Views/ParentsForm',
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
	ParentsForm,
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

		var _studentModel = new StudentModel();
		var _classroomModel = new ClassroomModel();
		var _loginModel = new LoginModel();
		var _guardianModel = new GuardianModel();
		var _guardianStudentModel = new GuardianStudentModel();
		var _pickupModel = new PickupModel();

		var _editStudentForm = new EditStudentForm();
		var _uploadImageForm = new UploadImageForm();
		var _parentsForm = new ParentsForm();
		var _pickupsTab = new PickupsTab();

		(function _init() {
			_editStudentForm.initialize($('#edit-student-form'));
			_editStudentForm.setListener('get_classroom', _getClassroom);
			_editStudentForm.setListener('edit_student', _editStudent);

			_uploadImageForm.initialize($('.upload-image-container'));
			_uploadImageForm.setListener('upload_image', _uploadImage);

			_parentsForm.initialize($('#parents'));
			_parentsForm.setListener('save_father', _saveFather);
			_parentsForm.setListener('save_mother', _saveMother);

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

		function _saveFather(data) {
			$('body').append(_.template(loadingTemplate));
			if (parseInt(data.guardian_id) && parseInt(data.login_id)) {
				_loginModel.update(data.login_id, {username: data.username, password: data.password, email: data.email}).then(
					function(success) {
						if (success) {
							_guardianModel.update(data.guardian_id, data).then(
								function(success) {
									$('body').find('.sq-loading-overlay').remove();
									if (success) {
										$.jGrowl('Father information is saved successfully', {header: 'Success'});
									} else {
										$.jGrowl('Unable to save father information', {header: 'Error'});
									}
								}
							);
						} else {
							$.jGrowl('Unable to save father information', {header: 'Error'});
						}
					}
				)
			} else {
				_guardianModel.add(data).then(
					function(guardian_id) {
						if (guardian_id) {
							_guardianStudentModel.add({guardian_id: guardian_id, student_id: _student_id}).then(
								function(guardian_student_id) {
									if (guardian_student_id) {
										_guardianModel.get({id: guardian_id}, ['login_id']).then(
											function(guardian_obj) {
												$('body').find('.sq-loading-overlay').remove();
												if (guardian_obj.length) {
													var _login_id = guardian_obj[0].login_id;
													$.jGrowl('Father information is saved successfully', {header: 'Success'});
													_parentsForm.setGuardianId('father', guardian_id);
													_parentsForm.setLoginId('father', _login_id);
												} else {
													$.jGrowl('Unable to assign this parent to this student', {header: 'Error'});
												}
											}
										)
									} else {
										$('body').find('.sq-loading-overlay').remove();
										$.jGrowl('Unable to assign this parent to this student', {header: 'Error'});
									}
								}
							);
						} else {
							$('body').find('.sq-loading-overlay').remove();
							$.jGrowl('Unable to save father information', {header: 'Error'});
						}
					}
				);
			}
		}

		function _saveMother(data) {
			$('body').append(_.template(loadingTemplate));
			if (parseInt(data.guardian_id) && parseInt(data.login_id)) {
				_loginModel.update(data.login_id, {username: data.username, password: data.password, email: data.email}).then(
					function(success) {
						if (success) {
							_guardianModel.update(data.guardian_id, data).then(
								function(success) {
									$('body').find('.sq-loading-overlay').remove();
									if (success) {
										$.jGrowl('Mother information is saved successfully', {header: 'Success'});
									} else {
										$.jGrowl('Unable to save mother information', {header: 'Error'});
									}
								}
							);
						} else {
							$.jGrowl('Unable to save mother information', {header: 'Error'});
						}
					}
				)
			} else {
				_guardianModel.add(data).then(
					function(guardian_id) {
						if (guardian_id) {
							_guardianStudentModel.add({guardian_id: guardian_id, student_id: _student_id}).then(
								function(guardian_student_id) {
									if (guardian_student_id) {
										_guardianModel.get({id: guardian_id}, ['login_id']).then(
											function(guardian_obj) {
												$('body').find('.sq-loading-overlay').remove();
												if (guardian_obj.length) {
													var _login_id = guardian_obj[0].login_id;
													$.jGrowl('Mother information is saved successfully', {header: 'Success'});
													_parentsForm.setGuardianId('mother', guardian_id);
													_parentsForm.setLoginId('mother', _login_id);
												} else {
													$.jGrowl('Unable to assign this parent to this student', {header: 'Error'});
												}
											}
										)
									} else {
										$('body').find('.sq-loading-overlay').remove();
										$.jGrowl('Unable to assign this parent to this student', {header: 'Error'});
									}
								}
							);
						} else {
							$('body').find('.sq-loading-overlay').remove();
							$.jGrowl('Unable to save mother information', {header: 'Error'});
						}
					}
				);
			}
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


	}
});
