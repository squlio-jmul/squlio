<div id="sq-school-admin-edit-student-container" class="sq-container">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Student Info</a></li>
		<li role="presentation"><a href="#guardians" aria-controls="guardians" role="tab" data-toggle="tab">Guardians</a></li>
		<li role="presentation"><a href="#pickups" aria-controls="pickups" role="tab" data-toggle="tab">Pickup List</a></li>
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
										<option value="<?=$cg['id']?>" <?=($student['classroom_grade_id'] == $cg['id']) ? 'selected':''?>><?=$cg['name']?></option>
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
		<div role="tabpanel" class="tab-pane fade" id="guardians">
			<div class="add-guardian-container">
				<button class="button add-guardian">+ Add Guardian</button>
			</div>
			<div class="no-guardian-container <?=(!$guardian_student) ? '':'sq-hidden'?>">
				Currently, there is no guardian for this student.
			</div>
			<div class="guardians-list-container">
				<? foreach($guardian_student as $gs) : ?>
					<div class="row existing-guardian-container existing-guardian-container-<?=$gs['id']?>">
						<div class="col-xs-3">
							<div class="guardian-name">
								<?=$gs['guardian']['first_name'] . ' ' . $gs['guardian']['last_name']?>
							</div>
						</div>
						<div class="col-xs-9">
							<button class="button red remove-guardian" data-guardian-id="<?=$gs['guardian_id']?>" data-guardian-student-id="<?=$gs['id']?>">Remove</button>
							<button class="button edit-guardian" data-guardian-id="<?=$gs['guardian_id']?>" data-guardian-student-id="<?=$gs['id']?>">Edit</button>
						</div>
					</div>
				<? endforeach; ?>
			</div>
			<div class="add-guardian-form-container sq-hidden">
				<div class="row">
					<div class="col-xs-6">
						<div class="add-guardian-form-step-1-container">
							<form id="add-guardian-form-step-1">
								<div class="header">Step 1.</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="email">Enter Guardian Email</label>
											<input type="text" name="email" class="form-control" placeholder="Email" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="button">Next</button>&nbsp;&nbsp;&nbsp;<a class="cancel">Cancel</a>
								</div>
								<div class="similar-guardian-container"></div>
							</form>
						</div>
						<div class="add-guardian-form-step-2-container sq-hidden">
							<form id="add-guardian-form-step-2">
								<div class="header">Step 2.</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="password">Password</label>
											<input type="password" name="password" class="form-control" />
											<i class="glyphicon glyphicon-eye-open form-control-feedback sq-view-password"></i>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="status">Status</label>
											<select name="status" class="form-control">
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="first_name">First Name</label>
											<input type="text" name="first_name" class="form-control" placeholder="First Name" />
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="last_name">Last Name</label>
											<input type="text" name="last_name" class="form-control" placeholder="Last Name" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="type">Type</label>
											<select name="type" class="form-control">
												<option value=""> Select Type </option>
												<option value="father">Father</option>
												<option value="mother">Mother</option>
												<option value="uncle">Uncle</option>
												<option value="aunt">Aunt</option>
												<option value="grandfather">Grandfather</option>
												<option value="grandmother">Grandmother</option>
												<option value="brother">Brother</option>
												<option value="sister">Sister</option>
												<option value="other">Other</option>
											</select>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="phone">Phone</label>
											<input type="text" name="phone" class="form-control" placeholder="Phone" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="button">Save</button>&nbsp;&nbsp;&nbsp;<a class="cancel">Cancel</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="edit-guardian-form-container sq-hidden">
				<div class="header">Edit Guardian</div>
				<form id="edit-guardian-form">
					<input type="hidden" name="login_id" value="" />
					<input type="hidden" name="guardian_id" value="" />
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="active" value="y" />
								Active
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" name="email" class="form-control" placeholder="Email" />
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control" />
								<i class="glyphicon glyphicon-eye-open form-control-feedback sq-view-password"></i>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="first_name">First Name</label>
								<input type="text" name="first_name" class="form-control" placeholder="First Name" />
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="last_name">Last Name</label>
								<input type="text" name="last_name" class="form-control" placeholder="Last Name" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="type">Type</label>
								<select name="type" class="form-control">
									<option value=""> Select Type </option>
									<option value="father">Father</option>
									<option value="mother">Mother</option>
									<option value="uncle">Uncle</option>
									<option value="aunt">Aunt</option>
									<option value="grandfather">Grandfather</option>
									<option value="grandmother">Grandmother</option>
									<option value="brother">Brother</option>
									<option value="sister">Sister</option>
									<option value="other">Other</option>
								</select>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="text" name="phone" class="form-control" placeholder="Phone" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="button">Save</button>&nbsp;&nbsp;&nbsp;<a class="cancel">Back</a>
					</div>
				</form>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="pickups">
			<div class="add-pickup-container">
				<button class="button add-pickup">+ Add Pickup</button>
			</div>
			<? if (!$pickup) : ?>
			<div class="no-pickup-container">
				Currently, there is no pickup assigned for this student.
			</div>
			<? endif; ?>
			<div class="pickups-list-container">
				<? foreach($pickup as $p) : ?>
					<div class="row existing-pickup-container existing-pickup-container-<?=$p['id']?>">
						<div class="col-xs-2">
							<div class="pickup-type">
								<?=ucfirst($p['type'])?>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="pickup-name">
								<?=$p['first_name'] . ' ' . $p['last_name']?>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="pickup-phone">
								<?=$p['phone']?>
							</div>
						</div>
						<div class="col-xs-6">
							<button class="button red remove-pickup" data-pickup-id="<?=$p['id']?>">Remove</button>
							<button class="button edit-pickup" data-pickup-id="<?=$p['id']?>">Edit</button>
						</div>
					</div>
				<? endforeach; ?>
			</div>
		</div>

	</div>
</div>
