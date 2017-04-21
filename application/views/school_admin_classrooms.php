<div id="sq-school-admin-classrooms-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<div class="classrooms-count">
					<?=number_format($classrooms_count)?> Classroom<?=($classrooms_count > 1) ? 's' : ''?>
				</div>
				<div class="add-classroom-container">
					<a href="/school_admin/add_classroom" class="button">+ Add New</a>
				</div>
			</div>
			<div class="col-xs-6 right">
				<div class="bulk-actions-container">
					<select name="bulk_actions" class="form-control">
						<option value="">Bulk Actions</option>
						<option value="activate">Activate</option>
						<option value="deactivate">Deactivate</option>
						<option value="delete">Delete</option>
					</select>
				</div>
				<div class="apply-button-container">
					<button class="button apply-bulk-actions">Apply</button>
				</div>
			</div>
		</div>
	</div>
	<div id="classrooms-table-container"></div>
</div>
