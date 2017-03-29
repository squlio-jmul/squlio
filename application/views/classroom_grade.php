<header class="admin-page-header">
	<h4>Classroom Grade</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<div class="add-classroom-grade">
	<h4>Classroom Grade</h4>
		<button type=submit class="btn btn-primary">+ Add New</button>
	</div>
	<div class="school-dropdown">
		<label for="School"> Select a School </label>
		<select id="school">
			<option value="">Select One</option>
	<?
				if (isset($school)) {
					foreach($school as $s) {
	?>
						<option value="<?=$s['id']?>"><?=$s['name']?></option>
	<?
					}
				}
	?>
		</select>
	</div>
	<table id="table" class="display" cellspacing="0" width="100%" >
		<thead>
			<tr>
				<th>Id</th>
				<th>School Name</th>
				<th>Display Name</th>
				<th>Action</th>
			</tr>
		</thead>
	</table>
</div>
