<div id="sq-school-admin-edit-classroom-container" class="sq-container">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Classroom Info</a></li>
		<li role="presentation"><a href="#teachers" aria-controls="teachers" role="tab" data-toggle="tab">Teachers</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="details">
			<div class="row">
				<div class="col-xs-3 upload-image-container">
					<? if (!$classroom['photo_url']) : ?>
					<div class="add-image-container">
						+<br />Add Image
					</div>
					<? endif; ?>
					<div class="image-preview-container marginbottom30" style="<?=($classroom['photo_url']) ? 'background-image: url(' . $classroom['photo_url'] . ')' : 'display:none'?>"></div>
					<div class="upload-image-form-container sq-hidden">
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
					<form id="edit-classroom-form">
						<input type="hidden" name="classroom_id" value="<?=$classroom['id']?>" />
						<input type="hidden" name="school_id" value="<?=$classroom['school_id']?>" />
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="active" value="y" <?=($classroom['active']) ? 'checked':''?>>
									Active
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="name">Class Name</label>
									<input type="text" name="name" class="form-control" placeholder="Class Name" value="<?=$classroom['name']?>" />
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="classroom_grade_id">Grade</label>
									<select name="classroom_grade_id" class="form-control">
										<option value=""> - Select Grade - </option>
										<? foreach($classroom_grade as $cg) : ?>
											<option value="<?=$cg['id']?>" <?=($classroom['classroom_grade_id'] == $cg['id']) ? 'selected':''?>><?=$cg['display_name']?></option>
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
		<div role="tabpanel" class="tab-pane fade" id="teachers">
			<div class="add-teacher-container">
				<button class="button add-teacher">+ Add New Teacher</button>
			</div>
			<? if (!$classroom['classroom_teacher']) : ?>
			<div class="no-teacher-container">
				Currently, there is no teacher assigned to this classroom.
			</div>
			<? endif; ?>
			<div class="teachers-list-container">
				<? foreach($classroom['classroom_teacher'] as $ct) : ?>
					<div class="row existing-teacher-container existing-teacher-container-<?=$ct['id']?>">
						<div class="col-xs-3">
							<div class="teacher-name">
								<?=$ct['teacher_first_name'] . ' ' . $ct['teacher_last_name']?>
							</div>
						</div>
						<div class="col-xs-9">
							<button class="button red remove-teacher" data-classroom-teacher-id="<?=$ct['id']?>">Remove</button>
							<button class="button set-primary set-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? 'sq-hidden':'' ?>" data-classroom-teacher-id="<?=$ct['id']?>">Set Primary</button>
							<span class="is-primary is-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? '':'sq-hidden' ?>" data-classroom-teacher-id="<?=$ct['id']?>">Primary</button>
						</div>
					</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
</div>
