<header class="admin-page-header">
	<h4>Edit Account Type</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id="edit-account-type-form">
<?		if (isset($account_type)) {
			foreach ($account_type as $at) {
?>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" placeholder="Name" value="<?=$at['name']?>" />
		</div>
		<div class="form-group">
			<label for="display_name">Display Name</label>
			<input type="text" name="display_name" class="form-control" placeholder="Display Name" value="<?=$at['display_name']?>" />
		</div>
		<div class="form-group">
			<label for="num_principal">Number of Principal</label>
			<input type="text" name="num_principal" class="form-control" placeholder="Number of Principal" value="<?=$at['num_principal']?>" />
		</div>
		<div class="form-group">
			<label for="num_school_admin">Number of School Admin</label>
			<input type="text" name="num_school_admin" class="form-control" placeholder="Number of School Admin" value="<?=$at['num_school_admin']?>" />
		</div>
		<div class="form-group">
			<label for="num_teacher">Number of Teacher</label>
			<input type="text" name="num_teacher" class="form-control" placeholder="Number of Teacher" value="<?=$at['num_teacher']?>" />
		</div>
		<div class="form-group">
			<label for="num_classroom">Number of Classroom</label>
			<input type="text" name="num_classroom" class="form-control" placeholder="Number of Classroom" value="<?=$at['num_classroom']?>" />
		</div>
		<div class="form-group">
			<label for="num_guardian">Number of Guardian</label>
			<input type="text" name="num_guardian" class="form-control" placeholder="Number of Guardian" value="<?=$at['num_guardian']?>" />
		</div>
		<div class="form-group">
			<label for="num_student">Number of Student</label>
			<input type="text" name="num_student" class="form-control" placeholder="Number of Student" value="<?=$at['num_student']?>" />
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
		<div id="success-container"></div>
		<div class="error-container"></div>
<?
			}
		}
?>
	</form>
</div>
