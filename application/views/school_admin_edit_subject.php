<div id="sq-school-admin-edit-subject-container" class="sq-container">
	<div class="row">
		<div class="col-xs-3 upload-image-container">
			<? if (!$subject['photo_url']) : ?>
			<div class="add-image-container">
				+<br />Add Image
			</div>
			<? endif; ?>
			<div class="image-preview-container marginbottom30" style="<?=($subject['photo_url']) ? 'background-image: url(' . $subject['photo_url'] . ')' : 'display:none'?>"></div>
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
			<form id="edit-subject-form">
				<input type="hidden" name="subject_id" value="<?=$subject['id']?>" />
				<input type="hidden" name="school_id" value="<?=$subject['school_id']?>" />
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Title" value="<?=$subject['title']?>" />
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="classroom_grade_id">Grade</label>
							<select name="classroom_grade_id" class="form-control">
								<option value=""> - Select Grade - </option>
								<? foreach($classroom_grade as $cg) : ?>
									<option value="<?=$cg['id']?>" <?=($cg['id'] == $subject['classroom_grade_id']) ? 'selected':''?>><?=$cg['name']?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control" placeholder="Description"><?=$subject['description']?></textarea>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="material">Material (Optional)</label>
							<textarea name="material" class="form-control" placeholder="Material"><?=$subject['material']?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="url">Supplementary URL (Optional)</label>
							<input type="text" name="url" class="form-control" placeholder="Supplementary URL" value="<?=$subject['url']?>" />
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="video_url">Supplementary Video URL (Optional)</label>
							<input type="text" name="video_url" class="form-control" placeholder="Supplementary Video URL" value="<?=$subject['video_url']?>" />
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
