<div id="sq-school-admin-edit-student-container" class="sq-container">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Student Info</a></li>
		<li role="presentation"><a href="#parents" aria-controls="parents" role="tab" data-toggle="tab">Parents</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="details">
			<div class="row">
				<div class="col-xs-3 upload-image-container">
					<? if (!$student['photo_url']) : ?>
					<div class="add-image-container">
						+<br />Add Image
					</div>
					<? endif; ?>
					<div class="image-preview-container marginbottom30" style="<?=($student['photo_url']) ? 'background-image: url(' . $student['photo_url'] . ')' : 'display:none'?>"></div>
					<div class="upload-image-form-container sq-hidden">
						<div class="form-group">
							<label for="image_file">Student Avatar</label>
							<input type="file" name="image_file" class="form-control" />
						</div>
						<div class="form-group">
							<button class="button upload" type="button">Upload</button><br /><a class="cancel">Cancel</a>
						</div>
					</div>
				</div>
				<div class="col-xs-9">
					<form id="edit-student-form">
						<input type="hidden" name="student_id" value="<?=$student['id']?>" />
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="active" value="y" <?=($student['active']) ? 'checked':''?>>
									Active
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?=$student['first_name']?>" />
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?=$student['last_name']?>" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="classroom_grade_id">Grade</label>
									<select name="classroom_grade_id" class="form-control">
										<option value=""> - Select Grade - </option>
										<? foreach($classroom_grade as $cg) : ?>
										<option value="<?=$cg['id']?>" <?=($student['classroom_grade_id'] == $cg['id']) ? 'selected':''?>><?=$cg['display_name']?></option>
										<? endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="classroom_id">Class</label>
									<select name="classroom_id" class="form-control">
										<option value=""> - Select Class - </option>
										<? foreach($classroom as $c) : ?>
										<option value="<?=$c['id']?>" <?=($student['classroom_id'] == $c['id']) ? 'selected':''?>><?=$c['name']?></option>
										<? endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="gender">Gender</label>
									<select name="gender" class="form-control">
										<option value="male" <?=$student['gender'] == 'male' ? 'selected':''?>>Male</option>
										<option value="female" <?=$student['gender'] == 'female' ? 'selected':''?>>Female</option>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="birthday">Birthday</label>
									<input type="text" name="birthday" class="form-control" value="<?=$student['birthday']->format('Y-m-d')?>" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="button">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="parents">
			<div class="row">
				<? foreach(array('father', 'mother') as $parent_type) : ?>
					<div class="col-xs-6">
						<div class="header"><?=ucfirst($parent_type)?></div>
						<form id="<?=$parent_type?>-form">
							<input type="hidden" name="login_id" value="<?=($$parent_type) ? ${$parent_type}['login_id'] : 0?>" />
							<input type="hidden" name="guardian_id" value="<?=($$parent_type) ? ${$parent_type}['id'] : 0?>" />
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="active" value="y" <?=($$parent_type && ${$parent_type}['active']) ? 'checked':''?>>
										Active
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" name="username" class="form-control" placeholder="Username" value="<?=($$parent_type && ${$parent_type}['username']) ? ${$parent_type}['username'] : ''?>" />
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" name="password" class="form-control" value="<?=($$parent_type && ${$parent_type}['login']['password']) ? ${$parent_type}['login']['password'] : ''?>"/>
										<i class="glyphicon glyphicon-eye-open form-control-feedback sq-view-password"></i>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="first_name">First Name</label>
										<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?=($$parent_type && ${$parent_type}['first_name']) ? ${$parent_type}['first_name'] : ''?>"/>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="last_name">Last Name</label>
										<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?=($$parent_type && ${$parent_type}['last_name']) ? ${$parent_type}['last_name'] : ''?>"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="email">Email</label>
										<input type="text" name="email" class="form-control" placeholder="Email" value="<?=($$parent_type && ${$parent_type}['email']) ? ${$parent_type}['email'] : ''?>"/>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="phone">Phone</label>
										<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?=($$parent_type && ${$parent_type}['phone']) ? ${$parent_type}['phone'] : ''?>"/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="button">Save</button>
							</div>
						</form>
					</div>
				<? endforeach; ?>
			</div>
<? /*
			<? if (!$student['student_teacher']) : ?>
			<div class="no-teacher-container">
				Currently, there is no teacher assigned to this student.
			</div>
			<? endif; ?>
			<div class="teachers-list-container">
				<? foreach($student['student_teacher'] as $ct) : ?>
					<div class="row existing-teacher-container existing-teacher-container-<?=$ct['id']?>">
						<div class="col-xs-3">
							<div class="teacher-name">
								<?=$ct['teacher_first_name'] . ' ' . $ct['teacher_last_name']?>
							</div>
						</div>
						<div class="col-xs-9">
							<button class="button red remove-teacher" data-student-teacher-id="<?=$ct['id']?>">Remove</button>
							<button class="button set-primary set-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? 'sq-hidden':'' ?>" data-student-teacher-id="<?=$ct['id']?>">Set Primary</button>
							<span class="is-primary is-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? '':'sq-hidden' ?>" data-student-teacher-id="<?=$ct['id']?>">Primary</button>
						</div>
					</div>
				<? endforeach; ?>
			</div>
 */
?>
		</div>
	</div>
</div>
