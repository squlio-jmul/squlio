<div id="sq-school-admin-edit-classroom-container" class="sq-container">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Classroom Info</a></li>
		<li role="presentation"><a href="#teachers" aria-controls="teachers" role="tab" data-toggle="tab">Teachers</a></li>
		<li role="presentation"><a href="#students" aria-controls="students" role="tab" data-toggle="tab">Students</a></li>
		<li role="presentation"><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">Schedule</a></li>
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
									<div class="input-value"><?=$classroom['classroom_grade']['name']?></div>
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
			<? if (!$teacher) : ?>
				<div class="no-teacher-container">
					Currently, you do not have any teacher in this school. <a href="/school_admin/add_teacher">Click here to add one now.</a>
				</div>
			<? else: ?>
				<div class="add-teacher-container">
					<button class="button add-teacher">+ Add Teacher To This Class</button>
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
								<button class="button red remove-teacher" data-teacher-id="<?=$ct['teacher_id']?>" data-classroom-teacher-id="<?=$ct['id']?>">Remove</button>
								<button class="button set-primary set-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? 'sq-hidden':'' ?>" data-classroom-teacher-id="<?=$ct['id']?>">Set Primary</button>
								<span class="is-primary is-primary-<?=$ct['id']?> <?=($ct['is_primary']) ? '':'sq-hidden' ?>" data-classroom-teacher-id="<?=$ct['id']?>">Primary</button>
							</div>
						</div>
					<? endforeach; ?>
				</div>
			<? endif; ?>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="students">
			<? if (!$student) : ?>
				<div class="no-student-container">
					Currently, you do not have any student in this school. <a href="/school_admin/add_student">Click here to add one now.</a>
				</div>
			<? else: ?>
				<div class="header">
					<div class="row">
						<div class="col-xs-6">
							<div class="students-count"></div>
							<div class="add-student-container">
								<button class="button add-student">+ Add Student To This Class</button>
							</div>
						</div>
						<div class="col-xs-6 right">
							<div class="bulk-actions-container">
								<select name="bulk_actions" class="form-control">
									<option value="">Bulk Actions</option>
									<option value="delete">Delete</option>
								</select>
							</div>
							<div class="apply-button-container">
								<button class="button apply-bulk-actions">Apply</button>
							</div>
						</div>
					</div>
				</div>
				<div id="student-table-container"></div>
				<div id="add-student-container" class="sq-hidden">
					<div class="title">Add Student to This Class</div>
					<form id="add-student-form">
						<input type="hidden" name="classroom_id" value="<?=$classroom['id']?>" />
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="student_id">Student</label>
									<select name="student_id" class="form-control">
										<option value=""> - Select Student - </option>
										<? foreach($student as $s) : ?>
											<option value="<?=$s['id']?>" class="<?=(in_array($s['id'], $selected_student_ids)) ? 'sq-hidden':''?>"><?=$s['first_name'] . ' ' . $s['last_name']?></option>
										<? endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<button type="submit" class="button">Save</button>&nbsp;&nbsp;<a class="cancel">Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			<? endif; ?>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="schedule">
			<? if (!$term) : ?>
				<div class="no-term-container">
					Currently, you do not have any term in this school. <a href="/school_admin/add_term">Click here to add one now.</a>
				</div>
			<? elseif (!$subject) : ?>
				<div class="no-subject-container">
					Currently, you do not have any subject in this school. <a href="/school_admin/add_subject">Click here to add one now.</a>
				</div>
			<? else : ?>
				<div class="header">
					<div class="row">
						<div class="col-xs-6">
							<button class="button add-schedule">+ Add New Schedule</button>
						</div>
						<div class="col-xs-6 right">
							<div class="bulk-actions-container">
								<select name="bulk_actions" class="form-control">
									<option value="">Bulk Actions</option>
									<option value="delete">Delete</option>
								</select>
							</div>
							<div class="apply-button-container">
								<button class="button apply-bulk-actions">Apply</button>
							</div>
						</div>
					</div>
				</div>
				<div id="schedule-table-container"></div>
				<div id="add-schedule-container" class="sq-hidden">
					<div class="title">Add New Schedule</div>
					<form id="add-schedule-form">
						<input type="hidden" name="classroom_id" value="<?=$classroom['id']?>" />
						<input type="hidden" name="school_id" value="<?=$classroom['school_id']?>" />
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="term_id">Term</label>
									<select name="term_id" class="form-control">
										<option value=""> - Select Term - </option>
										<? foreach($term as $t) : ?>
											<option value="<?=$t['id']?>" data-start-date="<?=$t['start_date']->format('Y-m-d')?>" data-end-date="<?=$t['end_date']->format('Y-m-d')?>"><?=$t['name']?></option>
										<? endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="date">Date</label>
									<input type="text" name="date" class="form-control" placeholder="Date" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="subject_id">Subject</label>
									<select name="subject_id" class="form-control">
										<option value=""> - Select Subject - </option>
										<? foreach($subject as $s) : ?>
											<option value="<?=$s['id']?>"><?=$s['title']?></option>
										<? endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="button">Save</button>&nbsp;&nbsp;<a class="cancel">Cancel</a>
						</div>
					</form>
				</div>
			<? endif; ?>
		</div>
	</div>
</div>
