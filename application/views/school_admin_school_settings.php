<div id="sq-school-admin-school-settings-container" class="sq-container">
	<div class="row">
		<div class="col-xs-8">
			<form id="school-settings-form">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" class="form-control" placeholder="Name" value="<?=$school['name']?>" />
				</div>
				<div class="form-group">
					<label for="address_1">Address</label>
					<input type="text" name="address_1" class="form-control" placeholder="Address" value="<?=$school['address_1']?>" />
				</div>
				<div class="form-group">
					<label for="address_2">Suite/Unit #</label>
					<input type="text" name="address_2" class="form-control" placeholder="Suite/Unit #" value="<?=$school['address_2']?>" />
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="form-group">
							<label for="city">City</label>
							<input type="text" name="city" class="form-control" placeholder="City" value="<?=$school['city']?>" />
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<label for="state">State</label>
							<input type="text" name="state" class="form-control" placeholder="State" value="<?=$school['state']?>" />
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<label for="zipcode">Zipcode</label>
							<input type="text" name="zipcode" class="form-control" placeholder="Zipcode" value="<?=$school['zipcode']?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" name="email" class="form-control" placeholder="Email" value="<?=$school['email']?>" />
				</div>
				<div class="form-group">
					<label for="phone_1">Phone</label>
					<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?=$school['phone_1']?>" />
				</div>
				<div class="form-group">
					<label for="fax">Fax</label>
					<input type="text" name="fax" class="form-control" placeholder="Fax" value="<?=$school['fax']?>" />
				</div>
				<div class="form-group">
					<label for="url">Website URL</label>
					<input type="text" name="url" class="form-control" placeholder="Website URL" value="<?=$school['url']?>" />
				</div>
				<div class="form-group">
					<button type="submit" class="button">Save</button>
				</div>
			</form>
		</div>
		<div class="col-xs-3 col-xs-offset-1 upload-image-container">
			<div class="image-preview-container marginbottom30">
				<img src="<?=($school['photo_url']) ? $school['photo_url'] : $img_path . '/no_image.png'?>" class="img-responsive" />
			</div>
			<div class="upload-image-form-container">
				<div class="form-group">
					<label for="image_file">Add New School Image</label>
					<input type="file" name="image_file" class="form-control" />
				</div>
				<div class="form-group">
					<button class="button upload" type="button">Upload</button>
				</div>
			</div>
		</div>
	</div>
</div>
