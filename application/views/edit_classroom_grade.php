<header class="admin-page-header">
	<h4>Edit Classroom Grade</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<header class="edit-classroom-grade">
		<h4><?=$school_name?></h4>
	</header>
	<form id="edit-classroom-grade-form">
<?		if (isset($classroom_grade)) {
			foreach ($classroom_grade as $cg) {
?>
		<div class="form-group">
		<input type="hidden" name="id" class="classroom_grade_id" placeholder="" value="<?=$cg['id']?>"/>
		</div>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" placeholder="Name" value="<?=$cg['name']?>" />
		</div>
		<div class="form-group">
			<label for="display_name">Display Name</label>
			<input type="text" name="display_name" class="form-control" placeholder="Display Name" value="<?=$cg['display_name']?>" />
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
		<button type="button" class="btn btn-danger delete">Delete</button>
<?
			}
		}
?>
	</form>
</div>
