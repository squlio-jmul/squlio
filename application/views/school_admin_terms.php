<div id="sq-school-admin-terms-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<div class="terms-count">
					<?=number_format($terms_count)?> Term<?=($terms_count > 1) ? 's' : ''?>
				</div>
				<div class="add-term-container">
					<a href="/school_admin/add_term" class="button add-term">+ Add New</a>
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
	<div id="terms-table-container"></div>
</div>
