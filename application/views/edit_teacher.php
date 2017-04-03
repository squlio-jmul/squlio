<header class="school-admin-page-header">
	<h4>Edit Classroom Grade</h4>
	<div class="user-section">
		<ul class="user">
			<li class="user-tag">
			<p> Hello, <?=$username?> </p>
			</li>
			<li class="user-avatar">
			</li>
			<li class="logout">
				<a class="school-admin-logout" href="/logout">Logout</a>
			</li>
		</ul>
	</div>
</header>
<div class="school-admin-main-content">
	<form id="edit-teacher-form">
		<div class="avatar-container">
			<div class="avatar">
			</div>
			<div class="upload-btn">
				<span class="btn btn-default btn-file ">
					Upload <input type="file" hidden />
				</span>
			</div>
		</div>
		<div class="edit-teacher">
			<div class="form-group">
				<input type="hidden" name="school_id"  class="form-control"  value="<?=$school_id?>" />
			</div>
<?
			if (isset($teacher)) {
				foreach($teacher as $t) {
?>
			<div class="form-group">
				<input type="hidden" name="login_id" class="form-control login_id"  value="<?=$t['login_id']?>" />
			</div>
			<div class="form-group">
				<input type="hidden" name="id" class="form-control id"  value="<?=$t['id']?>" />
			</div>
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" placeholder="Teacher username" value="<?=$t['login']['username']?>" />
			</div>
			<div class="form-left">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control" placeholder="Teacher email" value="<?=$t['login']['email']?>" />
				</div>
				<div class="form-group">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" class="form-control" placeholder="Teacher first name" value="<?=$t['first_name']?>" />
				</div>
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" name="phone" class="form-control" placeholder="Teacher phone" value="<?=$t['phone']?>" />
				</div>
				<div class="form-group">
					<label for="gender">Gender</label>
					<select id="gender" class="form-control">
						<option value="<?=$t['gender']?>"><?=$t['gender']?></option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>
			</div>
			<div class="form-right">
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" placeholder="Teacher password" value="" />
				</div>
				<div class="form-group">
					<label for="last_name">Last Name</label>
					<input type="text" name="last_name" class="form-control" placeholder="Teacher last name" value="<?=$t['last_name']?>" />
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" name="address" class="form-control" placeholder="Teacher address" value="<?=$t['address']?>" />
				</div>
				<div class="form-group">
					<label for="birthday">Birthday</label>
					<input type="text" id="birthday" name="birthday" class="form-control" placeholder="Teacher birthday" value="<?=$t['birthday']->format('d/m/Y');?>" />
				</div>
			</div>
<?
				}
			}
?>
		</div>
		<div class="status-container">
			<div class="teacher-action">
				<button type="submit" class="save-btn">Save</button>
				<button type="reset" class="reset-btn">Delete</button>
			</div>
		</div>
	</form>
</div>
