<div id="sq-school-admin-add-student-container" class="sq-container">
	<div class="row">
		<div class="col-xs-3 upload-image-container">
			<div class="add-image-container">
				+<br />Add Image
			</div>
			<div class="image-preview-container marginbottom30 sq-hidden"></div>
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
			<form id="add-student-parents-form">
				<div class="add-student-container">
					<input type="hidden" name="school_id" value="<?=$school['id']?>" />
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="active" value="y">
								Active
							</label>
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
								<label for="classroom_grade_id">Grade</label>
								<select name="classroom_grade_id" class="form-control">
									<option value=""> - Select Grade - </option>
									<? foreach($classroom_grade as $cg) : ?>
									<option value="<?=$cg['id']?>"><?=$cg['display_name']?></option>
									<? endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="classroom_id">Class</label>
								<select name="classroom_id" class="form-control">
									<option value=""> - Select Class - </option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="gender">Gender</label>
								<select name="gender" class="form-control">
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="birthday">Birthday</label>
								<input type="text" name="birthday" class="form-control" />
							</div>
						</div>
					</div>
				</div>
				<div class="add-parents-container">
					<div class="header">Parents</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="add-father-container">
								<div class="header">Father</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="father_username">Username</label>
											<input type="text" name="father_username" class="form-control" placeholder="Username" />
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="father_password">Password</label>
											<input type="password" name="father_password" class="form-control" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="father_first_name">First Name</label>
											<input type="text" name="father_first_name" class="form-control" placeholder="First Name" />
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="father_last_name">Last Name</label>
											<input type="text" name="father_last_name" class="form-control" placeholder="Last Name" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="father_email">Email</label>
									<input type="text" name="father_email" class="form-control" placeholder="Email" />
								</div>
								<div class="form-group">
									<label for="father_phone">Phone</label>
									<input type="text" name="father_phone" class="form-control" placeholder="Phone" />
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="add-mother-container">
								<div class="header">Mother</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="mother_username">Username</label>
											<input type="text" name="mother_username" class="form-control" placeholder="Username" />
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="mother_password">Password</label>
											<input type="password" name="mother_password" class="form-control" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<label for="mother_first_name">First Name</label>
											<input type="text" name="mother_first_name" class="form-control" placeholder="First Name" />
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<label for="mother_last_name">Last Name</label>
											<input type="text" name="mother_last_name" class="form-control" placeholder="Last Name" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="mother_email">Email</label>
									<input type="text" name="mother_email" class="form-control" placeholder="Email" />
								</div>
								<div class="form-group">
									<label for="mother_phone">Phone</label>
									<input type="text" name="mother_phone" class="form-control" placeholder="Phone" />
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="button">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
