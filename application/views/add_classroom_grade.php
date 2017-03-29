<header class="admin-page-header">
	<h4>Add Classroom Grade</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id="add-classroom-grade-form">
		<div class="form-group">
			<label for="school">Select School</label>
			<select id="school">
				<option value="">Select One</option>
<?
				if (isset($school)) {
					foreach ($school as $s) {
?>
						<option value="<?=$s['id']?>"><?=$s['name']?></option>
<?
					}
				}
?>
			</select>
		</div>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" placeholder="Classroom grade name" value="" />
		</div>
		<div class="form-group">
			<label for="display_name">Display Name</label>
			<input type="text" name="display_name" class="form-control" placeholder="Classroom grade display name" value="" />
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
	</form>
</div>
