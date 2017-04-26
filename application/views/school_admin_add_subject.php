<div id="sq-school-admin-add-subject-container" class="sq-container">
	<div class="row">
		<div class="col-xs-3 upload-image-container">
			<div class="add-image-container">
				+<br />Add Image
			</div>
			<div class="image-preview-container marginbottom30 sq-hidden"></div>
			<div class="upload-image-form-container sq-hidden">
				<div class="form-group">
					<label for="image_file">Subject Image</label>
					<input type="file" name="image_file" class="form-control" />
				</div>
				<div class="form-group">
					<button class="button upload" type="button">Upload</button><br /><a class="cancel">Cancel</a>
				</div>
			</div>
		</div>
		<div class="col-xs-9">
			<form id="add-subject-form">
				<input type="hidden" name="school_id" value="<?=$school_id?>" />
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Title" />
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
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control" placeholder="Description"></textarea>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="material">Material (Optional)</label>
							<textarea name="material" class="form-control" placeholder="Material"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="url">Supplementary URL (Optional)</label>
							<input type="text" name="url" class="form-control" placeholder="Supplementary URL" />
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="video_url">Supplementary Video URL (Optional)</label>
							<input type="text" name="video_url" class="form-control" placeholder="Supplementary Video URL" />
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
