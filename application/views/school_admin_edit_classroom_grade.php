<div id="sq-school-admin-edit-classroom-grade-container" class="sq-container">
	<form id="edit-classroom-grade-form">
		<input type="hidden" name="school_id" value="<?=$classroom_grade['school_id']?>" />
		<input type="hidden" name="classroom_grade_id" value="<?=$classroom_grade['id']?>" />
		<div class="form-group">
			<label for="name">Grade Name</label>
			<input type="text" name="name" class="form-control" placeholder="Grade Name" value="<?=$classroom_grade['name']?>" />
		</div>
		<div class="form-group">
			<button type="submit" class="button">Save</button>
		</div>
	</form>
</div>
