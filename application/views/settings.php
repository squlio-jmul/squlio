<header class="admin-page-header">
	<h4>App Settings</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<div class="add-type">
		<h4>Account Type</h4>
		<button type="submit" class="btn btn-primary">+ Add New</button>
	</div>
	<ul class="list-type">
<?
	if (isset($account_type)) {
		foreach ($account_type as $at) {
?>
	<li class="type" data-id="<?=$at['id']?>">
			<table class="type-table" style="width:100%;">
				<tr>
					<th colspan="2"><?=$at['display_name']?></th>
				</tr>
				<tr>
					<td>Principal</td>
					<td id="value"><?=$at['num_principal']?></td>
				</tr>
				<tr>
					<td>Teacher</td>
					<td id="value"><?=$at['num_teacher']?></td>
				</tr>
				<tr>
					<td>Admin</td>
					<td id="value"><?=$at['num_school_admin']?></td>
				</tr>
				<tr>
					<td>Classroom</td>
					<td id="value"><?=$at['num_classroom']?></td>
				</tr>
				<tr>
					<td>Guardian</td>
					<td id="value"><?=$at['num_guardian']?></td>
				</tr>
				<tr>
					<td>Student</td>
					<td id="value"><?=$at['num_student']?></td>
				</tr>
			</table>
			<a class="edit" href="/admin/editType?id=<?=$at['id']?>">Edit</a>
		</li>
<?
		}
	}
?>
	</ul>
</div>
