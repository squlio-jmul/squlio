<header class="admin-page-header">
	<h4>Edit School</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<form id="edit-school-form">
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
		<button type="submit" class="btn btn-primary">Save</button>
		<div id="success-container"></div>
		<div class="error-container"></div>
<?
		}
	}
?>
	</form>
</div>
