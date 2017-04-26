<div id="sq-school-admin-add-term-container" class="sq-container">
	<form id="add-term-form">
		<input type="hidden" name="school_id" value="<?=$school_id?>" />
		<div class="form-group">
			<label for="name">Term Name</label>
			<input type="text" name="name" class="form-control" placeholder="Term Name" />
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<label for="start_date">Start Date</label>
					<input type="text" name="start_date" class="form-control" placeholder="Start Date" />
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<label for="end_date">End Date</label>
					<input type="text" name="end_date" class="form-control" placeholder="End Date" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="button">Save</button>
		</div>
	</form>
</div>
