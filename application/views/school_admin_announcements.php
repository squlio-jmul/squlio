<div id="sq-school-admin-announcements-container" class="sq-container">
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<div class="announcements-count">
					<?=number_format($announcements_count)?> Announcement<?=($announcements_count > 1) ? 's' : ''?>
				</div>
				<div class="add-announcement-container">
					<button type="button" class="button add-announcement">+ Add New</button>
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
	<div id="announcements-table-container"></div>
	<div id="sq-school-admin-add-announcement-container" class="sq-hidden">
		<form id="add-announcement-form">
			<input type="hidden" name="school_id" value="<?=$school_id?>" />
			<div class="form-group">
				<label for="classroom_ids">Classroom</label>
				<select name="classroom_ids" class="form-control multiple" multiple>
					<? foreach($classroom as $c) : ?>
					<option value="<?=$c['id']?>"><?=$c['name']?></option>
					<? endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" name="title" class="form-control" placeholder="Title" />
			</div>
			<div class="form-group">
				<label for="content">Content</label>
				<textarea name="content" class="form-control content" placeholder="Content"></textarea>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="start_date">Start Date</label>
						<input type="text" name="start_date" class="form-control" />
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label for="end_date">End Date</label>
						<input type="text" name="end_date" class="form-control" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="button">Save</button>&nbsp;&nbsp;&nbsp;<a class="cancel">Cancel</a>
			</div>
		</form>
	</div>
</div>
<div id="sq-view-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-6">
						<label>Start Date</label>
						<div class="start-date"></div>
					</div>
					<div class="col-xs-6">
						<label>End Date</label>
						<div class="end-date"></div>
					</div>
				</div>
				<div class="title"></div>
				<div class="content"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="button close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
