<div id="sq-school-admin-add-classroom-container" class="sq-container">
	<div class="row">
		<div class="col-xs-3 upload-image-container">
			<div class="add-image-container">
				+<br />Add Image
			</div>
			<div class="image-preview-container marginbottom30 hidden"></div>
			<div class="upload-image-form-container hidden">
				<div class="form-group">
					<label for="image_file">Classroom Avatar</label>
					<input type="file" name="image_file" class="form-control" />
				</div>
				<div class="form-group">
					<button class="button upload" type="button">Upload</button><br /><a class="cancel">Cancel</a>
				</div>
			</div>
		</div>
		<div class="col-xs-9">
			<form id="add-classroom-form">
				<input type="hidden" name="school_id" value="<?=$school_id?>" />
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
							<label for="name">Class Name</label>
							<input type="text" name="name" class="form-control" placeholder="Class Name" />
						</div>
					</div>
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
				</div>
				<div class="form-group">
					<button type="submit" class="button">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
