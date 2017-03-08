<header class="admin-page-header">
	<h4>Edit Account Type</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id="edit-account-type-form">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" placeholder="Name" value="" />
		</div>
		<div class="form-group">
			<label for="display_name">Display Name</label>
			<input type="text" name="display_name" class="form-control" placeholder="Display Name" value="" />
		</div>
		<div class="form-group">
			<label for="num_principal">Number of Principal</label>
			<input type="text" name="num_principal" class="form-control" placeholder="Number of Principal" value="" />
		</div>
		<div class="form-group">
			<label for="num_school_admin">Number of School Admin</label>
			<input type="text" name="num_school_admin" class="form-control" placeholder="Number of School Admin" value="" />
		</div>
		<div class="form-group">
			<label for="num_teacher">Number of Teacher</label>
			<input type="text" name="num_teacher" class="form-control" placeholder="Number of Teacher" value="" />
		</div>
		<div class="form-group">
			<label for="num_classroom">Number of Classroom</label>
			<input type="text" name="num_classroom" class="form-control" placeholder="Number of Classroom" value="" />
		</div>
		<div class="form-group">
			<label for="num_guardian">Number of Guardian</label>
			<input type="text" name="num_guardian" class="form-control" placeholder="Number of Guardian" value="" />
		</div>
		<div class="form-group">
			<label for="num_student">Number of Student</label>
			<input type="text" name="num_student" class="form-control" placeholder="Number of Student" value="" />
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
		<div id="success-container"></div>
		<div class="error-container"></div>
	</form>
</div>
