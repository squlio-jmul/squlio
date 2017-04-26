<div id="sq-school-admin-edit-term-container" class="sq-container">
	<form id="edit-term-form">
		<input type="hidden" name="school_id" value="<?=$term['school_id']?>" />
		<input type="hidden" name="term_id" value="<?=$term['id']?>" />
		<div class="form-group">
			<label for="name">Term Name</label>
			<input type="text" name="name" class="form-control" placeholder="Term Name" value="<?=$term['name']?>" />
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<label for="start_date">Start Date</label>
					<input type="text" name="start_date" class="form-control" placeholder="Start Date" value="<?=$term['start_date']->format('Y-m-d')?>" />
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<label for="end_date">End Date</label>
					<input type="text" name="end_date" class="form-control" placeholder="End Date" value="<?=$term['end_date']->format('Y-m-d')?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="button">Save</button>
		</div>
	</form>
</div>
