<div id="sq-school-admin-classroom-grades-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<div class="classroom-grades-count">
					<?=number_format($classroom_grades_count)?> Classroom Grade<?=($classroom_grades_count > 1) ? 's' : ''?>
				</div>
				<div class="add-classroom-grade-container">
					<a href="/school_admin/add_classroom_grade" class="button add-classroom-grade">+ Add New</a>
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
	<div id="classroom-grades-table-container"></div>
</div>
