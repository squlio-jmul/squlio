<header class="admin-page-header">
	<h4>Schools/Add School</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id = add-school-type-form">
		<div class="school-form">
			<div class="form-group">
				<label for="name">School Name</label>
				<input type="text" name="name" class="form-control" placeholder="School Name" value="" />
			</div>
			<div class="form-group">
				<label for="email">School Email</label>
				<input type="email" name="email" class="form-control" placeholder="School Email" value="" />
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
			<select id="account_type">
				<option  value="">  Select One  </option>
			</select>
			<button type="submit" class="btn btn-primary">Save</option>
		</div>
		<div class="principal-form">
			<div class="principal-header">
				<p>School Principal</p>
				<button type="submit" class="btn btn-primary">+ Add New</button>
			</div>
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Name" value="" />
				<input type="email" name="email" class="form-control" placeholder="Email" value="" style="width:50%;" />
				<input type="password" name="password" class="form-control" placeholder="password" value="" style="width:50%;" />
			</div>
			<div class="delete">
				<button type="reset" class="delete-btn">Delete</button>
			</div>
		</div>
		<div class="school-avatar">
		</div>
		<div class="school-admin-form">
		</div>
	</form>
</div>
