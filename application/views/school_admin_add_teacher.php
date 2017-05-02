<div id="sq-school-admin-add-teacher-container" class="sq-container">
	<div class="row">
		<div class="col-xs-3 upload-image-container">
			<div class="add-image-container">
				+<br />Add Image
			</div>
			<div class="image-preview-container marginbottom30 sq-hidden"></div>
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
			<form id="add-teacher-form">
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
							<label for="email">Email</label>
							<input type="text" name="email" class="form-control" placeholder="Email" />
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" class="form-control" />
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
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" name="address" class="form-control" placeholder="Address" />
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="form-group">
							<label for="city">City</label>
							<input type="text" name="city" class="form-control" placeholder="City" />
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<label for="state">State</label>
							<input type="text" name="state" class="form-control" placeholder="State" />
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<label for="zipcode">Zipcode</label>
							<input type="text" name="zipcode" class="form-control" placeholder="Zipcode" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="form-group">
							<label for="phone">Phone</label>
							<input type="text" name="phone" class="form-control" placeholder="Phone" />
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<label for="gender">Gender</label>
							<select name="gender" class="form-control">
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<label for="birthday">Birthday</label>
							<input type="text" name="birthday" class="form-control" />
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
