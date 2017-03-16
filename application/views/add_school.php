<header class="admin-page-header">
	<h4>Schools/Add School</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id="add-school-form">
		<div class="school-form">
			<div class="form-group">
				<label for="name">School Name</label>
				<input type="text" name="school_name" class="form-control" placeholder="School Name" value="" />
			</div>
			<div class="form-group">
				<label for="email">School Email</label>
				<input type="email" name="school_email" class="form-control" placeholder="School Email" value="" />
			</div>
			<div class="form-group">
				<label for="phone_1">School Phone</label>
				<input type="text" name="phone_1" class="form-control" placeholder="School Phone" value="" />
			</div>
			<div class="form-group">
				<label for="address_1">School Adress</label>
				<input type="text" name="address_1" class="form-control" placeholder="School Adress" value="" />
			</div>
			<div class="form-group">
				<label for="zipcode">Zipcode</label>
				<input type="text" name="zipcode" class="form-control" placeholder="Zipcode" value=""/>
			</div>
			<div class="form-group">
				<label for="city">City</label>
				<input type="text" name="city" class="form-control" placeholder="City" value=""/>
			</div>
		</div>
		<div class="account-type-option">
			<p>Account Type</p>
			<select id="account_type" name="account_type">
				<option  value="">  Select One  </option>
			<?
				if (isset($account_type)) {
					foreach ($account_type as $at) {
			?>
						<option value="<?=$at['id']?>" data-num-principal="<?=$at['num_principal']?>" data-num-school-admin="<?=$at['num_school_admin']?>"><?=$at['display_name']?></option>
			<?
					}
				}
			?>
			</select>
			<button type="submit" class="btn btn-primary">Save</button>
			<div class="error-container"></div>
		</div>
	</form>
	<form id="add-principal-form" class="hidden">
		<div class="principal-form">
			<div class="principal-header">
				<p>School Principal</p>
				 <button type="submit" class="add-principal">+ Add New</button>
		    </div>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="password" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="First Name" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="" style="width:99%;" required/>
			</div>
			<div class="delete">
				<button type="reset" class="delete-btn"></button>
			</div>
		</div>
		<div id="preview-principal-container" class="row"></div>
		<div id="success-container-principal"></div>
		<div id="limit-container-principal"></div>
	</form>
	<form id="add-school-admin-form" class="hidden">
		<div class="school-admin-form">
			<div class="school-admin-header">
				<p>School Admin</p>
				<button type="submit" class="add-school-admin">+Add New</button>
			</div>
			<div class="form-group">
				<input type="text" id="school_admin_username" name="username" class="form-control" placeholder="Username" value="" style="width:99%;" required />
			</div>
			<div class="form-group">
				<input type="email" id="school_admin_email" name="email" class="form-control" placeholder="Email" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="password" id="school_admin_password" name="password" class="form-control" placeholder="Password" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="text" id="school_admin_first_name" name="first_name" class="form-control" placeholder="First Name" value="" style="width:99%;" required/>
			</div>
			<div class="form-group">
				<input type="text" id="school_admin_last_name" name="last_name" class="form-control" placeholder="Last Name" value="" style="width:99%;" required/>
			</div>
			<div class="delete">
				<button type="reset" class="delete-btn"></button>
			</div>
		</div>
		<div id="preview-school-admin-container" class="row"></div>
		<div id="success-container-school-admin"></div>
		<div id="limit-container-school-admin"></div>
	 </form>
    <div class="school-avatar">
        <div class="school-avatar-header">
            <p>School Avatar</p>
        </div>
        <div class="school-avatar-content">
            <div class="school-avatar-photo">
                <div class="upload-btn">
					<span class="btn btn-default btn-file ">
						Upload <input type="file" hidden />
					</span>
                </div>
            </div>
		</div>
	</div>
	<div id="success-container"></div>
	<div class="error-container"></div>
</div>
