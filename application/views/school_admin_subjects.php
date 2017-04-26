<div id="sq-school-admin-subjects-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<div class="subjects-count">
					<?=number_format($subjects_count)?> Subject<?=($subjects_count > 1) ? 's' : ''?>
				</div>
				<div class="add-subject-container">
					<a href="/school_admin/add_subject" class="button add-subject">+ Add New</a>
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
	<div id="subjects-table-container"></div>
</div>
