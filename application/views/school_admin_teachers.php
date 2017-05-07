<div id="sq-school-admin-teachers-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<div class="teachers-count">
					<?=number_format($teachers_count)?> Teacher<?=($teachers_count > 1) ? 's' : ''?>
				</div>
				<div class="add-teacher-container">
					<a href="/school_admin/add_teacher" class="button add-teacher">+ Add New</a>
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
	<div id="teachers-table-container"></div>
</div>
<div id="sq-contact-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form class="sq-contact-form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" name="title" placeholder="Title" class="form-control" />
					</div>
					<div class="form-group">
						<textarea name="message" class="form-control message" placeholder="Message"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="button close-modal" data-dismiss="modal">Close</button>
					<button type="submit" class="button">Send</button>
				</div>
			</div>
		</form>
	</div>
</div>
