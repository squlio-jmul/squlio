<div id="sq-school-admin-teachers-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-2 teachers-count">
				<?=number_format($teachers_count)?> Teacher<?=($teachers_count > 1) ? 's' : ''?>
			</div>
			<div class="col-xs-2 add-teacher-container">
				<a href="/school_admin/add_teacher" class="button">+ Add New</a>
			</div>
			<div class="col-xs-8">
				<div class="row">
					<div class="col-xs-3 bulk-actions-container">
						<select name="bulk_actions" class="form-control">
							<option value="">Bulk Actions</option>
							<option value="activate">Activate</option>
							<option value="deactivate">Deactivate</option>
							<option value="delete">Delete</option>
						</select>
					</div>
					<div class="col-xs-9">
						<button class="button apply-bulk-actions">Apply</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="teachers-table-container"></div>
</div>
