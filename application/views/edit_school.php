<header class="admin-page-header">
	<h4>Edit School</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id="edit-school-form">
		<div class="school-form">
	<?
		if (isset($school)) {
			foreach ($school as $s) {
	?>
			<div class="form-group">
			<input type="hidden" name="id" class="form-control" placeholder="" value="<?=$s['id']?>"/>
			</div>
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" placeholder="Name" value="<?=$s['name']?>" />
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" class="form-control" placeholder="Email" value="<?=$s['email']?>" />
			</div>
			<div class="form-group">
				<label for="phone_1">Phone Number</label>
				<input type="text" name="phone_1" class="form-control" placeholder="Phone number" value="<?=$s['phone_1']?>" />
			</div>
			<div class="form-group">
				<label for="address_1">Address</label>
				<input type="text" name="address_1" class="form-control" placeholder="Address" value="<?=$s['address_1']?>" />
			</div>
			<div class="form-group">
				<label for="zipcode">Zipcode</label>
				<input type="text" name="zipcode" class="form-control" placeholder="Zipcode" value="<?=$s['zipcode']?>" />
			</div>
			<div class="form-group">
				<label for="city">City</label>
				<input type="text" name="city" class="form-control" placeholder="City" value="<?=$s['city']?>" />
			</div>
			<div id="success-container"></div>
			<div class="error-container"></div>
	<?
			}
		}
	?>
		</div>
		<div class="account-type-option">
			<p>Account Type</p>

			<select id="account_type" name="account_type">
				<option  value="">Select One</option>
	<?

				if (isset($account_type)) {
					foreach ($account_type as $at) {
						$selected = "";
						if ($at['id'] == $school[0]['account_type_id'] ){
							$selected = 'selected="selected"';
						}
	?>
						<option value="<?=$at['id']?>" data-num-principal="<?=$at['num_principal']?>" data-num-school-admin="<?=$at['num_school_admin']?>" <?= $selected;?>><?=$at['display_name']?></option>
			<?
					}
				}
			?>
			</select>
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>
	<form id="edit-principal-form">
		<div class="principal-form">
			<div class="principal-header">
				<p>School Principal</p>
				 <button type="submit" class="add-principal">Add</button>
			</div>
			<div class="form-group">
				<input type="hidden" name="school_id" class="form-control" placeholder="" value="<?=$s['id']?>"/>
			</div>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" value="" style="width:99%;"/>
			</div>
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email" value="" style="width:99%;"/>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="password" value="" style="width:99%;"/>
			</div>
			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="First Name" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="" style="width:99%;" />
			</div>
			<div class="clear">
				<button type="reset" class="delete-btn"></button>
			</div>
		</div>
	</form>
	<form id="update-form-principal" class="hidden">
		<div class="update-form">
			<p>Edit Principal</p>
			<div class="form-group">
					<input type="hidden" name="school_id" class="form-control" placeholder="" value="<?=$s['id']?>"/>
			</div>
			<div class="form-group">
				<input type="text" name="login_id" class="form-control" placeholder="" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="hidden" name="principal_id" class="form-control" placeholder="" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="First Name" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="" style="width:99%;" />
			</div>
			<button type="reset" class="delete-btn"></button>
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
	</form>


	<div class="list-principal">
		<ul class="list-principal-data">
	<?
			if (isset($principal)){
				foreach ($principal as $p) {
	?>
				<li class="principal" data-login-id="principal-<?=$p['login_id']?>" data-id="<?=$p['id']?>">
					<p class="username"><?=$p['username']?></p>
					<p class="email"><?=$p['email']?></p>
					<p class="first_name"><?=$p['first_name']?></p>
					<p class="last_name"> <?=$p['last_name']?></p>
					<input type="hidden" class="principal_id" value="<?=$p['id']?>" />
					<input type="hidden" class="principal_login_id" value="<?=$p['login_id']?>" />
					<button type="button" class="btn btn-danger delete">Delete</button>
					<button type="button" class="btn btn-primary edit-principal">Edit</button>
				</li>
	<?
				}
			}
	?>
			</ul>
	</div>
	<div id="preview-principal" class="row"></div>
	<form id="edit-school-admin-form">
		<div class="school-admin-form">
			<div class="school-admin-header">
				<p>School Admin</p>
				<button type="submit" class="add-school-admin">Add</button>
			</div>
			<div class="form-group">
					<input type="hidden" name="school_id" class="form-control" placeholder="" value="<?=$s['id']?>"/>
			</div>
			<div class="form-group">
				<input type="text" id="school_admin_username" name="username" class="form-control" placeholder="Username" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="email" id="school_admin_email" name="email" class="form-control" placeholder="Email" value="" style="width:99%;">
			</div>
			<div class="form-group">
				<input type="password" id="school_admin_password" name="password" class="form-control" placeholder="Password" value="" style="width:99%;">
			</div>
			<div class="form-group">
				<input type="text" id="school_admin_first_name" name="first_name" class="form-control" placeholder="First Name" value="" style="width:99%;"/>
			</div>
			<div class="form-group">
				<input type="text" id="school_admin_last_name" name="last_name" class="form-control" placeholder="Last Name" value="" style="width:99%;"/>
			</div>
			<div class="clear">
				<button type="reset" class="delete-btn"></button>
			</div>
		</div>
	 </form>
	<form id="update-form" class="hidden">
		<div class="update-form">
			<p>Edit School Admin</p>
			<div class="form-group">
					<input type="hidden" name="school_id" class="form-control" placeholder="" value="<?=$s['id']?>"/>
			</div>
			<div class="form-group">
				<input type="hidden" name="login_id" class="form-control" placeholder="" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="hidden" name="school_admin_id" class="form-control" placeholder="" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="First Name" value="" style="width:99%;" />
			</div>
			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="" style="width:99%;" />
			</div>
			<button type="reset" class="delete-btn"></button>
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
	</form>
	<div id="list-school-admin">
		<ul class="list-school-admin-data">
	<?
			if (isset($school_admin)){
				foreach ($school_admin as $sa) {
	?>
				<li class="school-admin"  data-login-id="school-admin-<?=$sa['login_id']?>" data-id="<?=$sa['id']?>">
					<p class="username"><?=$sa['username']?></p>
					<p class="email"><?=$sa['email']?></p>
					<p class="first_name"><?=$sa['first_name']?></p>
					<p class="last_name"><?=$sa['last_name']?></p>
					<input type="hidden" class="school_admin_id" value="<?=$sa['id']?>" />
					<input type="hidden" class="school_admin_login_id" value="<?=$sa['login_id']?>" />
					<button type"button" class="btn btn-danger delete">Delete</button>
					<button type="button" class="btn btn-primary edit-school-admin">Edit</button>

				</li>
	<?
				}
			}
	?>
		</ul>
	</div>
	<div id="preview-school-admin" class="row"></div>
</div>
