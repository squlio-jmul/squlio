<div id="sq-school-admin-edit-teacher-container" class="sq-container">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
		<li role="presentation"><a href="#classrooms" aria-controls="classrooms" role="tab" data-toggle="tab">Classrooms</a></li>
		<!--<li role="presentation"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Password</a></li>-->
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="details">
			<div class="row">
				<div class="col-xs-3 upload-image-container">
					<? if (!$teacher['photo_url']) : ?>
					<div class="add-image-container">
						+<br />Add Image
					</div>
					<? endif; ?>
					<div class="image-preview-container marginbottom30" style="<?=($teacher['photo_url']) ? 'background-image: url(' . $teacher['photo_url'] . ')' : 'display:none'?>"></div>
					<div class="upload-image-form-container sq-hidden">
						<div class="form-group">
							<label for="image_file">Teacher Avatar</label>
							<input type="file" name="image_file" class="form-control" />
						</div>
						<div class="form-group">
							<button class="button upload" type="button">Upload</button><br /><a class="cancel">Cancel</a>
						</div>
					</div>
				</div>
				<div class="col-xs-9">
					<form id="edit-teacher-form">
						<input type="hidden" name="teacher_id" value="<?=$teacher['id']?>" />
						<input type="hidden" name="login_id" value="<?=$teacher['login_id']?>" />
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="active" value="y" <?=($teacher['active']) ? 'checked':''?>>
									Active
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" name="username" class="form-control" placeholder="Username" value="<?=$teacher['username']?>" />
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control" value="<?=$teacher['login']['password']?>" />
									<i class="glyphicon glyphicon-eye-open form-control-feedback sq-view-password"></i>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?=$teacher['first_name']?>" />
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?=$teacher['last_name']?>" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" name="email" class="form-control" placeholder="Email" value="<?=$teacher['email']?>" />
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<input type="text" name="address" class="form-control" placeholder="Address" value="<?=$teacher['address']?>" />
						</div>
						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" name="city" class="form-control" placeholder="City" value="<?=$teacher['city']?>" />
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label for="state">State</label>
									<input type="text" name="state" class="form-control" placeholder="State" value="<?=$teacher['state']?>" />
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label for="zipcode">Zipcode</label>
									<input type="text" name="zipcode" class="form-control" placeholder="Zipcode" value="<?=$teacher['zipcode']?>" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?=$teacher['phone']?>" />
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label for="gender">Gender</label>
									<select name="gender" class="form-control">
										<option value="male" <?=($teacher['gender'] == 'male') ? 'selected':''?>>Male</option>
										<option value="female" <?=($teacher['gender'] == 'female') ? 'selected':''?>>Female</option>
									</select>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label for="birthday">Birthday</label>
									<input type="text" name="birthday" class="form-control" value="<?=$teacher['birthday']->format('Y-m-d')?>" />
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
		<div role="tabpanel" class="tab-pane fade" id="classrooms">
			<div class="add-classroom-container">
				<button class="button add-classroom">+ Add New Classroom</button>
			</div>
			<? if (!$teacher['classroom_teacher']) : ?>
			<div class="no-classroom-container">
				Currently, this teacher is not belong to any classroom.
			</div>
			<? endif; ?>
			<div class="classrooms-list-container">
				<? foreach($teacher['classroom_teacher'] as $ct) : ?>
					<div class="row existing-classroom-container existing-classroom-container-<?=$ct['id']?>">
						<div class="col-xs-3">
							<div class="classroom-name">
								<?=$ct['classroom_name']?>
							</div>
						</div>
						<div class="col-xs-9">
							<button class="button red remove-classroom" data-classroom-id="<?=$ct['classroom_id']?>" data-classroom-teacher-id="<?=$ct['id']?>">Remove</button>
							<button class="button set-primary set-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? 'sq-hidden':'' ?>" data-classroom-teacher-id="<?=$ct['id']?>">Set Primary</button>
							<span class="is-primary is-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? '':'sq-hidden' ?>" data-classroom-teacher-id="<?=$ct['id']?>">Primary</button>
						</div>
					</div>
				<? endforeach; ?>
			</div>
		</div>
		<!--
		<div role="tabpanel" class="tab-pane fade" id="password">
			<form class="sq-change-password-form">
				<input type="hidden" name="login_id" value="<?=$teacher['login_id']?>" />
				<div class="form-group">
					<input type="password" name="old_password" class="form-control" placeholder="Old Password" value="" />
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="New Password" value="" />
				</div>
				<div class="form-group">
					<input type="password" name="password_confirm" class="form-control" placeholder="New Password Again" value="" />
				</div>
				<div class="form-group">
					<button class="button" type="submit">Save</button>
				</div>
			</form>
		</div>
		-->
	</div>
</div>
